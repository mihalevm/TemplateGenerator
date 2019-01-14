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


    /*

       public function selectAllTemplates (){
           $arr = $this->db_conn->createCommand("select tid, cdate, edate, tname  from tg_templates")
               ->queryAll();

           return $arr;
       }

       public function getTemplate ($tid){
           $arr = $this->db_conn->createCommand("select tbody from tg_templates where tid=".$tid)
               ->queryAll();

           return $arr;
       }

       public function setTemplate ($tid, $tbody, $attrs, $tname){
           $arr = $this->db_conn->createCommand("update tg_templates set tbody=:tbody, tvars=:attrs, tname=:tname where tid=:tid")
               ->bindValue(':tbody', $tbody)
               ->bindValue(':tid', $tid)
               ->bindValue(':attrs', $attrs)
               ->bindValue(':tname', $tname)
               ->execute();

           $arr = $this->db_conn->getLastInsertID();

           return $arr;
       }

       public function addTemplate( $tbody, $attrs, $tname){
           $arr = $this->db_conn->createCommand("insert into tg_templates (tbody, tvars, tname) values (:tbody, :attrs, :tname)")
               ->bindValue(':tbody', $tbody)
               ->bindValue(':attrs', $attrs)
               ->bindValue(':tname', $tname)
               ->execute();

           $arr = $this->db_conn->getLastInsertID();

           return $arr;

       }

       public function selectAllAttributes (){
           $arr = $this->db_conn->createCommand("select aname, adesc from tg_attributes")
               ->queryAll();

           return $arr;
       }

       public function getAttributeIdbyKey ($key){
           $arr = $this->db_conn->createCommand("select aid from tg_attributes where aname=:aname")
               ->bindValue(':aname', $key)
               ->queryAll();

           return $arr;
       }

       public function getAttrsTestData ($tid) {
           $arr = $this->db_conn->createCommand("select tvars from tg_templates where tid=:tid")
               ->bindValue(':tid', $tid)
               ->queryAll();

           $tvars = $arr[0]['tvars'];

           if ($tvars) {
               $arr = $this->db_conn->createCommand("select aname, test from tg_attributes where aid in (" . $tvars . ")")
                   ->queryAll();
           } else {
               $arr = [];
           }

           return $arr;
       }


       public function deleteTemplate ($tid) {
           $arr = $this->db_conn->createCommand("delete from tg_templates where tid=:tid")
               ->bindValue(':tid', $tid)
               ->execute();

           $arr = $this->db_conn->getLastInsertID();

           return $arr;

       }

   //------------------------------------------------------
   /*
       public function insertAttribute ($name, $type, $desc, $title, $test) {
           $res = null;

           try {
               $this->db_conn->createCommand("insert into tg_attributes (aname, atype, adesc, title, test) values ('".$name."','".$type."','".$desc."','".$title."','".$test."')")
                   ->execute();
               $res = $this->db_conn->getLastInsertID();
           } catch (\Exception $e) {
               throw new \yii\web\HttpException(405, 'Error saving model');
           }

           return  $res;
       }

       public function updateAttribute ($id, $name, $type, $desc, $title, $test) {
           $res = null;

           try {
               $this->db_conn->createCommand("update tg_attributes set aname='".$name."', atype='".$type."', adesc='".$desc."',title='".$title."',test='".$test."' where aid=$id")
                   ->execute();
               $res = $this->db_conn->getLastInsertID();
           } catch (\Exception $e) {
               throw new \yii\web\HttpException(405, 'Error saving model');
           }

           return  $res;
       }

       public function selectAttributeType (){
           $arr = $this->db_conn->createCommand("select tid, tname from tg_attributes_type")
               ->queryAll();

           $arr = ArrayHelper::map($arr,'tid','tname');

           return $arr;
       }

       public function selectAllAttributes (){
           $arr = $this->db_conn->createCommand("select a.aid, a.aname, t.tname, a.atype, a.adesc, a.title, a.test from tg_attributes a, tg_attributes_type t where a.atype = t.tid")
               ->queryAll();

           return $arr;
       }
   */
}