<?php

/*$recepient = "pbm.group.vyacheslav@yandex.ru";
$siteName = "https://pbm-group.org";

$name = trim($_POST["name"]);
$phone = trim($_POST["phone"]);
$message = "Имя: $name \nТелефон: $phone \n";
$headers = "From: info@pbm-group.org";

$pagetitle = "Заявка с сайта \"$siteName\"";
mail($recepient, $pagetitle, $message, $headers, "Content-type: text/plain; charset=\"utf-8\"\n From: $recepient");*/
$siteName = "https://pbm-group.org";
$name = trim($_POST["name"]);
$phone = trim($_POST["phone"]);
$to      = 'pbm.group.vyacheslav@yandex.ru';
$subject = 'Заявка с сайта \"$siteName\"';
$message = 'Имя: $name \nТелефон: $phone \n';
/*$headers = array(
    'From' => 'info@pbm-group.org',
    'Reply-To' => 'info@pbm-group.org',
    'X-Mailer' => 'PHP/' . phpversion()
);*/
$headers = "From: info@pbm-group.org \r\n";
$headers .= "Reply-To: info@pbm-group.org \r\n";
$headers .= 'X-Mailer: PHP/' . phpversion() . "\r\n";


mail($to, $subject, $message, $headers);

?>