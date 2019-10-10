<?php

use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;
use backend\modules\referenceBooks\models\CustomActionColumn;
use backend\modules\blog\widgets\settings\SettingsWidget;
use yii\helpers\Json;
use backend\modules\settings\SettingsAsset;

$this->title = 'Настройки';
$this->params['breadcrumbs'][] = $this->title;
SettingsAsset::register($this);
?>
<style>
    .table>tbody>tr>th {
        border: 1px solid #3c8dbc; 
    }
</style>
<div class="row">
    <div class="col-md-6">
        <?php if (isset($settings['contact']) && count($settings['contact']['body']) > 0): ?>
            <div class="box table-flexible">
                <div class="box-header">
                    <h3 class="box-title">Наши контакты</h3>
                    <i style="float:right;cursor: pointer;" class="fa fa-floppy-o save" data-action="contact" aria-hidden="true"></i>
                </div>
                <div class="box-body no-padding">
                    <table class="table">
                        <tr>
                            <th width="10%">Название</th>
                            <th width="50%">Значение</th>
                        </tr>
                        <?php foreach ($settings['contact']['body'] as $v): ?>
                            <tr data-key="<?php echo $v['key']; ?>">
                                <td><?php echo $v['name']; ?></td>
                                <td><?php echo $v['value']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <div class="col-md-6">
        <?php if (isset($settings['social']) && count($settings['social']['body']) > 0): ?>
            <div class="box table-flexible">
                <div class="box-header">
                    <h3 class="box-title">Социальные сети</h3>
                    <i style="float:right;cursor: pointer;" class="fa fa-floppy-o save" data-action="social" aria-hidden="true"></i>
                </div>
                <div class="box-body no-padding">
                    <table class="table">
                        <tr>
                            <th width="10%">Название</th>
                            <th width="50%">Значение</th>
                        </tr>
                        <?php foreach ($settings['social']['body'] as $v): ?>
                            <tr data-key="<?php echo $v['key']; ?>">
                                <td><?php echo $v['name']; ?></td>
                                <td><?php echo $v['value']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
