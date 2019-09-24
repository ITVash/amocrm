<?php
  require_once 'telegram.php';
  $tel = new Telegram('949259966:AAHnOHyAgfsCU8D9srzWiuOO55oC1GKi1ho', '-1001419468290');
  file_put_contents("creat.txt", json_encode($_POST['leads'], true) . "\n", FILE_APPEND);
  if (isset($_POST['leads']['add'])) {
    $lead = $_POST['leads']['add'][0];
    $name = $lead['name'];
    $id = $lead['id'];
    $tag = $lead['tag'];
    $tel->send('Новая сделка: ' . $name . "\n" . $tag, "Карточка сделки", "https://pbmgroupvyacheslav.amocrm.ru/leads/detail/{$id}");
  }
?>