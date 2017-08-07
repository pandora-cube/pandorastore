<?php
class Categories {
	private $mysqli = NULL;
	private $table = NULL;
	private $names = NULL;

	public function __construct($link, $table) {
		$this->mysqli = $link;
		$this->table = $table;
	}

	public function load() {
		$sql = "
			SELECT *, \"Genre\" AS Type
			FROM ".$this->table["genres"]."
			UNION
			SELECT *, \"Platform\" AS Type
			FROM ".$this->table["platforms"];
		$this->names = array();
		if($result = $this->mysqli->query($sql)) {
			for($i = 0; $i < $result->num_rows; $i++) {
				$data = $result->fetch_assoc();
				$this->names[$data["Type"]][$data["ID"]] = $data["Name"];
			}
			$result->free();
		}
		return $this->names;
	}

	public function parseName(&$data, $type) {
		$result = array();
		foreach(explode(',', $data[$type.'s']) as $id)
			array_push($result, $this->names[$type][$id]);
		$data[$type.'s'] = $result;
	}
}
?>
