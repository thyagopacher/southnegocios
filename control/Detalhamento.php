<?php
session_start();
include "../model/Conexao.php";
include "../model/ConsultasSouth.php";
$conexao = new Conexao();

$southconsultap = $conexao->comandoArray('select validade, dtcadastro, qtdconsulta  from southconsulta as sc where sc.codempresa = '. $_SESSION["codempresa"]. ' order by codconsulta desc limit 1');

if(isset($southconsultap["validade"]) && $southconsultap["validade"] != NULL && $southconsultap["validade"] != ""){
    $diaMais        = date('Y-m-d', strtotime('+'.$southconsultap["validade"].' days', strtotime($southconsultap["dtcadastro"])));
    $time_inicial   = strtotime(date("Y-m-d"));
    $time_final     = strtotime($diaMais);
    $diferenca      = $time_final - $time_inicial; // 19522800 segundos
    $diasExpira     = (int)floor( $diferenca / (60 * 60 * 24)); // 225 dias
    
    $diasMaisBrasil = date("d/m/Y", strtotime($diaMais));
}
//consultas usadas
$consultassouthp = $conexao->comandoArray('select count(1) as qtd from consultassouth as cs where cs.codempresa = ' . $_SESSION["codempresa"]);
$limiteConsulta = $southconsultap["qtdconsulta"] - $consultassouthp["qtd"];
if ($limiteConsulta <= 0) {
    die(json_encode(array('mensagem' => 'Acabaram seus créditos por favor consulte a administração!!!', 'situacao' => false)));
}

$conexao = new Conexao();
$cs = new ConsultasSouth($conexao);
$cs->campo = "numbeneficio";
$cs->valor = $_GET['nb'];
$resInserirConsulta = $cs->inserir();
if ($resInserirConsulta == FALSE) {
    die(json_encode(array('mensagem' => 'Não conseguiu gravar log de consulta!!!', 'situacao' => false)));
}
$configuracao = $conexao->comandoArray('select codconfiguracao, keyanaliseinfo 
            from configuracao where codempresa = ' . $_SESSION["codempresa"]);
if ($_GET['tipo'] == 1) {
    
    echo file_get_contents("http://api.analise.info/Caddetalha?nb={$_GET['nb']}&type=html&key={$configuracao['keyanaliseinfo']}");
} elseif ($_GET['tipo'] == 2) {
    echo file_get_contents("http://api.analise.info/Detalhamento?nb={$_GET['nb']}&type=html&key={$configuracao['keyanaliseinfo']}");
} elseif ($_GET['tipo'] == 3) {
    $url = "http://api.analise.info/Detalhamento2?nb={$_GET['nb']}&type=html&key={$configuracao['keyanaliseinfo']}";
    echo $url;
    echo file_get_contents($url);
}
