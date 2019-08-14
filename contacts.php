<?php 
  namespace Contacts;
  require_once "api.php";
  use \Api\Api;
  class Contact extends Api {
    /*public function getEmail($param = array()) {
			$this->_build($param);
			$out = $this->getOut();
			$data =[];
			for ($i=0; $i < count($out[0]['custom_fields']); $i++) { 
				if ($out[0]['custom_fields'][$i]['name'] == 'Email') {
					$data['email'] = $out[0]['custom_fields'][$i]['values'][0]['value'];
				}
				elseif ($out[0]['custom_fields'][$i]['name'] == 'Телефон') {
					$data['phone'] = $out[0]['custom_fields'][$i]['values'][0]['value'];
				}
			}
			return $data;
    }*/
    public $name;
    public $phone;
    public $email;
    public $tags;
    public $status;
    public $pipe;
    public $client;
    public $custom = array();

    public function addCustom($id, $value, $enum = null) {
      if (isset($enum)) {
        $data = array(
          array(
            "id"        =>  $id,
            "values"    => array(
              array(
                "value" =>  $value,
                "enum"  =>  $enum,
              ),
            ),
          ),
        );
      } else {
        $data = array(
          array(
            "id"        =>  $id,
            "values"    => array(
              array(
                "value" =>  $value,
              ),
            ),
          ),
        );
      }
      $this->custom[] = $data[0];
    }

    public function upp() {
      #code
    }
    public function listt($param = array()) {
      $link = "https://{$this->_subdomain}.amocrm.ru/api/v2/contacts?{$param}&{$this->_uh}";
    }
    public function del() {
      #code
    }

    public function getInfo($param) {
      $link = "https://{$this->_subdomain}.amocrm.ru/api/v2/contacts/?query=" .$param . "&{$this->_uh}";
      $this->_curl = curl_init();
      $out = $this->_build($link);
      $out = $out[ 'items' ];
      return $out;
    }

    public function dubl($param = array()) {
      isset($param['email']) ? $email = $param['email'] : $email = 'null';
      isset($param['phone']) ? $phone = $param['phone'] : $phone = 'null';
			$result = array();
      $offset = 0;
			$sort = array(
				'limit_rows' => '0',
				'limit_offset' => $offset
      );
      $this->_curl = curl_init();
      $link = "https://{$this->_subdomain}.amocrm.ru/api/v2/contacts/?" . http_build_query($sort) . "&{$this->_uh}";
      $out = $this->_build($link);
      $out = $out[ 'items' ];
      while ($out !== null) {
        foreach ($out as $cont) {
					if (count($cont['custom_fields']) == 0)
						continue;
					for ($i=0; $i < count($cont['custom_fields']); $i++) {
						if ($cont['custom_fields'][$i]['values'][0]['value'] == $email || $cont['custom_fields'][$i]['values'][0]['value'] == $phone) {
							$result = $cont;
						}
					}
        }
        if (count($out) >= 500) {
          $offset += 500;
          $sort = array(
            'limit_rows' => '500',
            'limit_offset' => $offset
          );
          $link = "https://{$this->_subdomain}.amocrm.ru/api/v2/contacts?" . http_build_query($sort) . "&{$this->_uh}";
          $out = $this->_build($link);
          $out = $out[ 'items' ];
        } else $out = null;
      }
      return $result;
    }
    public function add() {
      $param = array();
      $auth = $this->auth();
      if (!$auth) {
        echo "Вы не Авторизовались: \n";
      } else {
        $link = "https://{$this->_subdomain}.amocrm.ru/api/v2/contacts?{$this->_uh}";
        $curDate = date_create();
        $data['add'] = array(
          array(
            'name' => $param['name'],
            'created_at' => date_timestamp_get($curDate),
            'tags' => 'Пришел с сайта',
            'custom_fields'=>array(
              array(
                'id'=>29273,
                'values'=>array(
                  array(
                    'value'=>$param['phone'],
                    'enum'=>46179
                  )
                )
              ),
            )
          )
        );
        $data2['add'] = array(
          array(
            'name'          => $this->name,
            'created_at'    => date_timestamp_get($curDate),
            'tags'          => $this->tags,
            'custom_fields' =>  $this->custom,
          )
        );
        /* echo "<pre>";
        echo " \n Кастомные поля \n";
        print_r($this->custom);
        echo " \n Новый клиент \n";
        print_r($data2);
        echo "</pre>"; */
        $this->_curl = curl_init();
        $res = $this->_build($link, $data2);
        $res = $res [ 'items' ];
        unset($this->custom);
        return $res;
      }
    }
  }
?>