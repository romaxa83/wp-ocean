<?php

namespace backend\modules\user\events;

use backend\modules\user\entities\Passport;
use common\models\User;

class UserSignUpConfirm
{
    public $user;
    public $passport;

    public function __construct(User $user,Passport $passport)
    {
        $this->user = $user;
        $this->passport = $passport;
    }
}