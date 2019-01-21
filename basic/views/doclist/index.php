<?php

use yii\widgets\Pjax;
use app\assets\TgAsset;

TgAsset::register($this);

$this->title = 'Просмотр документов';
$this->params['breadcrumbs'][] = $this->title;

?>
<div>
    <?php
    Pjax::begin(['id' => 'attr_list', 'timeout' => false, 'enablePushState' => false, 'clientOptions' => ['method' => 'POST']]);
    echo \yii\grid\GridView::widget([
        'dataProvider' => $allDocs,
        'layout' => "{items}<div align='right'>{pager}</div>",
        'rowOptions' => function ($model, $key, $index, $grid) {
            return [
                'class' => $index&1 ? 'tg-attr-item-one':'tg-attr-item-two',
             ];
        },
        'columns' => [
            [
                'format' => 'ntext',
                'attribute'=>'dkey',
                'label'=>'Уникальное имя',
            ],
            [
                'format' => 'ntext',
                'attribute'=>'tname',
                'label'=>'Используемый шаблон',
            ],
            [
                'format' => 'ntext',
                'attribute'=>'cdate',
                'label'=>'Дата создания',
            ],
            [
                'label' => 'Действие',
                'format' => 'raw',
                'value' => function($data){
                    return '<div class="tg-attr-tools" onclick="doclist.preview(`'.$data['dkey'].'`)"><i class="fa fa-search" aria-hidden="true"></i></div>';
                }
            ],
        ],
    ]);
    Pjax::end();
    ?>
</div>