<?php

use himiklab\yii2\recaptcha\ReCaptcha3;
use yii\helpers\Url;

/* @var $page string */
/* @var $setings array */

$this->title = $page['pageMetas']['title'];
$this->registerMetaTag(['name' => 'description', 'content' => $page['pageMetas']['description']]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $page['pageMetas']['keywords']]);
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php echo (isset(Yii::$app->view->params['breadcrumbs'])) ? Yii::$app->view->params['breadcrumbs'] : FALSE; ?>
        </div>
    </div>
</div>
<section class="section section-contact pb-0">
    <div class="container">
        <div class="section-header header-text-left left-offset-3" id="line-1">
            <div class="row">
                <div class="col-9 offset-md-0 offset-lg-3 header-title" id="animate1">

                    <h1 class="header-title__title"> <span class="header-title__text">Наши</span>контакты</h1>
                </div>
            </div>
            <div class="row contacts-row">
                <?php foreach ($setings['contact']['body'] as $k => $v): ?>
                    <?php if ($k <= 3): ?>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-2 offset-lg-1 contact-col">
                            <div class="contact-col--header d-flex">
                                <span class="contact-col-icon"><i class="icon-other2 iconother2-<?php echo $v['key']; ?>"></i></span>
                                <h4><?php echo $v['name']; ?></h4>
                            </div>
                            <div class="contact-col--body">
                                <?php if ($v['key'] == 'phone'): ?>
                                    <p><?php echo implode('</p><p>', explode('/', $v['value'])); ?></p>
                                <?php else: ?>
                                    <p><?php echo $v['value']; ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>

        </div>
    </div>
</section>
<section class="section section-advantages-contact pt-0">
    <div class="advantages-contact">
        <div class="container">
            <div class="section-header header-text-right header-text_white w-b-150 active line-bottom" id="line-4">
                <div class="row">
                    <div class="offset-md-3 offset-lg-3 col-12 col-md-8 col-lg-7 header-title active pl-5" id="animate4">
                        <span class="header-title__text">мы в</span>
                        <h2 class="header-title__title pl-0">социальных сетях</h2>
                    </div>
                </div>
            </div>
            <div class="swiper-container counter-container">
                <div class="swiper-wrapper flex-sm-wrap">
                    <?php foreach (Yii::$app->view->params['settings']['social']['body'] as $k => $v): ?>
                        <div class="swiper-slide col-xs-12 col-sm-6 col-md-6 col-lg-3 advantages-col flex-column align-items-center">
                            <div class="advantages-col--icon mr-0 mb-4">
                                <span><i class="icon icon-<?php echo $v['key']; ?>"></i></span>
                            </div>
                            <div class="advantages-col--button">
                                <a target="_blank" rel="nofollow" href="<?php echo $v['value']; ?>" class="btn-white d-flex align-items-center justify-content-center btn-size-m real-white"><?php echo 'мы в ' . $v['key']; ?></a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="section mb-md-5">
    <div class="container">

        <div class="find-tour-form white-bg-form">
            <form action="<?php echo Url::to('/tour/save-request', TRUE); ?>" method="post" id="form-save-request-page">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <h2 class="block-header text-center block-header-before">
                                Остались вопросы?
                            </h2>
                        </div>
                    </div>
                    <div class="row align-items-stretch">
                        <div class="offset-lg-1 col-12 col-lg-10">
                            <div class="row inputs-wrapper">
                                <div class="col-12 col-lg-6 form-left">
                                    <div class="tour-form-input required-input">
                                        <input id="name" type="text" placeholder="Ваше имя" name="name"/>
                                    </div>
                                    <div class="tour-form-input required-input">
                                        <input id="phone" type="tel" placeholder="Ваш телефон" name="phone"/>
                                    </div>
                                    <div class="tour-form-input required-input">
                                        <input id="email" type="email" placeholder="Ваш e-mail" name="email"/>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6 form-right">
                                    <div class="tour-form-input">
                                        <textarea id="comment" placeholder="Сообщение" name="comment"></textarea>
                                    </div>
                                </div>
                                <div class="recaptcha">
                                    <?php
                                    echo ReCaptcha3::widget([
                                        'name' => 'reCaptcha',
                                        'siteKey' => Yii::$app->params['reCaptcha']['siteKey'],
                                        'action' => 'request'
                                    ]);
                                    ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-center">
                                    <input type="hidden" name="type" value="1">
                                    <button type="button" class="btn-find btn-regular btn-size-m button-isi save-request-page" data-badge="inline">Отправить</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<div id="contact-map" data-latitude="<?php echo $setings['contact']['body'][4]['value']; ?>" data-longitude="<?php echo $setings['contact']['body'][5]['value']; ?>"></div>
