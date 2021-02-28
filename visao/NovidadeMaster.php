<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
if (!isset($_SESSION["nome"])) {
        $retorno = "<script>alert('Não pode acessar funcionalidade sem estar logado!');</script>";
        $retorno .= "<script>location.href='http://www.southnegocios.com/'</script>";
        die($retorno);
} else {
    include("../model/Conexao.php");
    $conexao = new Conexao();    
    if(isset($_GET["codnewsletter"])){
        $newsletter = $conexao->comandoArray("select * from newsletter where codnewsletter = '{$_GET["codnewsletter"]}'");
    }
}
?>
<!DOCTYPE html>

<html lang="pt-br">
    <head>
        <?php include("head.php");?>     
        <title>South Negócios › Newsletter</title>
    </head>
    <body>
        <?php 
        include("cabecalho.php");
        include("menu.php");
        ?>
        <div id="barra_pos_cabecalho"></div>
        <h3>Newsletter Master</h3>
         <div id="tabs" style="width: 955px; margin: 0 auto;  margin-top: 55px;">
            <ul>
                <li><a href="#tabs-1">Importação</a></li>
                <li><a href="#tabs-2">Procurar</a></li>
            </ul>
            <div id="tabs-1">
                <form name="fnewsletter" id="fnewsletter" method="post" action="../control/NovidadeMaster.php">
                    <table class="tabela_formulario">
                        <tr>
                            <td>Arquivo</td>
                            <td><input type="file" name="arquivo" required title="Escolha seu arquivo aqui"/></td>
                        </tr>  
                        <tr>
                            <td>Assunto</td>
                            <td><input style="width: 695px" type="text" name="assunto" id="assunto" title="Assunto para newsletter" placeholder="assunto"/></td>
                        </tr>
                        <tr>
                            <td>Texto</td>
                            <td><textarea style="height: 250px;" name="texto" id="texto" class="texto" cols="70" rows="30"><?php echo file_get_contents("http://www.southnegocios.com/sistema/visao/recursos/template/email2.php?codnivel=1")?></textarea></td>
                        </tr>      
                        <tr>
                            <td><input type="submit" name="submit" value="Enviar" title="Clique aqui para enviar"/></td>
                        </tr>
                    </table>
                </form>
                
                <br><a href="../arquivos/importacao_email.xls" target="_blank" title="Download do arquivo de importação e-mail marketing">* Arquivo de importação e-mail</a><br>
                <div class="progress">
                    <div class="bar"></div>
                    <div class="percent">0%</div>
                </div>

                <div id="status"></div>                
            </div>
            <div id="tabs-2">
                <?php 
                include("./formProcurarNewsletter.php");
                ?>
            </div>
            <span style="float: right; color: grey;width: 100%;text-align: right;">
            @ South Negócios
            </span>               
        </div>
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.js"></script>
        <script type="text/javascript" src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>   
         <script src="/visao/recursos/js/chat.js"></script>       
        <script type="text/javascript" src="/visao/recursos/js/jquery.form.js"></script>  
        <script type="text/javascript" src="./recursos/js/tinymce/tinymce.min.js"></script>
        <script type="text/javascript" src="./recursos/js/Editor.js"></script>           
        <script type="text/javascript" src="../visao/recursos/js/Geral.js"></script>      
             
        <script type="text/javascript" src="../visao/recursos/js/ajax/Newsletter.js"></script>     
        
        <script type="text/javascript" src="./recursos/js/sweet-alert.min.js"></script>
        <script type="text/javascript" src="./recursos/js/tinybox.min.js"></script>
        <script type="text/javascript" src="./recursos/js/modernizr-2.5.3.min.js"></script>
            <?php
    $nivel_popup = $conexao->comandoArray("SELECT * FROM `nivelpagina` WHERE `codpagina` = 81 and inserir = 1");
    if(isset($nivel_popup["inserir"]) && $nivel_popup["inserir"] == 1){
        echo '<script src="/visao/recursos/js/ajax/Frase.js" type="text/javascript"></script>';
        echo '<script>visualizaPopup();</script>';
    }
?>      