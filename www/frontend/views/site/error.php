<?php

use yii\helpers\Url;

$this->title = $name;
?>

<div class="error-404">
    <div class="error-404--content d-flex flex-column align-items-center">
        <div class="img-404--wrapper">
            <img src="<?php echo Url::to('img/photos/404.png', TRUE); ?>" alt="404">
        </div>
        <h1 class="text-uppercase font-weight-500 font-size-sm">страница не найдена</h1>
        <a href="<?php echo Url::to('/', TRUE); ?>" class="btn-regular button-isi btn-shadow">на главную</a>
    </div>
</div>
