<?php

namespace backend\modules\menuBuilder\models;

use Yii;
use paulzi\adjacencyList\AdjacencyListBehavior;
use backend\modules\filter\models\Filter;
use yii\helpers\Url;

/**
 * This is the model class for table "menu_item".
 *
 * @property int $id
 * @property int $menu_id
 * @property int $parent_id
 * @property string $type
 * @property string $title
 * @property string $data
 * @property int $position
 * @property int $status
 *
 * @property Menu $menu
 */
class MenuItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'menu_item';
    }

//    public function behaviors() {
//        return [
//            [
//                'class' => AdjacencyListBehavior::className(),
//                'sortable' => [
//                    'sortAttribute' => 'position'
//                ]
//            ],
//        ];
//    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['menu_id', 'parent_id', 'type', 'title', 'position'], 'required'],
            [['menu_id', 'parent_id', 'position', 'status'], 'integer'],
            [['type', 'title', 'data'], 'string', 'max' => 255],
            [['menu_id'], 'exist', 'skipOnError' => true, 'targetClass' => Menu::className(), 'targetAttribute' => ['menu_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'menu_id' => 'Menu ID',
            'parent_id' => 'Parent ID',
            'type' => 'Type',
            'title' => 'Title',
            'data' => 'Data',
            'position' => 'Position',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenu()
    {
        return $this->hasOne(Menu::className(), ['id' => 'menu_id']);
    }

    public static function urlBy($type, $data)
    {
        $function = 'urlBy' . ucfirst($type);
        $link = self::$function($data);

        return $link;
    }

    public static function urlByRoute($data)
    {
        if (isset($data['slug']) && $data['template'] == 'tour_page') {
            $link = Url::to($data['slug'], true);
            return $link;
        }

        $route = $data['route'];
        unset($data['route']);
        unset($data['slug']);
        $data[0] = $route;
        $link = Url::to($data, true);
        return $link;
    }

    public static function urlByFilter($data){
        return Url::to('search/' . Filter::find()->select(['link'])->where(['status' => TRUE, 'alias' => $data['route']])->asArray()->one()['link'], TRUE);
    }

    public static function urlByLink($data)
    {
        return $data['link'];
    }

    public static function urlBySocial($data)
    {
        return $data['link'];
    }

    public static function getRoots(array $items)
    {
        $roots = array();

        foreach($items as $item) {
            if($item['parent_id'] == 0) {
                $roots[$item['id']] = $item;
            }
        }

        return $roots;
    }

    public static function getChildren(&$roots, $items)
    {
        foreach($items as $id =>$item) {
            if(isset($roots[$item['parent_id']])) {
                $roots[$item['parent_id']]['children'][$item['id']] = $item;
                unset($items[$id]);
            }
        }

        foreach($roots as $id => $root) {
            if(isset($root['children'])) {
                self::getChildren($roots[$id]['children'], $items);
            }
        }
    }

//    public static function getRoots($parentId = 0)
//    {
//        return self::find()
//            ->where(['parent_id' => $parentId])
//            ->asArray()
//            ->all();
//    }
//
//    public static function find()
//    {
//        return new MenuItemQuery(get_called_class());
//    }
}
