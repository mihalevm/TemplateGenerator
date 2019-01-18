<?php

use yii\helpers\Html;
use yii\bootstrap\Button;
use yii\widgets\Pjax;

use app\assets\TgAsset;

TgAsset::register($this);

/* @var $this yii\web\View */

$this->title = 'Редактор атрибутов';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="tg-edit-fields">
    <?= Html::textInput('aid', null, ['hidden' => 'true']); ?><br/>
    <label>Название: </label> <?= Html::textInput('aname', null, ['placeholder' => 'Название переменной APP_INN_DEF']); ?><br/>
    <label>Описание: </label> <?= Html::textInput('adesc', null, ['placeholder' => 'Описание переменной']); ?><br/>
    <label>Тип: </label> <?= Html::dropDownList('atype', null, $allAtributeType) ?><br/>
    <label>Имя: </label> <?= Html::textInput('atitle', null, ['placeholder' => 'Отображаемое имя']); ?><br/>
    <label>Тестовые данные: </label> <?= Html::textInput('atest', null, ['placeholder' => 'Тестовые данные']); ?><br/>

    <div class="tg-edit-control">
<?php
    echo Button::widget([
        'label' => 'Сохранить',
        'options' => [
            'class' => 'btn-primary grid-button pull-right',
            'onclick' => 'attreditor.saveAttr()'
        ],
    ]);
    echo Button::widget([
        'label' => 'Добавить',
        'options' => [
            'class' => ' btn-secondary grid-button pull-right',
            'onclick' => 'attreditor.clearAttr()'
        ],
    ]);
?>
    </div>
</div>
<div>
    <?php
    Pjax::begin(['id' => 'attr_list', 'timeout' => false, 'enablePushState' => false, 'clientOptions' => ['method' => 'POST']]);
    echo \yii\grid\GridView::widget([
        'dataProvider' => $allAtributes,
        'layout' => "{items}<div align='right'>{pager}</div>",
        'rowOptions' => function ($model, $key, $index, $grid) {
            return [
                'class'      => $index&1 ? 'tg-attr-item-one':'tg-attr-item-two',
                'data-aid'   => $model['aid'],
                'data-atype'   => $model['atype'],
                'data-aname' => $model['aname'],
                'data-adesc' => $model['adesc'],
                'data-title' => $model['title'],
                'data-test'  => $model['test'],
                'onclick'    => 'attreditor.setActiveItem(this);'
            ];
        },
        'columns' => [
            [
                'attribute'=>'aid',
                'label'=>'№',
            ],
            [
                'format' => 'ntext',
                'attribute'=>'aname',
                'label'=>'Название',
            ],
            [
                'format' => 'ntext',
                'attribute'=>'tname',
                'label'=>'Тип',
            ],
            [
                'format' => 'ntext',
                'attribute'=>'adesc',
                'label'=>'Описание',
            ],
            [
                'format' => 'ntext',
                'attribute'=>'title',
                'label'=>'Заголовок',
            ],
            [
                'format' => 'ntext',
                'attribute'=>'test',
                'label'=>'Тестовое значение',
            ],
            [
                'label' => 'Действие',
                'format' => 'raw',
                'value' => function($data){
                    return '<div class="tg-attr-tools" onclick="attreditor.deleteAttr('.$data['aid'].')"><i class="fa fa-times" aria-hidden="true"></i></div>';
                }
            ],
        ],
    ]);
    Pjax::end();
    ?>
</div>