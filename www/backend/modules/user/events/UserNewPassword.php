<?php

namespace backend\modules\user\events;

use common\models\User;
use backend\modules\user\entities\Passport;

class UserNewPassword
{
    public $user;
    public $password;

    public function __construct(User $user,string $password)
    {
        $this->user = $user;
        $this->password = $password;
    }
}