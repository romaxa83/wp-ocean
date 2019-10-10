<?php

namespace backend\modules\dispatch\repository;

use backend\modules\dispatch\entities\NewsLetter;

class NewsRepository
{
    public function get($id): NewsLetter
    {
        if (!$news = NewsLetter::findOne($id)) {
            throw new \DomainException('News-letter is not found.');
        }
        return $news;
    }

    public function save(NewsLetter $news): void
    {
        if (!$news->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(NewsLetter $news): void
    {
        if (!$news->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}