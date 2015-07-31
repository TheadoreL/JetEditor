<?php
if (!defined('UPLOAD_PATH'))
	require_once ("./config.inc.php");
class fileUpload {
	public $upload_path = UPLOAD_PATH;
	public $allow_type = UPLOAD_EXT;
	public $image_only = true;
	public $max_size = MAX_FILE_SIZE;
	public $overwrite = OVERWRITE_MODE;
	public $renamed = RENAME_MODE;
	private $upload_file = array();			//Upload File Array
	private $upload_file_num = 0;			//Upload Number Count
	private $succ_upload_file = array();
	public function __construct($upload_path = UPLOAD_PATH, $allow_type = UPLOAD_EXT, $image_only = IMAGES_ONLY, $overwrite = OVERWRITE_MODE, $max_size = MAX_FILE_SIZE) {
		$this -> upload_path = $upload_path;
		$this -> allow_type = $allow_type;
		$this -> image_only = $image_only;
		$this -> overwrite = $overwrite;
		$this -> max_size = $max_size;
		$this -> set_upload_path($upload_path);
		$this -> set_allow_type($allow_type);
		$this -> get_upload_files();
	}
	public function set_upload_path($path) {
		if(file_exists($path))
			if (is_writeable($path))
				$this -> upload_path = $path;
			else
				if (@chmod($path,'0666'))
					$this -> upload_path = $path;
		else
			if (@mkdir($path,'0666'))
				$this -> upload_path = $path;
	}
	public function set_allow_type($types) {
		$this -> allow_type = explode("|", $types);
	}
	public function get_upload_files() {
		foreach ($_FILES AS $key => $field)
			$this -> get_upload_files_detial($key);
	}
	public function get_upload_files_detial($field) {
		if (is_array($_FILES["$field"]['name'])) {
			for ($i = 0; $i < count($_FILES[$field]['name']); $i++)
				if ($_FILES[$field]['error'][$i] == 0) {
					$this -> upload_file[$this -> upload_file_num]['name'] = $_FILES[$field]['name'][$i];
					$this -> upload_file[$this -> upload_file_num]['type'] = $_FILES[$field]['type'][$i];
					$this -> upload_file[$this -> upload_file_num]['size'] = $_FILES[$field]['size'][$i];
					$this -> upload_file[$this -> upload_file_num]['tmp_name'] = $_FILES[$field]['tmp_name'][$i];
					$this -> upload_file[$this -> upload_file_num]['error'] = $_FILES[$field]['error'][$i];
					$this -> upload_file_num++;
				}
		}
		else
			if ($_FILES["$field"]['error'] == 0) {
				$this -> upload_file[$this -> upload_file_num]['name'] = $_FILES["$field"]['name'];
				$this -> upload_file[$this -> upload_file_num]['type'] = $_FILES["$field"]['type'];
				$this -> upload_file[$this -> upload_file_num]['size'] = $_FILES["$field"]['size'];
				$this -> upload_file[$this -> upload_file_num]['tmp_name'] = $_FILES["$field"]['tmp_name'];
				$this -> upload_file[$this -> upload_file_num]['error'] = $_FILES["$field"]['error'];
				$this -> upload_file_num++;
			}
		if (UPLOAD_DEBUG)
			var_dump($this -> upload_file, $_FILES);
	}
	public function check($i) {
		if(!empty($this -> upload_file[$i]['name'])) {
			if ($this -> upload_file[$i]['size'] > $this -> max_size*1024)
				$this -> upload_file[$i]['error'] = 2;
			$this -> upload_file[$i]['filename'] = $this -> upload_path.$this -> upload_file[$i]['name'];
			$file_info = pathinfo($this -> upload_file[$i]['name']);
			$file_ext = $file_info['extension'];
			if (!in_array($file_ext, $this -> allow_type))
				$this -> upload_file[$i]['error'] = 5;
			elseif ($this -> image_only && (getimagesize($this -> upload_file[$i]['tmp_name'])['mime'] == '' || getimagesize($this -> upload_file[$i]['tmp_name'])[1] <= 0)) {
				$this -> upload_file[$i]['error'] = 5;
			}
			if ($this -> renamed) {
				list($usec, $sec) = explode(" ",microtime());
				$this -> upload_file[$i]['filename'] = $sec.substr($usec,2).'.'.$file_ext;
				unset($usec);
				unset($sec);
			}
			if (file_exists($this -> upload_file[$i]['filename'])){
				if($this -> overwrite)
					@unlink($this->upload_file[$i]['filename']);
				else {
					$j = 0;
					do {
						$j++;
						$temp_file = str_replace('.'.$file_ext, '('.$j.').'.$file_ext, $this -> upload_file[$i]['filename']);
					}
					while (file_exists($temp_file));
					$this -> upload_file[$i]['filename'] = $temp_file;
					unset($temp_file);
					unset($j);
				}
			}
		}
		else
			$this -> upload_file[$i]['error'] = 6;
	}
	public function upload() {
		$upload_msg = '';
		for ($i = 0; $i < $this -> upload_file_num; $i++) {
			if (!empty($this -> upload_file[$i]['name'])) {
				$this -> check($i);
				if ($this -> upload_file[$i]['error'] == 0)
					if (!@move_uploaded_file($this -> upload_file[$i]['tmp_name'],$this -> upload_file[$i]['filename']))
						$upload_msg.='Upload File: '.$this -> upload_file[$i]['name'].' Error: '.$this -> error($this -> upload_file[$i]['error']).'!<br>';
					else {
						$this -> succ_upload_file[] = $this -> upload_file[$i]['filename'];
						$upload_msg.='Upload File: '.$this -> upload_file[$i]['name'].' Succeed<br>';
					}
				else
					$upload_msg.='Upload File: '.$this -> upload_file[$i]['name'].' Error: '.$this -> error($this -> upload_file[$i]['error']).'!<br>';
			}
		}
		echo $upload_msg;
	}
	public function error($error) {
		switch ($error) {
			case 1:
			return 'File Size > php.ini -> upload_max_filesize';
			break;
			case 2:
			return 'File Size > config -> MAX_FILE_SIZE';
			break;
			case 3:
			return 'Some files failed to upload';
			break;
			case 4:
			return 'No file uploaded';
			break;
			case 5:
			return 'Forbidden Filetype';
			break;
			case 6:
			return 'Filename Empty';
			break;
			default:
			return 'Unknown Error';
			break;
		}
	}
	public function get_succ_file() {
		return $this -> succ_upload_file;
	}
	
}
?>