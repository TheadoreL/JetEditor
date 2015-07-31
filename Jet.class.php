<?php
/*
	Module: print form by array from databases;
	Author: Theadore Lee;
	Create @ 2014.12.20;
*/
include_once("Db_pdo.class.php");
class jetEdit{
		//整理include
	private function RecoIncloud($displayArray){
		foreach ($displayArray as $key => $value) {
			if($displayArray[$key]['type'] == 'text' || $displayArray[$key]['type'] == 'file' || $displayArray[$key]['type'] == 'hidden' || $displayArray[$key]['type'] == 'password'){
				$include_value[$key] = 'input';
			}
			else{
				$include_value[$key] = $displayArray[$key]['type'];
			}
		}
		return $include_value;
	}
	//整理主数组
	private function RecoMainArray($displayArray){
		$db = new db_pdo();
		foreach ($displayArray as $key => $value) {
			$MainArray[$key]['title'] = $displayArray[$key]['title'];
			$MainArray[$key]['type'] = $displayArray[$key]['type'];
			if( $displayArray[$key]['type'] == 'select' || $displayArray[$key]['type'] == 'radio' || $displayArray[$key]['type'] == 'checkbox'){
				$MainArray[$key]['value'] =  explode(",", $displayArray[$key]['value']);
				$MainArray[$key]['output'] =  explode(",", $displayArray[$key]['output']);
			}
			elseif ($displayArray[$key]['type'] == 'checkfield') {
				$dbinfoVal = explode(",", $displayArray[$key]['value'] );
				$dbinfoOut = explode(",", $displayArray[$key]['output'] );
				$sqlVal = "select ".$dbinfoVal[1]." from ".$dbinfoVal[0];
				$sqlOut = "select ".$dbinfoOut[1]." from ".$dbinfoOut[0];
				$reVal = $db->query($sqlVal);

				foreach ($reVal as $valkey => $valvalue) {
					$val[$valkey] = $valvalue[$dbinfoVal[1]];
				}
				$reOut = $db->query($sqlOut);
				foreach ($reOut as $outkey => $outvalue) {
					$out[$outkey] = $outvalue[$dbinfoOut[1]];
				}
				$MainArray[$key]['value'] = $val;
				$MainArray[$key]['output'] = $out;
			}
			else{
				$MainArray[$key]['value'] = $displayArray[$key]['value'];
				$MainArray[$key]['output'] = $displayArray[$key]['output'];
			}
			$MainArray[$key]['class'] = $displayArray[$key]['class'];
			$MainArray[$key]['input_name'] = $displayArray[$key]['input_name'];
		}
		return $MainArray;
	}
	//整理数据库名
	private function RecoDBName($displayArray){
		foreach ($displayArray as $key => $value) {
			$DBname = $displayArray[$key]['table_id'];
		}
		return $DBname;
	}
	//整理字段名
	private function RecoColumnsName($displayArray){
		foreach ($displayArray as $key => $value) {
			$ColumnsName[$key] = $displayArray[$key]['field_name'];
		}
		return $ColumnsName;
	}
	//整理编辑值
	private function RecoEditValue($DBName,$edit_value,$ColumnsName,$include_value){
		if($edit_value!= ""){
			$edit = $this->GainArray($DBName,$edit_value,'1');
			foreach ($ColumnsName as $key => $value) {
				foreach ($edit[0] as $Edkey => $Edvalue) {
					if ($Edkey == $value) {
						$editArray[$key] = $Edvalue;
					}
				}
			}
			foreach ($include_value as $key => $value) {
				if ($value == 'checkbox' || $value == 'checkfield') {
					$editArray[$key] = explode(",", $editArray[$key]);
				}
			}
		}
		else{
			foreach ($ColumnsName as $key => $value) {
				$editArray[$key] = "";
			}
		}
		return $editArray;
	}
	//生成数组
	private function JointArray($displayArray,$edit_value){
		/*-----------------------为打印表单生成数组-----------------------*/
		//调用DBname方法
		$DBName = $this->RecoDBName($displayArray);
		//调用include方法
		$include_value = $this->RecoIncloud($displayArray);
		//调用MainArray方法
		$MainArray = $this->RecoMainArray($displayArray);
		//调用RecoColumnsName方法
		$ColumnsName = $this->RecoColumnsName($displayArray);
		//传入值，调用RecoEditValue方法
		$editArray = $this->RecoEditValue($DBName,$edit_value,$ColumnsName,$include_value);
		$FormArray['include'] = $include_value;
		$FormArray['main'] = $MainArray;
		$FormArray['edit'] = $editArray;
		/*-----------------------为session传值生成数组-----------------------*/
		foreach ($MainArray as $key => $value) {
			foreach ($value as $Vkey => $Vvalue) {
				$input_name[$key] = $value['input_name'];
			}
		}
		if ($edit_value != "") {
			$re_Array['edit'] = $edit_value;
		}
		else{
			$re_Array['edit'] = "";
		}
		$re_Array['DBName'] = $DBName;
		$re_Array['input'] = $input_name;
		$re_Array['Columns'] = $ColumnsName;
		$re_Array['include'] = $include_value;
		//开启session
		session_start();
		$_SESSION['Docum_ReArray'] = $re_Array;
		return $FormArray;
	}
	//从数据库中获取数组
	private function GainArray($table_id,$limits,$jud){
		$db = new db_pdo();
		if ($jud == '0') {
			$sql = "select * from form_model where table_id = :table_id and edit_limits >= :limits_start and edit_limits <= :limits_end order by order_id";
			$limit = explode(",", $limits);
			$a = array("table_id" => $table_id,"limits_start" => $limit[0],"limits_end" => $limit[1]);
		}
		elseif ($jud == '1') {
			$editValue = explode(",", $limits);
			$sql = "select * from ".$table_id." where ".$editValue[0]." = :limits";
			$a = array("limits" => $editValue[1]);
		}
		$re = $db->query($sql,$a);
		return $re;
	}
	//接收table_id,limits,edit_value生成表单打印数组
	public function DisplayForm($table_id,$limits,$edit_value){
		$displayArray = $this->GainArray($table_id,$limits,'0');
		$FinalArray = $this->JointArray($displayArray,$edit_value);
		return $FinalArray;
	}
	public function trash($tableName,$id,$status){
		$db = new db_pdo();
		$db->query("UPDATE ".$tableName." SET status = ".$status." WHERE id = ?", $id);
	}
}
?>