<h3>Роли</h3>
<p class="error">Выберите роль</p>
<p class="success"></p>
<hr/>
<?php if(isset($allRoles) && !empty($allRoles)):?>
    <?php foreach ($allRoles as $desc => $name):?>
        <div class="list-role">
            <div class="radio">
                <label>
                    <input
                        <?=!empty($checkRole) && $checkRole == $desc?'checked':''?>
                            type="radio"
                            name="role"
                            id="<?=$desc?>"
                            value="<?=$desc?>">
                    <?=$name?>
                </label>
            </div>
            <?php if($access->accessInView('user/rbac/remove-role')):?>
                <div class="remove-role"
                     data-role="<?=$desc?>"
                     data-role-name="<?=$name?>"
                     title="Удалить роль"><i class="fa fa-trash"></i>
                </div>
            <?php endif;?>
        </div>
    <?php endforeach;?>
<?php else:?>
    <p>Нет ролей</p>
<?php endif;?>

