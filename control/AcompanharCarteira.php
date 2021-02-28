<?php
     header ('Content-type: text/html; charset=UTF-8'); 
     session_start();
    //validação caso a sessão caia
    if(!isset($_SESSION)){
        die(json_encode(array('mensagem' => 'Sua sessão caiu, por favor logue novamente!!!', 'situacao' => false)));
    }        
    include "../model/Conexao.php";
    $conexao = new Conexao();
    if($_SESSION["codnivel"] != "1"){
        $and = " and carteira.codempresa = '{$_SESSION['codempresa']}'";
    }
    if(isset($_POST["filial"]) && $_POST["filial"] != NULL && $_POST["filial"] != ""){
        $and = " and carteira.codempresa = '{$_POST["filial"]}'";
    }
    $rescarteira = $conexao->comando('select * from carteira where 1 = 1 '.$and.' order by carteira.nome');
    $qtdcarteira = $conexao->qtdResultado($rescarteira);
    
    if($qtdcarteira > 0){
        echo '<table style="font-family: arial;width: 100%;font-size: 15px !important;">';
        echo '<tr style="background-color: red; color: white;font-weight: bolder;"><td>Carteira</td><td>Filial</td><td>N° Agentes Liberados</td>';
        echo '<td>';
        echo '<table style="color: white;  width: 100%;">';
        echo '<tr><td colspan="3" style="text-align: center;">Clientes da Carteira</td></tr>';
        echo '<tr>';
        echo '<td style="width: 33.3%">Total</td>';
        echo '<td style="width: 33.3%">Atendidos</td>';
        echo '<td style="width: 33.3%">Pendentes</td>';
        echo '</tr>';
        echo '</table>';
        echo '</td>';
        echo '</tr>';
        $cor1 = "background-color: #f7de7b;";
        $cor2 = "background-color: #FFFFED;";
        $cor_aplicada = $cor1;
        $qtdTotalOperadorLiberado = 0;
        $qtdTotalCarteiraFinal = 0;
        $qtdTotalCarteiraAtendidoFinal = 0;
        $qtdTotalPendentes = 0;
        while($carteira = $conexao->resultadoArray($rescarteira)){
            $qtdPendentes = 0;
            echo '<tr style="',$cor_aplicada,'">';
            echo '<td>',$carteira["nome"],'</td>';
            $filial = $conexao->comandoArray("select razao from empresa where codempresa = '{$carteira["codempresa"]}'");
            echo '<td>',$filial["razao"],'</td>';
            $sql = "select count(distinct(acessooperador.codoperador)) as qtd from acessooperador where codempresa = '{$carteira["codempresa"]}' and codcarteira = '{$carteira["codcarteira"]}'";
            $qtdOperadorLiberado = $conexao->comandoArray($sql);
            $qtdTotalOperadorLiberado += $qtdOperadorLiberado["qtd"];
            echo '<td style="text-align: center;">',$qtdOperadorLiberado["qtd"],'</td>';
            
            echo '<td>';
            echo '<table style="width: 100%;">';
            echo '<tr>';
            $sql = "select count(1) as qtd 
            from pessoa 
            inner join importacao on importacao.codimportacao = pessoa.codimportacao and importacao.codempresa = pessoa.codempresa
            inner join carteira on carteira.codcarteira = importacao.codcarteira and carteira.codempresa = pessoa.codempresa
            where pessoa.codempresa = '{$carteira["codempresa"]}' and carteira.codcarteira = '{$carteira["codcarteira"]}'";
            $qtdTotalCarteira = $conexao->comandoArray($sql);
            $qtdTotalCarteiraFinal += $qtdTotalCarteira["qtd"];
            echo '<td style="text-align: left; width: 33.3%">',$qtdTotalCarteira["qtd"],'</td>';
            
            $qtdTotalCarteiraAtendido = $conexao->comandoArray("select count(distinct(pessoa.codpessoa)) as qtd 
            from pessoa 
            inner join importacao on importacao.codimportacao = pessoa.codimportacao and importacao.codempresa = pessoa.codempresa
            inner join carteira on carteira.codcarteira = importacao.codcarteira and carteira.codempresa = pessoa.codempresa
            inner join atendimento on atendimento.codpessoa = pessoa.codpessoa and atendimento.codempresa = pessoa.codempresa
            where pessoa.codempresa = '{$carteira["codempresa"]}' and carteira.codcarteira = '{$carteira["codcarteira"]}'");            
            echo '<td style="text-align: left; width: 33.3%">',$qtdTotalCarteiraAtendido["qtd"],'</td>';
            
            $qtdTotalCarteiraAtendidoFinal += $qtdTotalCarteiraAtendido["qtd"];
            $qtdPendentes = $qtdTotalCarteira["qtd"] - $qtdTotalCarteiraAtendido["qtd"];
            $qtdTotalPendentes += $qtdPendentes;
            echo '<td style="text-align: left; width: 33.3%">',$qtdPendentes,'</td>';
            echo '</tr>';
            echo '</table>';
            echo '</td>';
            echo '</tr>';
            
            if($cor_aplicada != null && $cor_aplicada != "" && $cor_aplicada == $cor1){
                $cor_aplicada = $cor2;
            }else{
                $cor_aplicada = $cor1;
            }
        }
        echo '<tr>';
        echo '<td>TODAS AS CARTEIRAS</td>';
        echo '<td></td>';
        echo '<td>',$qtdTotalOperadorLiberado,'</td>';
        echo '<td>';
        echo '<table style="width: 100%;">';
        echo '<tr>';        
        echo '<td>',$qtdTotalCarteiraFinal,'</td>';
        echo '<td>',$qtdTotalCarteiraAtendidoFinal,'</td>';
        echo '<td>',$qtdTotalPendentes,'</td>';
        echo '</tr>';
        echo '</table>';
        echo '</td>';        
        echo '</tr>';
        echo '</table>';
    }
    include "../model/Log.php";
    $log = new Log($conexao);
    $log->codpessoa  = $_SESSION['codpessoa'];
    $log->codempresa = $_SESSION['codempresa'];
    $log->acao       = "procurar";
    $log->observacao = "Aberto acompanhar carteira - em ". date('d/m/Y'). " - ". date('H:i');
    $log->codpagina  = "0";
    $log->data = date('Y-m-d');
    $log->hora = date('H:i:s');
    $log->inserir();      