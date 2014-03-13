<?php
    require_once( dirname(__FILE__).'/autoload.php' );
    protegeArquivo( basename(__FILE__) );

    abstract class DAO extends Banco {
        public $tabela = "";
        /** Array dos campos do objeto com seus respectivos valores. */
        public $camposComValores = array();

        /**
         * Adiciona um campo no objeto.
         * @param o campo à ser adicionado.
         * @param o valor do campo.
         */
        public function addCampo( $campo, $valor ){
            if ($campo!=NULL) 
                $this->camposComValores[$campo]=$valor;
        }

        /**
         * Retira um campo no objeto.
         * @param o campo à ser removido.
         */
        public function delCampo( $campo ){
            if ( array_key_exists($campo, $this->camposComValores ) ) {
                unset( $this->camposComValores[$campo] );
            }
        }

        /**
         * Insere um novo valor à um campo no objeto.
         * @param o campo à ser editado.
         * @param o novo valor do campo.
         */
        public function setCampo( $campo, $valor ) {
            if ($campo != NULL && $valor != NULL)
                $this->camposComValores[$campo] = valor;
        }

        /**
         * Retorna o valor do campo do objeto.
         * @param o campo à ser resgatado.
         * @return o valor do campo do objeto.
         */
        public function getCampo( $campo ){
            if ($campo!=NULL && array_key_exists($campo, $this->camposComValores[$campo]))
                return $this->camposComValores[$campo];
            else
                return null;
        }

        /** 
         * Faz execução de todas as querys do sistema.
         * @param string query.
         * @return resultset da execução da função mysql_query( ).
         */
        function executarQuery( $query ) {
            return mysql_query($query);
        }

        /**
         * Mostra o número de linhas afetadas pela query.
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
         * @param O campo à ser verificado.
         * @param O valor desejado.
         * @return Booleano existência (ou não) do registro.
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
         * Executa a instrução INSERT no banco de dados.
         * @param o objeto à ser inserido.
         * @return booleano: resultante da operação.
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
         * Executa a instrução SELECT no banco de dados.
         * @param os campos desejados, 
         * @param a tabela pertencente, 
         * @param o complemento da instrução.
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
         * Executa a instrução LIKE no banco de dados
         * @param a tabela para exame,
         * @param o campo de comparação,
         * @param o termo pesquisado.
         * @return objeto formado pela consulta usando a função selecionar( ).
         */
        public function comparar( $tabela, $campo, $termoPesquisado ){
            mysql_real_escape_string($campo, $this->conexao );
            mysql_real_escape_string($tabela, $this->conexao );
            mysql_real_escape_string($termoPesquisado, $this->conexao );
            
            $db_sel_like_query = "WHERE ".$campo." LIKE '".$termoPesquisado."'";
            
            return $this->selecionar( "*" , $tabela, $db_sel_like_query);
        }

        /**
         * Executa a instrução UPDATE no banco de dados;<br /> O objeto à ser enviado por pâmetro deve vir com os valores já atualizados.
         * @param o objeto à ser editado.
         * @return booleano: resultante da operação.
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
         * Executa a instrução DELETE no banco de dados..
         * @param o objeto à ser deletado.
         * @return booleano: resultante da operação.
         */
        public function deletar( $objeto ){
            if($objeto!=null){
                $db_del_query = "DELETE FROM ".$objeto->tabela." WHERE int_id=".$objeto->camposComValores["int_id"]." LIMIT 1;";
                $this->executarQuery($db_del_query) or die( $this->exibeErro( __FILE__, __FUNCTION__ ) );
                return true;
            }
        }
    }
 