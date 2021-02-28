<?php
session_cache_expire(3600);
header('Content-Type: text/html; charset=utf-8');
session_start();
if (!isset($_SESSION["nome"])) {
        $retorno = "<script>alert('Não pode acessar funcionalidade sem estar logado!');</script>";
        $retorno .= "<script>location.href='/'</script>";
        die($retorno);
} else {
    include("../model/Conexao.php");
    $conexao = new Conexao();
    $nivelp = $conexao->comandoArray("select * from nivelpagina where codnivel = '{$_SESSION["codnivel"]}' and codpagina = '29'");
}
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <?php include("head.php");?>     
        <link rel="stylesheet" href="./recursos/css/jquery-ui.min.css">
        <title>South Negócios › Extrator de dados</title>
        <script type="text/javascript" src="./recursos/js/tinymce/tinymce.min.js"></script>
        <script type="text/javascript" src="./recursos/js/Editor.js"></script>              
    </head>
    <body>
        <?php
        include("cabecalho.php");
        include("menu.php");
        ?>
        <div id="barra_pos_cabecalho"></div>
        <h3><?= $titulo ?></h3>
         <div id="tabs" style="width: 955px; margin: 0 auto;  margin-top: 55px;">
            <ul>
                <li><a href="#tabs-1">Relatório</a></li>
            </ul>
            <div id="tabs-1">
                <form target="_blank" action="../control/Extrator.php" method="post">
                    <table class="tabela_formulario">
                        <tr>
                            <td>Tabela</td>
                            <td>
                                <select name="tabela" id="tabela">
                                    <?php
                                    $resTabelaExtrator = $conexao->comando("show tables");
                                    $qtd = $conexao->qtdResultado($resTabelaExtrator);
                                    if($qtd > 0){
                                        echo '<option value="">--Selecione--</option>';
                                        while($tabela = $conexao->resultadoArray($resTabelaExtrator)){
                                            if($tabela["Tables_in_u580800546_siste"] == "ajuda" || $tabela["Tables_in_u580800546_siste"] == "smtp" || $tabela["Tables_in_u580800546_siste"] == "advertencia"  || strpos($tabela["Tables_in_u580800546_siste"], "status") !== FALSE || strpos($tabela["Tables_in_u580800546_siste"], "categoria") !== FALSE
                                                     || strpos($tabela["Tables_in_u580800546_siste"], "erro") !== FALSE || strpos($tabela["Tables_in_u580800546_siste"], "upload") !== FALSE || $tabela["Tables_in_u580800546_siste"] == "consumoluz"
                                                     || $tabela["Tables_in_u580800546_siste"] == "nivelpagina" || $tabela["Tables_in_u580800546_siste"] == "valorcampo" || $tabela["Tables_in_u580800546_siste"] == "campoextra" || $tabela["Tables_in_u580800546_siste"] == "arquivo"
                                                     || $tabela["Tables_in_u580800546_siste"] == "pagina"  || $tabela["Tables_in_u580800546_siste"] == "paginamorador"  || $tabela["Tables_in_u580800546_siste"] == "achado"
                                                     || $tabela["Tables_in_u580800546_siste"] == "atestado"  || $tabela["Tables_in_u580800546_siste"] == "comunicado"  || $tabela["Tables_in_u580800546_siste"] == "aviso"
                                                     || $tabela["Tables_in_u580800546_siste"] == "tipoachado" || $tabela["Tables_in_u580800546_siste"] == "tipoinformativo" || $tabela["Tables_in_u580800546_siste"] == "votoenquete"
                                                     || $tabela["Tables_in_u580800546_siste"] == "enquete" || $tabela["Tables_in_u580800546_siste"] == "mudanca" || $tabela["Tables_in_u580800546_siste"] == "comentarioclassificado"
                                                     || $tabela["Tables_in_u580800546_siste"] == "consumoagua" || $tabela["Tables_in_u580800546_siste"] == "modulo" || $tabela["Tables_in_u580800546_siste"] == "classificado"
                                                     || $tabela["Tables_in_u580800546_siste"] == "servico" || $tabela["Tables_in_u580800546_siste"] == "ramo" || $tabela["Tables_in_u580800546_siste"] == "produto"
                                                     || $tabela["Tables_in_u580800546_siste"] == "manutencao" || $tabela["Tables_in_u580800546_siste"] == "mensagem"){
                                                continue;
                                            }
                                            $tabelaSelecionada = str_replace("configuracao", "configuração ", $tabela["Tables_in_u580800546_siste"]);
                                            $tabelaSelecionada = str_replace("correspondencia", "correspondência", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("observacao", "observação ", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("manutencao", "manutenção ", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("arquivo", "arquivo ", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("agenda", "agenda ", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("servico", "serviço", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("acesso", "acesso ", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("email", " e-mail ", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("mudanca", " mudança ", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("ambiente", " ambiente ", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("classificado", " classificado ", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("ocorrencia", " ocorrência ", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("importacao", " importação ", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("eletronico", " eletrônico ", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("agua", " água ", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("morador", " morador ", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("tipo", " tipo ", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("visitante", " visitante ", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("mensagem", " mensagem ", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("orcamento", " orçamento ", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("horario", " horário ", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("voto", " voto ", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("pedido", " pedido ", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("beneficio", " beneficio ", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("cliente", " cliente ", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("estado", " estado ", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("orgao", " órgão ", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("sms", " sms ", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("padrao", " padrão ", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("ligacao", " ligação ", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("cotacao", " cotação ", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("conteudo", " conteúdo ", $tabelaSelecionada);
                                            $tabelaSelecionada = str_replace("agencia", " agência ", $tabelaSelecionada);
                                            echo '<option value="',$tabela["Tables_in_u580800546_siste"],'">',trim($tabelaSelecionada),'</option>';
                                        }
                                    }else{
                                        echo '<option value="">--Nada encontrado--</option>';
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Campos</td>
                            <td id="listagemCamposTabela"></td>
                        </tr>
                    </table>
                    <input type="submit" name="submit" value="Gerar Relatório"/>
                </form>
            </div>
            <span style="float: right; color: grey;width: 100%;text-align: right;">
            @ South Negócios
            </span>               
        </div>
        <?php include "includeChat.php";?>
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="http://code.jquery.com/ui/1.11.2/jquery-ui.min.js"></script>         
        <script type="text/javascript" src="../visao/recursos/js/ajax/Extrator.js"></script>
        <script type="text/javascript" src="../visao/recursos/js/sweet-alert.min.js"></script>
        <script type="text/javascript" src="../visao/recursos/js/Geral.js"></script>
        <script type="text/javascript" src="../visao/recursos/js/tinybox.min.js"></script>
        <script type="text/javascript" src="../visao/recursos/js/modernizr-2.5.3.min.js"></script>
        <script src="/visao/recursos/js/chat.js"></script>
        <?php
    $nivel_popup = $conexao->comandoArray("SELECT * FROM `nivelpagina` WHERE `codpagina` = 81 and inserir = 1");
    if(isset($nivel_popup["inserir"]) && $nivel_popup["inserir"] == 1){
        echo '<script src="/visao/recursos/js/ajax/Frase.js" type="text/javascript"></script>';
        echo '<script>visualizaPopup();</script>';
    }
?>      