<?php
    session_start();
    //validação caso a sessão caia
    if(!isset($_SESSION)){
        die("<script>alert('Sua sessão caiu, por favor logue novamente!!!');window.close();</script>");
    }  
    include "../model/Conexao.php";
    include "../model/AchadoPerdido.php";
    $conexao = new Conexao();
    $achado  = new AchadoPerdido($conexao);
    
    $and     = "";
    if(isset($_POST["nome"])){
        $and .= " and achado.descricao like '%{$_POST["descricao"]}%'";
    }
    if(isset($_POST["codstatus"]) && $_POST["codstatus"] != NULL){
        $and .= " and achado.codstatus = '{$_POST["codstatus"]}'";
    }
    if(isset($_POST["codtipo"]) && $_POST["codtipo"] != NULL){
        $and .= " and achado.codtipo = '{$_POST["codtipo"]}'";
    }

    if(isset($_POST["data1"]) && $_POST["data1"] != NULL){
        $and .= " and achado.data >= '{$_POST["data1"]}'";
    }
    if(isset($_POST["data2"]) && $_POST["data2"] != NULL){
        $and .= " and achado.data <= '{$_POST["data2"]}'";
    }
    $sql = "select codachado, descricao, DATE_FORMAT(data, '%d/%m/%Y') as data2, pessoa.nome as quem_achou,
    achado.local, DATE_FORMAT(achado.horacadastro, '%H:%i') as hora_cadastro, entregue.nome as entregue, achado.entreguep,
    tipoachado.nome as tipo, entregue.codpessoa as codpessoaentregue
    from achado
    inner join tipoachado on tipoachado.codtipo = achado.codtipo and tipoachado.codempresa = achado.codempresa
    inner join pessoa on pessoa.codpessoa = achado.codpessoa and pessoa.codempresa = achado.codempresa
    left join pessoa as entregue on entregue.codpessoa = achado.codpessoaentregue and entregue.codempresa = achado.codempresa
    where 1 = 1
    and achado.codempresa = '{$_SESSION['codempresa']}' {$and} order by achado.data desc";
    $res = $conexao->comando($sql);
    $qtd = $conexao->qtdResultado($res);
    
    if($qtd > 0){
        echo 'Encontrou ',$qtd, ' resultados<br>';
        echo '<table class="responstable">';
        echo '<thead>';
        echo '<tr>';
        echo '<th style="width: 600px;">CONTROLE ACHADO</th>';
        echo '<th>Opções</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        while($achado = $conexao->resultadoArray($res)){
            echo '<tr>';
            echo '<td style="text-align: left;">';
            echo 'Dt:',$achado["data2"], ' às ', $achado["hora_cadastro"],' - Por:',$achado["quem_achou"], '<br>';
            echo 'Local:', $achado["local"], ' - ',$achado["tipo"],'<br>';
            echo 'Descrição:', $achado["descricao"] , '<br>';
            if(isset($achado["codpessoaentregue"]) && $achado["codpessoaentregue"] != NULL && $achado["codpessoaentregue"] != "" && $achado["codpessoaentregue"] > 0){
                echo 'Entregue:', $achado["entregue"], ' - ',trocaEntregue($achado["entreguep"]);
            }
            echo '</td>';
            echo '<td>';
            echo '<a href="Achado.php?codachado=',$achado["codachado"],'" title="Clique aqui para editar"><img src="../visao/recursos/img/editar.png" alt="botão editar"/></a>';
            echo '<a href="#" onclick="excluir2Achado(',$achado["codachado"],')" title="Clique aqui para excluir"><img src="../visao/recursos/img/excluir.png" alt="botão excluir"/></a>';
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
    $log->observacao = "Procurado achado - em ". date('d/m/Y'). " - ". date('H:i');
    $log->codpagina  = "0";
    $log->data = date('Y-m-d');
    $log->hora = date('H:i:s');
    $log->inserir();      
    
    function trocaEntregue($entregue){
        switch ($entregue) {
            case "m":
                $entregue = "morador";
                break;
            case "f":
                $entregue = "funcionário";
                break;
            case "":
                $entregue = "--";
                break;
        }
        return $entregue;
    }