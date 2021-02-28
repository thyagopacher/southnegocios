<?php
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
        $and .= " and classificado.titulo like '%{$_POST["nome"]}%'";
    }
    if(isset($_POST["ehMorador"]) && $_POST["ehMorador"] != NULL && $_POST["ehMorador"] != ""){
        $and .= " and classificado.ehMorador = '{$_POST["ehMorador"]}'";
        if($_POST["ehMorador"] == "s"){
            if(isset($_POST["apartamento"]) && $_POST["apartamento"] != NULL && $_POST["apartamento"] != ""){
                $and .= " and pessoa.apartamento = '{$_POST["apartamento"]}'";
            }
            if(isset($_POST["bloco"]) && $_POST["bloco"] != NULL && $_POST["bloco"] != ""){
                $and .= " and pessoa.bloco = '{$_POST["bloco"]}'";
            }
            if(isset($_POST["codmorador"]) && $_POST["codmorador"] != NULL && $_POST["codmorador"] != ""){
                $and .= " and pessoa.codpessoa = '{$_POST["codmorador"]}'";
            }
        }
        $and .= " and classificado.codempresa = '{$_SESSION['codempresa']}'";
    }else{
         $and .= " and (classificado.ehMorador is null or classificado.ehMorador = '')";
    }
    if(isset($_POST["data"]) && $_POST["data"] != NULL){
        $and .= " and classificado.data >= '{$_POST["data"]}'";
    }
    if(isset($_POST["data2"]) && $_POST["data2"] != NULL){
        $and .= " and classificado.data <= '{$_POST["data2"]}'";
    }
  
    $sql = "select codclassificado, titulo, data, DATE_FORMAT(data, '%d/%m/%Y') as data2, pessoa.nome as funcionario, 
        pessoa.codpessoa, classificado.valor, classificado.ehMorador, pessoa.apartamento, pessoa.bloco, classificado.codfornecedor
        from classificado
        inner join pessoa on pessoa.codpessoa = classificado.codpessoa
        where 1 = 1 {$and}"; 
    $res = $conexao->comando($sql);
    if($res != FALSE){
        $qtd = $conexao->qtdResultado($res);

        if($qtd > 0){
            echo '<table class="responstable">';
            echo '<thead>';
            echo '<tr>';
            if($_POST["ehMorador"] == "s"){
                echo '<th>CLASSIFICADO - MORADOR</th>';
            }else{
                echo '<th>CLASSIFICADO - FORNECEDOR</th>';
            }
            echo '<th>Opções</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            while($classificado = $conexao->resultadoArray($res)){
                if(isset($classificado["valor"]) && $classificado["valor"] != NULL && $classificado["valor"] != "" && $classificado["valor"] > 0){
                    $valorClassificado = ' R$ '. number_format($classificado["valor"], 2, ",", ".");
                }else{
                    $valorClassificado = 'A combinar';
                }                
                echo '<tr>';
                echo '<td style="text-align: left;">';
                echo 'Titulo:',$classificado["titulo"], ' - ', $valorClassificado, '<br>';
                echo 'Por:', $classificado["funcionario"], ' - ', $classificado["data2"], '<br>';
                if($_POST["ehMorador"] == "s"){
                    echo 'BL:', $classificado["bloco"], ' - Apto:', $classificado["apartamento"];
                }elseif(isset($classificado["codfornecedor"]) && $classificado["codfornecedor"] != NULL && $classificado["codfornecedor"] != ""){
                    $fornecedor = $conexao->comandoArray("select razao, telefone from empresa where codempresa = '{$classificado["codfornecedor"]}' and codramo <> '7'");
                    echo 'Fornecedor:', $fornecedor["razao"], ' - Telefone: ',$fornecedor["telefone"],'<br>';
                }
                echo '</td>';
                echo '<td>';
                echo '<a href="Classificado.php?codclassificado=',$classificado["codclassificado"],'" title="Clique aqui para editar"><img src="../visao/recursos/img/editar.png" alt="botão editar"/></a>';
                echo '<a href="#" onclick="excluir2(',$classificado["codclassificado"],')" title="Clique aqui para excluir"><img src="../visao/recursos/img/excluir.png" alt="botão excluir"/></a>';
                echo '</td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
        }else{
            echo '0';
        }
    }else{
        echo '0';
    }
    

    include "../model/Log.php";
    $log = new Log($conexao);
    $log->codpessoa  = $_SESSION['codpessoa'];
    $log->codempresa = $_SESSION['codempresa'];
    $log->acao       = "procurar";
    $log->observacao = "Procurado classificados - em ". date('d/m/Y'). " - ". date('H:i');
    $log->codpagina  = "0";
    $log->data = date('Y-m-d');
    $log->hora = date('H:i:s');
    $log->inserir();         