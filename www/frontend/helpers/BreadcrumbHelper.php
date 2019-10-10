<?php

namespace frontend\helpers;

use backend\modules\blog\entities\Category;
use backend\modules\referenceBooks\models\Country;
use backend\modules\referenceBooks\models\Hotel;

class BreadcrumbHelper
{
    public function parseForBlog($url)
    {
        $path = parse_url($url, PHP_URL_PATH);
        $parse_path = explode('/',substr($path,1));

        if(count($parse_path) > 1
            && $parse_path[1] !== 'post'
            && $parse_path[1] !== 'tag'){
            if(isset($parse_path[2]) && preg_match('/%20/',$parse_path[2])){
                $parse_path[2] = str_replace("%20", " ", $parse_path[2]);
            }
            //если редирект идет из карточкм тура
            if($parse_path[0] === 'tour'){
                $parse_path[1] = 'hotel';
                $parse_path[2] = end($parse_path);
                //подменяем url для редиректа в хл.крошках (если переход с карточки тура)
                $path = '/blog/hotel/'.$parse_path[2];
            }
            //если редирект идет со страницы направления
            if($parse_path[0] === 'napravlenia'){

                //берем id страны из сессии,так как alias может быть некорректным
                if(\Yii::$app->session->has('current_country_id')){
                    $countryId = \Yii::$app->session->get('current_country_id');
                }

                $parse_path[1] = 'country';

                return [
                    'title' => (new TitleHelper())->getBlogTitle($parse_path[1],$this->getEntityName($parse_path[1],'',$countryId??false)),
                    'url' => $path
                ] ;
            }

            return [
                'title' => (new TitleHelper())->getBlogTitle($parse_path[1],$this->getEntityName($parse_path[1],$parse_path[2])),
                'url' => $path
            ] ;
        }
        return false;
    }

    private function getEntityName($entity, $alias,$id = false)
    {
        switch ($entity) {
            case 'category' :
                return Category::find()->select('title')->where(['alias' => $alias])->asArray()->one()['title'];
            case 'hotel':
                return Hotel::find()->select('name')->where(['alias' => $alias])->asArray()->one()['name'];
            case 'country':
                if($id){
                    return Country::find()->select('name')->where(['id' => $id])->asArray()->one()['name'];
                }
                return Country::find()->select('name')->where(['alias' => $alias])->asArray()->one()['name'];
            default:
                throw new \DomainException('По данному алиасу не найдена сущьност');
        }
    }
}