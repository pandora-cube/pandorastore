<?php
class Orbit {
	private $mysqli = NULL;
	private $table = NULL;

	function __construct($link, $table) {
		$this->mysqli = $link;
		$this->table = $table;
	}

	function load() {
		$data = array();
		if($result = $this->mysqli->query("SELECT * FROM $this->table ORDER BY ID ASC")) {
			for($i = 0; $i < $result->num_rows; $i++)
				$data[$i] = $result->fetch_assoc();
			$result->free();
		}
		return $data;
	}
}
?>
