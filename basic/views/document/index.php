<?php

use yii\helpers\Html;
use yii\bootstrap\Button;

use app\assets\TgAsset;

TgAsset::register($this);

/* @var $this yii\web\View */

$this->title = 'Создание документа';
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = $DocName;
?>
<?= Html::textInput('tid', $tid, ['hidden' => 'true']); ?>
<div id="docMasterHolder">
    <ul>
<?php
    for ($step = 1; $step <= $StepCount; $step++) {
        echo "<li><a href='#step-".$step."'>Шаг ".$step."<br /><small></small></a></li>";
    }
?>
    </ul>
    <div>
<?php

//Master

    for ($step = 1; $step <= $StepCount; $step++) {
        echo "<div id='step-".$step."' class=''>";

        foreach ($Master as $StepContent) {
            if (intval($StepContent['step']) == $step) {
                if ($StepContent['ttype'] == 'TINPUT'){
                    echo '<span class="doc_item"><label>'.$StepContent['title'].'</label><input type="text" name="'.$StepContent['aname'].'"></span><br/>';
                }
            }
        }

        echo "</div>";
    }
?>
</div>
</div>

<script type="text/javascript">
    setTimeout(function () {
            $('#docMasterHolder').fadeIn();
            $('#docMasterHolder').smartWizard({
                toolbarSettings: {
                    toolbarPosition: 'bottom',
                    toolbarButtonPosition: 'right',
                    showNextButton: true,
                    showPreviousButton: true,
                    toolbarExtraButtons: [
                        $('<button></button>').text('Закончить')
                            .addClass('btn btn-info')
                            .on('click', function(){
                                documentGen.saveDocument();
                            }),
                        $('<button></button>').text('Предпросмотр')
                            .addClass('btn btn-warning')
                            .on('click', function(){
                                documentGen.previewDocument();
                            }),

                    ]
                },
            });
    }, 1000);
</script>