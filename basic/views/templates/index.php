<?php

use yii\helpers\Html;
use yii\bootstrap\Button;
use yii\widgets\Pjax;

use app\assets\TgAsset;

TgAsset::register($this);

/* @var $this yii\web\View */

$this->title = 'Редактор шаблонов';
$this->params['breadcrumbs'][] = $this->title;
?>
<?= Html::textInput('tid', null, ['hidden' => 'true']); ?>
<div id="tmpl_list_holder">
    <?php
    Pjax::begin(['id' => 'tmpl_list', 'timeout' => false, 'enablePushState' => false, 'clientOptions' => ['method' => 'POST']]);
    echo \yii\grid\GridView::widget([
        'dataProvider' => $allTemplates,
        'layout' => "{items}<div align='right'>{pager}</div>",
        'rowOptions' => function ($model, $key, $index, $grid) {
            return [
                'class'      => $index&1 ? 'tg-attr-item-one':'tg-attr-item-two',
                'data-tid'   => $model['tid'],
                'data-tname' => $model['tname'],
                'onclick'    => 'templates.setActiveItem(this);'
            ];
        },
        'columns' => [
            [
                'attribute'=>'tid',
                'label'=>'№',
            ],
            [
                'format' => 'ntext',
                'attribute'=>'cdate',
                'label'=>'Дата создания',
            ],
            [
                'format' => 'ntext',
                'attribute'=>'tname',
                'label'=>'Название',
            ],
        ],
    ]);
    Pjax::end();
    ?>
    <div class="tg-templates-control">
        <?php
        echo Button::widget([
            'label' => 'Предпросмотр',
            'options' => [
                'class' => 'btn-primary grid-button pull-right',
                'onclick' => 'templates.previewTemplate()'
            ],
        ]);
        echo Button::widget([
            'label' => 'Добавить',
            'options' => [
                'class' => 'btn-primary grid-button pull-left',
                'onclick' => 'templates.editSelectedItem(true)'
            ],
        ]);
        echo Button::widget([
            'label' => 'Удалить',
            'options' => [
                'class' => 'btn-primary grid-button pull-left',
                'onclick' => 'templates.deleteSelectedItem()'
            ],
        ]);
        echo Button::widget([
            'label' => 'Редактировать',
            'options' => [
                'class' => ' btn-secondary grid-button pull-right',
                'onclick' => 'templates.editSelectedItem(false)'
            ],
        ]);
        ?>
    </div>
</div>
<div id="editor-holder">
<div id="froala-editor"></div>
<div class="tg-templates-control">
    <label>Название: </label> <?= Html::textInput('tname', null, ['placeholder' => 'Название шаблона', 'class'=>'form-control']); ?><br/>
    <?php
    echo Button::widget([
        'label' => 'Сохранить и продолжить',
        'options' => [
            'class' => 'btn-primary grid-button pull-right',
            'onclick' => 'templates.saveSelectedItem(true)'
        ],
    ]);
    echo Button::widget([
        'label' => 'Сохранить и закрыть',
        'options' => [
            'class' => 'btn-primary grid-button pull-right',
                'onclick' => 'templates.saveSelectedItem()'
        ],
    ]);
    echo Button::widget([
        'label' => 'Предпросмотр',
        'options' => [
            'class' => 'btn-primary grid-button pull-right',
            'onclick' => 'templates.previewTemplate()'
        ],
    ]);
    echo Button::widget([
        'label' => 'Отмена',
        'options' => [
            'class' => ' btn-secondary grid-button pull-right',
            'onclick' => 'templates.cancelSelectedItem()'
        ],
    ]);
    ?>
</div>
</div>
