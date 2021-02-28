<?php
header ('Content-type: text/html; charset=UTF-8'); 
include "model/Conexao.php";
include "model/Pessoa.php";

$conexao = new Conexao();
$respessoa = $conexao->comando("select p1.codpessoa, p1.codempresa, p1.codcategoria, p1.cpf from pessoa as p1 where p1.cpf <> '' and codcategoria in(1,6) and length(rtrim(ltrim((p1.cpf)))) > 8 
order by rand()");
$qtdpessoa = $conexao->qtdResultado($respessoa);
$qtdArrumado = 0;
if ($qtdpessoa > 0) {
    while ($pessoa = $conexao->resultadoArray($respessoa)) {
        $sql = "select codpessoa, codcategoria from pessoa where (REPLACE(REPLACE(cpf,'.',''),'-','') = '".str_replace(".", "", str_replace("-", "", $pessoa["cpf"]))."' or cpf = '{$pessoa["cpf"]}') and codpessoa <> '{$pessoa["codpessoa"]}' and codcategoria in(1,6)";
        $respessoa2 = $conexao->comando($sql); //verificando pessoas com cpfs repetidos
        $qtdPessoa2 = $conexao->qtdResultado($respessoa2);
        if ($qtdPessoa2 > 0) {
            while ($pessoa2 = $conexao->resultadoArray($respessoa2)) {
                if (isset($pessoa2["codpessoa"]) && $pessoa2["codpessoa"] != NULL && $pessoa2["codpessoa"] != "") {
                    if (($pessoa["codcategoria"] == 1 && $pessoa2["codcategoria"] != 1) || ($pessoa["codcategoria"] == 1 && $pessoa2["codcategoria"] == 1) || ($pessoa["codcategoria"] == 6 && $pessoa2["codcategoria"] == 6)) {
                        echo "O primeiro tem categoria 1<br>";
                        $sql = "update beneficiocliente set codpessoa = '{$pessoa["codpessoa"]}' where codpessoa = '{$pessoa2["codpessoa"]}'";
                        $conexao->comando($sql)or die("<pre>$sql</pre>");
                        $conexao->comando("update atendimento set codpessoa = '{$pessoa["codpessoa"]}' where codpessoa = '{$pessoa2["codpessoa"]}'");
                        $conexao->comando("update emprestimo set quitacao = saldo_aproximado, codpessoa = '{$pessoa["codpessoa"]}' where codpessoa = '{$pessoa2["codpessoa"]}'");
                        $conexao->comando("update telefone set codpessoa = '{$pessoa["codpessoa"]}' where codpessoa = '{$pessoa2["codpessoa"]}'");
                        $conexao->comando("update agenda set codpessoa = '{$pessoa["codpessoa"]}' where codpessoa = '{$pessoa2["codpessoa"]}'");
                        $conexao->comando("update observacaocliente set codpessoa = '{$pessoa["codpessoa"]}' where codpessoa = '{$pessoa2["codpessoa"]}'");
                        $conexao->comando("update observacaoligacao set codpessoa = '{$pessoa["codpessoa"]}' where codpessoa = '{$pessoa2["codpessoa"]}'");
                        //excluindo o repetido
                        $conexao->comando("delete from carteiracliente where codcliente = '{$pessoa2["codpessoa"]}'");
                        $sql = "delete from pessoa where codpessoa = '{$pessoa2["codpessoa"]}'";
                        $resExcluirPessoa = $conexao->comando($sql)or die("<pre>$sql</pre>");
                        if ($resExcluirPessoa != FALSE) {
                            echo "Apagado pessoa de código: {$pessoa2["codpessoa"]} e deixado pessoa de código: {$pessoa["codpessoa"]}";
                            $qtdArrumado++;
                        } else {
                            echo "Erro na pessoa causado por:" . mysqli_error($conexao->conexao);
                        }
                    } elseif ($pessoa["codcategoria"] != 1 && $pessoa2["codcategoria"] == 1) {
                        echo "O segundo tem categoria 1<br>";
                        $sql = "update beneficiocliente set codpessoa = '{$pessoa2["codpessoa"]}' where codpessoa = '{$pessoa["codpessoa"]}'";
                        $conexao->comando($sql)or die("<pre>$sql</pre>");
                        $conexao->comando("update atendimento set codpessoa = '{$pessoa2["codpessoa"]}' where codpessoa = '{$pessoa["codpessoa"]}'");
                        $conexao->comando("update emprestimo set codpessoa = '{$pessoa2["codpessoa"]}' where codpessoa = '{$pessoa["codpessoa"]}'");
                        $conexao->comando("update telefone set codpessoa = '{$pessoa2["codpessoa"]}' where codpessoa = '{$pessoa["codpessoa"]}'");
                        $conexao->comando("update agenda set codpessoa = '{$pessoa2["codpessoa"]}' where codpessoa = '{$pessoa["codpessoa"]}'");
                        $conexao->comando("update observacaocliente set codpessoa = '{$pessoa2["codpessoa"]}' where codpessoa = '{$pessoa["codpessoa"]}'");
                        $conexao->comando("update observacaoligacao set codpessoa = '{$pessoa2["codpessoa"]}' where codpessoa = '{$pessoa["codpessoa"]}'");
                        //excluindo o repetido
                        $conexao->comando("delete from carteiracliente where codcliente = '{$pessoa["codpessoa"]}'");
                        $sql = "delete from pessoa where codpessoa = '{$pessoa["codpessoa"]}'";
                        $resExcluirPessoa = $conexao->comando($sql);
                        if ($resExcluirPessoa != FALSE) {
                            echo "Apagado pessoa de código: {$pessoa2["codpessoa"]} e deixado pessoa de código: {$pessoa["codpessoa"]}<br>";
                            $qtdArrumado++;
                        } else {
                            echo "Erro na pessoa causado por:" . mysqli_error($conexao->conexao). "<br>";
                        }
                    } else {
                        echo "O primeiro tem categoria {$pessoa["codcategoria"]} e o segundo {$pessoa2["codcategoria"]}<br>";
                    }
                }
            }
        }
    }
}

echo 'Foram arrumados:', $qtdArrumado, ' clientes duplicados';

function Mask($mask, $str) {

    $str = str_replace(" ", "", $str);

    for ($i = 0; $i < strlen($str); $i++) {
        $mask[strpos($mask, "#")] = $str[$i];
    }

    return $mask;
}
