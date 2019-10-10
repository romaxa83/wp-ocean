<?php

namespace backend\tests\unit\modules\forms;

use backend\modules\user\entities\Passport;
use backend\modules\user\forms\PassportForm;
use backend\tests\fixtures\user\UserFixture;
use backend\modules\user\forms\UserForm;
use common\models\User;

class PassportFormTest extends \Codeception\Test\Unit
{
    public function testEmptyValue()
    {
        $data = [];
        $form = $this->generatePassport($data);

        expect_not($form->validate());

        expect_that($form->getErrors('first_name'));
        expect($form->getFirstError('first_name'))
            ->equals('Необходимо заполнить «Имя».');

        expect_that($form->getErrors('last_name'));
        expect($form->getFirstError('last_name'))
            ->equals('Необходимо заполнить «Фамилия».');
    }

    public function testSuccessRequiredValue()
    {
        $data = [
            'first_name' => 'Bruce',
            'last_name' => 'Lee'
        ];
        $form = $this->generatePassport($data);

        expect_that($form->validate());
    }

    private function generatePassport($array)
    {
        $passport = Passport::create(
            $array['first_name']??null,
            $array['last_name']??null,
            $array['patronymic']??null,
            $array['birthday']??null,
            $array['series']??null,
            $array['number']??null,
            $array['issued']??null,
            $array['issued_date']??null
        );
        return new PassportForm($passport);
    }

}