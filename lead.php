<?php
  namespace Leads;
  require_once "api.php";
  use \Api\Api;
  class Lead extends Api {
    public function test () {
      $auth = $this->auth();
      if ($auth) {
        echo 'Авторизовались, мы красавы. В натуре!!!!';
      } else {
        echo 'Не авторизовались, нифига мы не красавы!!!!';
      }
    }
    public function add() {

    }
    public function upp() {

    }
    public function list() {
      $auth = $this->auth();
      if (!$auth) {
        echo "Вы не Авторизовались: \n";
      } else {
        $this->_curl = curl_init();
        echo "Успешная авторизация: \n";
        $arr = array();
        $offset = 0;
        $param =array(
          'limit_rows' => 0,
          'limit_offset' => $offset
        );
        $link = "https://{$this->_subdomain}.amocrm.ru/api/v2/leads?". http_build_query($param) . "&{$this->_uh}";
        $res = $this->_build($link);
        $res = $res [ 'items' ];
        $arr = $res;
        /*while ($res !== null) {
          foreach ($res as $count) {
            for ($i=0; $i < count($res); $i++) { 
              # code...
              $arr[$i] = $count;
            }
          }
          if (count($res) >= 500) {
            $offset += 500;
            $param['limit_rows'] = 500;
            $param['limit_offset'] = $offset;
            $link = "https://{$this->_subdomain}.amocrm.ru/api/v2/leads?". http_build_query($param) . "&{$this->_uh}";
            print_r($param);
            sleep(3);
            $res = $this->_build($link);
            $res = $res [ 'items' ];
            //array_push($arr, $res [ 'items' ]);
            //$arr[] = $res [ 'items' ];
          } else {
            $res = null;
          }
        }*/
        echo "Вот лист Лидов\n";
        echo "<pre>";
        print_r($arr);
        echo "</pre>";
      }
    }
    public function del() {

    }
  }
?>