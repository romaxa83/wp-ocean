<?php

namespace backend\modules\staticBlocks\helpers;

class Grid
{
    public static function set($data)
    {
        $cell = 0;
        $count = count($data);

        if($count == 4){$cell = 3;}
        if($count == 3){$cell = 4;}
        if($count == 2){$cell = 6;}
        if($count == 1){$cell = 12;}

        return $cell;
    }

}