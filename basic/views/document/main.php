<?php

use yii\helpers\Html;
use yii\bootstrap\Button;
use app\assets\TgAsset;

TgAsset::register($this);

/* @var $this yii\web\View */

$this->title = 'Генератор документов';
?>


<div class="tg-document-main">
    <label>Адрес эл. почты: </label> <?= Html::textInput('email', null, ['placeholder' => 'email']); ?><br/>
    <label>Номер телефона: </label> <?= Html::textInput('phone', null, ['placeholder' => 'Номер']); ?><br/>
    <label>Выберите шаблон: </label> <?= Html::dropDownList('template', null, $allTemplates) ?><br/>

    <?php
        echo Button::widget([
        'label' => 'Создать',
            'options' => [
                'class' => ' btn-secondary grid-button pull-right',
                'onclick' => 'documentGen.create()'
            ],
        ]);
    ?>
</div>