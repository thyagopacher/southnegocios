<form id="fenvioSMS" autocomplete="off"  method="POST" onsubmit="return false;">
    <input type="hidden" name="codachado" id="codachado"  value="<?php if(isset($achado["codachado"])){echo $achado["codachado"];}else{ echo "";}?>"/>                            
<table class="tabela_formulario">
    <tr>
        <td style="width: 65px;">Modelo</td>
        <td style="width: 200px;">
            <select name="modelo" id="modelo">
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
            <input style="width: 175px" type="text" name="numbers" id="numbers" class="telefone" value=""/>
        </td>     
    </tr>
    <tr>
        <td>Texto</td>
        <td colspan="3">
            <textarea style="width: 500px;" name="msg" id="msg"></textarea>
        </td>
    </tr>
   
</table>
        <?php
        echo '<button style="margin-left: 5px;" onclick="envioDireto()">Enviar</button>';
//        if (!isset($achado["codachado"])) {
//            if($nivelp["inserir"] == 1){
//                
//            }
//        } elseif (isset($achado["codachado"])) {
//            if($nivelp["atualizar"] == 1){
//                echo '<button style="margin-left: 5px;" onclick="atualizarEnvioSMS()">Atualizar</button>';
//            }
//            if($nivelp["excluir"] == 1){
//                echo '<button style="margin-left: 5px;" onclick="excluirEnvioSMS()">Excluir</button>';
//            }
//            echo '<button style="margin-left: 5px;" onclick="btNovoEnvioSMS()">Novo</button>';
//        } 
        ?>
</form>

<div class="progress">
    <div class="bar"></div>
    <div class="percent">0%</div>
</div>
<div id="status"></div>
