<?php
require_once( dirname(__FILE__).'/autoload.php' );
protegeArquivo( basename( __FILE__ ) );

class PontosDAO extends DAO {
    function __construct($campos = array() ) {
        parent::__construct();
        $this->tabela = "pontos";
        if( sizeof( $campos ) <= 0 ) {
            $this->camposComValores = array(
                                 "id_ponto" => 0
                                 , "dataEhora" => 0
                                 , "Funcionario_pis" => 0
                                 , "observacoes" => NULL
            );
        } else {
            $this->camposComValores = $campos;
        }
    }
}