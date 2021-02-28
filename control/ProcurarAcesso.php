<?php
    session_start();
    //validação caso a sessão caia
    if(!isset($_SESSION)){
        die("<script>alert('Sua sessão caiu, por favor logue novamente!!!');window.close();</script>");
    }  
    date_default_timezone_set('America/Sao_Paulo');
    include "../model/Conexao.php";
    $conexao = new Conexao();
    $and     = "";
    
    if(isset($_POST["nome"]) && $_POST["nome"] != NULL && $_POST["nome"] != ""){
        $and .= " and pessoa.nome like '%{$_POST["nome"]}%'";
    }
    if(isset($_POST["codmorador"]) && $_POST["codmorador"] != NULL && $_POST["codmorador"] != ""){
        $and .= " and pessoa.codpessoa = '{$_POST["codmorador"]}'";
    }
    if(isset($_POST["bloco"]) && $_POST["bloco"] != NULL && $_POST["bloco"] != ""){
        $and .= " and pessoa.bloco = '{$_POST["bloco"]}'";
    }
    if(isset($_POST["apartamento"]) && $_POST["apartamento"] != NULL && $_POST["apartamento"] != ""){
        $and .= " and pessoa.apartamento = '{$_POST["apartamento"]}'";
    }

    if(isset($_POST["data1"]) && $_POST["data1"] != NULL && $_POST["data1"] != ""){
        $and .= " and acesso.data >= '{$_POST["data1"]}'";
    }
    if(isset($_POST["data2"]) && $_POST["data2"] != NULL && $_POST["data2"] != ""){
        $and .= " and acesso.data <= '{$_POST["data2"]}'";
    }

    $res = $conexao->comando("select codacesso, pessoa.nome, acesso.enderecoip, DATE_FORMAT(data, '%d/%m/%Y') as data2, acesso.quantidade 
        from acesso
        inner join pessoa on pessoa.codpessoa = acesso.codpessoa and pessoa.codempresa = acesso.codempresa
        where 1 = 1 {$and} 
        and acesso.codempresa = '{$_SESSION['codempresa']}'            
        order by acesso.data desc");
    $qtd = $conexao->qtdResultado($res);
    
    if($qtd > 0){
        echo 'Encontrou ', $qtd, ' resultados<br>';
        echo '<table class="responstable">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Data</th>';
        echo '<th>Nome</th>';
        echo '<th>Endereço IP</th>';
        echo '<th>Quantidade</th>';
        echo '<th>Excluir</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        while($acesso = $conexao->resultadoArray($res)){
            echo '<tr id="',$acesso["codacesso"],'">';
            echo '<td>',$acesso["data2"],'</td>';
            echo '<td>',$acesso["nome"],'</td>';
            echo '<td>',$acesso["enderecoip"],'</td>';
            echo '<td>',$acesso["quantidade"],'</td>';
            echo '<td><a href="#" onclick="excluir2(',$acesso["codacesso"],')" title="Clique aqui para excluir"><img src="../visao/recursos/img/excluir.png" alt="botão excluir"/></a></td>';
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
    $log->observacao = "Procurado acesso - em ". date('d/m/Y'). " - ". date('H:i');
    $log->codpagina  = "0";
    $log->data = date('Y-m-d');
    $log->hora = date('H:i:s');
    $log->inserir();  