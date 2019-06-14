<?php 
  require_once 'lead.php';
  use Leads\Lead;
  $lead = new Lead('max.zoll45@yandex.ru', 'de4da9f0a169dcfafdf97d50ab8890db', 'dnevnikarma');
  //$auth = $lead->test();

  $list = $lead->list();
  
?>