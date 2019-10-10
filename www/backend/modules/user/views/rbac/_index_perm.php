<?php

use yii\helpers\Html;

/* @var $allPermissions */
/* @var $checkPermissions */
?>

<h3>Разрешения</h3>
<p class="error">Выберите разрешение</p>
<hr/>
<div class="block-permission">
    <?php if($allPermissions):?>
        <?php foreach ($allPermissions as $desc => $name):?>
            <div class="checkbox">
                <label>
                    <input type="checkbox"
                        <?= !empty($checkPermissions) && array_key_exists($desc,$checkPermissions)?'checked':''?>
                         data-perm="<?=$desc?>"
                        class="permission-check"><?=$name?>
                </label>
            </div>
        <?php endforeach;?>
    <?php else:?>
        <p>Нет активных разрешений</p>
    <?php endif;?>
</div>
<?php if($allPermissions):?>
    <?php if($access->accessInView('user/rbac/attach-permission')):?>
        <?= Html::button('Применить', [
            'class' => 'btn btn-primary attach-permission'
        ]) ?>
    <?php endif;?>
<?php endif;?>
