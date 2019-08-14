<?php

  class Telegram  {

    protected $_curl;
    protected $_token;
    protected $_chatID;
    protected $_link;

    public function __construct ($token, $chatID) {
      $this->_token = $token;
      $this->_chatID = $chatID;
      $this->_link = "https://api.telegram.org/bot{$this->_token}/";
    }
    public function send($text, $but, $id = null) {
      $link = $this->_link . "sendMessage";
      $this->_curl = curl_init();
      $param = array(
        "chat_id" => $this->_chatID,
        "text" => $text,
        "reply_markup" => array(
          "inline_keyboard" => array(
            array(
              array(
                "text" => $but,
                "url" => "{$id}"
              )
            )
          )
        )
      );
      $out = $this->_build($link, $param);
    }
    private function _build($link, $params = null) {
      curl_setopt( $this->_curl , CURLOPT_URL, $link);
      curl_setopt( $this->_curl , CURLOPT_RETURNTRANSFER, 1);
      curl_setopt( $this->_curl  ,CURLOPT_HTTPHEADER, array ( 'Content-Type: application/json' ) );
      curl_setopt( $this->_curl , CURLOPT_POST, 1);
      curl_setopt( $this->_curl , CURLOPT_POSTFIELDS, json_encode($params));
      $result = curl_exec($this->_curl);
      $code = curl_getinfo($this->_curl, CURLINFO_HTTP_CODE);
      curl_close($this->_curl);
      try {
        if ($code != 200 && $code != 204) 
          throw new Exception( isset ( $code ) ? $code : 'Не изветная ошибка: ' , $code);
      } catch (Exception $e) {
        die ( 'Ошибка: ' . $e -> getMessage ( ) .PHP_EOL. 'Код ошибки: ' . $e -> getCode ( ) );
      }
    }

    public function __destruct() {
      //curl_close($this->_curl);
    }
  }
  
?>