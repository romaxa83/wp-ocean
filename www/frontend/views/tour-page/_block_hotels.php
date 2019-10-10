<?php if (count($tours) > 0): ?>
    <?php foreach ($tours as $key => $item): ?>
        <div class="result-card col-xs-12 col-md-6 col-xl-4">
            <div class="card card-size-s ">
                <div class="card-header">
                    <a href="<?php echo $item['link']; ?>" target="_blank">
                        <div class="card-header--image preloader-inner">
                            <?php if (@getimagesize(yii\helpers\Url::to('/admin/' . $item['hotel']['media']['url'], TRUE))): ?>
                                <img src="<?php echo yii\helpers\Url::to('/admin/' . $item['hotel']['media']['url'], TRUE); ?>" alt="<?php echo $item['hotel']['media']['alt']; ?>" />
                            <?php else : ?>
                                <img src="<?php echo yii\helpers\Url::to('/admin/img/logo_no_photo.png', TRUE); ?>" alt="image not found or missed" class="img-not-found" />
                            <?php endif; ?>
                            <div class="card-header--common">
                                <?php if (isset($item['hotel']['review'][$item['hotel']['id']]['avg'])) : ?>
                                    <div class="card--rating text-white font-montserrat font-size-s">
                                        <span><strong><?php echo $item['hotel']['review'][$item['hotel']['id']]['avg']; ?></strong> оценка</span>
                                    </div>
                                <?php endif; ?>
                                <?php if (isset($item['hotel']['review'][$item['hotel']['id']]['count'])) : ?>
                                    <div class="card--rating card--rating__testimonials text-white font-montserrat font-size-s">
                                        <span><strong><?php echo $item['hotel']['review'][$item['hotel']['id']]['count']; ?></strong> </span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="card-body">
                    <div class="card-body-wrapper">
                        <div class="card-body--title d-flex justify-content-between">
                            <a href="<?php echo $item['link']; ?>" class="card-body--title__link" target="_blank"><span class="text-uppercase"><?php echo $item['hotel']['name']; ?> </span><?php echo $item['hotel']['category']['name']; ?></a>
                        </div>
                        <div class="card-body--region d-flex align-items-center justify-content-start">
                            <p><span class="text-uppercase"><?php echo $item['hotel']['countries']['name']; ?></span> <?php echo $item['hotel']['cites']['name']; ?></p>
                        </div>
                        <div class="tour-identification--list cube-hidden">
                            <ul class="tour-list d-flex flex-wrap">
                                <?php foreach ($item['description_list'] as $v): ?>
                                    <li class="tour-list--item before">
                                        <small><?php echo $v['key']; ?></small><?php echo $v['value']; ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div class="card-body--desc list-hidden"><?php echo $item['description']; ?></div>
                    </div>
                    <?php if (isset($item['hotelService'])): ?>
                        <div class="cube-hidden card--privileges ">
                            <div class="card--privileges ml-auto">
                                <?php foreach ($item['hotelService'] as $v): ?>
                                    <?php if (isset(Yii::$app->params['hotel_service'][$v['code']])): ?>
                                        <button class="snap snap-size-xs" data-toggle="tooltip" data-html="true" title="<?php echo $v['name']; ?>">
                                            <object type="image/svg+xml" data="<?php echo yii\helpers\Url::to('/img/service_icon/' . Yii::$app->params['hotel_service'][$v['code']], TRUE); ?>" width="20" height="20">
                                                <img src="<?php echo yii\helpers\Url::to('/img/service_icon/' . Yii::$app->params['hotel_service'][$v['code']], TRUE); ?>" width="20" height="20" alt="image format png">
                                            </object>
                                        </button>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="card-footer">
                    <a href="<?php echo $item['link']; ?>" class="btn-regular btn-size-m button-isi" target="_blank">Подробнее</a>
                    <div class="card-footer--prices">
                        <div class="descount-price">
                            <small>от</small> <?php echo number_format($item['price'], 2, '.', ' ') . ' ₴'; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <div class="result-card col-xs-12 col-md-6 col-xl-4 btn-card-more">
        <div class="card card-size-s ">
            <div class="card-more-wrapper next-page" data-page="0">
                <div class="more-loader"></div>
                <div class="more-text">
                    Показать еще
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>