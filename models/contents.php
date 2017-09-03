<?php
class Contents {
	private $mysqli;
	private $table;
	private $config;
	private $contents;
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
			FROM {$this->table["contents"]}
			WHERE {$genre} AND {$platform}
			ORDER BY CreatedTime DESC";

		$this->categories_model->load();
		$this->contents = array();
		if($result = $this->mysqli->query($sql)) {
			for($i = 0; $i < $result->num_rows; $i++) {
				$origin = $this->contents[$i] = $result->fetch_assoc();
				$identifier = $origin["Identifier"];

				// Thumbnail
				$this->contents[$i]["Thumbnail"] = $this->getPath($identifier)."/{$this->config["file"]["thumbnail"]}";
				// Images
				$this->contents[$i]["Images"] = $this->getImages($identifier);
				// Genres
				$this->categories_model->parseArray($origin, $this->contents[$i], "Genre");
				$this->categories_model->parseName($origin, $this->contents[$i], "Genre");
				// Platforms
				$this->categories_model->parseArray($origin, $this->contents[$i], "Platform");
				$this->categories_model->parseName($origin, $this->contents[$i], "Platform");
			}
			$result->free();
		}
		return $this->contents;
	}

	public function filterCategory($category_id, $type) {
		foreach($this->contents as $key => $content)
			if(!in_array($category_id, $content[$type."sID"]))
				unset($this->contents[$key]);
		return $this->contents;
	}

	private function getPath($identifier) {
		return "{$this->config["path"]["root"]}/$identifier";
	}

	private function getImages($identifier) {
		$globalpath = $this->getPath($identifier).$this->config["path"]["images"];
		$localpath = $_SERVER["DOCUMENT_ROOT"].$globalpath;
		$scan = scandir($localpath);
		$files = array();

		foreach($scan as $file) {
			if(is_file("{$localpath}/{$file}"))
				array_push($files, "{$globalpath}/{$file}");
		}

		return $files;
	}
}
?>
