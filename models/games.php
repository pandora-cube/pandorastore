<?php
class Games {
	private $mysqli = NULL;
	private $table = NULL;
	private $games = NULL;
	private $model_categories = NULL;

	public function __construct($link, $table, $model_categories) {
		$this->mysqli = $link;
		$this->table = $table;
		$this->model_categories = $model_categories;
	}

	public function load() {
		$this->model_categories->load();
		$this->games = array();
		if($result = $this->mysqli->query(sprintf("SELECT * FROM %s ORDER BY CreatedTime DESC", $this->table["games"]))) {
			for($i = 0; $i < $result->num_rows; $i++) {
				$origin = $this->games[$i] = $result->fetch_assoc();

				$this->model_categories->parseArray($origin, $this->games[$i], "Genre");
				$this->model_categories->parseName($origin, $this->games[$i], "Genre");
				$this->model_categories->parseArray($origin, $this->games[$i], "Platform");
				$this->model_categories->parseName($origin, $this->games[$i], "Platform");
			}
			$result->free();
		}
		return $this->games;
	}

	public function filterCategory($category_id, $type) {
		foreach($this->games as $key => $game)
			if(!in_array($category_id, $game[$type."sID"]))
				unset($this->games[$key]);
		return $this->games;
	}
}
?>
