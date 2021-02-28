<?php
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set('America/Sao_Paulo');
session_start();
if (!isset($_SESSION["nome"])) {
    $retorno = "<script>alert('Não pode acessar funcionalidade sem estar logado!');</script>";
    $retorno .= "<script>location.href='/'</script>";
    die($retorno);
} else {
    include "../model/Coeficiente.php";
    include("../model/Conexao.php");
    $conexao = new Conexao();
    $site = $conexao->comandoArray("select * from site limit 1");
    if (isset($_GET["codpessoa"]) && $_GET["codpessoa"] != NULL && trim($_GET["codpessoa"]) != "") {
        if(isset($_SESSION["codnivel"]) && ($_SESSION["codnivel"] == 18 || $_SESSION["codnivel"] == 1)){
            $sql = "select * from pessoa where codpessoa = '{$_GET["codpessoa"]}'";
            $pessoa = $conexao->comandoArray($sql);
            $_SESSION['codempresa'] = $pessoa["codempresa"];
        }
        $sql = "select * from pessoa where codpessoa = '{$_GET["codpessoa"]}' and codempresa = '{$_SESSION['codempresa']}'";
        $pessoa = $conexao->comandoArray($sql);

        $titulo = "Alterar um ";
        $action = "../control/AtualizarPessoa.php";
    } else {
        $titulo = "Cadastrar um ";
        $action = "../control/InserirCliente.php";
    }

    if (isset($_SESSION["codnivel"]) && $_SESSION["codnivel"] != NULL && $_SESSION["codnivel"] != "") {
        if (!isset($_GET["novo"]) && isset($_GET["callcenter"])) {
            if(isset($_GET["callcenter"])){
                $and .= " and pessoa.codcategoria = 6";
            }else{
                $and .= " and pessoa.codcategoria = 1";
            }
            if (!isset($_GET["codpessoa"]) || $_GET["codpessoa"] == NULL || $_GET["codpessoa"] == "") {
                //primeiro procura na agenda
                $sql = "select distinct pessoa.codpessoa, pessoa.* 
                from pessoa 
                inner join agenda on agenda.codpessoa = pessoa.codpessoa and agenda.atendido = 'n'
                left join importacao on importacao.codimportacao = pessoa.codimportacao and importacao.codempresa = pessoa.codempresa    
                left join acessooperador as acesso on acesso.codcarteira = importacao.codcarteira and acesso.codempresa = importacao.codempresa and acesso.codoperador = '{$_SESSION['codpessoa']}' 
                where pessoa.codstatus not in (1,2,6,8,13) and pessoa.codempresa = '{$_SESSION['codempresa']}' and pessoa.codcategoria in(6) and agenda.codfuncionario = '{$_SESSION['codpessoa']}'
                and pessoa.codpessoa not in(select codpessoa from agenda where codempresa = '{$_SESSION['codempresa']}' and dtagenda >= '" . date('Y-m-d') . " 00:00:00' and atendido = 'n')    
                and pessoa.codpessoa not in(select codpessoa from atendimento where codempresa = '{$_SESSION['codempresa']}' and dtcadastro >= '" . date('Y-m-d') . " 00:00:00' and dtcadastro <= '" . date('Y-m-d') . " 23:59:59')    
                and agenda.codfuncionario not in(select codpessoa from pessoa where status = 'i' and codempresa = '{$_SESSION['codempresa']}') and pessoa.codstatus <> '1' {$and}
                order by agenda.dtagenda desc";
                
                $pessoa = $conexao->comandoArray($sql);
                if(!isset($pessoa["codpessoa"]) || $pessoa["codpessoa"] == NULL || $pessoa["codpessoa"] == ""){
                    //depois procura cliente por critérios
                    $sql = "select distinct pessoa.codpessoa, pessoa.* 
                    from pessoa 
                    inner join acessooperador as acesso on acesso.codempresa = pessoa.codempresa and acesso.codoperador = '{$_SESSION['codpessoa']}' 
                    where pessoa.codstatus not in (1,2,6,8,13) and
                    pessoa.codempresa = '{$_SESSION['codempresa']}' and pessoa.codcategoria in(6) 
                    and pessoa.codpessoa not in(select codpessoa from atendimento where codempresa = '{$_SESSION['codempresa']}' and dtcadastro >= '" . date('Y-m-d') . " 00:00:00' and dtcadastro <= '" . date('Y-m-d') . " 23:59:01')    
                    and pessoa.codpessoa not in(select codpessoa from agenda where codempresa = '{$_SESSION['codempresa']}' and dtagenda >= '" . date('Y-m-d') . " 00:00:00' and atendido = 'n' and agenda.codfuncionario not in(select codpessoa from pessoa where status = 'i' and codempresa = '{$_SESSION['codempresa']}')) and pessoa.codstatus <> '1'   {$and}
                    order by pessoa.nome";  
                    $pessoa = $conexao->comandoArray($sql);
                }
                
                
                $sql = "INSERT INTO `atendimento`(`codempresa`, `codfuncionario`, `dtcadastro`, `codpessoa`) VALUES ('{$_SESSION['codempresa']}', '{$_SESSION['codpessoa']}', '" . date("Y-m-d H:i:s") . "', '{$pessoa["codpessoa"]}')";
                $conexao->comando($sql);

                $_GET["codpessoa"] = $pessoa["codpessoa"];
            }
            if (isset($pessoa) && isset($pessoa["codpessoa"])) {
                $action = "../control/AtualizarPessoa.php";
            } else {
                echo '<script>alert("Fila de atendimento acabou!!!");</script>';
            }
        }elseif(isset($_GET["callcenter"]) && !isset($nivel_operador) && isset($_GET["codpessoa"])){
            $pessoa = $conexao->comandoArray("select * from pessoa where codempresa = '{$_SESSION['codempresa']}' and codpessoa = '{$_GET["codpessoa"]}'");
        }elseif(isset($_GET["proximo"]) && !isset($_GET["tipo"])){
            if(isset($_GET["codpessoa"]) && $_GET["codpessoa"] != NULL && $_GET["codpessoa"] != ""){
                $andPessoa2 = " and pessoa.codpessoa > '{$_GET["codpessoa"]}'";//para rodar fila de clientes normais
            }
            $pessoa = $conexao->comandoArray("select * from pessoa where codcategoria = 1 {$andPessoa2} and codempresa = '{$_SESSION['codempresa']}' order by codcategoria");
        }else{
            if(isset($_GET["codpessoa"]) && $_GET["codpessoa"] != NULL && $_GET["codpessoa"] != "" && !isset($_GET["tipo"])){
                $andPessoa2 = " and pessoa.codpessoa = '{$_GET["codpessoa"]}'";//para rodar fila de clientes normais
            }elseif(isset($_GET["tipo"])){
                $andPessoa2 = " and pessoa.codpessoa not in(select codpessoa from atendimento where codempresa = '{$_SESSION['codempresa']}' and dtcadastro >= '" . date('Y-m-d') . " 00:00:00' and dtcadastro <= '" . date('Y-m-d') . " 23:59:01')";
            }            
            if($QtdAtendimento["qtd"] > $limiteDistr){
                echo '<script>alert("Já atendeu número maior que a divisão entre os operadores!!!");</script>';
            }else{
                if (isset($pessoa) && isset($pessoa["codpessoa"])) {
                    $action = "../control/AtualizarPessoa.php";
                }else{
                    $action = "../control/InserirCliente.php";
                }     
            }
        }
    }
    if (isset($_GET["callcenter"]) && $_GET["callcenter"] != NULL && $_GET["callcenter"] == "true") {
        $andNivelPagina = " and nivelpagina.codpagina = '58'";
        $requireForm = "";
    } else {
        $andNivelPagina = " and nivelpagina.codpagina = '55'";
        $requireForm = "";
    }
    $nivelp = $conexao->comandoArray("select nivelpagina.*, pagina.nome as pagina 
            from nivelpagina 
            inner join pagina on pagina.codpagina = nivelpagina.codpagina    
            where nivelpagina.codnivel = '{$_SESSION["codnivel"]}' {$andNivelPagina}");
    $titulo .= $nivelp["pagina"];        
}
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>

        <?php include("head.php"); ?>
        <style>
            .tbox{
                left: 100px !important;
                right: 100px !important;
            }
            .tinner{
                width: auto !important;
                height: auto !important;
            }
        </style>        
        <title><?= $site["nome"] ?> › <?= $titulo ?></title>        
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
                <li><a href="#tabs-1">Cadastro</a></li>
                <?php if ($nivelp["procurar"] == 1) { ?>
                    <li><a href="#tabs-2">Procurar</a></li>
                <?php } ?>
                <li><a href="#tabs-3"><?php echo "Proc. Agenda";?></a></li>
                <?php if(isset($_GET["codpessoa"]) && $_GET["codpessoa"] != NULL && $_GET["codpessoa"] != ""){?>
                <li><a href="#tabs-4">Proposta</a></li>
                <?php }?>
            </ul>
            <div id="tabs-1">
                <?php include("formCliente.php"); ?>
            </div>
            <?php if ($nivelp["procurar"] == 1) { ?>
                <div id="tabs-2">
                    <?php include("formProcurarCliente.php"); ?>
                </div>
            <?php } ?>
            <div id="tabs-3"><?php include("formProcurarAgenda.php"); ?></div>
            <?php if(isset($_GET["codpessoa"]) && $_GET["codpessoa"] != NULL && $_GET["codpessoa"] != ""){?>
            <div id="tabs-4"><?php include("formProposta.php"); ?></div>
            <?php }?>
            <span style="float: right; color: grey;width: 100%;text-align: right;">
                @ South Negócios
            </span>               
        </div>
        <?php include "includeChat.php";?>
        <script src="/visao/recursos/js/jquery-1.10.2.min.js"></script>
        <script src="/visao/recursos/js/jquery-ui.min.js"></script>
        <script src="/visao/recursos/js/jquery.form.js"></script>
        <script src="/visao/recursos/js/jquery.mask.min.js"></script>
        <script type="text/javascript" src="/visao/recursos/js/ajax/Pessoa.js"></script>
        <script type="text/javascript" src="/visao/recursos/js/ajax/BeneficioCliente.js"></script>
        <script type="text/javascript" src="/visao/recursos/js/ajax/EnvioSMS.js"></script>
        <script type="text/javascript" src="/visao/recursos/js/ajax/Agenda.js"></script>
        <script type="text/javascript" src="/visao/recursos/js/jquery.maskMoney.min.js"></script>
        <script type="text/javascript" src="/visao/recursos/js/jquery.mask.min.js"></script>
        <script type="text/javascript" src="/visao/recursos/js/Geral.js"></script>
        <script type="text/javascript" src="/visao/recursos/js/chat.js"></script>
        <script type="text/javascript" src="/visao/recursos/js/fancywebsocket.js"></script>
        <script type="text/javascript" src="./recursos/js/ajax/Proposta.js"></script>
        
        <script type="text/javascript" src="./recursos/js/sweet-alert.min.js"></script>
        <script type="text/javascript" src="./recursos/js/tinybox.min.js"></script>
        <script type="text/javascript" src="./recursos/js/modernizr-2.5.3.min.js"></script>
        <script src="/visao/recursos/js/chat.js"></script>    
        <script type="text/javascript" src="./recursos/js/tinymce/tinymce.min.js"></script>
        <?php if (isset($_GET["procurar"]) && $_GET["procurar"] != NULL && $_GET["procurar"] == "1") { ?>
            <script>
                $("#tabs").tabs({
                    active: 1
                });
                procurarPessoa(true);
            </script>        
        <?php } ?>        
  <?php
    $nivel_popup = $conexao->comandoArray("SELECT * FROM `nivelpagina` WHERE `codpagina` = 81 and inserir = 1");
    if(isset($nivel_popup["inserir"]) && $nivel_popup["inserir"] == 1){
        echo '<script src="/visao/recursos/js/ajax/Frase.js" type="text/javascript"></script>';
        echo '<script>visualizaPopup();</script>';
    }
?>                
<?php


function mask($val, $mask = "(##)####-####") {
    $maskared = '';
    $k = 0;
    for ($i = 0; $i <= strlen($mask) - 1; $i++) {
        if ($mask[$i] == '#') {
            if (isset($val[$k])) {
                $maskared .= $val[$k++];
            }
        } else {
            if (isset($mask[$i])) {
                $maskared .= $mask[$i];
            }
        }
    }
    return $maskared;
}

function reestruturandoTelefone($telefonepessoa2) {
    $telefone = str_replace("-", "", str_replace("(", "", str_replace(")", "", $telefonepessoa2)));
    $telefonepessoa = trim($telefone);
    if (strlen($telefonepessoa) == 10) {
        $mascaraTelefone = "(##)####-####";
    } else {
        $mascaraTelefone = "(##)#####-####";
    }
    if (strlen($telefonepessoa) > 8 && $telefonepessoa{0} == "0") {
        $ddd = substr($telefonepessoa, 0, 3);
        if ($ddd !== "021") {
            $telefone = mask($telefonepessoa, $mascaraTelefone);
        } else {
            $telefone = mask($telefonepessoa, $mascaraTelefone);
        }
    } elseif (strlen($telefonepessoa) > 8 && $telefonepessoa{0} != "0") {
        $ddd = substr($telefonepessoa, 0, 2);
        if ($ddd !== "21") {
            $telefone = mask($telefonepessoa, $mascaraTelefone);
        } else {
            $telefone = mask($telefonepessoa, $mascaraTelefone);
        }
    } elseif (strlen($telefonepessoa) == 8) {
        $telefone = mask("21" . $telefonepessoa, $mascaraTelefone);
    }
    return $telefone;
}