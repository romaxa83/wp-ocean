<?php

use app\modules\blog\BlogAsset;
use backend\modules\blog\helpers\DateHelper;
use backend\modules\blog\helpers\StatusHelper;
use backend\modules\filemanager\widgets\FileInput;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use backend\modules\blog\helpers\ImageHelper;

/* @var $this yii\web\View */
/* @var $hotelReview backend\modules\blog\entities\HotelReview */
/* @var $modificationsProvider yii\data\ActiveDataProvider */
/* @var $access backend\modules\user\useCase\Access */

$this->title = $hotelReview->title;
$this->params['breadcrumbs'][] = ['label' => 'Список обзоров', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

BlogAsset::register($this);
?>
<div class="user-view">
    <p>
        <?php if($access->accessInView(Url::toRoute(['update']))):?>
            <?= Html::a('Редактировать', ['update', 'id' => $hotelReview->id], ['class' => 'btn btn-primary']) ?>
        <?php endif;?>
        <?= Html::a('Вернуться', Yii::$app->request->referrer, ['class' => 'btn btn-primary']) ?>
        <?php if($access->accessInView(Url::toRoute(['delete']))):?>
            <?= Html::a('Удалить', ['delete', 'id' => $hotelReview->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Вы уверены ,что хотите удалить этот обзор?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif;?>
    </p>
    <div class="row">
        <div class="col-md-6">
            <div class="box">
                <div class="box-body">
                    <?= DetailView::widget([
                        'model' => $hotelReview,
                        'attributes' => [
                            'id',
                            [
                                'label' => 'Статус',
                                'format' =>'raw',
                                'value' => StatusHelper::label($hotelReview->status),
                            ],
                            [
                                'label' => 'Название поста',
                                'value' => $hotelReview->title,
                            ],
                            [
                                'label' => 'Алиас',
                                'value' => $hotelReview->alias,
                            ],
                            [
                                'label' => 'Отель',
                                'value' => ArrayHelper::getValue($hotelReview, 'hotel.name'),
                            ],
                            [
                                'label' => 'Теги',
                                'value' => implode(', ', ArrayHelper::getColumn($hotelReview->tags, 'title')),
                            ],
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box">
                <div class="box-body">
                    <?= DetailView::widget([
                        'model' => $hotelReview,
                        'attributes' => [
                            [
                                'label' => 'Просмотры',
                                'value' => $hotelReview->views,
                            ],
                            [
                                'label' => 'Лайки',
                                'value' => $hotelReview->likes . ' (в разработке)',
                            ],
                            [
                                'label' => 'Ссылки',
                                'value' => $hotelReview->links . ' (в разработке)',
                            ],
                            [
                                'label' => 'Создана',
                                'value' => DateHelper::convertDateTime($hotelReview->created_at)
                            ],
                            [
                                'label' => 'Опубликована',
                                'value' => DateHelper::convertDateTime($hotelReview->published_at)
                            ]
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="gallery box-header with-border">
                    <div>Галерея</div>
                    <?php if($access->accessInView('blog/hotelReview/addImgToGallery')):?>
                        <?=  FileInput::widget([
                            'name' => 'mediafile',
                            'buttonTag' => 'button',
                            'buttonName' => '<i class="fa fa-upload"></i>',
                            'buttonOptions' => ['class' => 'btn btn-primary'],
                            'template' => '<div class="hidden input-group">{input}</div><div>{button}</div>',
                            'callbackBeforeInsert' => 'function(e, data) {
                                addImageToGallery(data.id,e.target.baseURI)
                            }',
                        ]);?>
                    <?php endif;?>
                </div>
                <div class="box-body gallery-hotel-review">
                    <?php if($ids = ImageHelper::parseMediaIds($hotelReview->media_ids)):?>

                        <div class="row d-flex flex-wrap">
                        <?php foreach ($ids as $id):?>
                            <div class="col-md-3 col-hotel-review">
                                <div class="text-right mb-2">
                                    <?php if($access->accessInView('blog/hotelReview/removeImg')):?>
                                        <span
                                                style="cursor:pointer"
                                                title="Удалить данную фотографию"
                                                data-media-id="<?= $id?>"
                                                data-post-id="<?= $hotelReview->id?>"
                                                data-url="<?= Url::base() . '/blog/hotel-review/remove-img'?>"
                                                class="remove-media-review"
                                        ><i class="fa fa-trash"></i>
                                    </span>
                                    <?php endif;?>
                                </div>
                                <?= ImageHelper::getImageByIdAndRender($id,'medium');?>
                            </div>
                        <?php endforeach;?>
                        </div>
                    <?php else:?>
                        <p>Фотографии отсутствуют</p>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="box">
                <div class="box-header with-border">Описание</div>
                <div class="box-body">
                    <?= Yii::$app->formatter->asNtext($hotelReview->description) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="box">
        <div class="box-header with-border">Контент</div>
        <div class="box-body">
            <?= Yii::$app->formatter->asHtml($hotelReview->content, [
                'Attr.AllowedRel' => array('nofollow'),
                'HTML.SafeObject' => true,
                'Output.FlashCompat' => true,
                'HTML.SafeIframe' => true,
                'URI.SafeIframeRegexp'=>'%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
            ]) ?>
        </div>
    </div>

    <div class="box">
        <div class="box-header with-border">Seo</div>
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $hotelReview->getSeo(),
                'attributes' => [
                    [
                        'label' => 'H1',
                        'value' => $hotelReview->seo->h1,
                    ],
                    [
                        'label' => 'title',
                        'value' => $hotelReview->seo->title,
                    ],
                    [
                        'label' => 'keywords',
                        'value' => $hotelReview->seo->keywords,
                    ],
                    [
                        'label' => 'description',
                        'value' => $hotelReview->seo->description,
                    ],
                    [
                        'label' => 'seo_text',
                        'value' => $hotelReview->seo->seo_text,
                    ],
                ],
            ]) ?>
        </div>
    </div>

</div>