<?php
//    require_once '../classes/uploadFile.php';
//    require_once '../classes/PontosDAO.php';
//    $upload = new uploadFile('../FontesDeDados');
//    $registos = new PontosDAO();

    //$arq = '../FontesDeDados/MOVIMENT.txt';
    //$arq = '../FontesDeDados/AFD00003000517028466.txt';
    $arq = '../FontesDeDados/AFD00003000517026287.txt';
    //$arq = '../FontesDeDados/AFD00003000517026281.txt';
    if( file_exists($arq) ){
        $ponteiro = fopen($arq, 'r');
        $pontos = array();
        while( !feof( $ponteiro ) ) {
            $linha = fgets( $ponteiro, 1024);
            if( strlen($linha)==36 ){
                $data = substr($linha, 10, 8);
                $data = substr($data, 4,4) ."-". substr($data, 2,2) ."-". substr($data, 0,2);
                $hora = substr($linha, 18, 4);
                $hora = substr($hora, 0,2) .":". substr($hora, 2,2) ;
                $pis = substr($linha, 23, 11);
                
                $pontos[] = array( 'pis'=>$pis, 'data'=>$data, 'hora'=>$hora );
            }
        }
        fclose($ponteiro);
		
        $dataInicial = $pontos[0]['data']." ".$pontos[0]['hora'].":00";
        $dataFinal = $pontos[count($pontos)-1]['data']." ".$pontos[count($pontos)-1]['hora'].":00";
        
//        $blacklist[0] = array();
//        $blacklist[1] = array();
//        
//        $datasInseridasNoDB = $registos->selecionar('dataEhora, Funcionario_pis', 'pontos', "");
//        for ($i = 0; $i<count($datasInseridasNoDB); $i++){
//            $blacklist[0][] = $datasInseridasNoDB[$i][0];
//            $blacklist[1][] = $datasInseridasNoDB[$i][1];
//        }
        
        $contador = 0;
        $sql = "INSERT INTO `pontos`\r\n\t(`id_ponto`, `dataEhora`, `Funcionario_pis` )\r\nVALUES\r\n\t";
        for($i = 0;$i<count($pontos); $i++){
            $timestamp = $pontos[$i]['data']." ".$pontos[$i]['hora'].":00" ;
            $pis = $pontos[$i]['pis'];
//            if( in_array($timestamp, $blacklist[0]) && in_array($pis, $blacklist[1]) )
//                continue;
            $sql .= "( NULL, '$timestamp', '".$pis."' ), \r\n\t";
            $contador++;
        }
        $sql = substr($sql, 0, -5);
        $sql .=";";
        
        if($contador){
            $ponteiro = fopen('../FontesDeDados/sql.txt', 'w');
            fwrite($ponteiro, $sql);
            fclose($ponteiro);
            
            //$registos->executarQuery($sql);
        }
        
        echo $contador." pontos registrados<br />\n";
//        $dataFinal = $registos->selecionar('dataEhora', 'pontos', "ORDER BY 'dataEhora' DESC LIMIT 1");
//        echo "Ultima data registrada no banco de dados: ".$dataFinal[0][0];
    }