<?php

namespace backend\modules\menuBuilder\models;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "menu".
 *
 * @property int $id
 * @property string $name
 * @property string $label
 *
 * @property MenuItem[] $menuItems
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * @param array $items
     */
    protected static function sortMenuItems(array &$items)
    {
        if (is_array($items)) {
            foreach ($items as $key => $item) {
                if (isset($item['children'])) {
                    $children = $item['children'];
                    usort($children, array(Menu::className(), 'menuItemsSort'));
                    $items[$key]['children'] = $children;
                    self::sortMenuItems($items[$key]['children']);
                }
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'label'], 'required'],
            [['name'], 'string', 'max' => 25],
            [['label'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'label' => 'Подпись',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenuItems()
    {
        return $this->hasMany(MenuItem::className(), ['menu_id' => 'id']);
    }

    public static function prepareMenu($name)
    {
        $menu = self::find()
            ->where(['name' => $name])
            ->with(['menuItems' => function(ActiveQuery $query) {
                $query->indexBy('id')->asArray();
            }])
            ->asArray()
            ->one();

        $items = MenuItem::getRoots($menu['menuItems']);
        MenuItem::getChildren($items, $menu['menuItems']);

        usort($items, array(Menu::className(), 'menuItemsSort'));
        self::sortMenuItems($items);


        return $items;
    }

    static function menuItemsSort($x, $y)
    {
        if((int)$x['position'] > (int)$y['position']) {
            return true;
        } else if((int)$x['position'] < (int)$y['position']) {
            return false;
        } else {
            return 0;
        }
    }
}