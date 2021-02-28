<?php
    session_start();
        //validação caso a sessão caia
    if(!isset($_SESSION)){
        die("<script>alert('Sua sessão caiu, por favor logue novamente!!!');window.close();</script>");
    }  
    include "../model/Conexao.php";
    include "../model/Correspondencia.php";
    $conexao = new Conexao();
    
    $and = "";
    if(isset($_POST["codmorador"]) && $_POST["codmorador"] != NULL && $_POST["codmorador"] != ""){
        $and .= " and pessoa.codpessoa = '{$_POST["codmorador"]}'";
    }
    if(isset($_POST["bloco"]) && $_POST["bloco"] != NULL && $_POST["bloco"] != ""){
        $and .= " and pessoa.bloco = '{$_POST["bloco"]}'";
    }
    if(isset($_POST["apartamento"]) && $_POST["apartamento"] != NULL && $_POST["apartamento"] != ""){
        $and .= " and pessoa.apartamento = '{$_POST["apartamento"]}'";
    }

    if(isset($_POST["codtipo"]) && $_POST["codtipo"] != NULL && $_POST["codtipo"] != ""){
        $and .= " and correspondencia.codtipo = '{$_POST["codtipo"]}'";
    }
    if(isset($_POST["codstatus"]) && $_POST["codstatus"] != NULL && $_POST["codstatus"] != ""){
        $and .= " and correspondencia.codstatus = '{$_POST["codstatus"]}'";
    }
    if(isset($_POST["data1"]) && $_POST["data1"] != NULL && $_POST["data1"] != ""){
        $and .= " and correspondencia.data >= '{$_POST["data1"]}'";
    }
    if(isset($_POST["data2"]) && $_POST["data2"] != NULL && $_POST["data2"] != ""){
        $and .= " and correspondencia.data <= '{$_POST["data2"]}'";
    }
    if(isset($_POST["codempresa"]) && $_POST["codempresa"] != NULL && $_POST["codempresa"] != ""){
        $and .= " and correspondencia.codempresa = '{$_POST["codempresa"]}'";
    }else{
        $and .= " and correspondencia.codempresa = '{$_SESSION['codempresa']}'";
    }      
    $sql = "select codcorrespondencia, DATE_FORMAT(correspondencia.data, '%d/%m/%Y') as data2, correspondencia.remetente, 
        morador.nome as morador, statuscorrespondencia.nome as status, morador.apartamento, morador.bloco, funcionario.nome as funcionario, correspondencia.hora
    from correspondencia
    inner join pessoa as morador on morador.codpessoa = correspondencia.codmorador and morador.codempresa = correspondencia.codempresa
    inner join pessoa as funcionario on funcionario.codpessoa = correspondencia.codmorador and funcionario.codempresa = correspondencia.codempresa
    inner join statuscorrespondencia on statuscorrespondencia.codstatus = correspondencia.codstatus 
    where 1 = 1 {$and}";

    $res = $conexao->comando($sql)or die("<pre>$sql</pre>");
    $qtd = $conexao->qtdResultado($res);
    
    if($qtd > 0){
        $nome  = "Rel. Correspondências";
        $html  = "";
        $html .= '<table class="responstable">';
        $html .= '<thead>';
        $html .= '<tr>';
        $html .= '<th width="100" style="padding: 5px">Data</th>';
        $html .= '<th width="30" style="padding: 5px">Hora</th>';
        $html .= '<th width="200" style="padding: 5px">Morador</th>';
        $html .= '<th width="30" style="padding: 5px">Bloco</th>';
        $html .= '<th width="30" style="padding: 5px">Apto</th>';
        $html .= '<th style="padding: 5px">Remetente</th>';
        $html .= '<th width="100" style="padding: 5px">Status</th>';
        $html .= '<th width="200" style="padding: 5px">Funcionário</th>';
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
        while($correspondencia = $conexao->resultadoArray($res)){
            $html .= '<tr>';
            $html .= '<td width="100" style="padding: 5px">'.$correspondencia["data2"].'</td>';
            $html .= '<td width="30" style="padding: 5px">'.$correspondencia["hora"].'</td>';
            $html .= '<td width="200" style="padding: 5px">'.trim($correspondencia["morador"]).'</td>';
            $html .= '<td width="30" style="padding: 5px">'.$correspondencia["bloco"].'</td>';
            $html .= '<td width="30" style="padding: 5px">'.$correspondencia["apartamento"].'</td>';
            $html .= '<td style="padding: 5px">'.$correspondencia["remetente"].'</td>';
            $html .= '<td width="100" style="padding: 5px">'.$correspondencia["status"].'</td>';
            $html .= '<td width="200" style="padding: 5px">'.$correspondencia["funcionario"].'</td>';
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
        echo "0";
    }