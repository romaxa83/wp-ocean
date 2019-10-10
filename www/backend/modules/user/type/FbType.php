<?php

namespace backend\modules\user\type;

class FbType
{
    public $firstName;
    public $lastName;
    public $email;
    public $fbId;
    public $source;

    public function __construct(string $name, string $email ,string $id)
    {
        $parseName = $this->parseName($name);
        $this->email = $email;
        $this->fbId = $id;
        $this->source = 'facebook';
        $this->firstName = $parseName[0];
        $this->lastName = $parseName[1];
    }

    private function parseName($name)
    {
        if(strpos($name, 0x20)){

            return explode(' ',$name);
        }
        return [$name,' '];
    }
}