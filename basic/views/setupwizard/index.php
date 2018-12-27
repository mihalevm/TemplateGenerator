<?php

use yii\helpers\Html;
use yii\bootstrap\Button;
use yii\widgets\Pjax;

use app\assets\TgAsset;

TgAsset::register($this);

/* @var $this yii\web\View */

$this->title = 'Редактор мастера настройки';
$this->params['breadcrumbs'][] = $this->title;
?>
<?= Html::textInput('tid', null, ['hidden' => 'true']); ?>
<?= Html::textInput('tname', null, ['hidden' => 'true']); ?>

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
                'data-tname'   => $model['tname'],
                'onclick'    => 'setupwizard.setActiveItem(this);'
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
            [
                'format' => 'ntext',
                'attribute'=>'wizard',
                'label'=>'Мастер',
                'value' => function($data){
                    $item = 'Не настроен';
                    if (intval($data['wizard']) > 0) {
                        $item = 'Настроен';
                    }

                    return $item;
                }
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
                'onclick' => 'setupwizard.previewTemplate()'
            ],
        ]);
//        echo Button::widget([
//            'label' => 'Добавить',
//            'options' => [
//                'class' => 'btn-primary grid-button pull-left',
//                'onclick' => 'setupwizard.editSelectedItem(true)'
//            ],
//        ]);
//        echo Button::widget([
//            'label' => 'Удалить',
//            'options' => [
//                'class' => 'btn-primary grid-button pull-left',
//                'onclick' => 'setupwizard.deleteSelectedItem()'
//            ],
//        ]);
        echo Button::widget([
            'label' => 'Редактировать',
            'options' => [
                'class' => 'btn-secondary grid-button pull-right',
                'onclick' => 'setupwizard.editSelectedItem(false)'
            ],
        ]);
        ?>
    </div>
</div>
<div id="editor-holder">
<div id="wizard-editor">
    <table class="tree"></table>
</div>
<div class="tg-templates-control">
    <?php
    echo Button::widget([
        'label' => 'Добавить шаг',
        'options' => [
            'class' => 'btn-success grid-button pull-left',
            'onclick' => 'setupwizard.addStep()'
        ],
    ]);
    echo Button::widget([
        'label' => 'Сохранить и продолжить',
        'options' => [
            'class' => 'btn-primary grid-button pull-right',
            'onclick' => 'setupwizard.saveWizardSteps(true)'
        ],
    ]);
    echo Button::widget([
        'label' => 'Сохранить и закрыть',
        'options' => [
            'class' => 'btn-primary grid-button pull-right',
                'onclick' => 'setupwizard.saveWizardSteps()'
        ],
    ]);
    echo Button::widget([
        'label' => 'Предпросмотр',
        'options' => [
            'class' => 'btn-primary grid-button pull-right',
            'onclick' => 'setupwizard.previewTemplate()'
        ],
    ]);
    echo Button::widget([
        'label' => 'Отмена',
        'options' => [
            'class' => 'btn-secondary grid-button pull-right',
            'onclick' => 'setupwizard.cancelSelectedItem()'
        ],
    ]);
    ?>
</div>
</div>
