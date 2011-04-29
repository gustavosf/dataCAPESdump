<?php

class Parser extends Tables {

	private $files = array();
	private $info  = array();
	
	public function load() {
		$script = file_get_contents(DUMP_PATH . DS . 'script.ctl');
		$script = explode("\n", $script);
		
		$data = array();
		
		foreach ($script as $s) {
			$s = explode(" ", $s);
			if ($s[0] == "SET") {
				$this->info[$s[1]] = $s[2];
			} elseif ($s[0] == "IMPORTFILE") {
				$this->files[$s[2]] = $s[1];
			}
		}
	}
	
	public function parse($type) {
		if (!isset($this->tables[$type])) 
			throw new Exception("Parser não encontrado (verifique em cfg/tables.php)");

		$table = $this->tables[$type];
		$file = $this->files[$table];
		$table = ucwords(strtolower($table));
		
		$parser = new $table($file);
		return $parser->parse();
	}

}