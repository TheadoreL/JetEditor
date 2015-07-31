<?php
	header("Content-Type: text/html;charset=utf-8");
	include_once("Jet.class.php");
	$edit = new jetEdit();
	$re = $edit -> DisplayForm('users','0,1','username,admin');
	var_dump($re);
?>