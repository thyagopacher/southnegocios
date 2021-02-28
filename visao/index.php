<?php     
    session_start();
    header ('Content-type: text/html; charset=UTF-8');
    ini_set("zlib.output_compression", "On");
    if(!isset($_SESSION["nome"]) || $_SESSION["nome"] == NULL || $_SESSION["nome"] == ""){
        $retorno = "<script>alert('Não pode acessar funcionalidade sem estar logado!');</script>";
        $retorno .= "<script>location.href='Login.php'</script>";
        die($retorno);
    }else{
        include("../model/Conexao.php");
        $conexao = new Conexao();
    }
    ?> 
<!DOCTYPE html> 
<html lang="pt" xml:lang="pt">
    <head>
        
        <?php include("./head.php");?>       
        
        <title>South Negócios › Home</title>
        <style>
            .notificacao{
                background: white;
                width: 100%;
                margin: 0 auto;
                padding: 0px;
                position: absolute;
                overflow-x: hidden;
                height: auto;
                margin-top: 50px;
            }
            .notificacao li a{
                color: black;
            }
            .notificacao li{
                list-style: initial;
                padding-top: 5px;
                padding-bottom: 5px;
            }
            .tbox{
                left: 25% !important;
                right: 25% !important;
            }
        </style>
    </head> 
    <body>
        <?php
        include("cabecalho.php");
        ?>
        <div role="main" class="main container">
            <div class="row-fluid">
                
        <?php  
        
        include("menu.php");
        echo '<div id="barra_pos_cabecalho"></div>';
        echo '<div class="notificacao">';
        echo '<div class="botao_inicial">';
        echo '<a href="javascript: procurarComunicadoInicial();"><img src="/visao/recursos/img/comunicados.png"/>COMUNICADOS</a>';
        echo '<a href=""><img src="/visao/recursos/img/comissoes.png"/>COMISSÕES</a>';
//        echo '<a href=""><img src="/visao/recursos/img/informativos.png"/>INFORMATIVOS</a>';
        echo '<a href="javascript: procurarLinkInicial();"><img src="/visao/recursos/img/link.png"/>LINK</a>';
        echo '<a href="javascript: procurarManualInicial()"><img src="/visao/recursos/img/roteiros.png"/>ROTEIROS</a>';
        echo '</div>';

        echo '<div class="esteira_propostas">';
        echo '<h2>Esteira de Propostas</h2>';
        if($_SESSION["codnivel"] != "1" && $_SESSION["codnivel"] != 18){
            $and = " and proposta.codfuncionario = '{$_SESSION['codpessoa']}'";
        }
        $sql = "select proposta.codproposta, proposta.nome, DATE_FORMAT(proposta.dtcadastro, '%d/%m/%Y') as dtcadastro2, 
        funcionario.nome as funcionario, cliente.nome as cliente, cliente.cpf, proposta.vlsolicitado, convenio.nome as convenio, proposta.codbanco, proposta.codconvenio, 
        proposta.codtabela, proposta.prazo, banco.nome as banco, tabela.nome as tabela, status.nome as status, proposta.codstatus, proposta.codcliente, categoria.codcategoria, status.cor,
        empresa.razao as filial, DATE_FORMAT(proposta.dtvenda, '%d/%m/%Y') as dtvenda2, proposta.pendente
        from proposta
        inner join pessoa as funcionario on funcionario.codpessoa = proposta.codfuncionario
        inner join pessoa as cliente on cliente.codpessoa = proposta.codcliente
        inner join categoriapessoa as categoria on categoria.codcategoria = cliente.codcategoria
        inner join convenio on convenio.codconvenio = proposta.codconvenio
        inner join banco on banco.codbanco = proposta.codbanco
        inner join tabela on tabela.codtabela = proposta.codtabela
        inner join statusproposta as status on status.codstatus = proposta.codstatus
        inner join empresa on empresa.codempresa = proposta.codempresa
        where 1 = 1 {$and}";
 
        $resproposta = $conexao->comando($sql);
        $qtdproposta = $conexao->qtdResultado($resproposta); 
        if($qtdproposta > 0){
            echo '<table style="font-size: 10px;">';
            echo '<thead>';
            echo '<tr>';
            echo '<th style="width: 80px;">Data</th>';
            echo '<th style="width: 240px;">Cliente</th>';
            echo '<th style="width: 140px;">Banco</th>';
            echo '<th style="width: 140px;">Tabela</th>';
            echo '<th style="width: 150px;">Operador</th>';
            echo '<th style="width: 140px;">Situação</th>';
            echo '<th style="width: 50px;">Status</th>';            
            echo '<th style="width: 50px;">Filial</th>';
            echo '<th style="width: 80px;">Opções</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            $estilo1 = "background: #DBDBDB";
            $estilo2 = "background: white";
            $estilo_Aplicado = $estilo1;
            while($proposta = $conexao->resultadoArray($resproposta)){
                if(($proposta["codstatus"] == '22' && $proposta["pendente"] == "n")){
                    continue;
                }
                $sql = "select observacao, codproposta 
                from observacaoproposta as obs
                where obs.codempresa = '{$_SESSION['codempresa']}' 
                and obs.codcliente = '{$proposta["codcliente"]}' 
                and obs.observacao <> '' and obs.codstatus = '7' 
                and (obs.codproposta = '{$proposta["codproposta"]}' or obs.codproposta = 0)
                order by codobservacao desc";
                $observacao = $conexao->comandoArray($sql);
                echo '<tr class="',$proposta["cor"],'" style="',$estilo_Aplicado,'">';
                if(isset($proposta["dtvenda2"]) && trim($proposta["dtvenda2"]) != "00/00/0000"){
                    echo '<td>', $proposta["dtvenda2"], '</td>';
                }else{
                    echo '<td>--</td>';
                }
                echo '<td>', $proposta["cliente"], '</td>';
                echo '<td>', $proposta["banco"], '</td>';
                echo '<td>', $proposta["tabela"], '</td>';
                echo '<td>', $proposta["funcionario"], '</td>';
                echo '<td>', trocaPendente($proposta["pendente"]), '</td>';
                echo '<td title="',$observacao["observacao"],'">', $proposta["status"], '</td>';
                echo '<td>', $proposta["filial"], '</td>';
                echo '<td>';
                if(isset($proposta["codcategoria"]) && $proposta["codcategoria"] == "6"){
                    $complementoCaminho = "&callcenter=true";
                }else{
                    $complementoCaminho = "";
                }
                echo '<a href="/visao/Cliente.php?codpessoa=',$proposta["codcliente"],$complementoCaminho,'"><img style="width: 25px;" src="../visao/recursos/img/editar.png" alt="bt editar"/></a>';
                echo '<a href="#" onclick="excluir2Proposta(', $proposta["codproposta"], ')" title="Clique aqui para excluir"><img style="width: 25px;" src="../visao/recursos/img/excluir.png" alt="botão excluir"/></a>';
                echo '<a href="#" onclick="procurarObservacaoProposta(', $proposta["codproposta"], ',', $proposta["codcliente"], ')" title="Clique aqui para abrir as observações a proposta"><img style="width: 25px;" src="../visao/recursos/img/livro2.png" alt="botão excluir"/></a>';
                echo '</td>';
                echo '</tr>';
                if($estilo_Aplicado == $estilo1){
                    $estilo_Aplicado = $estilo2;
                }else{
                    $estilo_Aplicado = $estilo1;
                }
            }
            echo '</tbody>';
            echo '</table>';
        }
        echo '</div>';
        
        echo '<table style="width: 60%;margin: 0 auto;margin-top: 10px;" class="responstable">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Titulo</th>';
        echo '<th>Quantidade</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';        
        if($_SESSION["codnivel"] == 1){
            echo '<tr><td><a href="../control/BackupBancoSistema.php" target="_blank" class="botao">Backup banco de dados</a></td><td></td></tr>';
            $qtdCliente = $conexao->comandoArray("select count(1) as qtd from pessoa where codempresa = '{$_SESSION['codempresa']}' and codcategoria = 1");
            if(isset($qtdCliente["qtd"]) && $qtdCliente["qtd"] > 0){
                echo "<tr><td>Clientes na loja</td><td>{$qtdCliente["qtd"]}</td></tr>";
            }
            $qtdCliente = $conexao->comandoArray("select count(1) as qtd from pessoa where codempresa = '{$_SESSION['codempresa']}' and codcategoria = 6");
            if(isset($qtdCliente["qtd"]) && $qtdCliente["qtd"] > 0){
                echo "<tr><td>Callcenter na loja</td><td>{$qtdCliente["qtd"]}</td></tr>";
            }            
            $qtdBaixa = $conexao->comandoArray("select count(1) as qtd from baixa 
            where codempresa = '{$_SESSION['codempresa']}' 
            and dtcadastro >= '".date('Y-m-d')." 00:00:00'
            and dtcadastro <= '".date('Y-m-d')." 23:59:59'");
            if(isset($qtdCliente["qtd"]) && $qtdCliente["qtd"] > 0){
                echo "<tr><td>Qtd de baixas hoje</td><td>{$qtdBaixa["qtd"]}</td></tr>";
            }            
            $qtdProposta = $conexao->comandoArray("select count(1) as qtd from proposta 
            where codempresa = '{$_SESSION['codempresa']}' 
            and dtcadastro >= '".date('Y-m-d')." 00:00:00'
            and dtcadastro <= '".date('Y-m-d')." 23:59:59'");
            if(isset($qtdCliente["qtd"]) && $qtdCliente["qtd"] > 0){
                echo "<tr><td>Qtd de propostas hoje</td><td>{$qtdProposta["qtd"]}</td></tr>";
            }            
            $sql = "select count(DISTINCT(acesso.codpessoa)) as qtd from acesso 
            where data >= '".date('Y-m-d')."'
            and data <= '".date('Y-m-d')."'";
            $qtdAcesso = $conexao->comandoArray($sql);
            if(isset($qtdCliente["qtd"]) && $qtdCliente["qtd"] > 0){
                echo "<tr><td>Qtd de acessos(totas as empresas) hoje</td><td>{$qtdAcesso["qtd"]}</td></tr>";
            }            
            
            $sql = "select count(DISTINCT(acesso.codpessoa)) as qtd from acesso 
            where data >= '".date('Y-m-d')."'
            and acesso.codpessoa in(select codpessoa from pessoa where codnivel <> '1')    
            and data <= '".date('Y-m-d')."'";
            $qtdAcesso = $conexao->comandoArray($sql);
            if(isset($qtdCliente["qtd"]) && $qtdCliente["qtd"] > 0){
                echo "<tr><td>Qtd de acessos(só func.) hoje</td><td>{$qtdAcesso["qtd"]}</td></tr>";
            }        
        }
        echo '</tbody>';
        echo '</table>';
        echo '</div>';   
        ?>
               
        </div>
        </div>
        <?php include "./includeChat.php";?>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script type="text/javascript" src="/visao/recursos/js/Geral.js"></script>
        <script type="text/javascript" src="/visao/recursos/js/chat.js"></script>
        <script type="text/javascript" src="/visao/recursos/js/ajax/Proposta.js"></script>
        <script type="text/javascript" src="/visao/recursos/js/ajax/Comunicado.js"></script>
        <script type="text/javascript" src="/visao/recursos/js/ajax/Manual.js"></script>
        <script type="text/javascript" src="/visao/recursos/js/ajax/Link.js"></script>
        <script>
            var textoPiscante = $( '.textoPiscante' );

            window.setInterval( function() {
                textoPiscante.css( 'visibility', 'hidden' );

                window.setTimeout( function() {
                    textoPiscante.css( 'visibility', 'visible' );
                }, 150 );
            }, 1 * 1000 );        
        </script>
    </body>
</html>

<?php

    function trocaPendente($situacao){
        switch ($situacao) {
            case "s":
                $situacao = '<span class="textoPiscante" style="color: red;">PENDENTE</span>';
                break;
            case "n":
                $situacao = 'LIBERADO';
                break;
        }
        return $situacao;
    }