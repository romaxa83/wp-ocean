<?php

namespace console\controllers;

use backend\modules\faq\models\Category;
use backend\modules\faq\models\Faq;
use yii\helpers\Console;
use yii\console\Controller;

/**
 * Заполняет модули фейковыми данными.
 */
class FakeController extends Controller
{

    /**
     * Заполняет данные для модуля F.A.Q.
     * @package app\commands
     */
    public function actionFaqFill()
    {
        $faqCategory = require __DIR__ . '/../data/FaqCategoryData.php';
        $faq = require __DIR__ . '/../data/FaqData.php';

        \Yii::$app->db->createCommand()->batchInsert(
            'faq_category',['id','alias','name','position','status','created','updated'],
            array_map(function($item) {
                return [
                    'id' => $item['id'],
                    'alias' => $item['alias'],
                    'name' => $item['name'],
                    'position' => $item['position'],
                    'status' => $item['status'],
                    'created' => $item['created'],
                    'updated' => $item['updated'],
                ];
            },$faqCategory)
        )->execute();

        $this->stdout('Добавленно ('.count($faqCategory).') категория' . PHP_EOL,Console::FG_GREEN);

        \Yii::$app->db->createCommand()->batchInsert(
            'faq',['id','category_id','question','answer','page_faq','rate_faq','page_vip','rate_vip','page_exo','rate_exo','page_hot','rate_hot','status','created_at'],
            array_map(function($item) use($faqCategory) {
                return [
                    'id' => $item['id'],
                    'category_id' => rand(1,count($faqCategory)),
                    'question' => $item['question'],
                    'answer' => $item['answer'],
                    'page_faq' => $item['page_faq'],
                    'rate_faq' => $item['rate_faq'],
                    'page_vip' => $item['page_vip'],
                    'rate_vip' => $item['rate_vip'],
                    'page_exo' => $item['page_exo'],
                    'rate_exo' => $item['rate_exo'],
                    'page_hot' => $item['page_hot'],
                    'rate_hot' => $item['rate_hot'],
                    'status' => $item['status'],
                    'created_at' => $item['created_at'],
                ];
            },$faq)
        )->execute();

        $this->stdout('Добавленно ('.count($faq).') записей' . PHP_EOL,Console::FG_GREEN);
    }

    /**
     * Удаляет данные для модуля F.A.Q.
     * @package app\commands
     */
    public function actionFaqClear()
    {
        Category::deleteAll();
        Faq::deleteAll();
        $this->stdout('Корзиночка пуста ¯\_(ツ)_/¯' . PHP_EOL,Console::FG_RED);
    }
}