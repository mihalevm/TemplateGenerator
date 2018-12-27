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
class SetupwizardForm extends Model {
    protected $db_conn;

    function __construct () {
        $this->db_conn = Yii::$app->db;
    }

    public function selectAllTemplates (){
        $arr = $this->db_conn->createCommand("select t.tid, t.cdate, t.edate, t.tname, (select count(*) from tg_wizard w where w.tid = t.tid) as wizard  from tg_templates t")
            ->queryAll();

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


    public function getTemplate ($tid){
        $arr = $this->db_conn->createCommand("select tbody from tg_templates where tid=".$tid)
            ->queryAll();

        return $arr;
    }

    public function getAttributeIdbyKey ($key){
        $arr = $this->db_conn->createCommand("select aid from tg_attributes where aname=:aname")
            ->bindValue(':aname', $key)
            ->queryAll();

        return $arr[0]['aid'];
    }

    public function saveWizard ($tid, $wizard) {
        $res = null;

        $this->db_conn->createCommand("delete from tg_wizard where tid=:tid")
            ->bindValue(':tid', $tid)
            ->execute();

        $arr_wizard = json_decode($wizard);

        foreach ($arr_wizard as $wizard_item){
            $this->db_conn->createCommand("insert into tg_wizard (tid, step, pos, attr) values (:tid, :step, :pos, :attr)")
                ->bindValue(':tid', $tid)
                ->bindValue(':step', $wizard_item->s)
                ->bindValue(':pos', $wizard_item->p)
                ->bindValue(':attr', $this->getAttributeIdbyKey($wizard_item->v))
                ->execute();

            $res = $this->db_conn->getLastInsertID();

        }

        return $res;
    }

    public function getWizard ($tid){
        $arr = $this->db_conn->createCommand("select w.step, w.pos, a.aname, a.adesc from tg_wizard w, tg_attributes a where w.attr=a.aid and w.tid=:tid order by w.step, w.pos")
            ->bindValue(':tid', $tid)
            ->queryAll();

        return $arr;
    }

/*
    public function selectAllAttributes (){
        $arr = $this->db_conn->createCommand("select aname, adesc from tg_attributes")
            ->queryAll();

        return $arr;
    }


// --------------
    /*

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