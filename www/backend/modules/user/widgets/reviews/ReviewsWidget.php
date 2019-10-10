<?php

namespace backend\modules\user\widgets\reviews;

use backend\modules\user\entities\Reviews;
use common\models\User;
use yii\base\Widget;
use backend\modules\user\forms\ReviewsForm;
use backend\modules\user\repository\UserRepository;

class ReviewsWidget extends Widget
{
    /*
     * template указывает какая форма будет подгружена
     */
    public $template;
    public $user_id;
    public $hotel_id;

    public function init()
    {
        parent::init();

        \Yii::setAlias('@reviews-widget-assets',  \Yii::getAlias('@backend').'/modules/user/widgets/reviews/assets');

        ReviewsWidgetAsset::register(\Yii::$app->view);
    }

    public function run()
    {
        $file = __DIR__ . '/views/' . $this->template . '.php';
        if (!file_exists($file)) {
            return 'Неверно задан параметр $template';
        }

        /* рендерит отзывы на главной странице */
        if($this->template == 'frontend-reviews'){
            return $this->render($this->template,[
                'reviews' => $this->getReviews()
            ]);
        }

        if(empty($this->user_id)){
            throw new \DomainException('Неуказан id пользователя');
        }

        if(empty($this->hotel_id)){
            throw new \DomainException('Неуказан id отеля');
        }

        return $this->render($this->template,[
            'model' => new ReviewsForm(),
            'user' => $this->getUser($this->user_id),
            'hotel_id' => $this->hotel_id,
        ]);

    }

    private function getUser($id) : User
    {
        return User::findOne($id);
    }

    private function getReviews()
    {
        return Reviews::find()
            ->where(['status' => Reviews::STATUS_ACTIVE])
            ->orderBy(['created_at' => SORT_DESC])
            ->limit(8)
            ->all();
    }
}
