<?php
    include "model/Conexao.php";
    $conexao = new Conexao();
    
    $res = $conexao->comando("select codemprestimo, quitacao from emprestimo where quitacao < 10 and quitacao = saldo_aproximado and quitacao > 0");
    $qtd = $conexao->qtdResultado($res);
    
    if($qtd > 0){
        echo "Achou {$qtd} resultados para arrumar<br>";
        while($emprestimo = $conexao->resultadoArray($res)){
            $valor_quitacao = (double)str_replace(".", "", $emprestimo["quitacao"]);
            if($valor_quitacao < 10){
                $valor_quitacao = 10 * $valor_quitacao;
            }
            if($valor_quitacao < 100){
                $valor_quitacao = 10 * $valor_quitacao;
            }
            if($valor_quitacao < 1000){
                $valor_quitacao = 10 * $valor_quitacao;
            }
            
            $resAtualiza = $conexao->comando("update emprestimo set quitacao = '', saldo_aproximado = '' where codemprestimo = '{$emprestimo["codemprestimo"]}'");
        }
        echo 'Pronto arrumado a quitação!!!';
    }