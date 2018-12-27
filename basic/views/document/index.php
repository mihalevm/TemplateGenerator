<?php

use yii\helpers\Html;
use yii\bootstrap\Button;

use app\assets\TgAsset;

TgAsset::register($this);

/* @var $this yii\web\View */

$this->title = 'Создание документа';
?>
<?= Html::textInput('tid', $tid, ['hidden' => 'true']); ?>
<div class="tg-master-doc-name">Название документа:&nbsp;<label><?php echo $DocName?></label></div>
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
    var stepCount = <?php echo $StepCount?>;
    setTimeout(function () {
            $('#docMasterHolder').fadeIn();
            $('#docMasterHolder').smartWizard({
                lang:{
                    next: 'Следующий',
                    previous: 'Предыдущий'
                },
                theme:'arrows',
                toolbarSettings: {
                    toolbarPosition: 'bottom',
                    toolbarButtonPosition: 'right',
                    showNextButton: true,
                    showPreviousButton: true,
                    toolbarExtraButtons: [
                        $('<button></button>').text('Закончить')
                            .attr('id', 'master_doc_finish')
                            .hide()
                            .addClass('btn btn-info')
                            .on('click', function(){
                                documentGen.saveDocument();
                            }),
                        $('<button></button>').text('Предпросмотр')
                            .attr('id', 'master_doc_preview')
                            .hide()
                            .addClass('btn btn-warning')
                            .on('click', function(){
                                documentGen.previewDocument();
                            }),
                    ]
                },
            });
            $("#docMasterHolder").on("leaveStep", function(e, anchorObject, stepNumber, stepDirection) {
                if (stepCount == stepNumber+2) {
                    $('#master_doc_finish').show();
                } else {
                    $('#master_doc_finish').hide();
                }

                return;
            });
    }, 1000);
</script>