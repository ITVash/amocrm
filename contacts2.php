<?php
  namespace Contacts;
  require_once "api.php";
  use \Api\Api;
  class Contact extends Api {
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
    public function listt() {
      
    }
    public function del() {

    }
  }
?>