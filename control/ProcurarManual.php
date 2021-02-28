<?php
    session_start();
        //validação caso a sessão caia
    if(!isset($_SESSION)){
        die("<script>alert('Sua sessão caiu, por favor logue novamente!!!');window.close();</script>");
    }  
    include "../model/Conexao.php";
    include "../model/Manual.php";
    $conexao = new Conexao();
    $manual  = new Manual($conexao);
    
    $and     = "";
    if(isset($_POST["nome"]) && $_POST["nome"] != NULL && $_POST["nome"] != ""){
        $and .= " and manual.nome like '%{$_POST["nome"]}%'";
    }
    if(isset($_POST["data"]) && $_POST["data"] != NULL){
        $and .= " and manual.dtcadastro >= '{$_POST["data"]}'";
    }
    if(isset($_POST["data2"]) && $_POST["data2"] != NULL){
        $and .= " and manual.dtcadastro <= '{$_POST["data2"]}'";
    }
    $sql = "select codmanual, manual.nome, DATE_FORMAT(manual.dtcadastro, '%d/%m/%Y') as dtcadastro2, manual.arquivo, banco.nome as banco
    from manual
    inner join banco on banco.codbanco = manual.codbanco
    where 1 = 1
    {$and} order by manual.dtcadastro desc";
    $res = $conexao->comando($sql);
    $qtd = $conexao->qtdResultado($res);
    
    if($qtd > 0){
        echo 'Encontrou ',$qtd, ' resultados<br>';
        echo '<table class="responstable">';
        echo '<thead>';
        echo '<tr>';
        echo '<th style="width: 600px;">CADASTRO MANUAL</th>';
        if($_SESSION["codnivel"] == 1){
        echo '<th>Opções</th>';
        }
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        while($manual = $conexao->resultadoArray($res)){
            echo '<tr>';
            echo '<td style="text-align: left;">';
            echo 'Nome:', $manual["nome"], 'Dt. Cadastro: ',$manual["dtcadastro2"],'<br>';
            echo 'Banco:', $manual["banco"], '<br>';
            if(isset($manual["arquivo"]) && $manual["arquivo"] != NULL && $manual["arquivo"] != ""){
                echo '<a href="../arquivos/',$manual["arquivo"],'" target="_blank">Download</a>';
            }
            echo '</td>';
            if($_SESSION["codnivel"] == 1){
            echo '<td>';
            echo '<a href="Manual.php?codmanual=',$manual["codmanual"],'" title="Clique aqui para editar"><img src="../visao/recursos/img/editar.png" alt="botão editar"/></a>';
            echo '<a href="#" onclick="excluir2Manual(',$manual["codmanual"],')" title="Clique aqui para excluir"><img src="../visao/recursos/img/excluir.png" alt="botão excluir"/></a>';
            echo '</td>';
            }
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
        $log->observacao = "Procurado manual - em ". date('d/m/Y'). " - ". date('H:i');
        $log->codpagina  = "0";
        $log->data = date('Y-m-d');
        $log->hora = date('H:i:s');
        $log->inserir();        
    