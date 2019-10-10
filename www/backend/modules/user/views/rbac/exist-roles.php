<div>
    <?php if(is_array($roles) && !empty($roles)):?>
    <?php foreach ($roles as $role => $description):?>
        <p><?=$role?> (<?=$description?>)</p>
    <?php endforeach;?>
    <?php else:?>
        <p>нет данных</p>
    <?php endif;?>
</div>
