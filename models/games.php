<?php
class Games {
	private $mysqli = NULL;
	private $table = NULL;
	private $model_categories = NULL;

	public function __construct($link, $table, $model_categories) {
		$this->mysqli = $link;
		$this->table = $table;
		$this->model_categories = $model_categories;
	}

	public function load() {
		$this->model_categories->load();
		$data = array();
		if($result = $this->mysqli->query(sprintf("SELECT * FROM %s ORDER BY CreatedTime DESC", $this->table["games"]))) {
			for($i = 0; $i < $result->num_rows; $i++) {
				$data[$i] = $result->fetch_assoc();
				$this->model_categories->parseName($data[$i], "Genre");
				$this->model_categories->parseName($data[$i], "Platform");
			}
			$result->free();
		}
		return $data;
	}
}
?>
