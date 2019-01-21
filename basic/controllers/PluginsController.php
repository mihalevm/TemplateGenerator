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
use app\models\PluginsForm;

class PluginsController extends Controller
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

        return $this->render('index',[
        ]);
    }

    public function actionEgrul() {
        $model = new PluginsForm();
        $allTemplates = $model->selectAllTemplates();

        return $this->render('egrul',[
            'allTemplates' => $allTemplates,
        ]);
    }

    public function actionGettemplvars() {
        $model = new PluginsForm();
        $r = Yii::$app->request;
        $templateVars = [];

        if ( $r->post('t') ) {
            $templateVars = $model->getTemplateAttrs($r->post('t'));
        }

        return $this->_sendJSONAnswer($templateVars);
    }

    public function actionSavetemplvars(){
        $model = new PluginsForm();
        $r = Yii::$app->request;
        $res = '';

        if ($r->post('t') && $r->post('inn')){
            $res = $model->saveTemplateAttrs(
                $r->post('t'),
                $r->post('inn'),
                $r->post('oname'),
                $r->post('addr'),
                $r->post('st'),
                $r->post('ogrn'),
                $r->post('cdata'),
                $r->post('kpp'),
                $r->post('otype')
            );
        }

        return $this->_sendJSONAnswer($res);
    }

    public function actionGetscript(){
        $model = new PluginsForm();
        $r = Yii::$app->request;
        $scriptArr = [];

        if ( $r->post('t') ) {
            $scriptArr = $model->getScriptForTemplate($r->post('t'));
        }

        return $this->_sendJSONAnswer($scriptArr);
    }

    public function actionDelscript() {
        $model = new PluginsForm();
        $r = Yii::$app->request;
        $res = '';

        if ($r->post('t') && $r->post('i')){
            $model->deleteScriptForTemplate($r->post('t'), $r->post('i'));
        }

        return $this->_sendJSONAnswer($res);
    }

    public function actionEgrulreq() {
        $model = new PluginsForm();
        $r = Yii::$app->request;
        $res = [];

        if ($r->post('k')){
            $res = $model->EgrulRequest($r->post('k'));
        }

        return $this->_sendJSONAnswer($res);
    }

}