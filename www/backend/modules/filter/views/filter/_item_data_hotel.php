<?php

use yii\helpers\Html;
?>
<?php if (isset($hotel) && count($hotel) > 0): ?>
    <?php foreach ($hotel as $v): ?>
        <tr class="<?php echo 'hotel_box_' . $v['id']; ?> hotel_box">
            <td class="position"><i class="fa fa-arrows" aria-hidden="true"></i></td>
            <td><?php echo $v['name']; ?></td>
            <td>
                <?php
                $value = 0;
                if (isset($data['hotel']['hotel'])) {
                    $value = (array_search($v['id'], $data['hotel']['hotel']) !== FALSE) ? 1 : 0;
                }
                echo Html::checkbox('Hotel[hotel][' . $v['id'] . ']', $value, [
                    'id' => 'hotel_status_' . $v['id'],
                    'class' => 'tgl tgl-light custome-checkbox custome-checkbox-status',
                    'value' => $v['id'],
                    'data-id' => $v['id'],
                ]) . Html::label('', 'hotel_status_' . $v['id'], ['class' => 'tgl-btn']);
                ?>
            </td>
            <td class="position">
                <?php
                $value = 0;
                if (isset($data['hotel']['default'])) {
                    $value = ($v['id'] == $data['hotel']['default']) ? 1 : 0;
                }
                $value_status = 0;
                if (isset($data['hotel']['hotel'])) {
                    $value_status = (array_search($v['id'], $data['hotel']['hotel']) !== FALSE) ? 1 : 0;
                }
                echo Html::radio('Hotel[default]', $value, [
                    'id' => 'hotel_default_' . $v['id'],
                    'class' => 'tgl tgl-light custom-radio',
                    'value' => $v['id'],
                    'data-id' => $v['id'],
                    'disabled' => ($value_status == 0) ? TRUE : FALSE,
                    (($value == 1) ? 'checked="checked"' : ''),
                ]) . Html::label('', 'hotel_default_' . $v['id']);
                ?>
            </td>
        </tr>
    <?php endforeach; ?>
<?php else : ?>
    <tr>
        <td colspan="4">Ничего не найдено</td>
    </tr>   
<?php endif; ?>