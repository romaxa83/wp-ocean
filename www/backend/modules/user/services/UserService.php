<?php

namespace backend\modules\user\services;

use backend\modules\user\events\UserNewPassword;
use backend\modules\user\events\UserSignUpConfirm;
use backend\modules\user\type\FbType;
use common\models\Auth;
use common\models\SignupForm;
use common\models\User;
use backend\models\Settings;
use backend\modules\user\forms\UserForm;
use backend\modules\user\helpers\ImageData;
use backend\modules\user\entities\Passport;
use backend\modules\user\forms\PasswordForm;
use backend\modules\user\forms\UserEditForm;
use backend\modules\dispatch\entities\Subscriber;
use backend\modules\user\repository\AuthRepository;
use backend\modules\user\repository\UserRepository;
use backend\modules\user\events\UserSignUpRequested;
use backend\modules\user\events\UserSignUpByNetwork;
use backend\modules\filemanager\models\Mediafile;
use backend\modules\user\repository\MediaRepository;
use backend\modules\user\repository\PassportRepository;
use backend\modules\user\repository\IntPassportRepository;
use backend\modules\user\repository\SmartMailingRepository;
use backend\modules\dispatch\repository\SubscriberRepository;
use backend\modules\user\repository\PassportAssignmentRepository;

class UserService
{
    private $user_repository;
    private $auth_repository;
    private $smart_repository;
    private $media_repository;
    private $passport_repository;
    private $subscriber_repository;
    private $passport_int_repository;
    private $passport_assignment_repository;
    /**
     * @var RbacService
     */
    private $rbacService;

    public function __construct(UserRepository $user,
                                PassportRepository $passport,
                                IntPassportRepository $passport_int,
                                AuthRepository $auth_rep,
                                SubscriberRepository $subscriber_rep,
                                SmartMailingRepository $smart_rep,
                                MediaRepository $media_rep,
                                RbacService $rbacService,
                                PassportAssignmentRepository $passport_assignment)
    {
        $this->user_repository = $user;
        $this->auth_repository = $auth_rep;
        $this->smart_repository = $smart_rep;
        $this->media_repository = $media_rep;
        $this->passport_repository = $passport;
        $this->passport_int_repository = $passport_int;
        $this->subscriber_repository = $subscriber_rep;
        $this->passport_assignment_repository = $passport_assignment;
        $this->rbacService = $rbacService;
    }

    /**
     * создаем пользователя при регистрации
     * @param SignupForm $form
     * @return User
     * @throws \Exception
     */
    public function createByRegistration(SignupForm $form) : User
    {
        $user = User::create(
            $form->email,
            $form->phone,
            $form->password,
            true
        );
        $passport = Passport::createSignup(
            $form->passport->first_name,
            $form->passport->last_name
        );
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            //сохраняем паспортный данные
            $this->passport_repository->save($passport);
            //сохраняем пользователя
            $user_save = $this->user_repository->save($user);
            //привязываем к пользоователю паспорт
            $this->assignmentPassportId($user->id,$passport->id);
            //привязываем роль
            $this->rbacService->assignmentRole(User::USER_ROLE,$user->id);
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }

        $user_save->recordEvent(new UserSignUpConfirm($user,$passport));

        return $user;
    }

    public function create($form,$flag=null)
    {
        $user = User::create(
            $form->email,
            $form->phone,
            $form->password
        );

        /*
         * если в флаге приходит true,
         * что происходит при регистрации,
         * то в паспорт созраняеться только имя и фамилия
         * */
        if($form->role != 'user'){
            $passport = Passport::createSignup(
                $form->passport->first_name,
                $form->passport->last_name
            );
        } else {
            $passport =  Passport::create(
                $form->passport->first_name,
                $form->passport->last_name,
                $form->passport->patronymic,
                $this->isData($form->passport->birthday),
                $form->passport->series,
                $form->passport->number,
                $form->passport->issued,
                $this->isData($form->passport->issued_date)
            );
        }
        //обернуто в транзакцию
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $this->passport_repository->save($passport);
            $user_save = $this->user_repository->save($user);
            $this->assignmentPassportId($user->id,$passport->id);
            $this->rbacService->assignmentRole($form->role,$user->id);
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }

//        $user_save->recordEvent(new UserSignUpRequested($user,$passport,$form->password));
        return $user;
    }

    public function edit(UserForm $form,$user_id)
    {
        $user = $this->user_repository->get($user_id);

        $user->edit(
            $form->email,
            $form->phone,
            $form->password
        );

        $passport = $user->passport;
        $passport->edit(
            $form->passport->first_name,
            $form->passport->last_name,
            $form->passport->patronymic,
            $this->isData($form->passport->birthday),
            $form->passport->series,
            $form->passport->number,
            $form->passport->issued,
            $this->isData($form->passport->issued_date)
        );
        //обернуто в транзакцию
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $this->user_repository->save($user);
            $this->passport_repository->save($passport);
            $this->rbacService->removeRoleForUser($user->id);
            $this->rbacService->assignmentRole($form->role,$user->id);
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }

        if(!empty($form->password)){
            $user->recordEvent(new UserNewPassword($user,$form->password));
        }

        return $user;
    }

    public function confirmSignUp(string $token)
    {
        /** @var $user User*/
        $user = $this->user_repository->getByConfirmToken($token);
        if(!$user){
            return false;
        }
        $user->confirm();
        $this->user_repository->save($user);
        $user->recordEvent(new UserSignUpRequested($user,$user->passport));
        return $user;
    }

    /**
     * регистрация через Google
     * @param $attributes
     * @param ImageData $image_data
     * @return User
     * @throws \Exception
     */
    public function authGoogle($attributes, ImageData $image_data)
    {
        $password = \Yii::$app->security->generateRandomString(8);

        $image = Mediafile::create($image_data);

        $user = User::createByNetwork(
            $attributes['email'],
            $password
        );
        $passport = Passport::createSignup(
            $attributes['given_name'],
            $attributes['family_name']
        );

        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $this->media_repository->save($image);
            $this->passport_repository->save($passport);
            $user_save = $this->user_repository->save($user);

            $auth = Auth::create(
                $user->id,
                'google',
                (string) $attributes['id']
            );
            $this->auth_repository->save($auth);

            $this->assignmentPassportId($user->id,$passport->id);
            $this->setAvatar($user->id,$image->id);
            $this->rbacService->assignmentRole('user',$user->id);
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
        $user->recordEvent(new UserSignUpByNetwork($user,$passport,$password,'google'));
        return $user;
    }


    /**
     * регистрация через Facebook
     * @param FbType $type
     * @return User
     * @throws \Exception
     */
    public function authFacebook(FbType $type)
    {
        $password = \Yii::$app->security->generateRandomString(8);

        $user = User::createByNetwork(
            $type->email,
            $password
        );
        $passport = Passport::createSignup(
            $type->firstName,
            $type->lastName
        );

        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $this->passport_repository->save($passport);
            $user_save = $this->user_repository->save($user);

            $auth = Auth::create(
                $user->id,
                $type->source,
                $type->fbId
            );
            $this->auth_repository->save($auth);

            $this->assignmentPassportId($user->id,$passport->id);
            $this->rbacService->assignmentRole('user',$user->id);
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
        $user->recordEvent(new UserSignUpByNetwork($user,$passport,$password,$type->source));
        return $user;
    }

    public function addAuthNetwork($user_id,$source,$source_id)
    {
        $auth = Auth::create(
            $user_id,
            $source,
            $source_id
            );
        $this->auth_repository->save($auth);
    }

    public function editUser(UserEditForm $form,$user_id)
    {
        $user = $this->user_repository->get($user_id);
        $user->edit(
            $form->email,
            $form->phone
        );
        $this->user_repository->save($user);
    }

    public function changePassword(PasswordForm $form)
    {
        $user = $this->user_repository->get($form->userId);
        $user->changePassword($form->password_new);
        $this->user_repository->save($user);
    }

    public function setAvatar($user_id,$media_id)
    {
        $user = $this->user_repository->get($user_id);
        $user->setAvatar($media_id);
        $this->user_repository->save($user);
    }

    public function remove($user_id):void
    {
        $user = $this->user_repository->get($user_id);
        $passport = $this->passport_repository->get($user->passport_id);
        $passport_int_ids = $this->passport_assignment_repository->getAllId($user_id);
        $subscriber = $this->subscriber_repository->getByUserId($user_id);

        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $this->user_repository->remove($user);
            $this->passport_repository->remove($passport);
            $this->passport_int_repository->removeAll($passport_int_ids);
            $this->smart_repository->removeAll($user_id);
            $this->rbacService->removeRoleForUser($user->id);
            if($subscriber){
                $this->subscriber_repository->remove($subscriber);
            }

            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    //привязывает id-паспорта к пользователю
    public function assignmentPassportId($user_id,$passport_id):void
    {
        $user = $this->user_repository->get($user_id);
        $user->passport_id = $passport_id;
        $this->user_repository->save($user);
    }

    public function verifyToggle($status,$name)
    {
        $settings = Settings::findOne(['name' => $name]);
        $settings->body = $status;
        if(!$settings->update()){
            throw  new \DomainException('Ошибка обновления статуса.');
        }
    }

    public function dispatchToggle($user_id,$check)
    {
        $user = $this->user_repository->get($user_id);
        $user->dispatchToggle($check);

        if(!$subscriber = $this->subscriber_repository->getByUserId($user->id)){
            $subscriber = Subscriber::create($user->id,$user->email,$check);
        }
        $subscriber->status($check);

        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $this->subscriber_repository->save($subscriber);
            $this->user_repository->save($user);

            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    //проверяет данные
    private function isData($data)
    {
        return (isset($data) && !(empty($data)) && $data !== null)?$data:0;
    }
}