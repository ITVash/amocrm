<?php
  namespace Tasks;
  require_once "api.php";
  use \Api\Api;
  class Task extends Api {
    
    public $lead;
    public $text;
    public $resp;
        
    public function add() {
     
      $link = "https://{$this->_subdomain}.amocrm.ru/api/v2/tasks?{$this->_uh}";
      $curDate = date_create();
      $dd = date('d-m-Y H:i:s');
      $d2 = date('d-m-Y H:i:s', time()+1*60*60);
      $d1 = strtotime($d2);
      echo $d1;
      echo gettype($d1);
			$data['add'] = array(
				array(
					'element_id'=>$this->lead,
					'element_type'=>'2',
					'complete_till'=> $d1,
					'task_type'=>'1',
					'text'=>$this->text,
				)
      );
      
      $this->_curl = curl_init();
      $out = $this->_build($link, $data);
      $out = $out [ 'items' ];
      return $out;
    }
    public function upp() {

    }
    public function listt() {
      
    }
    public function del() {

    }
  }
?>