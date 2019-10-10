<?php

use yii\helpers\Url;
use yii\helpers\Html;
use frontend\widgets\InfoModal;
use frontend\widgets\RegModalWidget;
use frontend\widgets\LoginModalWidget;
use frontend\widgets\PasswordResetModalWidget;
use frontend\widgets\PasswordResetRequestModalWidget;
use backend\modules\menuBuilder\widgets\menuRender\MenuRenderWidget;

?>
<!-- HEADER START -->
<?= InfoModal::widget(['template' => 'confirm-sign-up-success'])?>
<?= (Yii::$app->user->isGuest ? LoginModalWidget::widget([]) : ''); ?>
<?= (Yii::$app->user->isGuest ? InfoModal::widget(['template' => 'confirm-sign-up']) : ''); ?>
<?= (Yii::$app->user->isGuest ? RegModalWidget::widget([]) : ''); ?>
<?= (Yii::$app->user->isGuest ? PasswordResetRequestModalWidget::widget([]) : ''); ?>
<?= (Yii::$app->user->isGuest && Yii::$app->request->get('token')
    ? PasswordResetModalWidget::widget(['token' => Yii::$app->request->get('token')])
    : ''); ?>
<?php if (Yii::$app->controller->id == 'site' && Yii::$app->response->statusCode == 200): ?>

    <header class="header main-header">
        <div class="header-wrapper">
            <div class="header__top container">
                <div class="row">
                    <div class="col-9 col-lg-4 logo-wrapper">
                        <span class="logo-purple"><img src="/img/logo_white2.png" alt="logo"/></span>
                        <span class="logo-white"><img src="/img/elementa/logo_white.png" alt="logo"/></span>
                    </div>
                    <div class="col-lg-4 d-none d-lg-flex text-center phone-wrapper">
                        <a href="<?php echo 'tel:' . Yii::$app->view->params['phone_mask']; ?>" class="footer-list__link">
                            <i class="icon-work">
                                <img src="/img/icon-work.png" alt="work">
                            </i><?php echo Yii::$app->view->params['phone']; ?>
                        </a>
                    </div>
                    <div class="col-3 col-lg-4 header-right">
                        <div class="btn-tour-wrapper d-none d-md-block">
                            <a href="#"
                               data-toggle="modal"
                               data-target="#modal-order-tour"
                               class="btn-regular button-isi btn-shadow btn-size-l">Подберите мне тур</a>
                        </div>
                        <div class="d-flex d-md-none header-mobile-icons">
                            <a href="#"
                               data-toggle="modal"
                               data-title="Остались вопросы?"
                               class="mobile-info-modal">
                                <i class="icon-other icon-question"></i>
                            </a>
                            <a href="<?php echo 'tel:' . Yii::$app->view->params['phone_mask']; ?>">
                                <i class="icon-other icon-phone"></i>
                            </a>
                        </div>
                        <?php if(false):?>
                        <div class="account pl-3">
                            <?php if(!Yii::$app->user->isGuest):?>
                                <?= Html::a(Yii::$app->user->identity->getFullName(),
                                    ['site/logout'],
                                    ['data' => [
                                        'method' => 'post'
                                    ]]);?>
                            <?php else:?>
                                <a href="#" data-toggle="modal" data-target="#modal-login"><i class="icon icon-user"></i></a>
                            <?php endif;?>
                        </div>
                        <?php endif;?>
                        <div class="hamburger hamburger--squeeze js-hamburger">
                            <div class="hamburger-box">
                                <div class="hamburger-inner"></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!--                    <div class="overlay">-->
            <div class="mobile-menu">
                <div class="mobile-menu--header d-lg-none"></div>
                <div class="mobile-menu--body">
                    <div class="d-flex flex-column">
                        <div class="mobile-menu--section d-none">
                            <ul>
                                <li>
                                    <!--                                            <a href="<?php //echo Url::to(['/cabinet/order']);                                                                                                                   ?>" class="menu-link">
                                                <i class="icon icon-user"></i>
                                                <b>Вход</b>&#160;в кабинет
                                            </a>-->
                                </li>
                            </ul>
                        </div>
                        <?= $mainMenu = MenuRenderWidget::widget([
                            'name' => 'main',
                            'options' => [
                                'container' => 'div'
                            ]
                        ]) ?>
                    </div>
                </div>
            </div>
            <!--                    </div>-->

        </div>
    </header>
<?php else: ?>
    <header class="header site-header">
        <div class="header-wrapper">
            <div class="header__top container">
                <div class="row">
                    <div class="col-9 col-lg-4 logo-wrapper">
                        <a href="<?php echo URL::to('/', TRUE); ?>" class="logo-purple"><img src="/img/logo_white2.png" alt="logo"/> </a>
                        <a href="<?php echo URL::to('/', TRUE); ?>" class="logo-white"><img src="/img/elementa/logo_white.png" alt="logo"/> </a>
                    </div>
                    <div class="col-lg-4 d-none d-lg-flex text-center phone-wrapper">
                        <a href="<?php echo 'tel:' . Yii::$app->view->params['phone_mask']; ?>" class="footer-list__link">
                            <i class="icon-work">
                                <img src="/img/icon-work.png" alt="work">
                            </i><?php echo Yii::$app->view->params['phone']; ?>
                        </a>
                    </div>
                    <div class="col-3 col-lg-4 header-right">
                        <div class="btn-tour-wrapper d-none d-md-block">
                            <a href="#"
                               data-toggle="modal"
                               data-target="#modal-order-tour"
                               class="btn-regular button-isi btn-shadow btn-size-l">Подберите мне тур</a>
                        </div>
                        <div class="d-flex d-md-none header-mobile-icons">
                            <a href="#"
                               data-toggle="modal"
                               data-title="Остались вопросы?"
                               class="mobile-info-modal">

                                <i class="icon-other icon-question"></i>
                            </a>
                            <a href="<?php echo 'tel:' . Yii::$app->view->params['phone_mask']; ?>">
                                <i class="icon-other icon-phone"></i>
                            </a>
                        </div>
                        <?php if(false):?>
                        <div class="account pl-3">
                            <?php if(!Yii::$app->user->isGuest):?>
                                <?= Html::a(Yii::$app->user->identity->getFullName(),
                                    ['site/logout'],
                                    ['data' => [
                                        'method' => 'post'
                                    ]]);?>
                            <?php else:?>
                                <a href="#" data-toggle="modal" data-target="#modal-login"><i class="icon icon-user"></i></a>
                            <?php endif;?>
                        </div>
                        <?php endif;?>
                        <div class="hamburger hamburger--squeeze js-hamburger">
                            <div class="hamburger-box">
                                <div class="hamburger-inner"></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="mobile-menu">
                <div class="mobile-menu--header d-lg-none"></div>
                <div class="mobile-menu--body">
                    <div class="d-flex flex-column">
                        <div class="mobile-menu--section d-none">
                            <ul>
                                <li>
                                    <?php if(false):?>
                                    <div class="account">
                                        <?php if(!Yii::$app->user->isGuest):?>
                                            <?= Html::a(Yii::$app->user->identity->getFullName(),
                                                ['site/logout'],
                                                ['data' => [
                                                    'method' => 'post'
                                                ]]);?>
                                        <?php else:?>
                                            <a href="#" data-toggle="modal" data-target="#modal-login"><i class="icon icon-user"></i></a>
                                        <?php endif;?>
                                    </div>
                                    <?php endif;?>
                                </li>
                            </ul>
                        </div>
                        <?= MenuRenderWidget::widget([
                            'name' => 'main',
                            'options' => [
                                'container' => 'div'
                            ]
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
    </header>
<?php endif; ?>

<!-- HEADER END -->
