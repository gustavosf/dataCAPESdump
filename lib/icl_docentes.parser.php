<?php

/**
 * Classe para parse do arquivo de docentes do DataCAPES
 *
 * Uso:
 * 1 $docentes = new ICL_Docentes("arquivo.docentes.txt", "docentes");
 * 2 $retorno = $docentes->parse();
 */
class ICL_Docentes {

	/* Variável que irá armazenar as informações extraídas do dump */
	private $data = array();
	
	/* nome do campo (em $fields) que irá indexar $data */
	private $dataIndex = 'lattes';
	
	/* Campos que vamos extraír do dump */
	private $fields = array(
		0  => 'ano',
		1  => 'programa',           // código do programa
		11 => 'nivel',              // nível de instrução do docente (M ou D)
		12 => 'somefield',
		13 => 'someflag',
		14 => 'anoformacao',        // ano da formação mais recente do docente
		15 => 'ies_formacao_cod',   // código da IES da formação
		16 => 'ies_formacao_sigla',
		17 => 'ies_formacao_nome',
		18 => 'ies_formacao_pais',  // formato XX (sigla do país)
		24 => 'lattes',             // código látes (16 digitos)
	);
	
	private $file;
	private $table;
	
	public function __construct($file, $table = null) {
		$this->file = $file;
		$this->table = $table;
	}
	
	public function parse() {
		$content = file_get_contents(DUMP_PATH . $this->file);
		$content = explode("\n", $content);

		// itera sobre a lista de docentes, pegando apenas os campos setados em $fields
		$info = array();
		foreach ($content as $row) {
			$info = array();
			$row = explode("\t", $row);
			foreach ($this->fields as $index => $field) {
				$info[$field] = trim($row[$index], "\s\r\n\t\"");
			}
			$this->data[$info[$this->dataIndex]] = $info;
		}

		return $this->data;
	}
}