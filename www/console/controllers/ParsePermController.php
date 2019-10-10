<?php

namespace console\controllers;

use Yii;
use ReflectionClass;
use yii\helpers\Console;
use yii\console\Controller;
use yii\helpers\ArrayHelper;
use RecursiveIteratorIterator;
use backend\modules\user\entities\rbac\Role;
use Symfony\Component\Finder\Iterator\RecursiveDirectoryIterator;

/**
 * Парсит action для создания разрешений.
 */
class ParsePermController extends Controller
{

    private $beginAnnotation = '@perm';

    private $allActions = 0;

    /**
     * Запускает парсер.
     * @package app\commands
     */
    public function actionStart()
    {
        $modulePath = Yii::getAlias('@backendModule');
        $iter = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($modulePath, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST,
            RecursiveIteratorIterator::CATCH_GET_CHILD // Ignore "Permission denied" (>>на которую у него нет прав на чтение)
        );
        //записуем пути всех контроллеров
        $paths = [];
        foreach ($iter as $path => $dir) {
            if (strstr($dir->getFilename(),'Controller')) {
                $paths[] = $path;
            }
        }

        $this->infoController($paths);

        //получаем данные с методов с нужной аннотацией
        $allPermission = [];
        foreach ($paths as $path){
            $reflection = new ReflectionClass($this->nameClass($path));
            $methods = $reflection->getMethods( \ReflectionMethod::IS_PUBLIC);
            $permMethods = $this->getMethodsForPerm($methods);
            if(is_array($permMethods) && !empty($permMethods)){
                foreach ($permMethods as $permMethod){
                    $allPermission [] = $permMethod;
                }
            }
        }
        $this->stdout('Найдено всего ('.$this->allActions.') actions' . PHP_EOL,Console::FG_GREEN);
        $this->infoMethod($allPermission);

        //записываем в бд новые разрешения
        if(!empty($allPermission)){
            $newPermission = $this->newPermission($allPermission);
            $this->infoNewMethod($newPermission);
            if (!empty($newPermission)){
                $this->stdout('Загрузка новых разрешений' . PHP_EOL,Console::FG_GREEN);

                $result =  $this->savePermission($this->super_unique($newPermission));
                $this->infoSave(count($newPermission),$result);

                return $result;
            }
        }
    }

    /**
     * Очищает бд от разрешений.
     * @package app\commands
     */
    public function actionClear()
    {
        Role::deleteAll(['type' => Role::PERMISSION]);
        $this->stdout('Корзиночка пуста ¯\_(ツ)_/¯' . PHP_EOL,Console::FG_YELLOW);
    }

    /*
     * из абсолютного пути к контроллеру
     * получаем нужный путь для ReflectionClass
     */
    private function nameClass($str)
    {
        $arr = [];
        $flag = false;

        foreach (explode('/',$str)as $item){
            if($item === 'backend'){
                $flag = true;
            }
            if($flag){
               $arr[] = pathinfo($item, PATHINFO_FILENAME);
            }
        }
        return implode('\\',$arr);
    }

    /**
     * получает массив методов класса
     * возвращает данные только с тех методов у которых есть соответствующая аннотация
     * формат возвращаемых данных
     * array = [
     *      .....
     *          [
     *          'name' => user/user/create             // формат - module/controller/action
     *          'description' => 'Создание пользователя'       //описание действий
     *      ]
     *      .....
     * ]
     *
     */
    private function getMethodsForPerm(array $methods)
    {
        if(is_array($methods) && !empty($methods)){
            //получаем методы с префиксом action
            $actionMethods = [];
            $result = [];
            foreach ($methods as $method){
                if(strstr($method->name,'action')){
                    $actionMethods[] = $method;
                }
            }
            $this->allActions += count($actionMethods);
            //проверяем методы у которых есть аннотация
            if(!empty($actionMethods)){
                foreach ($actionMethods as $method){
                    if ($doc = $method->getDocComment()){
                        //проверяем наличие аннотации формата @perm(.......)
                        if(preg_match('/'.$this->beginAnnotation.'(.*)/',$doc,$matches)){
                            $result[] = $this->createData($matches[1],$method);
                        }
                    }
                }
            }
            return $result;
        }
    }

    /*
     * формируем массив для каждого метода
     */
    private function createData($desc,$method)
    {
        // обрезаем по два символа с начала и конца и получаем описание
        $description = substr(substr($desc,2),0,-2);
        // получаем action
        $action = lcfirst(str_replace('action','',$method->name));

        $countModule = 0;
        $arr = explode('\\',$method->class);

        foreach ($arr as $id => $item){
            if($item === 'modules'){
                $countModule = $id + 1;
            }
        }
        // получаем модуль
        $module = $arr[$countModule];
        // получаем контроллер
        $controller = lcfirst(str_replace('Controller','',end($arr))) ;

        return [
            'name' => $module.'/'.$controller.'/'.$action,
            'description' => $description
        ];
    }

    /*
     * удаляем те данные которые уже есть в бд
     */
    private function newPermission($allPermissions)
    {
        $dbPermission = ArrayHelper::index(Role::find()
            ->select(['name','description'])
            ->where(['type' => Role::PERMISSION])
            ->asArray()->all(),'name') ;

        if($dbPermission){
            foreach ($allPermissions as $id => $permission){
                if(array_key_exists($permission['name'],$dbPermission)){
                    unset($allPermissions[$id]);
                }
            }
        }
        return $allPermissions;
    }

    /*
     * сохраняет разрешения в бд
     */
    private function savePermission($arrayPermission)
    {
        return \Yii::$app->db->createCommand()->batchInsert(
            'auth_item',['name','type','description','created_at','updated_at'],
            array_map(function($item) {
                return [
                    'name' => $item['name'],
                    'type' => 2,
                    'description' => $item['description'],
                    'created_at' => time(),
                    'updated_at' => time(),
                ];
            },$arrayPermission)
        )->execute();
    }

    /**
     * фильтрует дублирующие массивы
     * @param $array
     * @return array
     */
    private function super_unique($array)
    {
        $result = array_map("unserialize", array_unique(array_map("serialize", $array)));
        foreach ($result as $key => $value) {
            if ( is_array($value) ) {
                $result[$key] = $value;
            }
        }
        return $result;
    }

    private function infoController($array)
    {
        if(empty($array)){
            return $this->stdout('Не найдены контроллеры' . PHP_EOL,Console::FG_RED);
        }
        $this->stdout('Найдено ('.count($array).') контроллеров' . PHP_EOL,Console::FG_GREEN);
    }

    private function infoMethod($array)
    {
        if(empty($array)){
            return $this->stdout('Не найдено методов с нужно аннотацией' . PHP_EOL,Console::FG_RED);
        }
        $this->stdout('Найдено ('.count($array).') методов с аннотацией '.$this->beginAnnotation . PHP_EOL,Console::FG_GREEN);
    }

    private function infoNewMethod($array)
    {
        if(empty($array)){
            return $this->stdout('Новых разрешений не найдено' . PHP_EOL,Console::FG_YELLOW);
        }
        $this->stdout('Найдено ('.count($array).') новых разрешений' . PHP_EOL,Console::FG_GREEN);
    }

    private function infoSave($countNewPermission,$countSave)
    {
        $this->stdout('|',Console::FG_GREEN);

        for($i = 0;$i<$countSave;$i++){
            $this->stdout('=',Console::FG_GREEN);
            usleep(100000);
        }

        $this->stdout('>' . PHP_EOL,Console::FG_GREEN);
        $this->stdout('Загруженно ('.$countSave.'/'.$countNewPermission.')'. "\u{1F4AA}" . PHP_EOL,Console::FG_GREEN);

        if($countSave != $countNewPermission){
            $duplicate = (int)$countNewPermission - (int)$countSave;
            $this->stdout('В загрузке оказалось ('.$duplicate.') дубликатов'. PHP_EOL,Console::FG_YELLOW);
        }
    }
}