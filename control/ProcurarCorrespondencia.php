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
    $order = "";
    if(isset($_POST["codmorador"]) && $_POST["codmorador"] != NULL && $_POST["codmorador"] != ""){
        $and .= " and morador.codpessoa = '{$_POST["codmorador"]}'";
    }
    if(isset($_POST["bloco"]) && $_POST["bloco"] != NULL && $_POST["bloco"] != ""){
        $and .= " and morador.bloco = '{$_POST["bloco"]}'";
    }
    if(isset($_POST["apartamento"]) && $_POST["apartamento"] != NULL && $_POST["apartamento"] != ""){
        $and .= " and morador.apartamento = '{$_POST["apartamento"]}'";
    }

    if(isset($_POST["codtipo"]) && $_POST["codtipo"] != NULL && $_POST["codtipo"] != ""){
        $and .= " and correspondencia.codtipo = '{$_POST["codtipo"]}'";
    }
    if(isset($_POST["codstatus"]) && $_POST["codstatus"] != NULL && $_POST["codstatus"] != ""){
        $and .= " and correspondencia.codstatus = '{$_POST["codstatus"]}'";
        if($_POST["codstatus"] == "1"){
            $order = ", correspondencia.data desc, correspondencia.hora0 desc";
        }elseif($_POST["codstatus"] == "2"){
            $order = ", correspondencia.dtentrega desc, correspondencia.hora desc";
        }        
    }
    if(isset($_POST["data1"]) && $_POST["data1"] != NULL && $_POST["data1"] != ""){
        $and .= " and correspondencia.data >= '{$_POST["data1"]}'";
    }
    if(isset($_POST["data2"]) && $_POST["data2"] != NULL && $_POST["data2"] != ""){
        $and .= " and correspondencia.data <= '{$_POST["data2"]}'";
    }
    $and .= " and correspondencia.codempresa = '{$_SESSION['codempresa']}'";    
    $sql = "select codcorrespondencia, DATE_FORMAT(correspondencia.data, '%d/%m/%y') as data2, DATE_FORMAT(correspondencia.hora, '%H:%i') as hora,
    DATE_FORMAT(correspondencia.dtentrega, '%d/%m/%y') as dtentrega2, DATE_FORMAT(correspondencia.hora0, '%H:%i') as hora0, correspondencia.chave,   
    correspondencia.remetente, morador.nome as morador, statuscorrespondencia.nome as status, morador.apartamento, morador.bloco, tipocorrespondencia.nome as tipo,
    funcionario.nome as funcionario, funcionario2.nome as funcionario2
    from correspondencia
    inner join pessoa as morador on morador.codpessoa = correspondencia.codmorador and morador.codempresa = correspondencia.codempresa
    inner join pessoa as funcionario on funcionario.codpessoa = correspondencia.codfuncionario and funcionario.codempresa = correspondencia.codempresa
    left join pessoa as funcionario2 on funcionario2.codpessoa = correspondencia.codfuncionariob and funcionario2.codempresa = correspondencia.codempresa
    inner join statuscorrespondencia on statuscorrespondencia.codstatus = correspondencia.codstatus
    inner join tipocorrespondencia on tipocorrespondencia.codtipo = correspondencia.codtipo and tipocorrespondencia.codempresa = correspondencia.codempresa
    where 1 = 1 {$and} order by correspondencia.codstatus {$order}";
    $res = $conexao->comando($sql) or die("<pre>$sql</pre>");
    $qtd = $conexao->qtdResultado($res);
    
    if($qtd > 0){
        echo 'Encontrou ', $qtd, ' resultados<br>';
        echo '<table class="responstable" style="text-align: left;">';
        echo '<thead>';
        echo '<tr>';
        echo '<th width="500">CONTROLE DE CORRESPONDÊNCIA</th>';
        echo '<th width="100">Opções</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        while($correspondencia = $conexao->resultadoArray($res)){
        
            echo '<tr>';
            echo '<td style="text-align: left;" width="500">';
            echo 'BL:',$correspondencia["bloco"],' - AP:', $correspondencia["apartamento"], ' - ', $correspondencia["morador"],'</br>';
            echo 'Remetente: ',$correspondencia["remetente"], '<br>';
            echo 'Correspondência: ',$correspondencia["tipo"], ' - ',$correspondencia["chave"],'<br>';
            echo 'Registro: ',$correspondencia["data2"], ' - ' ,$correspondencia["hora0"]  ,' - ', $correspondencia["funcionario"],'<br>';
            if(isset($correspondencia["dtentrega2"]) && $correspondencia["dtentrega2"] != NULL && $correspondencia["dtentrega2"] != "00/00/00"){
                echo ' Baixado: '.$correspondencia["dtentrega2"] ,' - ', $correspondencia["hora"] ,' - ', $correspondencia["funcionario2"] ,'<br>';
                $dtentrega = "sim";
            }else{
                $dtentrega = "";
            }   
            echo '</td>';
            echo '<td width="100">'; 
            if($dtentrega == ""){
                echo '<a href="#" onclick="entregar(',$correspondencia["codcorrespondencia"],')" ><img width="32" src="../visao/recursos/img/confirmar.png" alt="Entregar correspondência" title="Entregar correspondência"/></a>';
            }
            echo '<a href="Correspondencia.php?codcorrespondencia=',$correspondencia["codcorrespondencia"],'" title="Clique aqui para editar"><img src="../visao/recursos/img/editar.png" alt="botão editar"/></a>';
            echo '<a href="#" onclick="excluirCorrespondencia2(',$correspondencia["codcorrespondencia"],')" title="Clique aqui para excluir"><img src="../visao/recursos/img/excluir.png" alt="botão excluir"/></a>';
            echo '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    }else{
        echo "";
    }
    
    include "../model/Log.php";
    $log = new Log($conexao);
    $log->codpessoa  = $_SESSION['codpessoa'];
    $log->codempresa = $_SESSION['codempresa'];
    $log->acao       = "procurar";
    $log->observacao = "Procurado correspondência - em ". date('d/m/Y'). " - ". date('H:i');
    $log->codpagina  = "0";
    $log->data = date('Y-m-d');
    $log->hora = date('H:i:s');
    $log->inserir();         