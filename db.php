<?php
session_start();

$connect = new PDO("mysql:host=localhost;dbname=ramazan_ayoz", "root", "");
$connect->query("SET NAMES 'utf8'");
?>