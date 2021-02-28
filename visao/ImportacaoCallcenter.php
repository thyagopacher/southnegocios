<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
if (!isset($_SESSION["nome"])) {
    $retorno = "<script>alert('Não pode acessar funcionalidade sem estar logado!');</script>";
    $retorno .= "<script>location.href='/'</script>";
    die($retorno);
} else {
    include("../model/Conexao.php");
    $conexao = new Conexao();
    if (isset($_GET["codimportacao"])) {
        $importacao = $conexao->comandoArray("select * from importacao where codimportacao = '{$_GET["codimportacao"]}'");
    }
}
?>
<!DOCTYPE html>

<html lang="pt-br">
    <head>
        <?php include("head.php"); ?>     
        <title>South Negócios › Carteiras de Clientes</title>
    </head>
    <body>
        <?php
        include("cabecalho.php");
        include("menu.php");
        ?>
        <div id="barra_pos_cabecalho"></div>
        <h3>Carteiras de Clientes</h3>
         <div id="tabs" style="width: 955px; margin: 0 auto;  margin-top: 55px;">
            <ul>
                <li><a href="#tabs-1">Importação</a></li>
                <li><a href="#tabs-2">Procurar</a></li>
                <li><a href="#tabs-3">Liberar carteira</a></li>
                <li><a href="#tabs-4" title="Procurar acesso de operadores">Procurar acesso</a></li>
            </ul>
            <div id="tabs-1">
                <form name="fimportacao" autocomplete="off" id="fimportacao" method="post" action="../control/Importacao.php">
                    <input type="hidden" name="layout" id="layout" value="6"/>
                    <table class="tabela_formulario">
                        <tr>
                            <td>Observação</td>
                            <td>*Para uma carteira já existente só escolher o nome na listagem abaixo</td>
                            <td>*Criar nova carteira é só digitar nome diferente dos que tem abaixo</td>
                        </tr>
                        <tr>
                            <td title="digite aqui ou escolha nome de carteira de clientes">Carteira</td>
                            <td colspan="3">
                                <input style="width: 490px;" type="text" name="nome" id="nome" list="nomes" maxlength="50" value=""/>
                                <datalist id="nomes"><!--para listar nomes dinamicamente no input de nome-->
                                <?php
                                    $resnomes = $conexao->comando("select distinct nome from carteira where codempresa = '{$_SESSION['codempresa']}' order by nome");
                                    $qtdnomes = $conexao->qtdResultado($resnomes);
                                    if($qtdnomes > 0){
                                        while($nome = $conexao->resultadoArray($resnomes)){
                                            echo '<option>',$nome["nome"],'</option>';
                                        }
                                    }
                                ?>                                    
                                </datalist>
                            </td>
                        </tr>
                        
                        <tr>
                            <td style="width: 50px;">Arquivo</td>
                            <td style="width: 250px;"><input type="file" name="arquivo" required title="Escolha arquivo de importação aqui"/></td>                       
                        </tr> 
                        <tr>
                            <td></td>
                            <td>Atualizar cliente se o mesmo já existir<input type="checkbox" name="atualizar_cliente" id="atualizar_cliente" value="s"/></td>
                            <td>Adicionar na carteira mesmo se o cliente já existir<input type="checkbox" name="adicionar_carteira" id="adicionar_carteira" value="s"/></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Atualizar somente telefones!<input type="checkbox" name="somente_telefone" id="somente_telefone" value="s"/></td>
                        </tr>
                        <tr>
                            <td><input type="submit" name="submit" value="Enviar" title="Clique aqui para enviar importacao ao cliente"/></td>
                        </tr>
                    </table>
                </form>
                <br>**Planilha xls formatar data em padrão americano (ano - mês - dia)
                <br>
                <a href="../arquivos/layout_de_importacao_29_06_2015.xls" target="_blank" title="Download do arquivo de importação padrão">
                    <img style="width: 30px;" src="../visao/recursos/img/download.png" alt="Download"/>
                    Arquivo de importação padrão
                </a>
                <br>
                <div class="progress">
                    <div class="bar"></div>
                    <div class="percent">0%</div>
                </div>

                <div id="status"></div>                
            </div>
            <div id="tabs-2"><?php include("formProcurarImportacao.php");?></div>
            <div id="tabs-3"><?php include("formLiberarCarteira.php");?></div>
            <div id="tabs-4"><?php include("./formProcurarAcessoOperador.php");?></div>
            <span style="float: right; color: grey;width: 100%;text-align: right;">
                @ South Negócios
            </span>               
        </div>
        <?php include "includeChat.php";?>

<script type="text/javascript" src="/visao/recursos/js/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="/visao/recursos/js/jquery-ui.min.js"></script>          
        <script src="/visao/recursos/js/jquery.form.js"></script>  
        <script src="../visao/recursos/js/jquery.maskedinput.min.js"></script>
        <script src="../visao/recursos/js/Geral.js"></script>      
        <script src="../visao/recursos/js/ajax/Importacao.js"></script>      
        <script src="../visao/recursos/js/ajax/AcessoOperador.js"></script>      
        
        <script type="text/javascript" src="./recursos/js/sweet-alert.min.js"></script>
        <script type="text/javascript" src="./recursos/js/tinybox.min.js"></script>
        <script type="text/javascript" src="./recursos/js/modernizr-2.5.3.min.js"></script>
        <script src="/visao/recursos/js/chat.js"></script>            
        <?php
    $nivel_popup = $conexao->comandoArray("SELECT * FROM `nivelpagina` WHERE `codpagina` = 81 and inserir = 1");
    if(isset($nivel_popup["inserir"]) && $nivel_popup["inserir"] == 1){
        echo '<script src="/visao/recursos/js/ajax/Frase.js" type="text/javascript"></script>';
        echo '<script>visualizaPopup();</script>';
    }
?>      