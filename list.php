<?php
header("Content-Type: text/html; charset=utf8");

require_once ("classes/Nota.php");

$notas = new Notas();

$notas->listar();
