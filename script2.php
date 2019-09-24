<?php 
  require_once 'contacts.php';
  require_once 'lead.php';
  require_once 'task.php';
  //require_once 'telegram.php';
  use Contacts\Contact;
  use Leads\Lead;
  use Tasks\Task;
  $cont = new Contact('pbm.group.vyacheslav@yandex.ru', 'ae7d049a5491683ec7643893e5423737269c1680', 'pbmgroupvyacheslav');
  $lead = new Lead('pbm.group.vyacheslav@yandex.ru', 'ae7d049a5491683ec7643893e5423737269c1680', 'pbmgroupvyacheslav');
  $task = new Task('pbm.group.vyacheslav@yandex.ru', 'ae7d049a5491683ec7643893e5423737269c1680', 'pbmgroupvyacheslav');
  //$tel = new Telegram('949259966:AAHnOHyAgfsCU8D9srzWiuOO55oC1GKi1ho', '-1001419468290');
  
  //$name = trim($_POST["name"]);
  //$phone = trim($_POST["phone"]);
  $name = trim('Иван');
  $phone = trim('380713679656');
  //$phone = trim('380958755772');

  $dubl = $cont->dubl(array('phone' => $phone));
  echo "Дубль <pre> \n";
  var_dump($dubl);
  echo "</pre> \n";
  if ($dubl == null) {
    $cont->name = $name;
    $cont->phone = $phone;
    $cont->tags = "Пришел с сайта";
    $cont->addCustom(29273, $phone, 46179);
    $cont->addCustom(148137, "vk");
    $cont->addCustom(148139, "cpc");
    $cont->addCustom(148141, "pbm-group");
    $cont->addCustom(148143, "ucrtorus");
    $cont->addCustom(148145, "ucrtorus");
    $conts = $cont->add();
    if ($conts != null) {
      $id = $conts[0]["id"];
      //$tel->send('Новая карточка клиента: ' . $name, $id);
    }
  } else {
    //$tel->send('Запрос на повторный звонок от клиента: ' . $dubl['name'], $dubl['id']);
  }
  echo " \n Инфо: \n <pre>";
  $inform = $cont->getInfo($phone);
  echo "Телефон: {$phone} \n";
  $inform = $inform[0];
  var_dump($inform);

  $out = $lead->dubl(1936621, array('id'=> $inform [ 'id' ], 'name'=> $inform [ 'name' ]));

  if ($out == null) {
    echo "Дубля сделки нет \n";
    $lead->name = "Сделка: {$inform [ 'name' ]}";
    $lead->resp = 3667327;
    $lead->sale = 0;
    $lead->status = 29056789;
    $lead->tags = "Сделка с сайта";
    $lead->pipe = 1936621;
    $lead->client = $inform [ 'id' ];
    $add = $lead->add();
    $task->lead = $add[0]['id'];
    $task->text = "Свяжитесь с клиентом, это необходимо предприятию";
    $addTask = $task->add();
    var_dump($add);
    echo "Задача \n";
    var_dump($addTask);
  } else  echo "Дубль есть \n";
  echo "Дата, смотрим и любуемся)))) \n";
  $d = date_create();
  $dd = date('d-m-Y H:i:s');
  $d1 = strtotime($dd, "+1 hours");
  $d2 = date('d-m-Y H:i:s', time()+1*60*60);
  echo "Время сейчас: ". date_timestamp_get($d) . " время " . $dd .", время через час {$d2} \n";
  /*$test = $cont->getInfo($phone);
  $test = $test[ 0 ];
  $out = $lead->dubl(1936621, array('id'=> $test [ 'id' ], 'name'=>$test [ 'name' ]));
  if ($out == null) {
    $lead->name = "Сделка: {$test [ 'name' ]}";
    $lead->resp = 3667327;
    $lead->sale = 0;
    $lead->status = 29056789;
    $lead->tags = "Сделка с сайта";
    $lead->pipe = 1936621;
    $lead->client = $test [ 'id' ];
    $add = $lead->add();
    echo "Дубля нет \n";
  } else echo "Дубль есть \n";*/
  //var_dump($out);
  echo "Дубли сделки \n";
  //var_dump($out);
  echo "</pre>";
  
?>