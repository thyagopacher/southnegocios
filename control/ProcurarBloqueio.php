<?php
    session_start();
        //validação caso a sessão caia
    if(!isset($_SESSION)){
        die("<script>alert('Sua sessão caiu, por favor logue novamente!!!');window.close();</script>");
    }  
    include "../model/Conexao.php";   
    $conexao = new Conexao();
    
    $and     = "";
    if(isset($_POST["enderecoip"])){
        $and .= " and bloqueio.enderecoip like '%{$_POST["enderecoip"]}%'";
    }
    if(isset($_POST["data1"]) && $_POST["data1"] != NULL){
        $and .= " and bloqueio.data >= '{$_POST["data1"]}'";
    }
    if(isset($_POST["data2"]) && $_POST["data2"] != NULL){
        $and .= " and bloqueio.data <= '{$_POST["data2"]}'";
    }

    if(isset($_POST["codempresa"]) && $_POST["codempresa"] != NULL && $_POST["codempresa"] != ""){
        $and .= " and bloqueio.codempresa = '{$_POST["codempresa"]}'";
    }else{
        $and .= " and bloqueio.codempresa = '{$_SESSION['codempresa']}'";
    }

    $res = $conexao->comando("select codbloqueio, enderecoip, DATE_FORMAT(data, '%d/%m/%Y') as data2, codfuncionario, pessoa.nome as funcionario
    from bloqueio
    inner join pessoa on pessoa.codpessoa = bloqueio.codfuncionario and pessoa.codempresa = bloqueio.codempresa
    where 1 = 1 {$and}");
    $qtd = $conexao->qtdResultado($res);
    
    if($qtd > 0){
        echo '<table class="responstable">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Endereço IP</th>';
        echo '<th>Data</th>';
        echo '<th>Funcionário</th>';
        echo '<th>Editar</th>';
        echo '<th>Excluir</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        while($bloqueio = $conexao->resultadoArray($res)){
            echo '<tr>';
            echo '<td>',$bloqueio["enderecoip"],'</td>';
            echo '<td>',$bloqueio["data2"],'</td>';
            echo '<td>',$bloqueio["funcionario"],'</td>';
            echo '<td><a href="Bloqueio.php?codbloqueio=',$bloqueio["codbloqueio"],'" title="Clique aqui para editar"><img src="../visao/recursos/img/editar.png" alt="botão editar"/></a></td>';
            echo '<td><a href="#" onclick="excluir2(',$bloqueio["codbloqueio"],')" title="Clique aqui para excluir"><img src="../visao/recursos/img/excluir.png" alt="botão excluir"/></a></td>';
            echo '</tr>'; 
        }
        echo '</tbody>';
        echo '</table>';
    }else{
        echo '';
    }
    

    include "../model/Log.php";
    $log = new Log($conexao);
    $log->codpessoa  = $_SESSION['codpessoa'];
    $log->codempresa = $_SESSION['codempresa'];
    $log->acao       = "procurar";
    $log->observacao = "Procurado bloqueio - em ". date('d/m/Y'). " - ". date('H:i');
    $log->codpagina  = "0";
    $log->data = date('Y-m-d');
    $log->hora = date('H:i:s');
    $log->inserir();        