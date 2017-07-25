<?php
class Game {
	private $mysqli = NULL;
	private $table = NULL;

	public function __construct($link, $table) {
		$this->mysqli = $link;
		$this->table = $table;
	}

	public function loadAll() {
		$data = array();
		if($result = $this->mysqli->query($this->getLoadSQL()." ORDER BY CreatedTime DESC")) {
			for($i = 0; $i < $result->num_rows; $i++)
				$data[$i] = $result->fetch_assoc();
			$result->free();
		}
		return $data;
	}

	public function load($id) {
		$id = (int)$id;
		if($result = $this->mysqli->query($this->getLoadSQL()." WHERE ID = $id")) {
			$data = $result->fetch_assoc();
			$result->free();
			return $data;
		}
		return NULL;
	}

	private function getLoadSQL() {
		return "
			SELECT
				a.*,
				b.Name AS Category
			FROM
				".$this->table["games"]." AS a
			LEFT OUTER JOIN
				".$this->table["categories"]." AS b
				ON a.CategoryID = b.ID";
	}
}
?>
