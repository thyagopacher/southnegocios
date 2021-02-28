<?php
    session_start();
    //validação caso a sessão caia
    if(!isset($_SESSION)){
        die("<script>alert('Sua sessão caiu, por favor logue novamente!!!');window.close();</script>");
    }      
    include "../model/Conexao.php";
    include "../model/AchadoPerdido.php";
    $conexao = new Conexao();
    $achado  = new AchadoPerdido($conexao);
    
    $and     = "";
    if(isset($_POST["nome"])){
        $and .= " and achado.descricao like '%{$_POST["descricao"]}%'";
    }
    if(isset($_POST["codstatus"]) && $_POST["codstatus"] != NULL){
        $and .= " and achado.codstatus = '{$_POST["codstatus"]}'";
    }
    if(isset($_POST["codtipo"]) && $_POST["codtipo"] != NULL){
        $and .= " and achado.codtipo = '{$_POST["codtipo"]}'";
    }    
    if(isset($_POST["data1"]) && $_POST["data1"] != NULL){
        $and .= " and achado.data >= '{$_POST["data1"]}'";
    }
    if(isset($_POST["data2"]) && $_POST["data2"] != NULL){
        $and .= " and achado.data <= '{$_POST["data2"]}'";
    }

    $res = $conexao->comando("select codachado, descricao, DATE_FORMAT(data, '%d/%m/%Y') as data2, pessoa.nome as quem_achou, achado.imagem
    from achado
    inner join pessoa on pessoa.codpessoa = achado.codpessoa and pessoa.codempresa = achado.codempresa
    where 1 = 1
    and achado.codempresa = '{$_SESSION['codempresa']}' {$and}");
    $qtd = $conexao->qtdResultado($res);
    
    if($qtd > 0){
        $html  = "";
        $nome  = 'Rel. Achado';
        $html .= '<table class="responstable">';
        $html .= '<thead>';
        $html .= '<tr>';
        $html .= '<th>Data</th>';
        $html .= '<th>Por quem</th>';
        $html .= '<th>Descrição</th>';
        $html .= '<th>Imagem</th>';
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
        while($achado = $conexao->resultadoArray($res)){
            $html .= '<tr>';
            $html .= '<td>'.$achado["data2"].'</td>';
            $html .= '<td>'.$achado["quem_achou"].'</td>';
            $html .= '<td>'.$achado["descricao"].'</td>';
            $html .= '<td><img width="50" src="../arquivos/'.$achado["imagem"].'" alt="Imagem achados e perdidos"/></td>';
            $html .= '</tr>';
        }
        $html .= '</tbody>'; 
        $html .= '</table>';

        $_POST["html"] = $html;
        $paisagem = "sim";        
        
        if(isset($_POST["tipo"]) && $_POST["tipo"] == "xls"){
            include "./GeraExcel.php";
        }else{
            include "./GeraPdf.php";
        }     
    }else{
        echo '<script>alert("Sem achados e perdidos encontrado!");window.close();</script>';
    }