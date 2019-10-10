<?php

namespace backend\modules\user\events;

use backend\modules\user\entities\IntPassport;

class PassportIntRejectScan
{
    public $passport;

    public function __construct(IntPassport $passport)
    {
        $this->passport = $passport;
    }
}