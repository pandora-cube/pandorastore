<?php
class Orbit {
	private $mysqli;
	private $table;

	public function __construct($link, $table) {
		$this->mysqli = $link;
		$this->table = $table;
	}

	public function load() {
		$data = array();
		if($result = $this->mysqli->query("SELECT * FROM {$this->table["orbit"]} WHERE Actived = 1 ORDER BY ID ASC")) {
			for($i = 0; $i < $result->num_rows; $i++)
				$data[$i] = $result->fetch_assoc();
			$result->free();
		}
		return $data;
	}
}
?>
