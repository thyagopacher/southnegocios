<?php
    session_start();
    //validação caso a sessão caia
    if(!isset($_SESSION)){
        die("<script>alert('Sua sessão caiu, por favor logue novamente!!!');window.close();</script>");
    }  
    date_default_timezone_set('America/Sao_Paulo');
    include "../model/Conexao.php";
    $conexao = new Conexao();
    $and     = "";

    if(isset($_POST["codoperador"]) && $_POST["codoperador"] != NULL && $_POST["codoperador"] != ""){
        $and .= " and pessoa.codpessoa = '{$_POST["codoperador"]}'";
    }

    if(isset($_POST["data1"]) && $_POST["data1"] != NULL && $_POST["data1"] != ""){
        $and .= " and acesso.dtcadastro >= '{$_POST["data1"]}'";
    }
    if(isset($_POST["data2"]) && $_POST["data2"] != NULL && $_POST["data2"] != ""){
        $and .= " and acesso.dtcadastro <= '{$_POST["data2"]}'";
    }
    $sql = "select acesso.codacesso, pessoa.nome as operador, DATE_FORMAT(acesso.dtcadastro, '%d/%m/%Y') as dtcadastro2, carteira.nome as carteira, carteira.codcarteira, acesso.codoperador
        from acessooperador as acesso
        inner join pessoa on pessoa.codpessoa = acesso.codoperador and pessoa.codempresa = acesso.codempresa
        left join carteira on carteira.codcarteira = acesso.codcarteira and carteira.codempresa = acesso.codempresa
        where 1 = 1 {$and} 
        and acesso.codempresa = '{$_SESSION['codempresa']}'            
        order by acesso.dtcadastro desc"; 
    $res = $conexao->comando($sql)or die("<pre>$sql</pre>");
    $qtd = $conexao->qtdResultado($res);
    
    if($qtd > 0){
        echo 'Encontrou ', $qtd, ' resultados<br>';
        echo '<table class="responstable">';
        echo '<thead>';
        echo '<tr>';
        echo '<th style="text-align: left;">LIBERAÇÃO DE OPERADOR</th>';
        echo '<th>Opções</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        while($acesso = $conexao->resultadoArray($res)){
            echo '<tr>';
            echo '<td style="text-align: left;">';
            echo 'Dt. Cadastro:', $acesso["dtcadastro2"], ' - Operador:', $acesso["operador"], '<br>';
            echo 'Carteira:', $acesso["carteira"];
            echo '</td>';
            echo '<td>';
            $arrayJavascript = "new Array('{$acesso["codacesso"]}', '{$acesso["codcarteira"]}', '{$acesso["codoperador"]}')";
            echo '<a href="#" onclick="setaEditarAcessoOperador(',$arrayJavascript,')" title="Clique aqui para editar"><img src="../visao/recursos/img/editar.png" alt="botão editar"/></a>';
            echo '<a href="#" onclick="excluir2AcessoOperador(',$acesso["codacesso"],')" title="Clique aqui para excluir"><img src="../visao/recursos/img/excluir.png" alt="botão excluir"/></a>';
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
    $log->observacao = "Procurado acesso operador - em ". date('d/m/Y'). " - ". date('H:i');
    $log->codpagina  = "0";
    $log->data = date('Y-m-d');
    $log->hora = date('H:i:s');
    $log->inserir();  