<?php
    session_start();
        //validação caso a sessão caia
    if(!isset($_SESSION)){
        die("<script>alert('Sua sessão caiu, por favor logue novamente!!!');window.close();</script>");
    }  
    include "../model/Conexao.php";
    include "../model/Nivel.php";
    $conexao = new Conexao();
    $nivel   = new Nivel($conexao);
    
    $nivel->codempresa = $_SESSION['codempresa'];
    
    if(isset($_POST["naomaster"]) && $_POST["naomaster"] != NULL && $_POST["naomaster"] != ""){
        $res = $nivel->procuraNome2($_POST["nome"]);
    }else{
        $res = $nivel->procuraNome($_POST["nome"]);
    }
    
    $qtd = $conexao->qtdResultado($res);
    
    if($qtd > 0){
        echo 'Encontrou ', $qtd, ' resultados<br>';
        echo '<table class="responstable">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Código</th>';
        echo '<th>Nome</th>';
        echo '<th>Porcentagem</th>';
        echo '<th>Padrão</th>';
        echo '<th>Opções</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        while($nivel = $conexao->resultadoArray($res)){
            echo '<tr>';
            echo '<td>',$nivel["codnivel"],'</td>';
            echo '<td>',$nivel["nome"],'</td>';
            echo '<td>',  number_format($nivel["porcentagem"], 2, ",", "."),'</td>';
            echo '<td>',$nivel["padrao"],'</td>';
            echo '<td>';
            echo '<a href="Nivel.php?codnivel=',$nivel["codnivel"],'" title="Clique aqui para editar"><img src="../visao/recursos/img/editar.png" alt="botão editar"/></a>';
            echo '<a href="#" onclick="excluirNivel2(',$nivel["codnivel"],')" title="Clique aqui para excluir"><img src="../visao/recursos/img/excluir.png" alt="botão excluir"/></a>';
            echo '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    }else{
        echo '0';
    }

