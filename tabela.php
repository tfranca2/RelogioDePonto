<?php 	
	$host = "localhost";
	$user = "root";
	$password = "pebaroxa";
	$database = "relogiodeponto";
	
	mysql_connect($host, $user, $password);
	mysql_select_db($database);
?>
<!DOCTYPE HTML>
<html lang="pt-BR">
<head>
	<title>Horas Trabalhadas</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
</head>
<body>
	<div id="container">
<form style="width: 500px; margin:10px auto 20px auto;" class="form-horizontal" method="post">
		Funcionario: 
	<select name="funcionario">
		<option value="">  </option>
		<?php
			$sql = "SELECT nome FROM funcionario;";
			
			$result = mysql_query($sql);
			while( $linha = mysql_fetch_assoc($result) ){
				echo '<option value="'.$linha['nome'].'"'; 
				if($linha['nome'] == @$_POST['funcionario'])
					echo ' selected ';
				echo '> '.$linha['nome'].' </option>';
			}
		?>
	</select>
	<input type="submit" value="mostrar" class="btn btn-info" />
</form>

<table class="table table-striped" id="pontosPorUsuario">
    <thead>
    <tr>
        <th>Data</th>
        <th></th>
        <th>Entrada</th>
        <th>Almo&ccedil;o</th>
        <th>Retorno</th>
        <th>Sa&iacute;da</th>
        <th>Inicio Extra</th>
        <th>Fim Extra</th>
        <th></th>
        <th>H. Trab.</th>
    </tr>
    </thead>
    <tbody>

<?php 		
	$sql = "SELECT DISTINCT p.`dataEhora` FROM pontos p
				LEFT JOIN funcionario f
					ON f.`Funcionario_pis` = p.`Funcionario_pis`
					WHERE MD5(f.`nome`) = '".MD5(@$_POST['funcionario'])."'
				ORDER BY p.`dataEhora` ASC;";
	
	$result = mysql_query($sql);
	$t = 0;
	while( $linha = mysql_fetch_assoc($result) ){
		$t++;
		@$pontos[] .= substr($linha['dataEhora'], 0, 10);
		$pontos = array_unique($pontos);
		@$pontos[substr($linha['dataEhora'], 0, 10)] .= substr($linha['dataEhora'], 10, 6);
	}
	
	function converterHora($total_segundos){
		$hora = sprintf("%02s",floor($total_segundos / (60*60)));
		$total_segundos = ($total_segundos % (60*60));
		
		$minuto = sprintf("%02s",floor ($total_segundos / 60 ));
		$total_segundos = ($total_segundos % 60);
		
		$hora_minuto = $hora.":".$minuto;
		return $hora_minuto;
	} 
	
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
	
	for($i=0; $i<=$t; $i++){
		$entrada = substr(@$pontos[$pontos[$i]], 1, 5);
		$almoco = substr(@$pontos[$pontos[$i]], 7, 5);
		$retorno = substr(@$pontos[$pontos[$i]], 13, 5);
		$saida = substr(@$pontos[$pontos[$i]], 19, 5);
		$extraIni = substr(@$pontos[$pontos[$i]], 25, 5);
		$extraFim = substr(@$pontos[$pontos[$i]], 31, 5);
		
		$entrada = strtotime($entrada);
		$almoco = strtotime($almoco);
		$retorno = strtotime($retorno);
		$saida = strtotime($saida);
		$extraIni = strtotime($extraIni);
		$extraFim = strtotime($extraFim);
		
		$horastrabalhadas = ($almoco-$entrada)+($saida-$retorno)+($extraFim-$extraIni);

		$horastrabalhadas = converterHora($horastrabalhadas);
		
		$entrada = substr(@$pontos[$pontos[$i]], 1, 5);
		$almoco = substr(@$pontos[$pontos[$i]], 7, 5);
		$retorno = substr(@$pontos[$pontos[$i]], 13, 5);
		$saida = substr(@$pontos[$pontos[$i]], 19, 5);
		$extraIni = substr(@$pontos[$pontos[$i]], 25, 5);
		$extraFim = substr(@$pontos[$pontos[$i]], 31, 5);
		
		if($horastrabalhadas == "00:00")
			continue;
		echo "
		<tr>
			<td> ".converteData(@$pontos[$i])." </td>
			<td></td>
			<td>".$entrada."</td>
			<td>".$almoco."</td>
			<td>".$retorno."</td>
			<td>".$saida."</td>
			<td>".$extraIni."</td>
			<td>".$extraFim."</td>
			<td></td>
			<td>";
			echo ( substr($horastrabalhadas, 0, 1) == '-' ) ? "<span class=\"btn-danger\"><b>&nbsp;Inconsist&ecirc;ncia&nbsp;</b></span>":$horastrabalhadas;
			echo "</td>
		</tr>
		";
	}
?>
    </tbody>
</table>

	</div>
</body>
</html>

