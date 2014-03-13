        <form name="periodo" action="" method="post">
            Período: de <input type="text" id="iniData" name="iniData" readonly /> 
            até <input type="text" id="finData" name="finData" readonly />
            <label>Funcionário 
                <select name="funcionario"> 
                    
                    <option>  </option> 
                    <?php 
                        require_once '../classes/PontosDAO.php';
                        
                        $pontos = new PontosDAO();
                        $resultados = $pontos->selecionar('nome, pis', 'funcionario', '');
                        foreach ($resultados as $funcionario){
                            echo '<option value="'.$funcionario['pis'].'">'.$funcionario['nome']."</option>\n\t\t\t\t\t";
                        }
                    ?>
                    
                </select> 
            </label>
            <input type="submit" value="Gerar" />
        </form>
        <?php 
            require_once 'tabelaMontada.php';
        ?>