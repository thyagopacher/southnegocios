<?php

include "../model/Conexao.php";
$conexao = new Conexao();
$banco   = $conexao->comandoArray("select codbanco from banco where numbanco = '{$_POST["numbanco"]}'");
echo $banco["codbanco"];


include "../model/Log.php";
$log = new Log($conexao);
$log->codpessoa  = $_SESSION['codpessoa'];
$log->codempresa = $_SESSION['codempresa'];
$log->acao       = "procurar";
$log->observacao = "Procurado código banco - em ". date('d/m/Y'). " - ". date('H:i');
$log->codpagina  = "0";
$log->data = date('Y-m-d');
$log->hora = date('H:i:s');
$log->inserir();     