<?php

namespace backend\modules\staticBlocks\services;

use backend\modules\staticBlocks\entities\Block;
use backend\modules\staticBlocks\forms\CompanyForm;
use backend\modules\staticBlocks\forms\SeoForm;
use backend\modules\staticBlocks\type\StatusType;
use backend\modules\staticBlocks\repository\StaticDataRepository;


class StaticBlocksService
{
    private $static_repository;

    public function __construct(
        StaticDataRepository $static_repository
    )
    {
        $this->static_repository = $static_repository;
    }

    public function create(SeoForm $form)
    {
        $seo = Block::create(
            $form->title,
            $form->alias,
            $form->description,
            $form->position,
            'seo'
        );

        $this->static_repository->save($seo);
    }

    public function createCompany(CompanyForm $form)
    {
        $seo = Block::create(
            $form->title,
            $form->alias,
            $form->description,
            $form->position,
            'company'
        );

        $this->static_repository->save($seo);
    }

    public function edit($id,$form)
    {
//        debug($form);
//        dd($id);
        $block = $this->static_repository->get($id);

        //при изменении позици,перезаписываем другой секции новую позицию
        if($block->position != $form->position){
            $block2 = $this->static_repository->getByPosition($form->position,$block->block);
            $block2->changePosition($block->position);
            $this->static_repository->save($block2);
        }
        $block->edit($form->title,$form->alias,$form->description,$form->position);
        $this->static_repository->save($block);
    }

    public function changeStatus(StatusType $status): void
    {
        $static = $this->static_repository->get($status->id);
        $static->status($status->checked);
        $this->static_repository->save($static);
    }

    public function toggleBlock($block_name,$status)
    {
        $this->static_repository->saveStatusBlock($block_name,$status);
    }
}