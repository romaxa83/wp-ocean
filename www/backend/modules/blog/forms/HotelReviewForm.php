<?php

namespace backend\modules\blog\forms;

use backend\modules\blog\entities\HotelReview;
use backend\modules\blog\helpers\DateHelper;
use backend\modules\blog\validators\AliasValidator;
use backend\modules\blog\repository\HotelReadRepository;

class HotelReviewForm extends CompositeForm
{
    public $hotel_id;
    public $title;
    public $alias;
    public $description;
    public $media_ids;
    public $content;
    public $status;
    public $published_at;

    public $hide_media;

    private $_hotel_review;

    public function __construct(HotelReview $hotel_review = null, $config = [])
    {
        if ($hotel_review) {
            $this->hotel_id = $hotel_review->hotel_id;
            $this->title = $hotel_review->title;
            $this->alias = $hotel_review->alias;
            $this->description = $hotel_review->description;
            $this->content = $hotel_review->content;
            $this->media_ids = $hotel_review->media_ids;
            $this->status = (int)$hotel_review->status;
            $this->published_at = DateHelper::convertUnixForPublished($hotel_review->published_at);

            $this->tagsReview = new TagsReviewForm($hotel_review);
            $this->meta = new MetaForm($hotel_review->seo);
            $this->_hotel_review = $hotel_review;
        } else {
            $this->tagsReview = new TagsReviewForm();
            $this->meta = new MetaForm();
        }
        parent::__construct($config);

    }

    public function rules(): array
    {
        return [
            [['hotel_id', 'title','alias','content','published_at'], 'required'],
            [['title','alias','description'], 'string', 'max' => 255],
            [['description', 'content'], 'string'],
            ['alias', AliasValidator::class],
            [['title', 'alias'], 'unique', 'targetClass' => HotelReview::class, 'filter' => $this->_hotel_review ? ['<>', 'id', $this->_hotel_review->id] : null],
            [['published_at','status','media_ids','hide_media','status'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название обзора',
            'alias' => 'Алиас',
            'content' => 'Контент',
            'description' => 'Описание',
            'hotel_id' => 'Отель',
            'status' => 'Статус',
            'published_at' => 'Дата публикации',
        ];
    }

    /**
     * @return array
     */
    public function hotelList(): array
    {
        return (new HotelReadRepository())->getAllOnlyName();
    }

    /**
     * @return array
     */
    protected function internalForms(): array
    {
        return ['tagsReview','meta'];
    }
}