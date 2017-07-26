<?php
class Games {
	private $mysqli = NULL;
	private $table = NULL;

	public function __construct($link, $table) {
		$this->mysqli = $link;
		$this->table = $table;
	}

	public function load() {
		$categories = $this->loadCategoriesName();
		$data = array();
		if($result = $this->mysqli->query(sprintf("SELECT * FROM %s ORDER BY CreatedTime DESC", $this->table["games"]))) {
			for($i = 0; $i < $result->num_rows; $i++) {
				$data[$i] = $result->fetch_assoc();
				$this->getCategoriesName($data[$i]["Categories"], $categories);
			}
			$result->free();
		}
		return $data;
	}

	private function loadCategoriesName() {
		$data = array();
		if($result = $this->mysqli->query(sprintf("SELECT * FROM %s", $this->table["categories"]))) {
			for($i = 0; $i < $result->num_rows; $i++) {
				$temp = $result->fetch_assoc();
				$data[$temp["ID"]] = $temp["Name"];
			}
			$result->free();
		}
		return $data;
	}

	private function getCategoriesName(&$data, $categories) {
		$data = explode(",", $data);
		for($i = 0; $i < count($data); $i++)
			$data[$i] = $categories[(int)$data[$i]];
	}
}
?>
