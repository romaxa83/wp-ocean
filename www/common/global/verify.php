<?php

function isVerifyPassport()
{
    return (bool)(\backend\models\Settings::find()->where(['name' => 'verify_passport'])->one())->body;
}

function isVerifyIntPassport()
{
    return (bool)(\backend\models\Settings::find()->where(['name' => 'verify_int_passport'])->one())->body;
}