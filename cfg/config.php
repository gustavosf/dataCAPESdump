<?php

define('ROOT', dirname(dirname(__FILE__)));
define('DS', DIRECTORY_SEPARATOR);

define('DUMP_PATH', ROOT . DS . 'dump');
define('LIB_PATH', ROOT . DS . 'dump');

/* função mágica usada para carregamento automático dos parsers */
function __autoload($className) {
	if (file_exists(LIB_PATH . DS . strtolower($className) . '.parser.php')) {
		require_once(LIB_PATH . DS . strtolower($className) . '.parser.php');
	} elseif (file_exists(LIB_PATH . DS . strtolower($className) . '.class.php')) {
		require_once(LIB_PATH . DS . strtolower($className) . '.class.php');
	} else {
		// parser não encontrado :(
	}
}