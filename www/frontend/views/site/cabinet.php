<?php

/* @var $this yii\web\View */
/* @var $form backend\modules\user\forms\PassportForm */

use yii\helpers\Html;

$this->title = 'Cabinet';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cabinet">
    <div class="box-body">
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#passport-form" data-toggle="tab" aria-expanded="true" style="color: #949ba2;">Passport-form</a>
            </li>
            <li class="">
                <a href="#int-passport-form" data-toggle="tab" aria-expanded="false" style="color: #949ba2;">Int-passport-form</a>
            </li>
            <li class="">
                <a href="#int-change-password" data-toggle="tab" aria-expanded="false" style="color: #949ba2;">Change-password</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade active in" id="passport-form">
                <div class="box-header with-border">
                    <h3 class="box-title">Passport</h3>
                </div>
                <?= \backend\modules\user\widgets\user\UserWidget::widget([
                    'template' => 'passport',
                    'form' => $form,
                ])?>
            </div>
            <div class="tab-pane fade" id="int-passport-form">
                <div class="box-header with-border">
                    <h3 class="box-title">Int-Passport</h3>
                </div>
                <?= \backend\modules\user\widgets\user\UserWidget::widget([
                    'template' => 'int-passport',
                    'countForms' => 1
                ])?>
            </div>
            <div class="tab-pane fade" id="int-change-password">
                <div class="box-header with-border">
                    <h3 class="box-title">Change-password</h3>
                </div>
                <?= \backend\modules\user\widgets\user\UserWidget::widget([
                    'template' => 'change-password'
                ])?>
            </div>
        </div>
    </div>
</div>