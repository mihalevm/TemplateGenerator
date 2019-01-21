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
use app\models\DoclistForm;
use yii\data\ArrayDataProvider;

class DoclistController extends Controller
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

        $model = new DoclistForm();

        $allDocs = new ArrayDataProvider([
            'allModels' => $model->selectAllDocs(),
            'sort' => [
                'attributes' => ['dkey', 'tname', 'cdate'],
            ],
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);


        return $this->render('index',[
            'model' => $model,
            'allDocs' => $allDocs
        ]);
    }
}