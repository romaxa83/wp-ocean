<?php


namespace backend\modules\menuBuilder\controllers;


use backend\modules\menuBuilder\models\Menu;
use backend\modules\menuBuilder\models\MenuItem;
use backend\modules\user\useCase\Access;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\db\Exception;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

class MenuItemController extends Controller
{
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'store' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index','store'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    protected $access;

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->access = new Access();
    }

    /**
     * List of items for dedicated menu
     *
     * @perm('Список элементов меню (редактор меню)')
     *
     * @param $menuId
     * @return string
     * @throws ForbiddenHttpException
     */
    public function actionIndex($menuId)
    {
        $this->access->accessAction();
        Yii::$app->assetManager->bundles = [
            'backend\assets\JqueryUIAsset' => false,
        ];

        $menu = Menu::find()
            ->where(['id' => $menuId])
            ->with(['menuItems' => function(ActiveQuery $query) {
                $query->andWhere('parent_id = 0')->orderBy('position');
            }])
            ->asArray()
            ->one();


        return $this->render('index', [
            'menu' => $menu,
        ]);
    }

    /**
     * Update structure of dedicated menu
     *
     * @perm('Обновление структуры меню (редактор меню)')
     *
     * @return false|string
     * @throws ForbiddenHttpException
     * @throws Exception
     */
    public function actionStore()
    {
        $this->access->accessAction();
        $itemsForDelete = Yii::$app->request->post('itemsForDelete');

        $this->deleteItems($itemsForDelete);

        $json = Yii::$app->request->post('items');
        $items = json_decode($json);

        $this->updateOrCreateItems($items);

        return json_encode(array(
            'success' => true
        ));
    }

    /**
     * @param array $itemsForDelete
     * @throws Exception
     */
    protected function deleteItems($itemsForDelete)
    {
        if (!empty($itemsForDelete)) {
            Yii::$app->db->createCommand()
                ->delete('menu_item', ['id' => $itemsForDelete])
                ->execute();
        }
    }

    /**
     * @param $items
     * @throws Exception
     */
    protected function updateOrCreateItems($items)
    {
        $newItems = array();
        $updatedItems = array();

        $this->divideItems($items, $newItems, $updatedItems);

        $itemsForInsert = array();
        $itemsForUpdate = array();

        foreach($newItems as $item) {
            if(isset($item->children)) {
                $rootItem = new MenuItem();
                $rootItem->attributes = array(
                    'parent_id' => 0,
                    'menu_id' => $item->menu_id,
                    'type' => $item->type,
                    'title' => $item->title,
                    'data' => json_encode($item->data),
                    'position' => $item->position,
                    'status' => $item->status
                );
                $rootItem->save();
                foreach($item->children as $childItem) {
                    $childItem->parent_id = $rootItem->id;
                    if($childItem->id != 0) {
                        $updatedItems[] = $childItem;
                    }
                    else {
                        $itemsForInsert[] = array(
                            'parent_id' => $childItem->parent_id,
                            'menu_id' => $childItem->menu_id,
                            'type' => $childItem->type,
                            'title' => $childItem->title,
                            'data' => json_encode($childItem->data),
                            'position' => $childItem->position,
                            'status' => $childItem->status
                        );
                    }
                }
            }
            else {
                $itemsForInsert[] = array(
                    'parent_id' => $item->parent_id,
                    'menu_id' => $item->menu_id,
                    'type' => $item->type,
                    'title' => $item->title,
                    'data' => json_encode($item->data),
                    'position' => $item->position,
                    'status' => $item->status
                );
            }
        }

        foreach($updatedItems as $item) {
            $itemsForUpdate['parent_id'][] = "WHEN id = {$item->id} THEN '{$item->parent_id}'";
            $itemsForUpdate['title'][] = "WHEN id = {$item->id} THEN '{$item->title}'";
            $itemsForUpdate['data'][] = "WHEN id = {$item->id} THEN '" . json_encode($item->data) . "'";
            $itemsForUpdate['position'][] = "WHEN id = {$item->id} THEN {$item->position}";
            $itemsForUpdate['status'][] = "WHEN id = {$item->id} THEN {$item->status}";
        }

        if (!empty($itemsForInsert)) {
            $columns = array('parent_id', 'menu_id', 'type', 'title', 'data', 'position', 'status');
            Yii::$app->db->createCommand()->batchInsert('menu_item', $columns, $itemsForInsert)->execute();
        }

        if (!empty($itemsForUpdate)) {
            Yii::$app->db->createCommand("UPDATE menu_item SET "
                . "parent_id = CASE " . implode(' ', $itemsForUpdate['parent_id']) . " ELSE parent_id END, "
                . "title = CASE " . implode(' ', $itemsForUpdate['title']) . " ELSE title END, "
                . "data = CASE " . implode(' ', $itemsForUpdate['data']) . " ELSE data END, "
                . "position = CASE " . implode(' ', $itemsForUpdate['position']) . " ELSE position END, "
                . "status = CASE " . implode(' ', $itemsForUpdate['status']) . " ELSE status END;"
            )->execute();
        }
    }

    /**
     * @param $items
     * @param array $newItems
     * @param array $updatedItems
     */
    protected function divideItems($items, array &$newItems, array &$updatedItems)
    {
        foreach ($items as $item) {
            if ($item->id == 0) {
                $newItems[] = $item;
            } else {
                $updatedItems[] = $item;

                if(isset($item->children)) {
                    $this->divideItems($item->children, $newItems, $updatedItems);
                }
            }
        }
    }
}