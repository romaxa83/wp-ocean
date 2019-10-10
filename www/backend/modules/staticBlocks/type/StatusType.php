<?php
namespace backend\modules\staticBlocks\type;

 class StatusType
{
    public $id;
    public $checked;

    public function __construct($id,$checked)
    {
        $this->id = $id;
        $this->checked = $checked;
    }
 }