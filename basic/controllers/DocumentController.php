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
use app\models\DocumentForm;
//use yii\data\ArrayDataProvider;

class DocumentController extends Controller
{
    public $layout = 'tg_layout_master';

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

    public function actionIndex() {
        $r = Yii::$app->request;
        $model = new DocumentForm();
        $stepCount = 0;
        $masterWizard = [];
        $templateName = '';

//        if ( $r->post('t') ) {
        if ( $r->get('t') ) {
            $stepCount = $model->getTemplateCount(intval($r->get('t')));
            $masterWizard = $model->getMasterWizard(intval($r->get('t')));
            $templateName = $model->getTemplateName(intval($r->get('t')));
        };

        return $this->render('index',[
            'model' => $model,
            'StepCount' => $stepCount,
            'Master' => $masterWizard,
            'DocName' => $templateName,
            'tid' => $r->get('t'),
        ]);
    }


    public function actionSavedocument() {
        $r = Yii::$app->request;
        $model = new DocumentForm();
        $dkey  = '';

        if ( $r->post('t') &&  $r->post('v') ) {
            $dkey = $this->__getGUID();

            $values = json_decode($r->post('v'));

            foreach ($values as $item){
                $model->saveDocAttr($r->post('t'), $dkey, $item->name,  $item->val);
            }
        }

        return $this->_sendJSONAnswer($dkey);
    }

    public function actionPreviewdocument(){
        $r = Yii::$app->request;
        $model = new DocumentForm();
        $mpdf = new \Mpdf\Mpdf();

        if ( $r->get('k') ) {
            $html_template = $model->getTemplatebyDkey($r->get('k'));

            $attrs = $model->getDocumentVars($r->get('k'));

            foreach ($attrs as $attr_it){
                if ($attr_it['ttype'] == 'TCHECK'){
                    $attr_it['val'] = ($attr_it['val']?'Да':'Нет');
                }

                $html_template = str_replace('{'.$attr_it['aname'].'}', $attr_it['val'], $html_template);
            }

            $mpdf->WriteHTML($html_template);

            return $this->_sendPDFDoc($mpdf->Output());
        }
    }

        public function actionGettemplate()
    {
        $r = Yii::$app->request;
        $model = new DocumentForm();
        $res = null;

        if ( $r->post('t') ) {
            $res = $model->getTemplate(intval($r->post('t')));
        } else {
            $res[0]['tbody'] = 'Новый текст...';
        }

        return $this->_sendJSONAnswer($res[0]['tbody']);
    }

    public function actionSettemplate()
    {
        $r = Yii::$app->request;
        $model = new DocumentForm();
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
        $res_raw = null;
        $res     = null;
        $model = new DocumentForm();
        $res_raw = $model->selectAllAttributes();

        foreach ($res_raw as $Item){
            $res[$Item['aname']] = $Item['adesc'];
        }

        return $this->_sendJSONAnswer($res);
    }

    public function actionDeletetemplate(){
        $r = Yii::$app->request;
        $model = new DocumentForm();

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