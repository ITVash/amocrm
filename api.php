<?php
  namespace Api;
  abstract class Api {
    /** 
    * Абстрактный класс который авторизиует в АМО
    * затем обрабатывает нужные данные из доценрних обьектов
    * @param private $_login - логин АмоЦрм
    * @param private $_hash - Апи шех АмоЦрм
    * @param private $_subdomain - домен АмоЦрм
    * @param private $_curl - Инициализация Курла
    **/
    protected $_login;
    protected $_hash;
    protected $_subdomain;
    protected $_curl;
    protected $_uh;

    public function __construct ($login, $hash, $subdomain) {
      $this->_login = $login;
      $this->_hash = $hash;
      $this->_subdomain = $subdomain;
      $this->_uh = "USER_LOGIN={$this->_login}&USER_HASH={$this->_hash}&lang=ru";
    }

    /**
     * Авторизация, авторизация будет происходить в основном классе
     * для удобства и уменьшения кода
     * @param Type var Description
    */
    protected function auth () {
      $this->_curl = curl_init();
      $link = "https://{$this->_subdomain}.amocrm.ru/private/api/auth.php?type=json";
      $user = array(
        "USER_LOGIN" => $this->_login,
        "USER_HASH" => $this->_hash
      );
      $res = $this->_build($link, $user);
      //print_r($res);
      //$res = $res [ 0 ];
      if ( isset($res['auth']) == 1 ) {
        return true;
      } else {
        return false;
      }
    }

    /**
     * Функция отправки запросса на сервер АмоЦрм
     */
    protected function _build($link, Array $data = null, $type = null) {
      //$this->_curl = curl_init();
      curl_setopt ( $this->_curl ,CURLOPT_RETURNTRANSFER, true );
      curl_setopt ( $this->_curl ,CURLOPT_USERAGENT, 'amoCRM-API-client/1.0' );
      curl_setopt ( $this->_curl ,CURLOPT_URL, $link );
      if ($data != null) {
        curl_setopt( $this->_curl ,CURLOPT_CUSTOMREQUEST, 'POST');
        switch ($type) {
          case 'HTTP':
            curl_setopt( $this->_curl ,CURLOPT_POSTFIELDS, http_build_query($data));
            break;
          default:
            curl_setopt ( $this->_curl ,CURLOPT_POSTFIELDS, json_encode ( $data ) );
            curl_setopt ( $this->_curl ,CURLOPT_HTTPHEADER, array ( 'Content-Type: application/json' ) );            
            break;
        }
      }
      curl_setopt ( $this->_curl ,CURLOPT_HEADER, false );
      curl_setopt ( $this->_curl ,CURLOPT_SSL_VERIFYPEER, 0 );
      curl_setopt ( $this->_curl ,CURLOPT_SSL_VERIFYHOST, 0 );

      $out = curl_exec ( $this->_curl );
      $code = curl_getinfo ( $this->_curl ,CURLINFO_HTTP_CODE);
      $code = (int)$code;
      $error = $this->_error($code);
      $Response = json_decode ( $out , true ) ;
      $Response = isset( $Response [ 'response' ] ) ? $Response [ 'response' ] : $Response [ '_embedded' ];
      return $Response;
    }

    /**
     * Функция обработки ошибок
     */
    protected function _error($code) {
      $errors = array (
        301 => 'Moved permanently' ,
        400 => 'Bad request' ,
        401 => 'Unauthorized' ,
        403 => 'Forbidden' ,
        404 => 'Not found' ,
        500 => 'Internal server error' ,
        502 => 'Bad gateway' ,
        503 => 'Service unavailable'
      ) ;
      try {
        if ($code != 200 && $code != 204) 
          throw new \Exception( isset ( $errors [ $code ] ) ? $errors [ $code ] : 'Не изветная ошибка: ' , $code);        
      } catch (\Exception $e) {
        die ( 'Ошибка: ' . $e -> getMessage ( ) .PHP_EOL. 'Код ошибки: ' . $e -> getCode ( ) ) ;
      }
    }

    /**
     * Функция перебора массива
     */
    protected function forEach ($request) {
      while ($reqest !== null) {
        foreach ($reqest as $req) {
          # code...
        }
      }
    }

    public function __destruct() {
      curl_close($this->_curl);
    }
    abstract protected function add();
    abstract protected function upp();
    abstract protected function list();
    abstract protected function del();
  }
?>