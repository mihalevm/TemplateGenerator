<?php
/**
 * Created by PhpStorm.
 * User: mmv
 * Date: 18.12.2018
 * Time: 10:21
 */

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\AttreditorForm;
use yii\data\ArrayDataProvider;

class AttreditorController extends Controller
{
    public $layout = 'tg_layout';

    private function _sendJSONAnswer($res){
        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->data = $res;

        return $response;
    }

    public function actionIndex() {
        if ( null === Yii::$app->user->id) {
            return $this->redirect(['/auth']);
        }

        $model = new AttreditorForm();
        $allAtributeType = $model->selectAttributeType();

        $allAtributes = new ArrayDataProvider([
            'allModels' => $model->selectAllAttributes(),
            'sort' => [
                'attributes' => ['aid', 'aname', 'adesc'],
            ],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);


        return $this->render('index',[
            'model' => $model,
            'allAtributeType' => $allAtributeType,
            'allAtributes' => $allAtributes
        ]);
    }

    public function actionNewattr() {
        $model = new AttreditorForm();
        $status['status'] = null;
        $r = Yii::$app->request;

        if ( null !== $r->post('n') and null !== $r->post('ty') ) {
           $status['status'] = $model->insertAttribute(
                $r->post('n'),
                $r->post('ty'),
                $r->post('d'),
                $r->post('ti'),
                $r->post('te')
            );
        }

        return $this->_sendJSONAnswer(json_encode($status));
    }

    public function actionUpdateattr() {
        $model = new AttreditorForm();
        $status['status'] = null;
        $r = Yii::$app->request;

        if ( null !== $r->post('id') and null !== $r->post('n') and null !== $r->post('ty') ) {
            $status['status'] = $model->updateAttribute(
                $r->post('id'),
                $r->post('n'),
                $r->post('ty'),
                $r->post('d'),
                $r->post('ti'),
                $r->post('te')
            );
        }

        return $this->_sendJSONAnswer(json_encode($status));
    }

    public  function actionDeleteattr() {
        $model = new AttreditorForm();
        $r = Yii::$app->request;
        $res = 0;

        if ( null !== $r->post('a') ) {
            $res = $model->deleteAttribute($r->post('a'));
        }

        return $this->_sendJSONAnswer($res);
    }
}