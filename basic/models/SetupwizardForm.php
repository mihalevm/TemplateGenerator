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
            $this->db_conn->createCommand("insert into tg_wizard (tid, step, pos, attr, req) values (:tid, :step, :pos, :attr, :req)")
                ->bindValue(':tid', $tid)
                ->bindValue(':step', $wizard_item->s)
                ->bindValue(':pos', $wizard_item->p)
                ->bindValue(':req', $wizard_item->r)
                ->bindValue(':attr', $this->getAttributeIdbyKey($wizard_item->v))
                ->execute();

            $res = $this->db_conn->getLastInsertID();

        }

        return $res;
    }

    public function getWizard ($tid){
        $arr = $this->db_conn->createCommand("select w.step, w.pos, a.aname, a.adesc, w.req from tg_wizard w, tg_attributes a where w.attr=a.aid and w.tid=:tid order by w.step, w.pos")
            ->bindValue(':tid', $tid)
            ->queryAll();

        return $arr;
    }

}