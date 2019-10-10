<?php

use yii\helpers\Html;
?>
<?php if (isset($city) && count($city) > 0): ?>
    <?php foreach ($city as $v): ?>
        <tr class="<?php echo 'city_box_' . $v['id']; ?> city_box">
            <td class="position"><i class="fa fa-arrows" aria-hidden="true"></i></td>
            <td><?php echo $v['name']; ?></td>
            <td><?php
                $value = 0;
                if (isset($data['city']['city'])) {
                    $value = (array_search($v['id'], $data['city']['city']) !== FALSE) ? 1 : 0;
                }
                echo Html::checkbox('City[city][' . $v['id'] . ']', $value, [
                    'id' => 'city_status_' . $v['id'],
                    'class' => 'tgl tgl-light custome-checkbox custome-checkbox-status',
                    'value' => $v['id'],
                    'data-id' => $v['id'],
                ]) . Html::label('', 'city_status_' . $v['id'], ['class' => 'tgl-btn']);
                ?></td>
            <td class="position">
                <?php
                $value = 0;
                if (isset($data['city']['default'])) {
                    $value = ($v['id'] == $data['city']['default']) ? 1 : 0;
                }
                $value_status = 0;
                if (isset($data['city']['city'])) {
                    $value_status = (array_search($v['id'], $data['city']['city']) !== FALSE) ? 1 : 0;
                }
                echo Html::radio('City[default]', $value, [
                    'id' => 'city_default_' . $v['id'],
                    'class' => 'tgl tgl-light custom-radio',
                    'value' => $v['id'],
                    'data-id' => $v['id'],
                    'disabled' => ($value_status == 0) ? TRUE : FALSE,
                    (($value == 1) ? 'checked="checked"' : ''),
                ]) . Html::label('', 'city_default_' . $v['id']);
                ?>
            </td>
        </tr>
    <?php endforeach; ?>
<?php else : ?>
    <tr>
        <td colspan="4">Ничего не найдено</td>
    </tr>   
<?php endif; ?>