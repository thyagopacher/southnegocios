<?php

include "model/Conexao.php";
$conexao = new Conexao();
$sql     = "SELECT * FROM `agenda` where dtagenda > '".date('Y-m-d')."' order by codpessoa;";
$res     = $conexao->comando($sql);
$qtd     = $conexao->qtdResultado($res);
if($qtd > 0){
    echo 'Encontrou ', $qtd, ' agendas para remanejar<br>';
    $qtdAgendas = 0;
    while($agenda = $conexao->resultadoArray($res)){
        $sql = "select * from agenda where codpessoa = {$agenda["codpessoa"]} and dtagenda > '".date('Y-m-d')."' and dtagenda <> '{$agenda["dtagenda"]}' and codempresa = '{$agenda["codempresa"]}'";
        $agenda2   = $conexao->comandoArray($sql);
        $resagenda = $conexao->comando("update agenda set atendido = 's' where codpessoa = '{$agenda2["codpessoa"]}' and codagenda = '{$agenda2["codagenda"]}'");
        if($resagenda == FALSE){
            die("Erro ao remanejar agenda!!!");
        }else{
            $qtdAgendas++;
        }
    }
    echo 'Agenda remanejada com sucesso!!! Remanejou ', $qtdAgendas, ' agendas';
}