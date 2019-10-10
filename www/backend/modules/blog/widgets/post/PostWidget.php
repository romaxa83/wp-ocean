<?php

namespace backend\modules\blog\widgets\post;

use backend\modules\blog\entities\Post;
use backend\modules\blog\repository\PostRepository;
use yii\base\Widget;
use yii\db\Expression;

class PostWidget extends Widget
{
    public $template;

    private $data;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $view = $this->template;

        switch ($this->template) {
            case 'popular':
                $this->data = $this->getPostMainPaige();
                break;

            default:
                throw new \DomainException('Неверно указан template,либо его не существует');
        }

        return $this->render($view,[
            'data' => $this->data
        ]);
    }

    private function getPostMainPaige()
    {
        $static_posts = Post::find()->where(['is_main' => Post::ON_MAIN_PAGE])->andWhere(['position' => 1])->limit(1)->all();
        $random_posts = Post::find()->where(['is_main' => Post::ON_MAIN_PAGE])->andWhere(['!=', 'position', 1])->orderBy(new Expression('rand()'))->limit(3)->all();
        $posts = array_merge($static_posts, $random_posts);
        if(count($posts) == 4){
            return $posts;
        }
        return false;
    }

}
