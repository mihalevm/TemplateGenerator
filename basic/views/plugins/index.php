<?php

use app\assets\TgAsset;

TgAsset::register($this);

/* @var $this yii\web\View */

$this->title = 'Список плагинов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tg-plugin-list-holder">
    <table class="tg-plugin-list">
        <tr>
            <th>Название плагина</th>
            <th>Описание</th>
            <th>Настройка</th>
        </tr>
        <tr>
            <td>Автозаполнение через ЕГРЮЛ</td>
            <td>Заполнение сопоставленных полей из выписки ЕГРЮЛ</td>
            <td class="tg-plugin-list-tools"><a href="plugins/egrul"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
        </tr>
    </table>
</div>
