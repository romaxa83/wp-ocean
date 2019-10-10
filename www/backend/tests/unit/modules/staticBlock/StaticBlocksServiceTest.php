<?php

namespace backend\tests\unit\modules\staticBlock;

use common\models\User;
use backend\modules\staticBlocks\forms\SeoForm;
use backend\tests\fixtures\StaticBlocksFixture;
use backend\modules\staticBlocks\entities\Block;
use backend\modules\staticBlocks\forms\CompanyForm;
use backend\modules\staticBlocks\services\StaticBlocksService;
use backend\modules\staticBlocks\repository\StaticDataRepository;

class StaticBlocksServiceTest extends \Codeception\Test\Unit
{
    /**
     * @var \backend\tests\UnitTester
     */
    protected $tester;

    /** @var $user User */
    private $user;

    /**
     * @var $staticBlocksService StaticBlocksService
     */
    private $staticBlocksService;


    /* подгрузка данных в тестовую бд,перед тестами */
    public function _before()
    {

        $this->tester->haveFixtures([
            'staticBlocks' => [
                'class' => StaticBlocksFixture::className(),
            ],
        ]);

//        $this->user = $this->tester->grabFixture('user', 1);

        $this->staticBlocksService = new StaticBlocksService(new StaticDataRepository());
    }

    public function testCreateSeo()
    {
        $repository = new StaticDataRepository();
        $block = 'seo';

        $seo = new SeoForm();
        $seo->title = 'seo_title_test';
        $seo->alias = 'seo_title_test';
        $seo->description = 'seo_description_test';
        $seo->position = 3;

        $this->staticBlocksService->create($seo);

        $seoSave = $repository->getByPosition($seo->position,$block);

        expect($seoSave->title)->equals($seo->title);
        expect($seoSave->alias)->equals($seo->alias);
        expect($seoSave->description)->equals($seo->description);
        expect($seoSave->status)->equals(Block::STATUS_ACTIVE);
        expect($seoSave->status_block)->equals(Block::STATUS_BLOCK_ACTIVE);
    }

    public function testCreateCompany()
    {
        $repository = new StaticDataRepository();
        $block = 'company';

        $company = new CompanyForm();
        $company->title = 'company_title_test';
        $company->alias = 'company_title_test';
        $company->description = 'company_description_test';
        $company->position = 3;

        $this->staticBlocksService->createCompany($company);

        $companySave = $repository->getByPosition($company->position,$block);

        expect($companySave->title)->equals($company->title);
        expect($companySave->alias)->equals($company->alias);
        expect($companySave->description)->equals($company->description);
        expect($companySave->status)->equals(Block::STATUS_ACTIVE);
        expect($companySave->status_block)->equals(Block::STATUS_BLOCK_ACTIVE);
    }

    public function testToggleBlock()
    {
        $repository = new StaticDataRepository();
        $block = 'smart';

        expect($repository->getData($block))->notEmpty();

        $this->staticBlocksService->toggleBlock($block,'false');

        expect($repository->getData($block))->isEmpty();
    }
}