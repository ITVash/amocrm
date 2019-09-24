<?php

file_put_contents('task2.xt', json_encode($_POST['task'], true), FILE_APPEND);
file_put_contents('task.txt', json_encode($_POST['leads'], true) . "\n", FILE_APPEND);
?>