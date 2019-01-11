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
class TemplatesForm extends Model {
    protected $db_conn;

    private function __getGUID(){
        mt_srand((double)microtime() * 10000);
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $uuid = substr($charid, 0, 8)
            . substr($charid, 8, 4)
            . substr($charid, 12, 4)
            . substr($charid, 16, 4)
            . substr($charid, 20, 12);

        return $uuid;
    }

    function __construct () {
        $this->db_conn = Yii::$app->db;
    }

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
            $arr = $this->db_conn->createCommand("select a.aname, a.test, t.ttype from tg_attributes a, tg_attributes_type t where a.atype=t.tid and a.aid in (" . $tvars . ")")
                ->queryAll();
        } else {
            $arr = [];
        }

        return $arr;
    }


    public function deleteTemplate ($tid) {
        $this->db_conn->createCommand("delete from tg_templates where tid=:tid")
            ->bindValue(':tid', $tid)
            ->execute();

        $this->db_conn->createCommand("delete from tg_wizard where tid=:tid")
            ->bindValue(':tid', $tid)
            ->execute();

        $this->db_conn->createCommand("delete from tg_documents where tid=:tid")
            ->bindValue(':tid', $tid)
            ->execute();

        $arr = $this->db_conn->getLastInsertID();

        return $arr;

    }

    public function uploadImage ($img) {
        $new_src = strtolower($this->__getGUID());

        $arr = $this->db_conn->createCommand("insert into tg_gallery (gkey) values (:gkey)")
            ->bindValue(':gkey', $new_src)
            ->execute();

        $arr = $this->db_conn->getLastInsertID();

        move_uploaded_file($img["tmp_name"], Yii::getAlias('@webroot').'\\assets\\img\\'.$new_src);

        return '/assets/img/'.$new_src;
    }

    public function getGallery(){
        $arr = $this->db_conn->createCommand("select concat('/assets/img/',gkey) as url, concat('/assets/img/',gkey) as thumb, 'all' as tag from tg_gallery")
            ->queryAll();

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