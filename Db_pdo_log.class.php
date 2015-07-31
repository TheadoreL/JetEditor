<?php
/*
	Module:	PDO Access Log
	Author: Mean Machine;
	Create @ 2014-12-01;
*/
class db_pdo_log {
	private $_path = DB_LOG_DSN;
	public function __construct() {
		$this -> _path = $this -> _path;
	}
	public function write($message) {
	$date = new DateTime();
	$log = $this -> _path.LOG_FILE_NAME.$date -> format('Y-m-d').".log";
	if(is_dir($this -> _path)) {
		// echo "<div>Writing to <b style='color: darkred'>'".$log."'</b></div>";
		echo "<div>写入至 <b style='color: darkred'>'".$log."'</b></div>";
		if(!file_exists($log)) {
			// $fh = fopen($log, 'a+') or die("Fatal Error!");
			$fh = fopen($log, 'a+') or die("尝试写入时出错！");
			$logcontent = "Time: ".$date->format('H:i:s')."\r\n".$message."\r\n";
			fwrite($fh, $logcontent);
			fclose($fh);
		}
		else
			$this -> edit($log, $date, $message);
	}
	else {
		if(mkdir($this -> _path) === true) 
			$this -> write($message);
		}
	}
	private function edit($log, $date, $message) {
		$logcontent = "Time: ".$date -> format('H:i:s')."\r\n".$message."\r\n\r\n";
		$logcontent = $logcontent.file_get_contents($log);
		file_put_contents($log, $logcontent);
	}
}
?>