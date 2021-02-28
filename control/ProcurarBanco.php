<?php
    session_start();
        //validação caso a sessão caia
    if(!isset($_SESSION)){
        die("<script>alert('Sua sessão caiu, por favor logue novamente!!!');window.close();</script>");
    }  
    include "../model/Conexao.php";
    include "../model/Banco.php";
    $conexao = new Conexao();
    $banco  = new Banco($conexao);
    
    $and     = "";
    if(isset($_POST["nome"]) && $_POST["nome"] != NULL && $_POST["nome"] != ""){
        $and .= " and banco.nome like '%{$_POST["nome"]}%'";
    }
    if(isset($_POST["data1"]) && $_POST["data1"] != NULL){
        $and .= " and banco.dtcadastro >= '{$_POST["data1"]}'";
    }
    if(isset($_POST["data2"]) && $_POST["data2"] != NULL){
        $and .= " and banco.dtcadastro <= '{$_POST["data2"]}'";
    }
    $sql = "select codbanco, nome, DATE_FORMAT(dtcadastro, '%d/%m/%Y') as dtcadastro2, banco.site
    from banco
    where 1 = 1
    {$and} order by banco.dtcadastro desc";
    $res = $conexao->comando($sql);
    $qtd = $conexao->qtdResultado($res);
    
    if($qtd > 0){
        echo 'Encontrou ',$qtd, ' resultados<br>';
        echo '<table class="responstable">';
        echo '<thead>';
        echo '<tr>';
        echo '<th style="width: 600px;">CADASTRO BANCO</th>';
        echo '<th>Opções</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        while($banco = $conexao->resultadoArray($res)){
            echo '<tr>';
            echo '<td style="text-align: left;">';
            echo 'Nome:', $banco["nome"], 'Dt. Cadastro: ',$banco["dtcadastro2"],'<br>';
            if(isset($banco["site"]) && $banco["site"] != NULL && $banco["site"] != ""){
                echo 'Site: <a href="http://', str_replace("http://", "", $banco["site"]) , '">Site banco</a><br>';
            }
            echo '</td>';
            echo '<td>';
            echo '<a href="Banco.php?codbanco=',$banco["codbanco"],'" title="Clique aqui para editar"><img src="../visao/recursos/img/editar.png" alt="botão editar"/></a>';
            echo '<a href="#" onclick="excluir2Banco(',$banco["codbanco"],')" title="Clique aqui para excluir"><img src="../visao/recursos/img/excluir.png" alt="botão excluir"/></a>';
            echo '</td>';
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
        $log->observacao = "Procurado banco - em ". date('d/m/Y'). " - ". date('H:i');
        $log->codpagina  = "0";
        $log->data = date('Y-m-d');
        $log->hora = date('H:i:s');
        $log->inserir();        
    