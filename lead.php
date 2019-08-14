<?php
  namespace Leads;
  require_once "api.php";
  use \Api\Api;
  class Lead extends Api {
    public $name;
    public $sale;
    public $resp;
    public $tags;
    public $status;
    public $pipe;
    public $client;
    public $custom = array();
    public function test () {
      $auth = $this->auth();
      if ($auth) {
        echo 'Авторизовались, мы красавы. В натуре!!!!';
      } else {
        echo 'Не авторизовались, нифига мы не красавы!!!!';
      }
    }
    public function dubl($pipe = null, $client = array()) {
      isset( $client [ 'id' ] ) ? $clientID = $client [ 'id' ] : $clientID = 'null';
      isset( $client [ 'name' ] ) ? $clientName = $client [ 'name' ] : $clientName = 'null';
      $auth = $this->auth();
      $offset = 0;
      $param = array(
        'limit_rows' => '500',
				'limit_offset' => $offset
      );
      $link = "https://{$this->_subdomain}.amocrm.ru/api/v2/leads?" . http_build_query($param) . "&{$this->_uh}";
      $this->_curl = curl_init();
      $res = array();
      $out = $this->_build($link);
      while ($out !== null) {
        $out = $out [ 'items' ];
        echo "ответ на запрос: ID:{$clientID}, pipe:{$pipe} \n";
        foreach ($out as $outs) {
          if ($outs["is_deleted"] === true || $outs["closed_at"] !== 0)
            continue;
          if ($outs['main_contact']['id'] == $clientID) 
            $res = $outs;
        }
        if (count($out) >= 500) {
          sleep(1);
          $offset += 500;
          $param = array(
            'limit_rows' => '500',
            'limit_offset' => $offset
          );
          $link = "https://{$this->_subdomain}.amocrm.ru/api/v2/leads?" . http_build_query($param) . "&{$this->_uh}";
          $out = $this->_build($link);
        } else $out = null;
      }
      return $res;
    }
    public function addCustom($id, $value) {
      $data = array(
        array(
          "id"        =>  $id,
          "values"    => array(
            "value" =>  $value,
          ),
        ),
      );
      $this->custom[] = $data[0];
    }
    public function add() {
      $param = array();
      $link = "https://{$this->_subdomain}.amocrm.ru/api/v2/leads?{$this->_uh}";
      $curDate = date_create();
			$data['add'] = array(
				array(
					'name'=>$param['name'],
					'created_at'=>date_timestamp_get($curDate),
					'responsible_user_id'=>$param['resp'],
					'status_id'=>$param['status'],
					'sale'=>$param['sale'],
					'tags'=>$param['tags'],
					'pipeline_id'=>$param['pipe'],				 
					'visitor_uid'=>$param['uid'],
					'contacts_id'=>array(
						$param['client'],
					),
					'custom_fields'=>array(
						$param['cust']
					)
				)
      );
      $data2['add'] = array(
				array(
					'name'=>$this->name,
					'created_at'=>date_timestamp_get($curDate),
					'responsible_user_id'=>$this->resp,
					'status_id'=>$this->status,
					'sale'=>$this->sale,
					'tags'=>$this->tags,
					'pipeline_id'=>$this->pipe,				 
					'visitor_uid'=>"",
					'contacts_id'=>array(
						$this->client,
					),
					'custom_fields'=> $this->custom,
				)
      );
      /* echo "<pre>";
      echo " \n Старая база \n";
      print_r($data);
      echo " \n Новая база \n";
      print_r($data2);
      echo "</pre>"; */
      $this->_curl = curl_init();
      $out = $this->_build($link, $data2);
      $out = $out [ 'items' ];
      unset($this->custom);
      return $out;
    }
    public function upp() {

    }
    public function listt() {
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