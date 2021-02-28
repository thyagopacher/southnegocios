<?php
    header ('Content-type: text/html; charset=UTF-8');
    session_start();
        //validação caso a sessão caia
    if(!isset($_SESSION)){
        die("<script>alert('Sua sessão caiu, por favor logue novamente!!!');window.close();</script>");
    }  
    include "../model/Conexao.php";
    include "../model/Classificado.php";
    
    $conexao = new Conexao();
    $classificado = new Classificado($conexao);
    $and     = "";
    if(isset($_POST["nome"])){
        $and .= " and titulo like '%{$_POST["nome"]}%'";
    }
    if(isset($_POST["data"]) && $_POST["data"] != NULL){
        $and .= " and data >= '{$_POST["data"]}'";
    }
    if(isset($_POST["data2"]) && $_POST["data2"] != NULL){
        $and .= " and data <= '{$_POST["data2"]}'";
    }
    if(isset($_POST["codempresa"]) && $_POST["codempresa"] != NULL && $_POST["codempresa"] != ""){
        $and .= " and classificado.codempresa = '{$_POST["codempresa"]}'";
    }else{
        $and .= " and classificado.codempresa = '{$_SESSION['codempresa']}'";
    }       
    $sql = "select codclassificado, titulo, data, DATE_FORMAT(data, '%d/%m/%Y') as data2, pessoa.nome as funcionario, pessoa.codpessoa, classificado.valor
        from classificado
        inner join pessoa on pessoa.codpessoa = classificado.codpessoa and pessoa.codempresa = classificado.codempresa
        where 1 = 1 {$and}";
      
    $res = $conexao->comando($sql);
    if($res != FALSE){
        $qtd = $conexao->qtdResultado($res);
        if($qtd > 0){
            $html  = '<table class="responstable">';
            $html .= '<thead>';
            $html .= '<tr>';
            $html .= '<th>Nome</th>';
            $html .= '<th>Data</th>';
            $html .= '<th>Responsável</th>';
            $html .= '<th>Valor</th>';
            if (isset($_POST["tipo"]) && $_POST["tipo"] == "xls") {
                $rescampo = $conexao->comando("select * from campoextra where codpagina = '{$_POST["codpagina"]}' and codempresa = '{$_SESSION['codempresa']}'");
                $qtdcampo = $conexao->qtdResultado($rescampo);
                if ($qtdcampo > 0) {
                    while ($campo = $conexao->resultadoArray($rescampo)) {
                        $html .= '<th>' . $campo["titulo"] . '</th>';
                    }
                }
            }            
            $html .= '</tr>';
            $html .= '</thead>';
            $html .= '<tbody>';
            while($classificado = $conexao->resultadoArray($res)){
                $html .= '<tr>';
                $html .= '<td>'.$classificado["titulo"].'</td>';
                $html .= '<td>'.$classificado["data2"].'</td>';
                $html .= '<td><a href="Pessoa.php?codpessoa='.$classificado["codpessoa"].'" title="Clique para visualizar ficha da pessoa">'.$classificado["funcionario"].'</a></td>';
                $html .= '<td> R$ '.number_format($classificado["valor"], 2, ",", ".").'</td>';
                $html .= '</tr>';
            }
            $html .= '</tbody>';
            $html .= '</table>';
            $_POST["html"] = $html;
            $paisagem = "sim";
            $nome = "Relatório de Classificados";

            if(isset($_POST["tipo"]) && $_POST["tipo"] == "xls"){
                include "./GeraExcel.php";
            }else{
                include "./GeraPdf.php";
            }            
        }
    }else{
        echo '';
    }