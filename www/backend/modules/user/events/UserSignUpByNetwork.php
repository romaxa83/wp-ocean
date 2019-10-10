<?php

namespace backend\modules\user\events;

use common\models\User;
use backend\modules\user\entities\Passport;

class UserSignUpByNetwork
{
    public $user;
    public $passport;
    public $password;
    public $network;

    public function __construct(User $user,Passport $passport,string $password,string $network)
    {
        $this->user = $user;
        $this->passport = $passport;
        $this->password = $password;
        $this->network = $network;
    }
}