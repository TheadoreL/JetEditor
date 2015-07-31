<?php
/*
	Module: print form by array from databases;
	Author: Theadore Lee;
	Create @ 2014.12.14;
*/
class Result_doc{
	public function resu(){
		$resultDoc = new docum();
		header("Content-Type: text/html;charset=utf-8");
		session_start();
		$reArray = $_SESSION['Docum_ReArray'];
		unset($_SESSION['Docum_ReArray']);
		$upload = new fileUpload(UPLOAD_PATH, UPLOAD_EXT);
		$upload -> upload();
		$filePath = $upload -> get_succ_file();
		foreach ($filePath as $key => $value) {
			$fp[$key] = substr($value, strlen(UPLOAD_PATH));
		}
		// echo "<script>alert(".$fp[0].");</script>";
		// var_dump($fp);
		$i = 0;
		foreach ($reArray['input'] as $key => $value) {
			if (substr($value, -4) == 'file') {
				// var_dump($fp[$i]);
				$GetValue[$key] = $fp[$i];
				$i++;
			}
			else if (substr($value, -3) == 'md5') {
				$GetValue[$key] = md5($_POST[$value]);
				$i++;
			}
			else
				$GetValue[$key]=@$_POST[$value];
		}
		foreach ($reArray['include'] as $key => $value) {
			if ($value == 'checkbox' || $value == 'checkfield') {
				$GetValue[$key] = implode(",", $GetValue[$key]);
			}
		}
		if ($reArray['edit'] == "") {
			$resultDoc->doc_result($reArray['DBName'],$GetValue,'insert');
		}
		else{
			$resultDoc->doc_result($reArray['DBName'],$GetValue,'edit');
		}
		// var_dump($GetValue);
		// var_dump($reArray);
	}





	//传入参数：数据库表名，id
	public function doc_delete($form_name,$id){
		$sql = "delete from ".$form_name." where id = ".$id;
		$db = new db_pdo();
		$db -> query($sql);
	}
}

class docum{
	//传入参数：数据库表名，字段名(数组)，值(数组)
	public function doc_result($form_name,$values,$act)
		$lenth_2 = count($values);
		$values_str = "'".$values[0]."'";
		for($i=1;$i<$lenth_2;$i++){
			$values_str = $values_str." , "."'".$values[$i]."'";
		}
		$sql = "CALL sp_".$form_name.$act."(".$_SESSION['uid']." , '".$values_str.")";
					
		$db = new db_pdo();
		if($db -> query($sql)) {
			// echo "Success";
			echo "操作成功";
		}
		else
			echo "<script>alert('表单插入出错！');</script>";
		echo "<script>javascript:parent.$.fancybox.close();</script>";

	}
}
?>