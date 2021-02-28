<?php
    header('Content-Type: text/html; charset=utf-8');
    session_start();
    include "../model/Conexao.php";
    include "../model/StatusAchado.php";
    
    $conexao = new Conexao();
    $status  = new StatusAchado($conexao);
    
    if(isset($_POST["nome"]) && $_POST["nome"] != NULL && $_POST["nome"] != ""){
        $res = $status->procuraNome($_POST["nome"]);
    }else{
        $res = $status->procuraNome("");
    }
    $qtd = $conexao->qtdResultado($res);
    
    if($qtd > 0){
        echo 'Encontrou ', $qtd, ' resultados<br>';
        echo '<table class="responstable">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Código</th>';
        echo '<th>Nome</th>';
        echo '<th>Editar</th>';
        echo '<th>Excluir</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        while($status = $conexao->resultadoArray($res)){
            echo '<tr>';
            echo '<td>',$status["codstatus"],'</td>';
            echo '<td>',$status["nome"],'</td>';
            $arrayJavascript = "new Array('{$status["codstatus"]}', '{$status["nome"]}', '{$status["padrao"]}')";
            echo '<td><a href="javascript:setaEditar(',$arrayJavascript,')" title="Clique aqui para editar"><img src="../visao/recursos/img/editar.png" alt="botão editar"/></a></td>';
            echo '<td><a href="#" onclick="excluir2(',$status["codstatus"],')" title="Clique aqui para excluir"><img src="../visao/recursos/img/excluir.png" alt="botão excluir"/></a></td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    }else{
        echo '0';
    }

