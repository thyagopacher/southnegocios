<?php

include("../model/Conexao.php");
$conexao = new Conexao();
$sql = "select * from empresa where codempresa = '{$_POST["codempresa"]}'";
$fornecedor = $conexao->comandoArray($sql);

echo json_encode(array('codramo' => $fornecedor["codramo"], 'razao' => $fornecedor["razao"],
        'cep' => $fornecedor["cep"], 'tipologradouro' => $fornecedor["tipologradouro"], 'logradouro' => $fornecedor["logradouro"],
        'numero' => $fornecedor["numero"], 'bairro' => $fornecedor["bairro"], 'cidade' => $fornecedor["cidade"], 'estado' => $fornecedor["estado"],
        'telefone' => $fornecedor["telefone"], 'celular' => $fornecedor["celular"], 'email' => $fornecedor["email"], 'sitemorador' => $fornecedor["sitemorador"], 'codstatus' => $fornecedor["codstatus"]));