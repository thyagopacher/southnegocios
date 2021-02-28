<?php

session_start();
include 'model/Conexao.php';
include 'model/BeneficioCliente.php';

$conexao = new Conexao();
$beneficio = new BeneficioCliente($conexao);

$chave = $beneficio->consultaBenInss2('1519900047');
foreach ($chave->fones->fone as $key => $fone) {
    echo '<br>Telefone:'.$fone->telefone;
}
