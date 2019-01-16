<?php

use app\assets\TgAsset;
use yii\helpers\Html;
use yii\bootstrap\Button;

TgAsset::register($this);

/* @var $this yii\web\View */

$this->title = 'Список плагинов / Автозаполнение ЕГРЮЛ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tg-plugin-list-holder">
    <label>Шаблоны: </label> <?= Html::dropDownList('temps', null, $allTemplates, ['onchange'=>'plugin_egrul.loadScriptForFields(this)']) ?><br/>
    <hr/>
    <table class="tg-plugin-egrul-fields">
        <tr>
            <td><label>Ключевое поле(ИНН): </label> <br/> <?= Html::dropDownList('inn', null, ['0'=>'Не задано']) ?></td>
            <td><label>Название: </label> <br/> <?= Html::dropDownList('oname', null, ['0'=>'Не задано']) ?></td>
            <td><label>Адрес: </label> <br/> <?= Html::dropDownList('addr', null, ['0'=>'Не задано']) ?></td>
            <td><label>Должность: </label> <br/> <?= Html::dropDownList('status', null, ['0'=>'Не задано']) ?></td>
        </tr>
        <tr>
            <td><label>ОГРН: </label> <br/> <?= Html::dropDownList('ogrn', null, ['0'=>'Не задано']) ?></td>
            <td><label>Дата регистрации: </label> <br/> <?= Html::dropDownList('cdata', null, ['0'=>'Не задано']) ?></td>
            <td><label>КПП: </label> <br/> <?= Html::dropDownList('kpp', null, ['0'=>'Не задано']) ?></td>
            <td><label>Тип: </label> <br/> <?= Html::dropDownList('otype', null, ['0'=>'Не задано']) ?></td>
        </tr>
    </table>
    <?php
    echo Button::widget([
        'label' => 'Сохранить',
        'options' => [
            'id'            => 'save_prms',
            'class'         => 'btn-primary grid-button pull-right disabled',
            'onclick'       => 'plugin_egrul.saveScriptForFields()',
            'aria-disabled' => 'true',
        ],
    ]);
    ?>

    <table class="tg-plugin-egrul-script tg-plugin-egrul-fields"></table>
</div>
