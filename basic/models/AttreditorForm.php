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
class AttreditorForm extends Model {
    protected $db_conn;

    function __construct () {
        $this->db_conn = Yii::$app->db;
    }

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
        $arr = $this->db_conn->createCommand("select a.aid, a.aname, t.tname, t.ttype, a.atype, a.adesc, a.title, a.test from tg_attributes a, tg_attributes_type t where a.atype = t.tid")
            ->queryAll();

        return $arr;
    }

    public function deleteAttribute ($aid) {
        $res = 1;

        $this->db_conn->createCommand("delete from tg_attributes where aid=:aid")
            ->bindValue(':aid', $aid)
            ->execute();

        return  $res;
    }
}