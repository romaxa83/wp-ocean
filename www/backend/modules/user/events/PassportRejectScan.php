<?php

namespace backend\modules\user\events;

use backend\modules\user\entities\Passport;

class PassportRejectScan
{
    public $passport;

    public function __construct(Passport $passport)
    {
        $this->passport = $passport;
    }
}