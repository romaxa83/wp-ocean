<?php
/* @var $this \yii\web\View */

/* @var $content string */

use backend\modules\menuBuilder\widgets\menuRender\MenuRenderWidget;
use backend\modules\request\models\Request;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\helpers\Url;
use himiklab\yii2\recaptcha\ReCaptcha3;

AppAsset::register($this);
?>
<?php
$this->beginPage();
$currentLocation = Yii::$app->request->url;
?>
<!DOCTYPE html>
<html class="no-js" lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <link rel="apple-touch-icon" sizes="57x57" href="/img/favicon/apple-icon-57x57.png"/>
        <link rel="apple-touch-icon" sizes="60x60" href="/img/favicon/apple-icon-60x60.png"/>
        <link rel="apple-touch-icon" sizes="72x72" href="/img/favicon/apple-icon-72x72.png"/>
        <link rel="apple-touch-icon" sizes="76x76" href="/img/favicon/apple-icon-76x76.png"/>
        <link rel="apple-touch-icon" sizes="114x114" href="/img/favicon/apple-icon-114x114.png"/>
        <link rel="apple-touch-icon" sizes="120x120" href="/img/favicon/apple-icon-120x120.png"/>
        <link rel="apple-touch-icon" sizes="144x144" href="/img/favicon/apple-icon-144x144.png"/>
        <link rel="apple-touch-icon" sizes="152x152" href="/img/favicon/apple-icon-152x152.png"/>
        <link rel="apple-touch-icon" sizes="180x180" href="/img/favicon/apple-icon-180x180.png"/>
        <link rel="icon" type="image/png" sizes="192x192" href="/img/favicon/android-icon-192x192.png"/>
        <link rel="icon" type="image/png" sizes="32x32" href="/img/favicon/favicon-32x32.png"/>
        <link rel="icon" type="image/png" sizes="96x96" href="/img/favicon/favicon-96x96.png"/>
        <link rel="icon" type="image/png" sizes="16x16" href="/img/favicon/favicon-16x16.png"/>
        <link rel="manifest" href="/img/favicon/manifest.json"/>
        <meta name="msapplication-TileColor" content="#ffffff"/>
        <meta name="msapplication-TileImage" content="/img/favicon/ms-icon-144x144.png"/>
        <meta name="theme-color" content="#ffffff"/>
        <?php $this->head() ?>
        <?php if (Yii::$app->controller->id === 'search' && Yii::$app->response->statusCode === 200): ?>
            <?php if (Yii::$app->request->get('city') && strpos(Yii::$app->request->get('city'), ':') !== FALSE): ?>
                <meta name="robots" content="noindex, follow" />
            <?php endif; ?>
        <?php endif; ?>

        <style>
            #modal-application-tour .error,
            #modal-application-tour-1 .error,
            #form-save-request-page .error,
            #modal-order-tour .error,
            #modal-join-us .error {
                border: 1px solid red;
            }
            .filter-form-wrapper .full-filter .filter-items__item_country .select2-results__option:nth-child(-n+2){
                background: #ddd;
            }
            /*            .full-filter .filter-items__item_country .select2-results__option:nth-child(1){
                            display: none;
                        }*/
            .breadcrumb-mark {
                text-transform: capitalize;
            }
            .help-block{
                color: rgb(173,78,76);
                font-size:13px;
            }
        </style>
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-5KQ8RW');</script>
        <!-- End Google Tag Manager -->
    </head>
    <body class="<?php echo (Yii::$app->controller->id != 'site' || Yii::$app->response->statusCode != 200) ? 'body-padding' : 'fixed-body'; ?>">
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5KQ8RW"
        height="0" width="0"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
        <?php $this->beginBody() ?>

        <?= $this->render('header') ?>

        <!-- CONTENT START -->
        <?php if (Yii::$app->controller->id == 'site' && Yii::$app->response->statusCode == 200): ?>
            <div class="content content-main-page">
            <?php else: ?>
                <div class="content">
                <?php endif; ?>

                <div class="loading-page">
                    <div class="loading-page--counter">
                        <p>Загрузка</p>
                        <h6>0%</h6>
                        <hr/>
                    </div>
                </div>

                <!--  Welcome page  -->
                <div class="welcome-page" style="background: url(/img/zaglushkabg.png) center / cover no-repeat">
                    <div class="welcome-page--header">
                        <div class="welcome-page--logo">
                            <img
                                src="/img/logo_white2.png"
                                alt="Logotype"
                                >
                        </div>
                        <div class="welcome-page--cross">
                            <div class="hamburger hamburger--squeeze js-hamburger is-active hamburger-welcome">
                                <div class="hamburger-box">
                                    <div class="hamburger-inner"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="welcome-page--content">
                        <h2 class="text-center text-white welcome-page--title">
                            <span class="font-weight-light">Новый</span>
                            <br>

                            уникальный <span class="text-uppercase">сервис</span>,
                            <br>

                            <span class="font-weight-light">
                                который поможет
                                <br>

                                Вам подобрать тур
                                <br>
                            </span>

                            легко и быстро!
                        </h2>
                        <a href="#" class="button-isi btn-regular btn-size-m">спасибо</a>
                    </div>
                </div>

                <?php echo $content; ?>
            </div>
            <!-- CONTENT END -->


            <!-- FOOTER START -->
            <footer class="footer">
                <div class="action-scroll-top">
                    <div></div>
                    <object type="image/svg+xml" data="/img/icons/arrow_to_top.svg" width="38" height="38">
                        <img src="/img/icons/arrow_to_top.svg" alt="icon">
                    </object>
                </div>

                <div class="container">
                    <div class="footer-top">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-4 text-center text-lg-left footer-top__item logo-wrapper">
                                <?php if (Yii::$app->controller->id == 'site' && Yii::$app->response->statusCode == 200): ?>
                                    <img src="/img/elementa/logo_white.png" alt="logo"/>
                                <?php else: ?>
                                    <a href="<?php echo Url::to('/', TRUE); ?>">
                                        <img src="/img/elementa/logo_white.png" alt="logo"/>
                                    </a>
                                <?php endif; ?>
                            </div>
                            <div class="col-12 col-md-4 text-center footer-top__item d-none d-md-block">

                            </div>
                            <!--                        <div class="col-12 col-md-4 text-center text-md-right footer-top__item d-none d-lg-block">
                                                        <div class="payment d-flex justify-content-center justify-content-md-end align-items-center">
                                                            <div class="payment__item">
                                                                <img src="/img/elementa/master_card.png" alt="mastercard"/>
                                                            </div>
                                                            <div class="payment__item">
                                                                <img src="/img/elementa/maestro.png" alt="maestro"/>
                                                            </div>
                                                            <div class="payment__item">
                                                                <img src="/img/elementa/visa.png" alt="visa"/>
                                                            </div>
                                                            <div class="payment__item">
                                                                <img src="/img/elementa/visa_electron.png" alt="visa-electron"/>
                                                            </div>
                                                        </div>
                                                    </div>-->
                        </div>
                    </div>
                    <div class="footer-bottom">
                        <?=
                        MenuRenderWidget::widget([
                            'name' => 'footer-menu',
                            'options' => [
                                'container' => 'nav',
                                'class' => 'd-flex justify-content-start align-items-start footer-links'
                            ]
                        ])
                        ?>
                        <!--                    <div class="col-12 text-center text-md-right footer-top__item d-block d-lg-none">
                                                <div class="payment d-flex justify-content-center align-items-center">
                                                    <div class="payment__item">
                                                        <img src="/img/elementa/master_card.png" alt="mastercard"/>
                                                    </div>
                                                    <div class="payment__item">
                                                        <img src="/img/elementa/maestro.png" alt="maestro"/>
                                                    </div>
                                                    <div class="payment__item">
                                                        <img src="/img/elementa/visa.png" alt="visa"/>
                                                    </div>
                                                    <div class="payment__item">
                                                        <img src="/img/elementa/visa_electron.png" alt="visa-electron"/>
                                                    </div>
                                                </div>
                                            </div>-->
                        <div class="row">
                            <div class="col-12 col-md-6 order-1 order-md-0">
                                <p class="copyright text-center text-md-left ">
                                    © "Пятый океан", 2006
                                </p>
                            </div>
                            <div class="col-12 col-md-6 text-center text-md-right">
                                <a href="https://bonum-studio.com/" class="developed">Разработка и продвижение сайтов
                                    <span>
                                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
                                             xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                             viewBox="0 0 487 74" style="enable-background:new 0 0 487 74;"
                                             xml:space="preserve">
                                        <style type="text/css">
                                            .st0 {
                                                fill: #ffffff;
                                            }
                                        </style>
                                        <path class="st0" d="M215.7,37.5c0,20.7-15.4,35.6-36.6,35.6s-36.7-14.9-36.7-35.6s15.5-35.6,36.7-35.6S215.7,16.8,215.7,37.5z
                                              M157,37.5c0,13.5,9.2,23.2,21.9,23.2c12.9,0,22.1-9.6,22.1-23.2c0-13.4-9.2-23.2-22.1-23.2C166.3,14.3,157,24.1,157,37.5z"/>
                                        <path class="st0" d="M92.2,1.9C71,1.9,55.5,16.8,55.5,37.5c0,8,2.4,15.2,6.5,21H9.2c-4,0-7.3,3.3-7.3,7.3v7.3h90.2l0,0
                                              c0,0,0,0,0.1,0c21.2,0,36.6-14.9,36.6-35.6C128.8,16.8,113.4,1.9,92.2,1.9z M92,60.7c-12.7,0-21.9-9.6-21.9-23.2
                                              c0-13.4,9.2-23.2,21.9-23.2c12.9,0,22.1,9.8,22.1,23.2C114.1,51.1,104.9,60.7,92,60.7z"/>
                                        <path class="st0" d="M293.3,65.8L293.3,65.8V32.2c0-18.1-13.1-30.3-32.1-30.3c-18.9,0-31.8,12.2-31.8,30.3v33.6c0,4,3.3,7.3,7.3,7.3
                                              l0,0l0,0h7.3V32.2c0-10.9,6.8-18.2,17.3-18.2s17.3,7.3,17.3,18.2v33.6c0,4,3.3,7.3,7.3,7.3l0,0h7.3v-7.3H293.3z"/>
                                        <path class="st0" d="M370.7,7.8V1.9h-7.2c-4,0-7.3,3.3-7.3,7.3l0,0V43c0,10.9-7,18.1-17.5,18.1S321.4,54,321.4,43v-8.4v-24V7.8V1.9
                                              h-7.2c-4,0-7.3,3.3-7.3,7.3l0,0V43c0,17.9,12.9,30.1,32,30.1c18.9,0,31.8-12.2,31.8-30.1V25.8V10.6L370.7,7.8L370.7,7.8z"/>
                                        <path class="st0" d="M459.4,1.9c-11.1,0-19.8,5-24,13.2c-4.3-8.2-12.9-13.2-24-13.2c-16.4,0-27,11-27,27.6v36.3c0,4,3.3,7.3,7.3,7.3
                                              l0,0h7.3v-7.3l0,0l0,0V29c0-9.2,5.7-15.5,14.5-15.5s14.6,6.3,14.6,15.5v36.8l0,0c0,4,3.3,7.3,7.3,7.3l0,0l0,0h7.2V72v-4.8v-2.8V54
                                              V29c0-9.2,5.8-15.5,14.6-15.5c8.8,0,14.5,6.3,14.5,15.5v36.8l0,0c0,4,3.3,7.3,7.3,7.3l0,0h7.3V29.5C486.4,12.8,475.8,1.9,459.4,1.9z
                                              "/>
                                        </svg>
                                    </span>
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <p class="copyright text-center text-md-left">
                                    This site is protected by reCAPTCHA and the Google
                                    <a href="https://policies.google.com/privacy" class="footer-list__link google-link" rel="nofollow">Privacy Policy</a> 
                                    and <a href="https://policies.google.com/terms" class="footer-list__link google-link" rel="nofollow">Terms of Service</a> apply.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- modal drop comment -->

                    <?php if (Yii::$app->user->identity): ?>
                        <?=
                        \frontend\widgets\ReviewWidget::widget([
                            'user_id' => Yii::$app->user->identity->id,
                            'hotel_review_id' => Yii::$app->request->get('id'),
                        ])
                        ?>
                    <?php endif; ?>

                    <!-- modal order tour -->
                    <div class="modal fade"
                         id="modal-order-tour"
                         tabindex="-1"
                         role="dialog"
                         aria-hidden="true"
                         >
                        <div class="modal-dialog" role="dialog">
                            <div class="modal-content modal-action-notification">
                                <form action="<?php echo Url::to('/tour/save-request', TRUE); ?>"
                                      method="post" id="form-save-request">
                                    <div class="modal-header modal-header-center d-flex justify-content-center">
                                        <h2 class="modal-title">Заказать тур</h2>
                                        <span class="close" data-dismiss="modal">&times;</span>
                                    </div>
                                    <div class="d-flex flex-wrap w-100">
                                        <div class="modal-body--fields fields-left">
                                            <input type="hidden" name="type" value="<?= Request::TYPE_REQUEST ?>">
                                            <div class="form-group required-input">
                                                <input type="text" name="name" placeholder="Ваше имя">
                                            </div>
                                            <div class="form-group required-input">
                                                <input type="tel" name="phone" placeholder="Ваш телефон">
                                            </div>
                                            <div class="form-group required-input">
                                                <input type="email" name="email" placeholder="Ваш e-mail">
                                            </div>
                                            <div class="recaptcha m-auto">
                                                <?php
                                                echo ReCaptcha3::widget([
                                                    'name' => 'reCaptcha',
                                                    'siteKey' => Yii::$app->params['reCaptcha']['siteKey'],
                                                    'action' => 'request'
                                                ]);
                                                ?>
                                            </div>
                                        </div>
                                        <div class="modal-body--fields fields-right">
                                            <div class="form-group">
                                                <textarea name="comment" placeholder="Сообщение"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="button" class="button-isi btn-regular save-request w-100" data-badge="inline">
                                            Отправить
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>




                    <!--
                            Modal join us, attach resume
                    -->
                    <?php if (isset($this->params['vacancies'])) : ?>
                        <!--
                                Modal join us, attach resume
                        -->
                        <div class="modal fade"
                             id="modal-join-us"
                             tabindex="-1"
                             role="dialog"
                             aria-hidden="true"
                             >
                            <div class="modal-dialog" role="dialog">
                                <form id="vacancy-form" action="<?= Url::to('vacancy/notificator', true) ?>" method="post" enctype="multipart/form-data">
                                    <div class="modal-content modal-action-notification">
                                        <div class="modal-header modal-header-center d-flex justify-content-center">
                                            <h2 class="modal-title">присоединиться</h2>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                                        </div>
                                        <div class="modal-body ordered">
                                            <div class="modal-body--fields d-flex flex-wrap">
                                                <div class="form-group required-input">
                                                    <input type="text" name="name" value="" placeholder="Ваше имя">
                                                </div>
                                                <div class="form-group required-input">
                                                    <input type="tel" name="phone" value="" placeholder="Ваш телефон">
                                                </div>
                                                <div class="form-group form-has-dropdown">
                                                    <div class="filter-items__header d-flex justify-content-between align-items-stretch p-0">
                                                        <div class="blog-left--fields">
                                                            <div class="filter-items__item filter-items__item_country">
                                                                <select class="mobile-shadow-select d-md-none" name="shadowSelectVacancy">
                                                                    <option value="">Выберите вакансию</option>
                                                                    <?php foreach ($this->params['vacancies'] as $vacancy) : ?>
                                                                        <?php $selected = (isset($this->params['vacancy']) && $vacancy['title'] == $this->params['vacancy']) ? 'selected' : ''; ?>
                                                                        <option value="<?= $vacancy['title'] ?>" <?= $selected ?>><?= $vacancy['title'] ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                                <select class="form-control search-select" name="vacancy" data-tags="true" data-action="country">
                                                                    <option value="">Выберите вакансию</option>
                                                                    <?php foreach ($this->params['vacancies'] as $vacancy) : ?>
                                                                        <?php $selected = (isset($this->params['vacancy']) && $vacancy['title'] == $this->params['vacancy']) ? 'selected' : ''; ?>
                                                                        <option value="<?= $vacancy['title'] ?>" <?= $selected ?>><?= $vacancy['title'] ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group label-decorated">
                                                    <input type="file" name="cv_path" multiple="multiple" accept=".doc, .docx, .pdf, .odt, .rtf, .txt, .wps, .pages, .png, .jpg" style="display: none" id="cvFile">
                                                    <label for="cvFile">
                                                        <img src="/img/addfile.png" alt="" width="22" class="mr-2">
                                                        <span class="uploaded-filename">Прикрепите Ваше резюме</span>
                                                    </label>
                                                </div>
                                                <div class="form-group mw-100">
                                                    <textarea name="comment" placeholder="Сообщение"></textarea>
                                                </div>
                                            </div>
                                            <div class="pl-3 pr-3 mb-3" id="gg-material-loading">
                                                <div class="material-loading"></div>
                                            </div>
                                            <div class="recaptcha">
                                                <?php
                                                echo ReCaptcha3::widget([
                                                    'name' => 'reCaptcha',
                                                    'siteKey' => Yii::$app->params['reCaptcha']['siteKey'],
                                                    'action' => 'vacancy_notification'
                                                ]);
                                                ?>
                                            </div>
                                            <button type="submit" class="btn-regular" data-badge="inline">
                                                отправить
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- modal-send-request -->
                    <span data-toggle="modal" data-target="#modal-send-request" class="btn-regular btn-size-m button-isi d-none"></span>
                    <div class="modal fade" id="modal-send-request" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog" role="dialog">
                            <div class="modal-content modal-notification">
                                <div class="modal-header modal-header-left">
                                    <h2 class="modal-title">Запрос отправлен</h2>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <p>Спасибо за обращение!</p>
                                    <p>
                                        Ваш запрос успешно отправлен, наш
                                        менеджер свяжется с Вами в ближайшее
                                        время.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- modal-buy-tour -->
                    <div class="modal fade" id="modal-buy-tour" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog" role="dialog">
                            <div class="modal-content modal-notification">
                                <div class="modal-header modal-header-left">
                                    <h2 class="modal-title">купить тур</h2>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <p>
                                        К сожалению этот сервис пока в стадии
                                        разработки, Вы можете написать нам и
                                        уточнить все интересующие Вас
                                        вопросы.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- modal-Smart -->
                    <div class="modal fade" id="modal-smart" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog" role="dialog">
                            <div class="modal-content modal-notification">
                                <div class="modal-header modal-header-left">
                                    <h2 class="modal-title">Smart-рассылка</h2>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <p>
                                        Вы успешно подписались на рассылку
                                        лучших предложений
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
            <div class="overlay"></div>
            <!-- FOOTER END -->
            <!--[if lt IE 9]>
            <script src="libs/html5shiv/es5-shim.min.js"></script>
            <script src="libs/html5shiv/html5shiv.min.js"></script>
            <script src="libs/html5shiv/html5shiv-printshiv.min.js"></script>
            <script src="libs/respond/respond.min.js"></script>
            <![endif]-->
            <?php $this->endBody() ?>
            <?php if (isset(Yii::$app->view->params['MarkingForBreadcrumbs'])): ?>
                <script type="application/ld+json"><?php echo Yii::$app->view->params['MarkingForBreadcrumbs']; ?></script>
            <?php endif; ?>

            <?php if (isset(Yii::$app->view->params['SchemaPost'])): ?>
                <script type="application/ld+json"><?php echo Yii::$app->view->params['SchemaPost']; ?></script>
            <?php endif; ?>

            <script type="application/ld+json"><?php echo Yii::$app->view->params['LocalBusiness']; ?></script>
            <script src="//code.jivosite.com/widget.js" data-jv-id="YhV0aBUMxV" async></script>
    </body>
</html>
<?php $this->endPage() ?>
