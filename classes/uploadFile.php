<?php
class uploadFile{
    var $pasta;
    var $nome;
    var $tmp_name;
    var $caminho;
    private $erro = false;

    /** 
     * Inicia os parametros básicos para o upload de arquivo.
     * @param Pasta de destino.
     */
    public function __construct($pastaDeDestino){
        if( !empty($_FILES['movimento']) && !empty($_FILES['movimento']['name']) ){
            $this->pasta     = $pastaDeDestino;
            $this->nome      = $_FILES['movimento']['name'];
            $this->tmp_name  = $_FILES['movimento']['tmp_name'];
            
            $this->uploadArquivo();
            
            if( !empty($this->nome) && !$this->erro )
                $this->caminho = $this->pasta.'/'.$this->nome;
        } 
    }

    /** 
     * Upa o arquivo .txt para o servidor
     */
    private function uploadArquivo() {
        if( preg_match("/\.txt{1}$/i", $_FILES['movimento']["name"], $ext) ) {
            if($_FILES['movimento']['size'] < 5000000){
                $this->nome = "MOVIMENT.txt";
                chmod($this->pasta."/", 0777);
                if(move_uploaded_file($this->tmp_name, $this->pasta."/".$this->nome)){
                    $this->erro = false;
                } else {
                    echo '<div class="erro radius5">Não foi possível salvar o arquivo no servidor!</div>';
                    $this->erro = true;
                }
            } else {
                echo '<div class="erro radius5">Arquivo muito grande!</div>';
                $this->erro = true;  
            }
        } else {
            echo '<div class="erro radius5">Tipo de arquivo inválido!</div>';
            $this->erro = true;
        }  
    }

    /** 
     * Diz se houve algum erro na execução da classe
     * @return Booleano do erro
     */
    public function getErro(){
        return $this->erro;
    }
}