<?php
$_db = new PDO('mysql:host=127.0.0.1;dbname=TP_mini_combat;charset=utf8','root','');
$_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$PersonnagesManager = new PersonnagesManager($_db);


$manager = new PersonnagesManager($_db);

?>