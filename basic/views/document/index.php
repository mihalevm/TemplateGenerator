<?php

use yii\helpers\Html;
//use yii\bootstrap\Button;
use yii\jui\DatePicker;
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
    <script>
        var plg_egrul = JSON.parse('<?php echo json_encode($plg_egrul) ?>');
    </script>
<?php
    for ($step = 1; $step <= $StepCount; $step++) {
        echo "<div id='step-".$step."' class=''>";
        $plg_egrul_bnt = '';
        $step_desc = NULL;
        foreach ($Master as $StepContent) {
            if (intval($StepContent['step']) == $step) {
                if ($StepContent['sdesc'] && !$step_desc) {
                    $step_desc = $step;
                    echo '<span class="doc_item"><label>Описание</label><label>'.$StepContent['sdesc'].'</label></span><br/>';
                }

                $plg_egrul_idx = 0;
                foreach ($plg_egrul as $script_item) {
                    if ($script_item['inn'] == $StepContent['aname']){
                        $plg_egrul_bnt = '<button class="btn btn-primary disabled" onclick="plugin_client_egrul.autofill(plg_egrul['.$plg_egrul_idx.'], '.$step.', \''.$StepContent['aname'].'\')">Автозаполнение</button>';
                        break;
                    }
                    $plg_egrul_idx++;
                }

                $required = ($StepContent['req']?'required=""':'');

                if ($StepContent['ttype'] == 'TTABLE'){
                    echo '<br/>';
                    echo '<span class="doc_item" name="'.$StepContent['aname'].'"><label>'.$StepContent['title'].'</label>'.preg_replace('/{(v\d+)}/', "<input style='width: 90%;' type='text' name='$1' ".$required." data-type='table' >", $StepContent['test']).'</span>';
                    echo '<br/>';
                }
                if ($StepContent['ttype'] == 'TINPUT'){
                    echo '<span class="doc_item"><label>'.$StepContent['title'].'</label><input type="text" name="'.$StepContent['aname'].'" '.$required.' ></span>';
                    echo $plg_egrul_bnt;
                    echo '<br/>';
                }
                if ($StepContent['ttype'] == 'TAREA'){
                    echo '<span class="doc_item"><label>'.$StepContent['title'].'</label><textarea name="'.$StepContent['aname'].'"  '.$required.' ></textarea></span>';
                    echo $plg_egrul_bnt;
                    echo '<br/>';

                }
                if ($StepContent['ttype'] == 'TCHECK'){
                    echo '<span class="doc_item"><label>'.$StepContent['title'].'</label><input type="checkbox" name="'.$StepContent['aname'].'" '.$required.' ></input></span>';
                }
                if ($StepContent['ttype'] == 'TSELECT'){
                    echo '<span class="doc_item"><label>'.$StepContent['title'].'</label>';
                    foreach (explode(';',$StepContent['test']) as $it){
                        if (strlen($it)>0) {
                            echo '<p><input type="radio" name="' . $StepContent['aname'] . '" value="'.$it.'"  '.$required.' >' . $it . '</p>';
                        }
                    };
                    echo '</input></span><br/>';
                    echo $plg_egrul_bnt;
                    echo '<br/>';
                }
                if ($StepContent['ttype'] == 'TCALENDAR'){
                    $required = (strlen($required)>0?['required'=>'']:[]);

                    echo '<span class="doc_item"><label>'.$StepContent['title'].'</label>';
                    echo DatePicker::widget([
                        'language' => 'ru',
                        'dateFormat' => 'dd.MM.yyyy',
                        'name' => $StepContent['aname'],
                        'options' => $required,
                    ]);
                    echo '</span><br/>';
                }
                if ($StepContent['ttype'] == 'TDROPDOWN'){
                    echo '<span class="doc_item"><label>'.$StepContent['title'].'</label><select name="' . $StepContent['aname'] . '">';
                    foreach (explode(';',$StepContent['test']) as $it){
                        if (strlen($it)>0) {
                            echo '<option value="'.$it.'">' . $it . '</option>';
                        }
                    };
                    echo '</select></span>';
                    echo $plg_egrul_bnt;
                    echo '<br/>';
                }
            }

            if ($plg_egrul_bnt) {
                echo "<script>setTimeout(function () { $('input[name=\'".$StepContent['aname']."\']').keyup(function(e) { if($(e.currentTarget).val().length){ $('#step-".$step."').find('.btn-primary:first').removeClass('disabled') }else{ $('#step-".$step."').find('.btn-primary:first').addClass('disabled') }; });}, 1000)</script>";
            }

            $plg_egrul_bnt = '';
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
                                var ret = true;

                                $('#step-'+<?=$StepCount?>).find('input').each(function (it,obj) {
                                    if ( $(obj).prop('required') && $(obj).prop('type')=='text' && $(obj).val().length == 0){
                                        $(obj).addClass('has-error');
                                        ret = false;
                                    }
                                });

                                if (ret){
                                    documentGen.saveDocument();
                                }
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

                var ret = true;

                $('#step-'+(stepNumber+1)).find('input').each(function (it,obj) {
                    if ( $(obj).prop('required') && $(obj).prop('type')=='text' && $(obj).val().length == 0){
                        $(obj).addClass('has-error');
                        ret = false;
                    }
                })

                return ret;
            });
    }, 1000);
</script>