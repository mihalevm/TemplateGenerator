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
use app\models\SetupwizardForm;
use yii\data\ArrayDataProvider;

class SetupwizardController extends Controller
{
    public $layout = 'tg_layout';

    private function _sendJSONAnswer($res){
        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->data = $res;

        return $response;
    }

    private function _sendPDFDoc($res){
        $response = Yii::$app->response;
        $response->headers->add('appliction','octet-stream');
        $response->headers->add('Content-disposition','attachment; filename="doc01.pdf"');
        $response->format = \yii\web\Response::FORMAT_RAW;
        $response->data = $res;

        return $response;
    }

    public function actionIndex() {
        $model = new SetupwizardForm();

        $allTemplates = new ArrayDataProvider([
            'allModels' => $model->selectAllTemplates(),
            'sort' => [
                'attributes' => ['tid', 'tname', 'cdate'],
            ],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);


        return $this->render('index',[
            'model' => $model,
            'allTemplates' => $allTemplates
        ]);
    }

    public function actionGettemplate()
    {
        $r = Yii::$app->request;
        $model = new SetupwizardForm();
        $res = null;

        if ( $r->post('t') ) {
            $res = $model->getTemplate(intval($r->post('t')));
        } else {
            $res[0]['tbody'] = 'Новый текст...';
        }

        return $this->_sendJSONAnswer($res[0]['tbody']);
    }


    public function actionGetwizard() {
        $r = Yii::$app->request;
        $model = new SetupwizardForm();

        if ( $r->post('t') ) {
            $res = $model->getWizard(intval($r->post('t')));
        }

        return $this->_sendJSONAnswer($res);
    }

    public function actionSavewizard(){
        $r = Yii::$app->request;
        $model = new SetupwizardForm();

        if ( $r->post('t') && $r->post('w')) {
            $res = $model->saveWizard(intval($r->post('t')), $r->post('w'));
        }

        return $this->_sendJSONAnswer($res);
    }

    public function actionSettemplate()
    {
        $r = Yii::$app->request;
        $model = new SetupwizardForm();
        $res  = null;
        $attr = null;

        if (null !== $r->post('a')){
            foreach (explode(';', $r->post('a')) as $it){
                $attr = $model->getAttributeIdbyKey($it)[0]['aid'].','.$attr;
            }
            $attr = rtrim($attr, ',');
        }

        if (  $r->post('b') ) {
            if ($r->post('t')){
                $res = $model->setTemplate(intval($r->post('t')), $r->post('b'), $attr, $r->post('n'));
            } else {
                $res = $model->addTemplate( $r->post('b'), $attr, $r->post('n'));
            }
        }

        return $this->_sendJSONAnswer($res);
    }

    public function actionGetattr(){
        $r = Yii::$app->request;

        $res_raw = null;
        $res     = [];

        $model = new SetupwizardForm();

        if ($r->post('t')) {
            $res_raw = $model->getTemplateAttrs($r->post('t'));

            foreach ($res_raw as $Item) {
                $res[$Item['aname']] = $Item['adesc'];
            }
        }

        return $this->_sendJSONAnswer($res);
    }

    public function actionTmplpreview() {
        $r = Yii::$app->request;
        $mpdf = new \Mpdf\Mpdf();
        $model = new SetupwizardForm();

        $html_template = ($model->getTemplate($r->get('t')))[0]['tbody'];

        $attrs = $model->getAttrsTestData($r->get('t'));

        foreach ($attrs as $attr_it){
            $html_template = str_replace('{'.$attr_it['aname'].'}', $attr_it['test'], $html_template);
        }

        $mpdf->WriteHTML($html_template);

        return $this->_sendPDFDoc($mpdf->Output());
    }

    public function actionDeletetemplate(){
        $r = Yii::$app->request;
        $model = new SetupwizardForm();

        $res = $model->deleteTemplate($r->post('t'));

        return $this->_sendJSONAnswer($res);
    }

    /*
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
    */

}