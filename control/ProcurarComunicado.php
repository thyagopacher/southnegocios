<?php
    session_start();
        //validação caso a sessão caia
    if(!isset($_SESSION)){
        die("<script>alert('Sua sessão caiu, por favor logue novamente!!!');window.close();</script>");
    }  
    include "../model/Conexao.php";
    include "../model/Comunicado.php";
    $conexao = new Conexao();
    $comunicado  = new Comunicado($conexao);
    
    $and     = "";
    if(isset($_POST["nome"]) && $_POST["nome"] != NULL && $_POST["nome"] != ""){
        $and .= " and comunicado.nome like '%{$_POST["nome"]}%'";
    }
    if(isset($_POST["data"]) && $_POST["data"] != NULL){
        $and .= " and comunicado.dtcadastro >= '{$_POST["data"]}'";
    }
    if(isset($_POST["data2"]) && $_POST["data2"] != NULL){
        $and .= " and comunicado.dtcadastro <= '{$_POST["data2"]}'";
    }
    $sql = "select codcomunicado, comunicado.nome, DATE_FORMAT(comunicado.dtcadastro, '%d/%m/%Y') as dtcadastro2, comunicado.arquivo
    from comunicado
    where 1 = 1
    {$and} order by comunicado.dtcadastro desc";
    $res = $conexao->comando($sql);
    $qtd = $conexao->qtdResultado($res);
    
    if($qtd > 0){
        if(isset($_POST["nome"])){
            echo 'Encontrou ',$qtd, ' resultados<br>';
        }
        echo '<table class="responstable">';
        echo '<thead>';
        echo '<tr>';
        echo '<th style="width: 600px;">COMUNICADO</th>';
        if(isset($_POST["nome"])){
            echo '<th>Opções</th>';
        }
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        while($comunicado = $conexao->resultadoArray($res)){
            echo '<tr>';
            echo '<td style="text-align: left;">';
            echo 'Nome:', $comunicado["nome"], ' - Dt. Cadastro: ',$comunicado["dtcadastro2"],'<br>';
            if(isset($comunicado["arquivo"]) && $comunicado["arquivo"] != NULL && $comunicado["arquivo"] != ""){
                echo '<a href="../arquivos/',$comunicado["arquivo"],'" target="_blank">Download</a>';
            }
            echo '</td>';
            if(isset($_POST["nome"])){
                echo '<td>';
                echo '<a href="Comunicado.php?codcomunicado=',$comunicado["codcomunicado"],'" title="Clique aqui para editar"><img src="../visao/recursos/img/editar.png" alt="botão editar"/></a>';
                echo '<a href="#" onclick="excluir2Comunicado(',$comunicado["codcomunicado"],')" title="Clique aqui para excluir"><img src="../visao/recursos/img/excluir.png" alt="botão excluir"/></a>';
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
        $log->observacao = "Procurado comunicado - em ". date('d/m/Y'). " - ". date('H:i');
        $log->codpagina  = "0";
        $log->data = date('Y-m-d');
        $log->hora = date('H:i:s');
        $log->inserir();        
    