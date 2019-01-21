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
use app\models\AuthForm;

class AuthController extends Controller {
    public $layout = 'tg_layout';

    private function _sendJSONAnswer($res){
        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->data = $res;

        return $response;
    }

    public function actionIndex() {
        $model = new AuthForm();

        return $this->render('index',[
            'model' => $model,
        ]);
    }

    public function actionLogin() {
        $model = new AuthForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goHome();
        }

        $model->password = '';
        return $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
}