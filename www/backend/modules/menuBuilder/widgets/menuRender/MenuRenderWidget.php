<?php


namespace backend\modules\menuBuilder\widgets\menuRender;


use backend\modules\menuBuilder\models\Menu;
use backend\modules\menuBuilder\widgets\menuRenderGroup\MenuRenderGroupWidget;
use Yii;
use yii\base\Widget;

class MenuRenderWidget extends Widget
{
    public $name;
    public $options = array();
    public $currentUrl;

    public function init()
    {
        parent::init();

        $this->currentUrl = Yii::$app->request->url;
    }

    public function run()
    {
        $container = isset($this->options['container']) ? $this->options['container'] : 'nav';
        $class = isset($this->options['class']) ? "class='{$this->options['class']}'" : '';

        $response = "<{$container} {$class} itemscope itemtype=\"http://schema.org/SiteNavigationElement\">";

        $menu = Menu::prepareMenu($this->name);

        foreach($menu as $group) {
            $data = json_decode($group['data'], true);

            if($group['type'] == 'group') {
                $response .= MenuRenderGroupWidget::widget([
                    'template' => $data['template'],
                    'group' => $group
                ]);
            }
            else {
                $response .= $this->render('item', [
                    'group' => $group,
                    'currentUrl' => $this->currentUrl
                ]);
            }
        }

        $response .= "</{$container}>";

        return $response;
    }
}
