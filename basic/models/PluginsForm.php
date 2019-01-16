<?php
/**
 * Created by PhpStorm.
 * User: mmv
 * Date: 18.12.2018
 * Time: 10:48
 */
namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\rest\UpdateAction;

/**
 * AttreditorForm is the model behind the contact form.
 */
class PluginsForm extends Model {
    protected $db_conn;

    function __construct () {
        $this->db_conn = Yii::$app->db;
    }

    public function selectAllTemplates (){
        $arr = $this->db_conn->createCommand("select tid, tname from tg_templates")
            ->queryAll();

        $arr = ArrayHelper::map($arr,'tid','tname');

        $arr[0] = 'Выбрать шаблон';
        ksort($arr);

        return $arr;
    }

    public function getTemplateAttrs ($tid) {
        $arr = $this->db_conn->createCommand("select tvars from tg_templates where tid=:tid")
            ->bindValue(':tid', $tid)
            ->queryAll();

        $tvars = $arr[0]['tvars'];

        if ($tvars) {
            $arr = $this->db_conn->createCommand("select aid, aname, adesc from tg_attributes where aid in (" . $tvars . ")")
                ->queryAll();
        } else {
            $arr = [];
        }

        return $arr;
    }

    public function saveTemplateAttrs($tid, $inn, $oname, $addr, $st, $ogrn, $cdata, $kpp, $otype){
        $arr = $this->db_conn->createCommand("select count(*) as cnt from tg_plugin_egrul where tid=:tid and inn=:inn")
            ->bindValue(':tid', $tid)
            ->bindValue(':inn', $inn)
            ->queryAll();

        if ( $arr[0]['cnt'] == 0 ){
            $this->db_conn->createCommand("insert into tg_plugin_egrul (tid, inn, oname, addr, status, ogrn, cdata, kpp, otype) values (:tid, :inn, :oname, :addr, :status, :ogrn, :cdata, :kpp, :otype)")
                ->bindValue(':tid', $tid)
                ->bindValue(':inn', $inn)
                ->bindValue(':oname', $oname)
                ->bindValue(':addr', $addr)
                ->bindValue(':status', $st)
                ->bindValue(':ogrn', $ogrn)
                ->bindValue(':cdata', $cdata)
                ->bindValue(':kpp', $kpp)
                ->bindValue(':otype', $otype)
                ->execute();

            $arr = $this->db_conn->getLastInsertID();
        } else {
            $this->db_conn->createCommand("update tg_plugin_egrul set oname=:oname, addr=:addr, status=:status, ogrn=:ogrn, cdata=:cdata, kpp=:kpp, otype=:otype where tid=:tid and inn=:inn")
                ->bindValue(':tid', $tid)
                ->bindValue(':inn', $inn)
                ->bindValue(':oname', $oname)
                ->bindValue(':addr', $addr)
                ->bindValue(':status', $st)
                ->bindValue(':ogrn', $ogrn)
                ->bindValue(':cdata', $cdata)
                ->bindValue(':kpp', $kpp)
                ->bindValue(':otype', $otype)
                ->execute();

            $arr = 1;
        }

        return $arr;
    }

    public function getScriptForTemplate($tid){
        $arr = $this->db_conn->createCommand("select tid, inn, oname, addr, status, ogrn, cdata, kpp, otype from tg_plugin_egrul where tid=:tid")
            ->bindValue(':tid', $tid)
            ->queryAll();

        return $arr;
    }

    public function deleteScriptForTemplate($tid, $inn){
        $arr = $this->db_conn->createCommand("delete from tg_plugin_egrul where tid=:tid and inn=:inn")
            ->bindValue(':tid', $tid)
            ->bindValue(':inn', $inn)
            ->execute();

        return $arr;
    }


}