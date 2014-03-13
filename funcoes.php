<?php
    inicializa();
    protegeArquivo( basename( __FILE__ ) );

    /**
     * Inicializa as configurações básicas do sistema
     */
    function inicializa(){
        if( file_exists( dirname(__FILE__)."\conf.php" ) )
            require_once( dirname(__FILE__)."\conf.php" );
        else 
            die( "O arquivo de conexão não foi localizado" );
        
        $constantesDoSistema = array( 
                                    "BASEPATH", "BASEURL", "CLASSESPATH"
                                    , "MODULOPATH", "CSSPATH", "JSPATH" , "DBHOST"
                                    , "DBUSER" , "DBPASS", "DBNAME"
                               );
        foreach( $constantesDoSistema as $constate ){
            if( !defined($constate) )
                die( "Faltam configurações básicas do sistema" );
        }
        
        if( file_exists(BASEPATH.CLASSESPATH."autoload.php") )
            require_once(BASEPATH.CLASSESPATH."autoload.php");
        
        if( isset( $_GET['logoff'] ) ) {
            if( $_GET['logoff'] == true ){
                $user = new UsuarioDAO();
                $user->doLogout();
                exit;
            }
        }
        
    }

    /**
     * Cria referencia para o arquivo css.
     * @param o nome do arquivo css.
     * @param o parametro media da css.
     */
    function loadCss($arquivo, $media) {
        if ($arquivo !=null){
                echo "\t\t<link rel=\"stylesheet\" type=\"text/css\" href=\"".BASEURL.CSSPATH.$arquivo.".css\" media=\"".$media."\" />\n";
        }
    }

    /**
     * Cria referencia para o arquivo js.
     * @param o nome do arquivo js.
     */
    function loadJs($arquivo){
        if ($arquivo!=null){
            echo "\t\t<script type=\"text/javascript\" src=\"".BASEURL.JSPATH.$arquivo.".js\"></script>\n";
        }
    }

    /**
     * Carrega o módulo do sistema.
     * @param o nome do módulo.
     * @param a tela do módulo à ser carregada.
     */
    function loadModulo($modulo, $tela){
        if($modulo == null){
            echo '<p>Erro na função <b>'.__FUNCTION__.'</b>: faltam parâmetros para a execução.</p>';
        }else {
            if( file_exists( MODULOPATH."$modulo.php") ){
                require_once( MODULOPATH."$modulo.php" );
            }else{
                echo '<div class="erro radius5">Módulo inexistente neste sistema!</div>';
            }
        }
    }

    /**
     * Impede o acesso direto ao arquivo solicitado.
     * @param o nome do arquivo atual: <b>basename( __FILE__ )</b>.
     */
    function protegeArquivo($nomeArquivo) {
        $url = $_SERVER['PHP_SELF'];
        if( strpos($url, $nomeArquivo) )
            header("location: ".BASEURL."index.php?erro=3");
    }

    /** 
     * Verifica se o usuario está logado no sistema. 
     * Caso contrário o redireciona para a tela de login.
     */
    function verificaLogin() {
        $sessao = new Sessao();
        if(    $sessao->getNvars() <= 0 
            || $sessao->getVar('boo_logado') == 0 
           // || $sessao->getVar('num_ip') != $_SERVER['REMOTE_ADDR'] 
          )
            header("location: ".BASEURL."index.php?erro=3");
    }

    /** 
     * Criptografa dados do sistema. 
     * @return A string criptografada.
     */
    function criptografar($str_original){
        return md5($str_original);
    }

    /** 
     * Faz a requisição do arquivo de maneira segura.
     * @param O arquivo para inserção.
     */
    function insereArquivo($arquivo){
        if(file_exists($arquivo))
            require_once $arquivo;
        else 
            echo '<div class="erro radius5">Arquivo não encontrado!</div>';
    }

    /** 
     * Faz a conversão dos padroes de datas: EUA-BR e BR-EUA.
     * @param A data em qualquer um dos padrões.
     * @return A data convertida no padrão oposto ao de entrada.
     */
    function converteData($data){
        if(strstr($data, "/")){
            $data = explode('/', $data);
            $dataNova = $data[2].'-'.$data[1].'-'.$data[0];
        }
         else if(strstr($data, "-")){
            $data = explode('-', $data);
            $dataNova = $data[2].'/'.$data[1].'/'.$data[0];
        }
        
        return $dataNova;
    }