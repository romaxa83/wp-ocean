<?php

namespace backend\modules\user\useCase;

use Yii;
use Exception;
use common\models\User;
use yii\web\ForbiddenHttpException;
use backend\modules\user\entities\rbac\Role;
use backend\modules\user\entities\rbac\PermissionForRole;

/**
 * Метод проверяет разрешения у ролей для определеных действий
 * в перед action нужно установить аннотацию такого вида
 * @perm('Изменить статус публикации поста (блог)')
 * в скобках указываеться группа к которой относиться разрешение
 * по которым оно будет сформировано при выводе,
 * группу можно не указывать ,тогда разрешение попадет в группу "без группы"
 * После запустить консольный скрипт - php yii parse-perm/start
 * Чтоб перекрыть action в контролере
 *      1) - в конструкторе инициализируем обьект $this->access = new Access();
 *      2) - в начале каждого action вставляем - $this->access->accessAction();
 * Чтоб прекрыть действие в представлении
 *      1) - создаем обьект new Access();
 *      2) - действие оборачивеам в консрукцию if,в условии которого
 *          вызываем метод accessInView() - предавая туда
 *          либо путь к action (в формате модуль/контролер/action,испоьзуется camelCase),
 *          либо Url:to(['create]) - урл к action
 * Чтобы закрыть меню с под-категориями
 *      1) - используеться метод accessForMenu(),который принимает название модуль
 *
 * админ не подподает по разрешения(у него полный доступ ко всему)
 */
class Access
{

    /**
     * используеться во view
     * @param $actionRoute
     * @return bool
     */
    public function accessInView($actionRoute)
    {
        $permName = $actionRoute;
        //убираем в начале пути /admin ,если он есть
        if(strstr($actionRoute,'admin')){
            $permName = str_replace('admin','',$actionRoute);
        }
        // убираем параметры
        if($params = strstr($actionRoute,'?')){
            $permName = str_replace($params,'',$permName);
        }
        // убираем дефис
        $permName = $this->deleteDash($permName);
        // убираем слеш в начале
        $permName = $this->deleteFirstSlash($permName);

        // проверяем на существование данного разрешения
        if(!$this->existPerm($permName)){
            return true;
        }

        if($this->isAdmin()){
            return true;
        }

        if(!Yii::$app->user->can($permName)){
            return false;
        }
        return true;
    }

    /**
     * используеться в контролере
     * @throws Exception
     * @throws ForbiddenHttpException
     */
    public function accessAction()
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
            if($this->isAdmin()){
                return true;
            }
            if(!Yii::$app->user->can($permName)){
                throw new ForbiddenHttpException('У вас недостаточно прав для выполнения указанного действия');
            }
            return true;
        }
        throw new Exception('Нет данных');
    }

    /**
     * проверка для меню
     * @param $module
     * @return bool
     */
    public function accessForMenu($module)
    {
        if ($this->isAdmin()){
            return true;
        }
        if(!$this->existPermFormModule($module)){
            return true;
        }
        /** @var $user User*/
        $user = Yii::$app->user->identity;
        $role = $user->getRoles();

        if(strpos($role,',')){
            $role = explode(',',$role);
        }

        $perm = PermissionForRole::find()
            ->where(['in','parent',$role])
            ->andWhere(['like','child',$module.'%',false])
            ->exists();
//        $query = "SELECT * FROM `auth_item_child` WHERE parent IN('".$role."') AND `child` LIKE '".$module."%'"
//        $result = PermissionForRole::findBySql($query)->all();
        if($perm){
            return true;
        }
        return false;
    }

    /**
     * проверяет существование разрешения
     * @param $permName
     * @return bool
     */
    private function existPerm($permName)
    {
        return Role::find()
            ->where(['type' => Role::PERMISSION])
            ->andWhere(['name' => $permName])
            ->exists();
    }

    /**
     * проверяет существование разрешения на модуль
     * @param $permName
     * @return bool
     */
    private function existPermFormModule($module)
    {
        return Role::find()
            ->where(['type' => Role::PERMISSION])
            ->andWhere(['like','name',$module])
            ->exists();
    }

    /**
     * проверка пользователя на админа
     * @return bool
     */
    private function isAdmin()
    {
        /** @var $user User*/
        $user = Yii::$app->user->identity;

        return $user->getRole() === 'admin'? true : false;
    }

    /**
     * варезаем дефис в словах преобразуя в camelCase
     * @param $str
     * @return mixed
     */
    private function deleteDash($str)
    {
        if($pos = strpos($str,'-')){
            $word = mb_strtoupper($str[$pos+1]);
            $str = substr_replace($str,$word,$pos+1,1);
            $str = substr_replace($str,'',$pos,1);

            return self::deleteDash($str);
        }
        return $str;
    }

    /**
     * удаляем слеш с начала строки
     * @param $str
     * @return bool|string
     */
    private function deleteFirstSlash($str)
    {
        $firstSymbol = substr($str,0,1);
        if($firstSymbol == '/'){
            $str = substr($str,1);

            return self::deleteFirstSlash($str);
        }
        return $str;
    }
}