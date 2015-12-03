<?php
session_start();
session_register("A");
$_SESSION['A']=10;

var_dump($_SESSION);
