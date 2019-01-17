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
use yii\httpclient\Client;

/**
 * AttreditorForm is the model behind the contact form.
 */
class PluginsForm extends Model {
    protected $db_conn;

    function __construct () {
        $this->db_conn = Yii::$app->db;
    }

    public function selectAllTemplates (){
        $arr = $this->db_conn->createCommand("select tid, tname from tg_templates")
            ->queryAll();

        $arr = ArrayHelper::map($arr,'tid','tname');

        $arr[0] = 'Выбрать шаблон';
        ksort($arr);

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

    public function saveTemplateAttrs($tid, $inn, $oname, $addr, $st, $ogrn, $cdata, $kpp, $otype){
        $arr = $this->db_conn->createCommand("select count(*) as cnt from tg_plugin_egrul where tid=:tid and inn=:inn")
            ->bindValue(':tid', $tid)
            ->bindValue(':inn', $inn)
            ->queryAll();

        if ( $arr[0]['cnt'] == 0 ){
            $this->db_conn->createCommand("insert into tg_plugin_egrul (tid, inn, oname, addr, status, ogrn, cdata, kpp, otype) values (:tid, :inn, :oname, :addr, :status, :ogrn, :cdata, :kpp, :otype)")
                ->bindValue(':tid', $tid)
                ->bindValue(':inn', $inn)
                ->bindValue(':oname', $oname)
                ->bindValue(':addr', $addr)
                ->bindValue(':status', $st)
                ->bindValue(':ogrn', $ogrn)
                ->bindValue(':cdata', $cdata)
                ->bindValue(':kpp', $kpp)
                ->bindValue(':otype', $otype)
                ->execute();

            $arr = $this->db_conn->getLastInsertID();
        } else {
            $this->db_conn->createCommand("update tg_plugin_egrul set oname=:oname, addr=:addr, status=:status, ogrn=:ogrn, cdata=:cdata, kpp=:kpp, otype=:otype where tid=:tid and inn=:inn")
                ->bindValue(':tid', $tid)
                ->bindValue(':inn', $inn)
                ->bindValue(':oname', $oname)
                ->bindValue(':addr', $addr)
                ->bindValue(':status', $st)
                ->bindValue(':ogrn', $ogrn)
                ->bindValue(':cdata', $cdata)
                ->bindValue(':kpp', $kpp)
                ->bindValue(':otype', $otype)
                ->execute();

            $arr = 1;
        }

        return $arr;
    }

    public function getScriptForTemplate($tid){
        $arr = $this->db_conn->createCommand("select tid, inn, oname, addr, status, ogrn, cdata, kpp, otype from tg_plugin_egrul where tid=:tid")
            ->bindValue(':tid', $tid)
            ->queryAll();

        return $arr;
    }

    public function deleteScriptForTemplate($tid, $inn){
        $arr = $this->db_conn->createCommand("delete from tg_plugin_egrul where tid=:tid and inn=:inn")
            ->bindValue(':tid', $tid)
            ->bindValue(':inn', $inn)
            ->execute();

        return $arr;
    }

    private function _sendFirstRequest($key) {
        $client = new Client();

        $response = $client->createRequest()
            ->setMethod('post')
            ->setUrl('https://egrul.nalog.ru/')
            ->setHeaders([
                'Accept' => 'application/json, text/javascript, */*; q=0.01',
                'Accept-Encoding' => 'gzip, deflate, br',
                'Accept-Language' => 'ru-RU,ru;q=0.8,en-US;q=0.5,en;q=0.3',
                'Cache-Control' => 'no-cache',
                'Connection' => 'keep-alive',
                'Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8',
                'Host' => 'egrul.nalog.ru',
                'Pragma' => 'no-cache',
                'Referer' => 'https://egrul.nalog.ru/',
                'User-Agent' => 'runscope/0.1,Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:39.0) Gecko/20100101 Firefox/39.0',
                'X-Requested-With' => 'XMLHttpRequest'
            ]);

        $response->setData([
            'vyp3CaptchaToken' => '',
            'query' =>	$key,
            'region' => '',
            'PreventChromeAutocomplete' => '',
        ]);

        return $response->send();
    }

    private function _sendSecondRequest($key, $t1, $t2) {
        $client = new Client();

        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl('https://egrul.nalog.ru/search-result/'.$key)
            ->setHeaders([
                'Accept' => 'application/json, text/javascript, */*; q=0.01',
                'Accept-Encoding' => 'gzip, deflate, br',
                'Accept-Language' => 'ru-RU,ru;q=0.8,en-US;q=0.5,en;q=0.3',
                'Cache-Control' => 'no-cache',
                'Connection' => 'keep-alive',
                'Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8',
                'Host' => 'egrul.nalog.ru',
                'Pragma' => 'no-cache',
                'Referer' => 'https://egrul.nalog.ru/',
                'User-Agent' => 'runscope/0.1,Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:39.0) Gecko/20100101 Firefox/39.0',
                'X-Requested-With' => 'XMLHttpRequest'
            ]);

        $response->setData([
            'r' => $t1,
            '_' => $t2,
        ]);

        return $response->send();
    }

    public function EgrulRequest($key){
        $res = 0;
        $first_time_mark = round(microtime(true) * 1000);

        $res = $this->_sendFirstRequest($key);

        if ( $res->getIsOk() ) {
            $res = json_decode($res->content);
            if (property_exists($res, 't')){
                $second_time_mark = round(microtime(true) * 1000);
                $res = $this->_sendSecondRequest($res->t, $first_time_mark, $second_time_mark);
                if ( $res->getIsOk() ) {
                    $res = json_decode($res->content);
                    if (property_exists($res, 'rows')){
                        if (sizeof($res->rows)> 0){
                            $res = $res->rows[0];
                        } else {
                            $res = 0;
                        }
                    } else {
                        $res = 0;
                    }
                } else {
                    $res = 0;
                }
            } else {
                $res = 0;
            }
        } else {
            $res = 0;
        }

        return $res;
    }
}