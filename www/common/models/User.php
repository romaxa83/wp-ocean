<?php
namespace common\models;

use backend\modules\filemanager\models\Mediafile;
use backend\modules\user\entities\AggregateRoot;
use backend\modules\user\entities\IntPassport;
use backend\modules\user\entities\PassportAssignment;
use backend\modules\user\entities\rbac\RoleAssignment;
use backend\modules\user\events\EventTrait;
use backend\modules\user\events\UserSignUpByNetwork;
use backend\modules\user\events\UserSignUpRequested;
use backend\modules\user\helpers\RolesHelper;
use kartik\form\ActiveForm;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use backend\modules\user\entities\Passport;
use backend\modules\users\roles\models\AuthAssignment;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property integer $passport_id
 * @property integer $passport_int_id
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $phone
 * @property string $auth_key
 * @property integer $status
 * @property integer $dispatch
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $settings
 * @property integer $media_id
 * @property string $password write-only password
 * @property string $confirm_token
 */
class User extends ActiveRecord implements IdentityInterface,AggregateRoot
{
    use EventTrait;

    const STATUS_DRAFT = 0;
    const STATUS_ACTIVE = 10;

    const USER_ROLE = 'user';

    public $old_password;
    public $new_password;
    public $new_password_repeat;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'email' => 'Email',
            'phone' => 'Телефон',
            'password_hash' => 'Пароль',
            'created_at' => 'Дата регистрации',
            'updated_at' => 'Время обновления',
            'roleName' => 'Роль',
            'old_password' => 'Старый пароль',
            'new_password' => 'Новый пароль',
            'new_password_repeat' => 'Потвержедния нового товара',
            'confidentiality' => 'Условия и политика конфиденциальности',
            'settings' => 'Настройки',
            'role' => 'Роль'
        ];
    }

    public static function create(
        $email,
        $phone,
        $password,
        $flagConfirm = false
        ) : self
    {
        $user = new static();
        $user->email = $email;
        $user->phone = $phone;
        $user->setPassword($password);
        $user->generateAuthKey();
        $user->confirm_token = $flagConfirm ? Yii::$app->security->generateRandomString() . '_' . time():null;
        $user->status = $flagConfirm ? self::STATUS_DRAFT : self::STATUS_ACTIVE;
        $user->created_at = time();
        $user->updated_at = time();
//        $user->recordEvent(new UserSignUpRequested($user,$password));

        return $user;
    }

    public static function createByNetwork(
        $email,
        $password
    ) : self
    {
        $user = new static();
        $user->email = $email;
        $user->setPassword($password);
        $user->generateAuthKey();
        $user->status = self::STATUS_ACTIVE;
        $user->created_at = time();
        $user->updated_at = time();

        return $user;
    }

    public function edit($email,$phone,$password = null):void
    {
        $this->email = $email;
        $this->phone = $phone;
        if($password){
            $this->setPassword($password);
        }
        $this->updated_at = time();
    }

    public function changePassword($password):void
    {
        $this->setPassword($password);
        $this->updated_at = time();
    }

    public function dispatchToggle($check):void
    {
        $this->dispatch = (bool)$check;
        $this->updated_at = time();
    }

    public function setAvatar($media_id)
    {
        $this->media_id = $media_id;
        $this->updated_at = time();
    }

    public function confirm()
    {
        $this->status = self::STATUS_ACTIVE;
        $this->confirm_token = null;
        $this->updated_at = time();
    }


    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token,$type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email,$user_id = null)
    {
        if($user_id){
             return User::find()->where(['email' => $email, 'status' => self::STATUS_ACTIVE])
                ->andWhere(['not',['id' => $user_id]])->one();
        } else {

            return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
        }
    }

    public static function findByPhone($phone,$user_id = null)
    {
        if($user_id){
            return User::find()->where(['phone' => $phone, 'status' => self::STATUS_ACTIVE])
                ->andWhere(['not',['id' => $user_id]])->one();
        } else {

            return static::findOne(['phone' => $phone, 'status' => self::STATUS_ACTIVE]);
        }
    }

    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }
        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Generates new confirm token
     */
    public function generateConfirmToken()
    {
        return Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function getDispatch()
    {
        return $this->dispatch;
    }

    public function getFullName()
    {
        if($this->passport->last_name !== null){

            return ucfirst($this->passport->first_name) .' '.ucfirst($this->passport->last_name);
        }
        return ucfirst($this->passport->first_name);
    }

    public function getRole()
    {
        return (\Yii::$app->authManager->getRolesByUser($this->id)[$this->roleReletion->item_name])->name;
    }

    public function getRoles()
    {
        if(count(\Yii::$app->authManager->getRolesByUser($this->id)) > 1){
            return RolesHelper::getDataFromAuthManager(\Yii::$app->authManager->getRolesByUser($this->id),'name',true);
        }
        return $this->getRole();
    }

    public function getRoleDescription()
    {
        return (\Yii::$app->authManager->getRolesByUser($this->id)[$this->roleReletion->item_name])->description;
    }

    public function getRolesDescription()
    {
        if(count(\Yii::$app->authManager->getRolesByUser($this->id)) > 1){
            return RolesHelper::getDataFromAuthManager(\Yii::$app->authManager->getRolesByUser($this->id),'description',true);
        }
        return $this->getRoleDescription();
    }

    public function getRoleName() {

        if (isset($this->role->item_name)){
            return $this->role->item_name;
        }else{
            return 'Нет роли';
        }
    }

    public function validatePhone($attribute, $params)
    {
        if (strlen(preg_replace("/[^0-9]/", '', $this->phone)) != 12){
            $this->addError($attribute, 'Введите корректно номер телефона (380*********)');
        }
    }

    public function isAdmin()
    {
        return $this->username === 'admin';
    }

    //Relation
    public function getPassport(): ActiveQuery
    {
        return $this->hasOne(Passport::class, ['id' => 'passport_id']);
    }

    public function getPassportAssignments(): ActiveQuery
    {
        return $this->hasMany(PassportAssignment::class, ['user_id' => 'id']);
    }

    public function getIntPassports(): ActiveQuery
    {
        return $this->hasMany(IntPassport::class, ['id' => 'passport_int_id'])->via('passportAssignments');
    }

    public function getMedia() : ActiveQuery
    {
        return $this->hasOne(Mediafile::class,['id' => 'media_id']);
    }

    public function getRoleReletion() : ActiveQuery
    {
        return $this->hasOne(RoleAssignment::class,['user_id' => 'id']);
    }

    //Settings
    public function getSettings($entity=null)
    {
        if($entity && $this->settings){
            if($this->hasEntity($entity)){

                return JSON::decode($this->settings)[$entity];
            }
            return null;
        }
        return $this->settings;
    }

    /*
     * метод добавляет настройки пользователю
     * принимает 3 параметра:
     * - сущьность (для которой будет применяться настройка ,к примеру article-для статей)
     * - тип настройки (пример hide-col - прячет колонки)
     * - значение (пример title)
     */

    public function addSetting($entity,$type,$value)
    {

        if($this->settings){
            if($this->hasEntity($entity)){
                if($this->hasType($entity,$type)){
                    $this->addValue($entity,$type,$value);
                }else{
                    $this->newSetting($entity,$type,$value);
                }
            }else{
                $this->newSetting($entity,$type,$value);
            }
        } else {
            $this->settings = JSON::encode($this->createSettings($entity,$type,$value));
        }
        $this->update();

    }

    public function removeSetting($entity,$type,$value)
    {
        $this->deleteValue($entity,$type,$value);
        $this->update();
    }

    private function createSettings($entity,$type,$value)
    {
        return [$entity => [$type => [$value]]];
    }

    //проверка наличия сущьности
    private function hasEntity($entity)
    {
        return array_key_exists($entity,JSON::decode($this->settings));
    }

    // проверка наличия типа в сущьности
    private function hasType($entity,$type)
    {
        return array_key_exists($type,JSON::decode($this->settings)[$entity]);
    }

    private function newSetting($entity,$type,$value)
    {
        $temp = JSON::decode($this->settings);
        $temp[$entity][$type][] = $value;

        return $this->settings = JSON::encode($temp);
    }

    // добавляет новое значение
    private function addValue($entity,$type,$value)
    {
        if($type == 'count-page'){
            $this->clearType($entity,$type,$value);
            $this->newSetting($entity,$type,$value);
        }
        if(!in_array($value,JSON::decode($this->settings)[$entity][$type])){
            $this->newSetting($entity,$type,$value);
        }
        return $this->settings;
    }

    private function deleteValue($entity,$type,$value)
    {
        if(in_array($value,JSON::decode($this->settings)[$entity][$type])){
            $temp = JSON::decode($this->settings);
            unset($temp[$entity][$type][array_search($value,$temp[$entity][$type])]);
            $temp[$entity][$type] = array_values($temp[$entity][$type]);
            return $this->settings = JSON::encode($temp);
        }
        return $this->settings;
    }
    private function clearType($entity,$type,$value)
    {
        $temp = JSON::decode($this->settings);
        unset($temp[$entity][$type]);
        $this->settings = JSON::encode($temp);
        $this->update();
    }
}
