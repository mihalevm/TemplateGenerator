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

/**
 * AttreditorForm is the model behind the contact form.
 */
class DocumentForm extends Model {
    protected $db_conn;

    function __construct () {
        $this->db_conn = Yii::$app->db;
    }

    public function getTemplateCount ($tid){
        $arr = $this->db_conn->createCommand("select max(step) as cnt from tg_wizard where tid = :tid")
            ->bindValue(':tid', $tid)
            ->queryAll();

        return intval($arr[0]['cnt']);
    }

    public function getTemplateName ($tid){
        $arr = $this->db_conn->createCommand("select tname from tg_templates where tid = :tid")
            ->bindValue(':tid', $tid)
            ->queryAll();

        return $arr[0]['tname'];
    }

    public function getMasterWizard ($tid){
        $arr = $this->db_conn->createCommand("select w.step, w.pos, w.req, a.aname, t.ttype, a.title, a.adesc, a.test from tg_wizard w, tg_attributes a, tg_attributes_type t where w.attr=a.aid and a.atype = t.tid and w.tid=:tid order by step, pos")
            ->bindValue(':tid', $tid)
            ->queryAll();

        return $arr;
    }

    public function getAttributeIdbyKey ($key){
        $arr = $this->db_conn->createCommand("select aid from tg_attributes where aname=:aname")
            ->bindValue(':aname', $key)
            ->queryAll();

        return $arr[0]['aid'];
    }

    public function saveDocAttr ($tid, $dkey, $aid, $val) {
        $aid = $this->getAttributeIdbyKey($aid);

        $this->db_conn->createCommand("insert into tg_documents (dkey, tid, aid, val) values (:dkey, :tid, :aid, :val)")
            ->bindValue(':dkey', $dkey)
            ->bindValue(':tid', $tid)
            ->bindValue(':aid', $aid)
            ->bindValue(':val', $val)
            ->execute();

        $arr = $this->db_conn->getLastInsertID();

        return $arr;
    }

    public function getTemplatebyDkey ($dkey){
        $arr = $this->db_conn->createCommand("select t.tbody from tg_templates t, tg_documents d where t.tid=d.tid and d.dkey=:dkey limit 1")
            ->bindValue(':dkey', $dkey)
            ->queryAll();

        return $arr[0]['tbody'];
    }

    public function getDocumentVars ($dkey) {
        $arr = $this->db_conn->createCommand("select a.aname, d.val, t.ttype from tg_attributes a, tg_documents d, tg_attributes_type t where a.atype=t.tid and a.aid=d.aid and d.dkey=:dkey")
            ->bindValue(':dkey', $dkey)
            ->queryAll();

        return $arr;
    }

    public function getTemplateAttrs ($tid) {
        $arr = $this->db_conn->createCommand("select tvars from tg_templates where tid=:tid")
            ->bindValue(':tid', $tid)
            ->queryAll();

        $tvars = $arr[0]['tvars'];

        if ($tvars) {
            $arr = $this->db_conn->createCommand("select aname from tg_attributes where aid in (" . $tvars . ")")
                ->queryAll();

            $res = [];

            foreach ($arr as $itattr){
                $res[$itattr['aname']] = '';
            }

            $arr = $res;

        } else {
            $arr = [];
        }

        return $arr;
    }

    public function getAttributeKeybyId ($aid){
        $arr = $this->db_conn->createCommand("select aname from tg_attributes where aid=:aid")
            ->bindValue(':aid', $aid)
            ->queryAll();

        return $arr[0]['aname'];
    }

    public function getScriptForTemplate($tid){
        $res = [];
        $arr = $this->db_conn->createCommand("select inn, oname, addr, status, ogrn, cdata, kpp, otype from tg_plugin_egrul where tid=:tid")
            ->bindValue(':tid', $tid)
            ->queryAll();

        foreach ($arr as $it) {
            $it['inn'] = $this->getAttributeKeybyId($it['inn']);
            $it['oname'] = $this->getAttributeKeybyId($it['oname']);
            $it['addr'] = $this->getAttributeKeybyId($it['addr']);
            $it['status'] = $this->getAttributeKeybyId($it['status']);
            $it['ogrn'] = $this->getAttributeKeybyId($it['ogrn']);
            $it['cdata'] = $this->getAttributeKeybyId($it['cdata']);
            $it['kpp'] = $this->getAttributeKeybyId($it['kpp']);
            $it['otype'] = $this->getAttributeKeybyId($it['otype']);
            array_push($res, $it);
        }

        return $res;
    }

}