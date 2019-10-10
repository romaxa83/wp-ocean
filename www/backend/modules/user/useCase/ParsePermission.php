<?php

namespace backend\modules\user\useCase;

use Yii;
use ReflectionClass;
use yii\helpers\ArrayHelper;
use RecursiveIteratorIterator;
use backend\modules\user\entities\rbac\Role;
use Symfony\Component\Finder\Iterator\RecursiveDirectoryIterator;

class ParsePermission
{
    private $beginAnnotation = '@perm';

    private $allActions = 0;

    /**
     * Запускает парсер
     * возвращает кол-во записаных разрешений
     * либо false если их не было
     * @return bool|int
     */
    public function start()
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
        //записываем в бд новые разрешения
        if(!empty($allPermission)){
            $newPermission = $this->newPermission($allPermission);

            if (!empty($newPermission)){
                $result =  $this->savePermission($this->super_unique($newPermission));

                return $result;
            }
            return false;
        }
        return false;
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
}