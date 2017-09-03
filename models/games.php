<?php
class Games {
	private $mysqli;
	private $table;
	private $config;
	private $games;
	private $categories_model;

	public function __construct($link, $table, $config, $categories_model) {
		$this->mysqli = $link;
		$this->table = $table;
		$this->config = $config;
		$this->categories_model = $categories_model;
	}

	public function load($genre = NULL, $platform = NULL) {
		$genre = ($genre == NULL) ? "TRUE" : "CONCAT(\",\", Genres, \",\") LIKE \"%,{$genre},%\"";
		$platform = ($platform == NULL) ? "TRUE" : "CONCAT(\",\", Platforms, \",\") LIKE \"%,{$platform},%\"";
		$sql = "
			SELECT *
			FROM {$this->table.games}
			WHERE {$genre} AND {$platform}
			ORDER BY CreatedTime DESC";

		$this->categories_model->load();
		$this->games = array();
		if($result = $this->mysqli->query($sql)) {
			for($i = 0; $i < $result->num_rows; $i++) {
				$origin = $this->games[$i] = $result->fetch_assoc();
				$identifier = $origin.Identifier;

				// Thumbnail
				$this->games[$i].Thumbnail = getPath($identifier)."/{$this->config.thumbnail}";
				// Images
				$this->games[$i].Images = getImages($identifier);
				// Genres
				$this->categories_model->parseArray($origin, $this->games[$i], "Genre");
				$this->categories_model->parseName($origin, $this->games[$i], "Genre");
				// Platforms
				$this->categories_model->parseArray($origin, $this->games[$i], "Platform");
				$this->categories_model->parseName($origin, $this->games[$i], "Platform");
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

	private function getPath($identifier) {
		return "{$this->config.path}/$identifier";
	}

	private function getImages($identifier) {

	}
}
?>
