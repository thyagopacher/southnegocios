<?php 
    header('Content-Type: text/html; charset=utf-8');
    session_start();
    include("../model/Conexao.php");
    $conexao = new Conexao();
?>
<link rel="stylesheet" type="text/css" href="./recursos/css/sweet-alert.css">
<form id="fenvioSMS" autocomplete="off"  method="POST" onsubmit="return false;">
<?php
    $configuracao = $conexao->comandoArray("select loginSMS, senhaSMS from configuracao where codempresa = '{$_SESSION['codempresa']}'");
    if(isset($configuracao) && isset($configuracao["loginSMS"]) && $configuracao["loginSMS"] != NULL && $configuracao["loginSMS"] != ""){
        echo '<input type="hidden" name="lgn" id="loginSMS" value="',$configuracao["loginSMS"],'"/>';
        echo '<input type="hidden" name="pwd" id="senhaSMS" value="',$configuracao["senhaSMS"],'"/>';
    }else{
        echo '<script>alert("Deve configurar antes a conta de SMS na configuração da empresa!!!");</script>';
    }
?>    
    <table class="tabela_formulario">
        <tr>
            <td style="width: 65px;">Modelo</td>
            <td style="width: 200px;">
                <select name="modelo" id="modelo" onchange="trocaTexto();">
                    <?php
                    $ressmspadrao = $conexao->comando("select * from smspadrao where codempresa = '{$_SESSION['codempresa']}' order by texto");
                    $qtdsmspadrao = $conexao->qtdResultado($ressmspadrao);
                    if($qtdsmspadrao > 0){
                        while($smspadrao = $conexao->resultadoArray($ressmspadrao)){
                            echo '<option>',$smspadrao["texto"],'</option>';
                        }
                    }
                    ?>
                </select>
            </td>        
            <td style="width: 30px;">Número</td>
            <td style="width: 294px;">
                <input style="width: 155px;" type="text" name="numbers" id="numbers" class="telefone" value="<?php if(isset($_GET["numero"])){echo $_GET["numero"];}?>"/>
            </td>     
        </tr>
        <tr>
            <td>Texto</td>
            <td colspan="3">
                <textarea style="width: 500px;" name="msg" id="msg"></textarea>
            </td>
        </tr>

    </table>
        <?php echo '<button style="margin-left: 5px;" onclick="envioDireto()">Enviar</button>';?>
</form>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.11.2/jquery-ui.min.js"></script>   
<script type="text/javascript" src="./recursos/js/jquery.mask.min.js"></script>
<script type="text/javascript" src="./recursos/js/ajax/EnvioSMS.js"></script>
<script type="text/javascript" src="./recursos/js/sweet-alert.min.js"></script>
<script type="text/javascript" src="./recursos/js/Geral.js"></script>

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