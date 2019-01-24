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
class DoclistForm extends Model {
    protected $db_conn;

    function __construct () {
        $this->db_conn = Yii::$app->db;
    }

    public function selectAllDocs (){
        $arr = $this->db_conn->createCommand("SELECT DISTINCT d.dkey, t.tname, (SELECT email FROM tg_users WHERE d.uid=uid) AS uname ,(SELECT MAX(cdate) FROM tg_documents WHERE d.dkey= dkey) AS cdate FROM tg_documents d , tg_templates t WHERE d.tid=t.tid")
            ->queryAll();

        return $arr;
    }

    public function deleteDoc ($id) {
        $res = 1;

        $this->db_conn->createCommand("delete from tg_documents where dkey=:dkey")
            ->bindValue(':dkey', $id)
            ->execute();

        return  $res;
    }

}