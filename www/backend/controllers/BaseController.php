<?php

namespace backend\controllers;

use Yii;
use yii\base\Exception;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

class BaseController extends Controller
{

    public function access()
    {
        if((isset(debug_backtrace()[1]['function']) && !empty(debug_backtrace()[1]['function']))
            && (isset(debug_backtrace()[1]['class']) && !empty(debug_backtrace()[1]['class'])) )
        {
            if(!strstr(debug_backtrace()[1]['function'],'action')){
                throw new Exception('Не корректный action');
            }
            //получаем action
            $action = lcfirst(str_replace('action','',debug_backtrace()[1]['function']));

            $countModule = 0;
            $arr = explode('\\',debug_backtrace()[1]['class']);
            foreach ($arr as $id => $item) {
                if($item === 'modules'){
                    $countModule = $id + 1;
                }
            }
            // получаем модуль
            $module = $arr[$countModule];
            // получаем контроллер
            $controller = lcfirst(str_replace('Controller','',end($arr))) ;
            // получаем имя разрешения
            $permName = $module.'/'.$controller.'/'.$action;

            //проверяем разрешение
            if(Yii::$app->user->identity->username == null){
                if(!Yii::$app->user->can($permName)){
                    throw new ForbiddenHttpException('У вас недостаточно прав для выполнения указанного действия');
                }
                return;
            }
            return;
        }
        throw new Exception('Нет данных');
    }
}
