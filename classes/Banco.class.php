<?php
    require_once( dirname(__FILE__).'/autoload.php' );
    protegeArquivo( basename( __FILE__ ) );

    abstract class Banco {
        private $servidor = DBHOST;
        private $usuario = DBUSER;
        private $senha = DBPASS;
        private $nomeDoBanco = DBNAME;
        public $conexao = NULL;

        public function __construct(){
            $this->conecta();
        }

        public function __destruct(){
            if ($this->conexao != NULL)
                mysql_close($this->conexao);
        }

        public function conecta(){
            $this->conexao = mysql_connect($this->servidor,$this->usuario,$this->senha,TRUE) 
                    or die( $this-> exibeErro( __FILE__, __FUNCTION__ ) );
            mysql_select_db($this->nomeDoBanco) or die( $this-> exibeErro( __FILE__, __FUNCTION__ ) );
        }

        public function exibeErro($arquivo,$rotina){
            if ($arquivo != NULL && $rotina != NULL) {
                $url = explode("\\", $arquivo);
                unset($url[0]); unset($url[1]); unset($url[2]); unset($url[3]);
                $arquivo = implode("\\", $url);
                
                echo "Ocorreu um erro com os seguintes detalhes: <br />
                      <b>Arquivo:</b> ".$arquivo."<br />
                      <b>Rotina:</b> ".ucfirst($rotina)."( )<br />
                      <b>Codigo:</b> ".mysql_errno($this->conexao)."<br />
                      <b>Mensagem:</b> ".mysql_error($this->conexao)."<br />";
            } else echo "Um erro desconhecido ocorreu!";
        }

    }
