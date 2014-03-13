<?php
    require_once( dirname(__FILE__).'/autoload.php' );
    protegeArquivo( basename(__FILE__) );

    abstract class DAO extends Banco {
        public $tabela = "";
        /** Array dos campos do objeto com seus respectivos valores. */
        public $camposComValores = array();

        /**
         * Adiciona um campo no objeto.
         * @param o campo � ser adicionado.
         * @param o valor do campo.
         */
        public function addCampo( $campo, $valor ){
            if ($campo!=NULL) 
                $this->camposComValores[$campo]=$valor;
        }

        /**
         * Retira um campo no objeto.
         * @param o campo � ser removido.
         */
        public function delCampo( $campo ){
            if ( array_key_exists($campo, $this->camposComValores ) ) {
                unset( $this->camposComValores[$campo] );
            }
        }

        /**
         * Insere um novo valor � um campo no objeto.
         * @param o campo � ser editado.
         * @param o novo valor do campo.
         */
        public function setCampo( $campo, $valor ) {
            if ($campo != NULL && $valor != NULL)
                $this->camposComValores[$campo] = valor;
        }

        /**
         * Retorna o valor do campo do objeto.
         * @param o campo � ser resgatado.
         * @return o valor do campo do objeto.
         */
        public function getCampo( $campo ){
            if ($campo!=NULL && array_key_exists($campo, $this->camposComValores[$campo]))
                return $this->camposComValores[$campo];
            else
                return null;
        }

        /** 
         * Faz execu��o de todas as querys do sistema.
         * @param string query.
         * @return resultset da execu��o da fun��o mysql_query( ).
         */
        function executarQuery( $query ) {
            return mysql_query($query);
        }

        /**
         * Mostra o n�mero de linhas afetadas pela query.
         * @param string query.
         * @return integer numero de linhas afetadas.
         */
        public function numResultados( $query ){
            mysql_real_escape_string($query, $this->conexao );
            $this->executarQuery( $query );
            return mysql_affected_rows();
        }

        /** 
         * Diz se o registro existe no banco de dados.
         * @param O campo � ser verificado.
         * @param O valor desejado.
         * @return Booleano exist�ncia (ou n�o) do registro.
         */
        public function existeRegistro($campo, $valor){
            if($campo!=null && $valor!=null){
                if( $this->numResultados("SELECT $campo FROM $this->tabela WHERE $campo='$valor';") )
                    return true;
                else
                    return false;
            }
        }

        /**
         * Executa a instru��o INSERT no banco de dados.
         * @param o objeto � ser inserido.
         * @return booleano: resultante da opera��o.
         */
        public function inserir( $objeto ){
            $campos = array();
            $valores = array();
            foreach( $objeto->camposComValores as $campo => $valor){
                $campos[] = $campo;
                $valores[] = $valor;
            }
            $db_ins_query = "INSERT INTO ".$objeto->tabela."( ".implode(", ", $campos)." ) VALUES( '".implode("', '", $valores)."' );";
            $this->executarQuery($db_ins_query) or die( $this->exibeErro( __FILE__, __FUNCTION__ ) ); 
            return true;
        }

        /**
         * Executa a instru��o SELECT no banco de dados.
         * @param os campos desejados, 
         * @param a tabela pertencente, 
         * @param o complemento da instru��o.
         * @return objeto formado pela consulta.
         */
        public function selecionar( $campos, $tabela, $complemento ){
            mysql_real_escape_string($campos, $this->conexao );
            mysql_real_escape_string($tabela, $this->conexao );
            mysql_real_escape_string($complemento, $this->conexao );
            
            $resultado = array();
            $db_sel_query = "SELECT ".$campos." FROM ".$tabela." ".$complemento.";";
            $db_select_query = $this->executarQuery($db_sel_query) or die( $this->exibeErro( __FILE__, __FUNCTION__ ) );
            while ($linha = mysql_fetch_array($db_select_query)) {
                $resultado[] = $linha;
            }
            return $resultado;
        }

        /**
         * Executa a instru��o LIKE no banco de dados
         * @param a tabela para exame,
         * @param o campo de compara��o,
         * @param o termo pesquisado.
         * @return objeto formado pela consulta usando a fun��o selecionar( ).
         */
        public function comparar( $tabela, $campo, $termoPesquisado ){
            mysql_real_escape_string($campo, $this->conexao );
            mysql_real_escape_string($tabela, $this->conexao );
            mysql_real_escape_string($termoPesquisado, $this->conexao );
            
            $db_sel_like_query = "WHERE ".$campo." LIKE '".$termoPesquisado."'";
            
            return $this->selecionar( "*" , $tabela, $db_sel_like_query);
        }

        /**
         * Executa a instru��o UPDATE no banco de dados;<br /> O objeto � ser enviado por p�metro deve vir com os valores j� atualizados.
         * @param o objeto � ser editado.
         * @return booleano: resultante da opera��o.
         */
        public function editar( $objeto ){
            $resultado = $this->selecionar("*", $objeto->tabela, " WHERE int_id=".$objeto->camposComValores["int_id"].";");
            $db_upd_query = "UPDATE ".$objeto->tabela." SET ";
            $complemento = "";
            foreach( $objeto->camposComValores as $campo => $valor){
                if($campo=="int_id") continue;
                if( $valor == $resultado[0][$campo] ) continue;
                $complemento .= $campo." = '".$valor."', ";
            }
            $complemento = rtrim($complemento,', ');
            if( empty($complemento) ) return false;
            $db_upd_query .= $complemento." WHERE int_id=".$objeto->camposComValores["int_id"].";";
            $this->executarQuery($db_upd_query) or die( $this->exibeErro( __FILE__, __FUNCTION__ ) );
            return true;
        }

        /**
         * Executa a instru��o DELETE no banco de dados..
         * @param o objeto � ser deletado.
         * @return booleano: resultante da opera��o.
         */
        public function deletar( $objeto ){
            if($objeto!=null){
                $db_del_query = "DELETE FROM ".$objeto->tabela." WHERE int_id=".$objeto->camposComValores["int_id"]." LIMIT 1;";
                $this->executarQuery($db_del_query) or die( $this->exibeErro( __FILE__, __FUNCTION__ ) );
                return true;
            }
        }
    }
 