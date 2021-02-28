<?php
    session_start();
        //validação caso a sessão caia
    if(!isset($_SESSION)){
        die("<script>alert('Sua sessão caiu, por favor logue novamente!!!');window.close();</script>");
    }  
    include "../model/Conexao.php";
    include "../model/Conteudo.php";
    $conexao = new Conexao();
    
    $and = "";
    $order = "";
 
    if(isset($_POST["texto"]) && $_POST["texto"] != NULL && $_POST["texto"] != ""){
        $and .= " and conteudo.texto like '%{$_POST["texto"]}%'";
    }
    if(isset($_POST["nome"]) && $_POST["nome"] != NULL && $_POST["nome"] != ""){
        $and .= " and conteudo.nome like '%{$_POST["nome"]}%'";
    }
    if(isset($_POST["data1"]) && $_POST["data1"] != NULL && $_POST["data1"] != ""){
        $and .= " and conteudo.data >= '{$_POST["data1"]}'";
    }
    if(isset($_POST["data2"]) && $_POST["data2"] != NULL && $_POST["data2"] != ""){
        $and .= " and conteudo.data <= '{$_POST["data2"]}'";
    }
    $sql = "select codconteudo, DATE_FORMAT(conteudo.dtcadastro, '%d/%m/%y %H:%i') as dtcadastro2, 
    conteudo.nome, funcionario.nome as funcionario
    from conteudo
    inner join pessoa as funcionario on funcionario.codpessoa = conteudo.codpessoa
    where 1 = 1 {$and} order by conteudo.nome";
    $res = $conexao->comando($sql) or die("<pre>$sql</pre>");
    $qtd = $conexao->qtdResultado($res);
    
    if($qtd > 0){
        echo 'Encontrou ', $qtd, ' resultados<br>';
        echo '<table class="responstable" style="text-align: left;">';
        echo '<thead>';
        echo '<tr>';
        echo '<th width="500">CONTROLE DE CONTEÚDO</th>';
        echo '<th width="100">Opções</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        while($conteudo = $conexao->resultadoArray($res)){
        
            echo '<tr>';
            echo '<td style="text-align: left;" width="500">';
            echo 'Nome:',$conteudo["nome"],'</br>';
            echo 'Registro: ',$conteudo["dtcadastro2"], ' - ' , $conteudo["funcionario"],'<br>';  
            echo '</td>';
            echo '<td width="100">'; 
            echo '<a href="Conteudo.php?codconteudo=',$conteudo["codconteudo"],'" title="Clique aqui para editar"><img src="../visao/recursos/img/editar.png" alt="botão editar"/></a>';
            echo '<a href="#" onclick="excluir2(',$conteudo["codconteudo"],')" title="Clique aqui para excluir"><img src="../visao/recursos/img/excluir.png" alt="botão excluir"/></a>';
            echo '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    }else{
        echo "";
    }

    include "../model/Log.php";
    $log = new Log($conexao);
    $log->codpessoa  = $_SESSION['codpessoa'];
    $log->codempresa = $_SESSION['codempresa'];
    $log->acao       = "procurar";
    $log->observacao = "Procurado conteudo - em ". date('d/m/Y'). " - ". date('H:i');
    $log->codpagina  = "0";
    $log->data = date('Y-m-d');
    $log->hora = date('H:i:s');
    $log->inserir();         