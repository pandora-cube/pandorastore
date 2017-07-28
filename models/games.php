<?php
class Games {
	private $mysqli = NULL;
	private $table = NULL;

	public function __construct($link, $table) {
		$this->mysqli = $link;
		$this->table = $table;
	}

	public function load() {
		$this->loadCategories($genres, $platforms);
		$data = array();
		if($result = $this->mysqli->query(sprintf("SELECT * FROM %s ORDER BY CreatedTime DESC", $this->table["games"]))) {
			for($i = 0; $i < $result->num_rows; $i++) {
				$data[$i] = $result->fetch_assoc();
				$this->getCategoriesName($data[$i]["Genres"], $genres);
				$this->getCategoriesName($data[$i]["Platforms"], $platforms);
			}
			$result->free();
		}
		return $data;
	}

	private function loadCategories(&$genres, &$platforms) {
		$sql = "
			SELECT *, \"Genre\" AS Type
			FROM ".$this->table["genres"]."
			UNION
			SELECT *, \"Platform\" AS Type
			FROM ".$this->table["platforms"];
		$genres = $platforms = array();
		if($result = $this->mysqli->query($sql)) {
			for($i = 0; $i < $result->num_rows; $i++) {
				$data = $result->fetch_assoc();
				if($data["Type"] == "Genre")
					$genres[$data["ID"]] = $data["Name"];
				else if($data["Type"] == "Platform")
					$platforms[$data["ID"]] = $data["Name"];
			}
			$result->free();
		}
	}

	private function getCategoriesName(&$data, $categories) {
		$data = explode(",", $data);
		for($i = 0; $i < count($data); $i++)
			$data[$i] = $categories[(int)$data[$i]];
	}
}
?>
