<?php 

  require_once 'contacts.php';
  require_once 'lead.php';
  require_once 'task.php';
  require_once 'telegram.php';
  use Contacts\Contact;
  use Leads\Lead;
  use Tasks\Task;
  $cont = new Contact('pbm.group.vyacheslav@yandex.ru', 'ae7d049a5491683ec7643893e5423737269c1680', 'pbmgroupvyacheslav');
  $lead = new Lead('pbm.group.vyacheslav@yandex.ru', 'ae7d049a5491683ec7643893e5423737269c1680', 'pbmgroupvyacheslav');
  $task = new Task('pbm.group.vyacheslav@yandex.ru', 'ae7d049a5491683ec7643893e5423737269c1680', 'pbmgroupvyacheslav');
  $tel = new Telegram('949259966:AAHnOHyAgfsCU8D9srzWiuOO55oC1GKi1ho', '-1001419468290');
  
  //$name = trim('Иван');
  //$phone = trim('380713679656');
  file_put_contents('file.txt', $_POST['utm']);
  $name = "Без имени";
  $phone = trim($_POST["phone"]);
  $utm_source = !empty($_POST["utm1"]) ? trim($_POST["utm1"]) : "null";
  $utm_medium = !empty($_POST["utm2"]) ? trim($_POST["utm2"]) : "null";
  $utm_campaign = !empty($_POST["utm3"]) ? trim($_POST["utm3"]) : "null";
  $utm_term = !empty($_POST["utm4"]) ? trim($_POST["utm4"]) : "null";
  $utm_content = !empty($_POST["utm5"]) ? trim($_POST["utm5"]) : "null";

  $dubl = $cont->dubl(array('phone' => $phone));
  if ($dubl == null) {
    $cont->name = $name;
    $cont->phone = $phone;
    $cont->tags = "Пришел с {$utm_source}";
    $cont->addCustom(29273, $phone, 46179);
    $cont->addCustom(148137, $utm_source);
    $cont->addCustom(148139, $utm_medium);
    $cont->addCustom(148141, $utm_campaign);
    $cont->addCustom(148143, $utm_term);
    $cont->addCustom(148145, $utm_content);
    $conts = $cont->add();
    echo "Дубля контакта нет, идет создание контакта \n";
    if ($conts != null) {
      $id = $conts[0]["id"];
      $tel->send('Новая карточка клиента: ' . $name . "\nТелефон: " . $phone, "Карточка клиента", "https://pbmgroupvyacheslav.amocrm.ru/contacts/detail/{$id}");
    }
  } else {
    echo "Дубль контакта есть, идем дальше \n";
    $tel->send('Запрос на повторный звонок от клиента: ' . $dubl['name'] . "\nТелефон: " . $phone, "Карточка клиента", "https://pbmgroupvyacheslav.amocrm.ru/contacts/detail/{$dubl['id']}");
  }

  $inform = $cont->getInfo($phone);
  $inform = $inform[0];
  echo "Информация о контакте: \n";
  var_dump($inform);
  echo "Поиск дубля сделки \n";
  $out = $lead->dubl(1936621, array('id'=> $inform [ 'id' ], 'name'=> $inform [ 'name' ]));
  
  if ($out == null) {
    echo "Дубля сделки нет, делаем сделку \n";
    $lead->name = "Сделка: {$inform [ 'name' ]}";
    $lead->resp = 3667327;
    $lead->sale = 0;
    $lead->status = 29056789;
    $lead->tags = "Сделка с сайта";
    $lead->pipe = 1936621;
    $lead->client = $inform [ 'id' ];
    $add = $lead->add();

    /*  Таскуем всю эту богодельню  */
    $task->lead = $add[0]['id'];
    $task->text = "Свяжитесь с клиентом. Уточните детали сделки. Вишлете КП";
    $addTask = $task->add();
    if ($addTask !== null) {
      $tel->send('Создана задача для Сделки: ' . $inform [ 'name' ] . "\n ", "Карточка сделки" , "https://pbmgroupvyacheslav.amocrm.ru/leads/detail/{$add[0]['id']}");
    }
  } else echo "Дубль сделки найден, повторное создание запрещено \n";
  
  
?>