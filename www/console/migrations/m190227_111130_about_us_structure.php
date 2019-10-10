<?php

use yii\db\Migration;
use yii\db\Query;

/**
 * Class m190227_111130_about_us_structure
 */
class m190227_111130_about_us_structure extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('slug_manager', [
            'slug' => 'o-kompanii',
            'route' => 'team/index',
            'template' => 'about-us'
        ]);

        $slug_id = Yii::$app->db->createCommand('SELECT id FROM slug_manager ORDER BY id DESC LIMIT 1')->queryOne();
        $slug_id = $slug_id['id'];

        $this->insert('page', [
            'title' => 'О Компании',
            'slug_id' => $slug_id,
            'creation_date' => date('Y-m-d'),
            'modification_date' => date('Y-m-d'),
        ]);

        $page_id = Yii::$app->db->createCommand('SELECT id FROM page ORDER BY id DESC LIMIT 1;')->queryOne();
        $page_id = $page_id['id'];

        $this->insert('page_meta', [
            'page_id' => $page_id,
            'title' => 'О Компании',
            'description' => 'Description',
            'keywords' => ''
        ]);

        $description = "<h2>Подзаголовок</h2>
        <p>Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Mauris in erat justo. 
        Nullam ac urna eu felis dapibus condimentum sit amet a augue. Sed non neque elit. Sed ut imperdiet nisi. Proin condimentum 
        fermentum nunc. Etiam pharetra, erat sed fermentum feugiat, velit mauris egestas quam, ut aliquam massa nisl quis neque. 
        Suspendisse in orci enim.</p>
        <ol>
            <li>Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat 
            ipsum, nec sagittis sem nibh id elit.</li>
            <li>Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio 
            tincidunt auctor a ornare odio.Sed non mauris vitae erat consequat auctor eu in elit.</li>
            <li>Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</li>
        </ol>
        <ul>
            <li>Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat 
            ipsum, nec sagittis sem nibh id elit.</li>
            <li>Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio 
            tincidunt auctor a ornare odio. Sed non mauris vitae erat consequat auctor eu in elit.</li>
            <li>Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</li>
        </ul>";

        $team = 'a:1:{i:0;a:3:{s:5:"photo";s:1:"1";s:4:"name";s:27:"Инна Николаева";s:11:"description";s:36:"менеджер по туризму";}}';

        $this->insert('page_text', [
            'page_id' => $page_id,
            'name' => 'description',
            'label' => 'О Компании',
            'type' => 'editor',
            'text' => $description
        ]);

        $this->insert('page_text', [
            'page_id' => $page_id,
            'name' => 'team',
            'label' => 'Команда',
            'type' => 'team',
            'text' => $team
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190227_111130_about_us_structure cannot be reverted.\n";

        return false;
    }
}
