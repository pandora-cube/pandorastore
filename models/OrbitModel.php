<?php
class OrbitModel {
	private $mysqli = NULL;

	function __construct($link) {
		$this->mysqli = $link;
	}

	function load($table) {
		$data = array();
		if($result = $this->mysqli->query("SELECT * FROM $table ORDER BY id ASC")) {
			for($i = 0; $i < $result->num_rows; $i++)
				$data[$i] = $result->fetch_assoc();
			$result->free();
		}
		return $data;
	}
}
?>
