<?php
    include "../model/Conexao.php";
    include "../model/Pagina.php";
    $conexao = new Conexao();
    $pagina  = new Pagina($conexao);

    if(isset($_POST["nome"])){
        $res = $pagina->procuraNome($_POST["nome"]);
    }else{
        $res = $pagina->procuraNome("");
    }
    $qtd = $conexao->qtdResultado($res);
    
    if($qtd > 0){
        echo 'Encontrou ', $qtd, ' resultados<br>';
        echo '<table class="responstable">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Código</th>';
        echo '<th>Nome</th>';
        echo '<th>Link</th>';
        echo '<th>Título</th>';
        echo '<th>Opções</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        while($pagina = $conexao->resultadoArray($res)){
            echo '<tr>';
            echo '<td>',$pagina["codpagina"],'</td>';
            echo '<td>',$pagina["nome"],'</td>';
            echo '<td><a href="../visao/',$pagina["link"],'" title="Clique aqui para ver a funcionalidade">',$pagina["link"],'</a></td>';
            echo '<td>',$pagina["titulo"],'</td>';
            $arrayJavascript = "new Array('{$pagina["codpagina"]}', '{$pagina["nome"]}', '{$pagina["titulo"]}', '{$pagina["link"]}', '{$pagina["codmodulo"]}')";
            echo '<td>';
            echo '<a href="javascript:setaEditarPagina(',$arrayJavascript,')" title="Clique aqui para editar"><img src="../visao/recursos/img/editar.png" alt="botão editar"/></a>';
            echo '<a href="#" onclick="excluir2(',$pagina["codpagina"],')" title="Clique aqui para excluir"><img src="../visao/recursos/img/excluir.png" alt="botão excluir"/></a>';
            echo '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    }else{
        echo '0';
    }

