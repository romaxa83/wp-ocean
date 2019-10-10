<?php

namespace backend\modules\blog\forms;

use backend\modules\blog\entities\Post;
use backend\modules\blog\helpers\DateHelper;
use backend\modules\blog\repository\CategoryRepository;
use backend\modules\blog\repository\CountryReadRepository;
use backend\modules\blog\repository\PostRepository;
use backend\modules\blog\repository\TagRepository;
use backend\modules\blog\validators\AliasValidator;

class PostForm extends CompositeForm
{
    public $category_id;
    public $country_id;
    public $title;
    public $alias;
    public $description;
    public $media_id;
    public $content;
    public $status;
    public $published_at;

    private $_post;

    public function __construct(Post $post = null, $config = [])
    {
        if ($post) {
            $this->category_id = $post->category_id;
            $this->country_id = $post->country_id;
            $this->title = $post->title;
            $this->alias = $post->alias;
            $this->description = $post->description;
            $this->content = $post->content;
            $this->media_id = $post->media_id;
            $this->status = (int)$post->status;
            $this->published_at = DateHelper::convertUnixForPublished($post->published_at);

            $this->tags = new TagsForm($post);
            $this->meta = new MetaForm($post->seo);
            $this->_post = $post;
        } else {
            $this->tags = new TagsForm();
            $this->meta = new MetaForm();
        }
        parent::__construct($config);

    }

    public function rules(): array
    {
        return [
            [['category_id', 'title','alias','content','published_at'], 'required'],
            [['title','alias','description'], 'string', 'max' => 255],
            [['category_id','media_id','country_id'], 'integer'],
            [['description', 'content'], 'string'],
            ['alias', AliasValidator::class],
            [['title', 'alias'], 'unique', 'targetClass' => Post::class, 'filter' => $this->_post ? ['<>', 'id', $this->_post->id] : null],
            [['published_at','status','country_id'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название поста',
            'alias' => 'Алиас',
            'content' => 'Контент',
            'description' => 'Описание',
            'category_id' => 'Категория',
            'country_id' => 'Привязать Страну',
            'status' => 'Статус',
            'published_at' => 'Дата публикации'
        ];
    }

    /**
     * @return array
     */
    public function categoriesList(): array
    {
        $cat = new CategoryForm();
        return $cat->categoriesList(true);
    }

    /**
     * @return array
     */
    public function countryList(): array
    {
        return (new CountryReadRepository(new PostRepository(new CategoryRepository(),new TagRepository())))->getAllOnlyNameForAdmin();
    }

    /**
     * @return array
     */
    protected function internalForms(): array
    {
        return ['tags','meta'];
    }
}
