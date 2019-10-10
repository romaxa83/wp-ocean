<?php

use himiklab\yii2\recaptcha\ReCaptcha3;
use yii\helpers\Url;

/** @var $categories backend\modules\faq\repository\FaqCategoryRepository*/
/** @var $faqs backend\modules\faq\repository\FaqRepository*/
/** @var $categoryActive*/
/** @var $searchInputValue*/
$this->title = 'Часто задаваемые вопросы о туризме в компании "Пятый Океан"';
$this->registerMetaTag(['name' => 'description', 'content' => 'Ответы на самые часто задаваемые вопросы клиентов при оформлении путевок и сопроводительных документов в туристической компании "Пятый Океан".']);
?>

<?= $this->render('_search',['searchInputValue' => $searchInputValue])?>

<section id="faqBody" class="section section-ocean-recommends grey-bg">
    <div class="container">
        <div class="section-header header-text-left left-offset-3 line-bottom active" id="line-1">
            <div class="row">
                <div class="col-9 offset-md-0 offset-lg-3 header-title active" id="animate1">
                    <h2 class="header-title__title"><span class="header-title__text">Часто задаваемые</span> вопросы
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <?= $this->render('_category',[
                'categories' => $categories,
                'categoryActive' => $categoryActive
            ])?>

            <?php if($faqs):?>
                <div class="col-sm-12 col-lg-8 col-xl-9">
                    <?php foreach ($faqs as $faq):?>
                        <div class="accordeon-item">
                            <h5><i class="icon icon-arrow-down"></i><?= strip_tags($faq->question)?></h5>
                            <p><?=strip_tags($faq->answer)?></p>
                        </div>
                    <?php endforeach;?>
                </div>
            <?php endif;?>
        </div>
    </div>

    <div class="container container-faq-form">
        <div class="row">
            <div class="col-12">
                <h2 class="block-header text-center block-header-before">
                    Остались вопросы?
                </h2>
            </div>
        </div>
        <form action="<?php echo Url::to('/tour/save-request', TRUE); ?>"
              method="post"
              enctype="multipart/form-data"
              id="form-save-request-page">
            <div class="row align-items-stretch">
                <div class="offset-lg-1 col-12 col-lg-10">
                    <div class="row inputs-wrapper faq-form">

                        <div class="col-12 col-lg-6 form-left">
                            <input type="hidden" name="type" value="1">
                            <div class="tour-form-input required-input">
                                <input type="text" placeholder="Ваше имя" name="name">
                            </div>
                            <div class="tour-form-input required-input">
                                <input type="tel" placeholder="Ваш телефон" name="phone" maxlength="17">
                            </div>
                            <div class="tour-form-input required-input">
                                <input type="email" placeholder="Ваш e-mail" name="email">
                            </div>
                            <div class="recaptcha">
                                <?php echo ReCaptcha3::widget([
                                    'name' => 'reCaptcha',
                                    'siteKey' => Yii::$app->params['reCaptcha']['siteKey'],
                                    'action' => 'request'
                                ]);
                                ?>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6 form-right">
                            <div class="tour-form-input">
                                <textarea placeholder="Сообщение" name="comment"></textarea>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-12 text-center">
                            <button type="button" class="save-request-page btn-find btn-regular btn-size-m button-isi save-request-page" data-badge="inline">
                                Отправить
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>