<?php
    include "../model/Conexao.php";
    include "../model/Modulo.php";
    $conexao = new Conexao();
    $modulo  = new Modulo($conexao);

    if(isset($_POST["nome"])){
        $res = $modulo->procuraNome($_POST["nome"]);
    }else{
        $res = $modulo->procuraNome("");
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
        while($modulo = $conexao->resultadoArray($res)){
            echo '<tr>';
            echo '<td>',$modulo["codmodulo"],'</td>';
            echo '<td>',$modulo["nome"],'</td>';
            $arrayJavascript = "new Array('{$modulo["codmodulo"]}', '{$modulo["nome"]}', '{$modulo["titulo"]}')";
            echo '<td><a href="javascript:setaEditarModulo(',$arrayJavascript,')" title="Clique aqui para editar"><img src="../visao/recursos/img/editar.png" alt="botão editar"/></a></td>';
            echo '<td><a href="#" onclick="excluirModulo2(',$modulo["codmodulo"],')" title="Clique aqui para excluir"><img src="../visao/recursos/img/excluir.png" alt="botão excluir"/></a></td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    }else{
        echo '0';
    }

