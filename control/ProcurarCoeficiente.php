<?php
    session_start();
        //validação caso a sessão caia
    if(!isset($_SESSION)){
        die("<script>alert('Sua sessão caiu, por favor logue novamente!!!');window.close();</script>");
    }  
    include "../model/Conexao.php";
    
    $conexao = new Conexao();
    if(isset($_POST["data1"]) && $_POST["data1"] != NULL && $_POST["data1"] != ""){
        if(strpos($_POST["data1"], "/")){
            $data1 = implode("-",array_reverse(explode("/", $_POST["data1"])));
            $and .= " and coeficiente.dtcadastro >= '{$data1}'";
        }else{
            $and .= " and coeficiente.dtcadastro >= '{$_POST["data1"]}'";
        }          
    }
    if(isset($_POST["data2"]) && $_POST["data2"] != NULL && $_POST["data2"] != ""){
        if(strpos($_POST["data2"], "/")){
            $data2 = implode("-",array_reverse(explode("/", $_POST["data2"])));
            $and .= " and coeficiente.dtcadastro <= '{$data2}'";
        }else{
            $and .= " and coeficiente.dtcadastro <= '{$_POST["data2"]}'";
        } 
    }
    $res = $conexao->comando("select codcoeficiente, DATE_FORMAT(dtcadastro, '%d/%m/%Y') as dtcadastro2, valor from coeficiente where 1 = 1 {$and}");
    $qtd = $conexao->qtdResultado($res);
    
    if($qtd > 0){
        echo 'Encontrou ', $qtd, ' resultados<br>';
        echo '<table class="responstable">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Dt Cadastro</th>';
        echo '<th>Valor</th>';
        echo '<th>Opções</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        while($coeficiente = $conexao->resultadoArray($res)){
            echo '<tr>';
            echo '<td>',$coeficiente["dtcadastro2"],'</td>';
            echo '<td>',  $coeficiente["valor"],'</td>';
            echo '<td>';
            echo '<a href="Coeficiente.php?codcoeficiente=',$coeficiente["codcoeficiente"],'" title="Clique aqui para editar"><img src="../visao/recursos/img/editar.png" alt="botão editar"/></a>';
            echo '<a href="#" onclick="excluir2Coeficiente(',$coeficiente["codcoeficiente"],')" title="Clique aqui para excluir"><img src="../visao/recursos/img/excluir.png" alt="botão excluir"/></a>';
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
    $log->observacao = "Procurado coeficiente - em ". date('d/m/Y'). " - ". date('H:i');
    $log->codpagina  = "0";
    $log->data = date('Y-m-d');
    $log->hora = date('H:i:s');
    $log->inserir();  