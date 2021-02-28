<?php
    session_start();
        //validação caso a sessão caia
    if(!isset($_SESSION)){
        die("<script>alert('Sua sessão caiu, por favor logue novamente!!!');window.close();</script>");
    }  
    include "../model/Conexao.php";   
    $conexao = new Conexao();
    
    $and     = "";
    if(isset($_POST["nome"])){
        $and .= " and conta.nome like '%{$_POST["nome"]}%'";
    }
    if(isset($_POST["data"]) && $_POST["data"] != NULL){
        $data = implode("-",array_reverse(explode("/",$_POST["data"])));
        $and .= " and conta.data >= '{$data}'";
    }
    if(isset($_POST["data2"]) && $_POST["data2"] != NULL){
        $data2 = implode("-",array_reverse(explode("/",$_POST["data2"])));
        $and  .= " and conta.data <= '{$data2}'";
    }
    if(isset($_POST["movimentacao"]) && $_POST["movimentacao"] != NULL && $_POST["movimentacao"] != ""){
        $and .= " and conta.movimentacao = '{$_POST["movimentacao"]}'";
    }
    if(isset($_POST["codtipo"]) && $_POST["codtipo"] != NULL && $_POST["codtipo"] != ""){
        $and .= " and conta.codtipo = '{$_POST["codtipo"]}'";
    }
    if(isset($_POST['valor']) && $_POST['valor'] != NULL && $_POST['valor'] != ""){
        $and .= " and conta.valor = '{$_POST['valor']}'";
    }
    if(isset($_POST["codstatus"]) && $_POST["codstatus"] != NULL && $_POST["codstatus"] != ""){
        $and .= " and conta.codstatus = '{$_POST["codstatus"]}'";
    }
    if(isset($_POST["codempresa"]) && $_POST["codempresa"] != NULL && $_POST["codempresa"] != ""){
        $and .= " and conta.codempresa = '{$_POST["codempresa"]}'";
    }elseif(!isset($_POST["master"]) || $_POST["master"] == NULL || $_POST["master"] == ""){
        $and .= " and conta.codempresa = '{$_SESSION['codempresa']}'";
    }
    if(isset($_POST["rateio"]) && $_POST["rateio"] != NULL && $_POST["rateio"] == "s"){
        $and .= " and conta.codambiente > 0";
        $link = "Rateio.php";
    }else{
        $link = "Conta.php";
    }
    if(isset($_POST["ordem"]) && $_POST["ordem"] != NULL && $_POST["ordem"] != ""){
        if($_POST["ordem"] == 1){
            $orderBy = "order by codconta desc";
        }elseif($_POST["ordem"] == 2){
            $orderBy = "order by conta.nome desc";
        }
    }
    
    $sql = "select conta.codconta, conta.nome, conta.valor, DATE_FORMAT(conta.data, '%d/%m/%Y') as data2, DATE_FORMAT(conta.dtpagamento, '%d/%m/%Y') as dtpagamento2,
    DATE_FORMAT(conta.dtcadastro, '%d/%m/%Y') as dtcadastro2, funcionario.nome as funcionario, conta.data, empresa.razao as empresa, tipo.nome as tipo
    from conta 
    inner join pessoa as funcionario on funcionario.codpessoa = conta.codfuncionario
    inner join empresa on empresa.codempresa = conta.codempresa
    inner join tipoconta as tipo on tipo.codtipo = conta.codtipo and tipo.codempresa = tipo.codempresa 
    where 1 = 1 {$and} $orderBy";
    $res = $conexao->comando($sql);
    $qtd = $conexao->qtdResultado($res);
    $totalConta = 0.0;
    if($qtd > 0){
        echo 'Encontrou ', $qtd, ' resultados<br>';
        echo '<table class="responstable">';
        echo '<thead>';
        echo '<tr>';
        echo '<th style="width: 700px;">CONTROLE DE CONTAS</th>';
        echo '<th>Opções</th>';
        echo '</tr>';  
        echo '</thead>';
        echo '<tbody>';
        while($conta = $conexao->resultadoArray($res)){
            if(isset($conta["codstatus"]) && $conta["codstatus"] == 2){
                if(strtotime(date($conta["data"])) < strtotime(date('Y-m-d'))){
                    $estiloLinha = "color: red;";
                }
            }
            echo '<tr style="',$estiloLinha,'">';
            echo '<td style="text-align: left;">';
            echo 'Dt. Cadastro:', $conta["dtcadastro2"]. ' - Por:', $conta["funcionario"], '<br>';
            echo 'Nome:', $conta["nome"], '- R$ ', number_format($conta["valor"], 2, ",", "."), '<br>';
            echo 'Vencimento:', $conta["data2"] ,' - Centro de Custo:',$conta["empresa"], '<br>';
            echo 'Tipo:', $conta["tipo"].'<br>';
            if(isset($conta["dtpagamento2"]) && $conta["dtpagamento2"] != "00/00/0000"){
                echo 'Dt. Pagamento:', $conta["dtpagamento2"].'<br>';
            }
            $sql = "select * from arquivoconta where codconta = '{$conta["codconta"]}'";
            $resarquivo = $conexao->comando($sql);
            $qtdarquivo = $conexao->qtdResultado($resarquivo);
            if($qtdarquivo > 0){
                $linhaArquivo = 1;
                echo '<ul>';
                echo 'Encontrou ',$qtdarquivo, ' arquivos para baixar';
                while($arquivo = $conexao->resultadoArray($resarquivo)){
                    echo '<li style="list-style-type: initial;">';
                    echo '<a target="_blank" href="../arquivos/',$arquivo["link"],'" title="Clique aqui para baixar arquivo">Arquivo ',$linhaArquivo,'</a>';
                    echo '</li>';
                    $linhaArquivo++;
                }
                echo '</ul>';
            }            
            $totalConta += $conta["valor"];
            echo '</td>';
            echo '<td>';
            echo '<a href="',$link,'?codconta=',$conta["codconta"],'&master=',$_POST["master"],'" title="Clique aqui para editar"><img src="../visao/recursos/img/editar.png" alt="botão editar"/></a>';
            echo '<a href="#" onclick="excluir2Conta(',$conta["codconta"],')" title="Clique aqui para excluir"><img src="../visao/recursos/img/excluir.png" alt="botão excluir"/></a>';
            echo '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '<tfoot>';
        echo '<tr>';
        echo '<td>Total</td>';
        echo '<td>',  number_format($totalConta, 2, ",", "."),'</td>';
        echo '</tr>';
        echo '</tfoot>';        
        echo '</table>';
    }else{
        echo '';
    }
    

    include "../model/Log.php";
    $log = new Log($conexao);
    $log->codpessoa  = $_SESSION['codpessoa'];
    $log->codempresa = $_SESSION['codempresa'];
    $log->acao       = "procurar";
    $log->observacao = "Procurado conta - em ". date('d/m/Y'). " - ". date('H:i');
    $log->codpagina  = "0";
    $log->data = date('Y-m-d');
    $log->hora = date('H:i:s');
    $log->inserir();         