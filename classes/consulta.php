<?php

require_once( dirname(__FILE__).'/autoload.php' );
protegeArquivo( basename( __FILE__ ) );

class Consulta extends DAO {
	function __construct($sql) {
        parent::__construct();
        $this->tabela = "pontos";
		
		return $this->executarQuery($sql);
	}
}