<?php
    session_start();
        //validação caso a sessão caia
    if(!isset($_SESSION)){
        die("<script>alert('Sua sessão caiu, por favor logue novamente!!!');window.close();</script>");
    }  
    include "../model/Conexao.php";
    include "../model/Conteudo.php";
    $conexao = new Conexao();
    
    $and = "";
    $order = "";
 
    if(isset($_POST["texto"]) && $_POST["texto"] != NULL && $_POST["texto"] != ""){
        $and .= " and conteudo.texto like '%{$_POST["texto"]}%'";
    }
    if(isset($_POST["nome"]) && $_POST["nome"] != NULL && $_POST["nome"] != ""){
        $and .= " and conteudo.nome like '%{$_POST["nome"]}%'";
    }
    if(isset($_POST["data1"]) && $_POST["data1"] != NULL && $_POST["data1"] != ""){
        $and .= " and conteudo.data >= '{$_POST["data1"]}'";
    }
    if(isset($_POST["data2"]) && $_POST["data2"] != NULL && $_POST["data2"] != ""){
        $and .= " and conteudo.data <= '{$_POST["data2"]}'";
    }
    $sql = "select codconteudo, DATE_FORMAT(conteudo.dtcadastro, '%d/%m/%y %H:%i') as dtcadastro2, 
    conteudo.nome, funcionario.nome as funcionario
    from conteudo
    inner join pessoa as funcionario on funcionario.codpessoa = conteudo.codpessoa
    where 1 = 1 {$and} order by conteudo.nome";
    $res = $conexao->comando($sql) or die("<pre>$sql</pre>");
    $qtd = $conexao->qtdResultado($res);
    
    if($qtd > 0){
        $nome  = "Relatório de Conteúdo";
        $html .= '<table class="responstable" style="text-align: left;">';
        $html .= '<thead>';
        $html .= '<tr>';
        $html .= '<th>Nome</th>';
        $html .= '<th>Dt. Cadastro</th>';
        $html .= '<th>Por</th>';
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
        while($conteudo = $conexao->resultadoArray($res)){
        
            $html .= '<tr>';
            $html .= '<td>'.$conteudo["nome"].'</td>';
            $html .= '<td>'.$conteudo["dtcadastro2"].'</td>';  
            $html .= '<td>'.$conteudo["funcionario"].'</td>';
            $html .= '</tr>';
        }
        $html .= '</tbody>';
        $html .= '</table>';
        
        $_POST["html"] = $html;
        $paisagem = "sim";   
        //echo $html;
        
        if(isset($_POST["tipo"]) && $_POST["tipo"] == "xls"){
            include "./GeraExcel.php";
        }else{
            include "./GeraPdf.php";
        }           
    }else{
        echo "";
    }