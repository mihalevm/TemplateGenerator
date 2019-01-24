<?php

use yii\widgets\Pjax;
use app\assets\TgAsset;

TgAsset::register($this);

$this->title = 'Просмотр документов';
$this->params['breadcrumbs'][] = $this->title;

?>
<div>
    <?php
    Pjax::begin(['id' => 'doc_list', 'timeout' => false, 'enablePushState' => false, 'clientOptions' => ['method' => 'POST']]);
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
                'attribute'=>'uname',
                'label'=>'Email пользователя',
                'value' => function($data){
                    return $data['uname'] ? $data['uname'] : '';
                }
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
                    return '<div class="tg-doclist-tools" onclick="doclist.preview(`'.$data['dkey'].'`)"><i class="fa fa-search" aria-hidden="true"></i></div><div class="tg-doclist-tools" onclick="doclist.delete(`'.$data['dkey'].'`)"><i class="fa fa-times" aria-hidden="true"></i></div>';
                }
            ],
        ],
    ]);
    Pjax::end();
    ?>
</div>