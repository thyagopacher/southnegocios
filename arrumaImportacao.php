<?php

include "model/Conexao.php";
include "model/CarteiraCliente.php";
$conexao = new Conexao();
$res     = $conexao->comando("select codpessoa, codempresa, codimportacao from pessoa where codimportacao > 0");
$qtd     = $conexao->qtdResultado($res);
$qtdArrumado = 0;
if($qtd > 0){
    echo "Encontrou $qtd resultados para verificar<br>";
    while($pessoa = $conexao->resultadoArray($res)){
        $importacao = $conexao->comandoArray("select codcarteira from importacao where codimportacao = '{$pessoa["codimportacao"]}'");
        $carteiraClientep = $conexao->comandoArray("select codcarteira from carteiracliente where codcliente = '{$pessoa["codpessoa"]}' and codempresa = '{$pessoa["codempresa"]}' and codcarteira = '{$importacao["codcarteira"]}'");
        if(!isset($carteiraClientep) || $carteiraClientep["codcarteira"] == NULL || $carteiraClientep["codcarteira"] == ""){
            $ct = new CarteiraCliente($conexao);
            $ct->codcarteira    = $importacao["codcarteira"];
            $ct->codcliente     = $pessoa["codpessoa"];
            $ct->codempresa     = $pessoa["codempresa"];
            $ct->codfuncionario = 6;
            $ct->dtcadastro     = date("Y-m-d H:i:s");
            $resArrumado = $ct->inserir();
            if($resArrumado == FALSE){
                echo "Problemas ao arrumar carteiras de clientes causado por:". mysqli_error($conexao->conexao);
                break;
            }else{
                $qtdArrumado++;
            }
        }
    }
}