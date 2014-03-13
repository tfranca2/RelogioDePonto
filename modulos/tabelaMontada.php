<?php 
    require_once '../funcoes.php';
    require_once '../classes/PontosDAO.php';
    
?>

<script type="text/javascript">
    $(document).ready(function(){
        $("#pontosPorUsuario").dataTable({
            "sScrollY": "340px",
            "bPaginate": false,
            "aaSorting": [[0, "asc"]],
            "oLanguage": {
                "sProcessing":   "Processando...",
                "sLengthMenu":   "Mostrar _MENU_ registros",
                "sZeroRecords":  "Não foram encontrados resultados",
                "sInfo":         "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                "sInfoEmpty":    "Mostrando de 0 até 0 de 0 registros",
                "sInfoFiltered": "(filtrado de _MAX_ registros no total)",
                "sInfoPostFix":  "",
                "sSearch":       "Buscar:",
                "sUrl":          "",
                "oPaginate": {
                    "sFirst":    "Primeiro",
                    "sPrevious": "Anterior",
                    "sNext":     "Seguinte",
                    "sLast":     "Último"
                }
            }
        });
    });
</script>
<table class="display" id="pontosPorUsuario" border=1>
    <thead>
    <tr>
        <th>Data</th>
        <th>Entrada</th>
        <th>Almoço</th>
        <th>Retorno</th>
        <th>Saída</th>
        <th>Inicio Extra</th>
        <th>Fim Extra</th>
        <th></th>
        <th>Situação</th>
        <th>H. Trab.</th>
        <th>H. Calc.</th>
        <th>H. Extr.</th>
        <th>DSR</th>
        <th>H. Abon.</th>
        <th>H. N. Trab.</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td> a </td>
        <td> a </td>
        <td> a </td>
        <td> a </td>
        <td> a </td>
        <td> a </td>
        <td> a </td>
        <td></td>
        <td> a </td>
        <td> a </td>
        <td> a </td>
        <td> a </td>
        <td> a </td>
        <td> a </td>
        <td> a </td>
    </tr>

<?php 
	/*/
    if( isset($_POST['iniData']) && isset($_POST['finData']) && isset($_POST['funcionario'])){
        $inicio = converteData($_POST['iniData'])." 00:00:00";
        $final = converteData($_POST['finData'])." 23:59:59";
        $pisFuncionario = $_POST['funcionario'];
        
        $registros = new PontosDAO();
        $pontos = $registros->selecionar('dataEhora, observacoes', 'pontos', 
                "WHERE Funcionario_pis = $pisFuncionario AND dataEhora BETWEEN '$inicio' AND '$final'
                    ORDER BY dataEhora ASC");
        foreach ($pontos as $chave => $valor){
            $valor['dataEhora'];
        }
    }
	//*/
	
	$sql = "SELECT p.`dataEhora`,f.`nome` FROM `pontos` p
				INNER JOIN `funcionario` f
					ON f.`Funcionario_pis` = p.`Funcionario_pis`
				ORDER BY f.`nome` ASC, p.`dataEhora` ASC; ";
	
?>
    </tbody>
</table>


