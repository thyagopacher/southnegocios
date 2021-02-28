<form id="fpsmspadrao"  method="POST" onsubmit="return false;">
    <input type="hidden" name="codsmspadrao" id="codsmspadrao"  value="<?php if(isset($smspadrao["codsmspadrao"])){echo $smspadrao["codsmspadrao"];}?>"/>                            
<table class="tabela_formulario">
    <tr>
        <td>Dt. Inicio</td>
        <td><input type="text" name="data1" id="data1" class="data"/></td>
        <td>Dt. Fim</td>
        <td><input type="text" name="data2" id="data2" class="data"/></td>
    </tr>
    <tr>
        <td>Texto</td>
        <td colspan="3">
            <textarea style="margin: 0px; width: 530px; height: 30px;" name="texto" id="texto" style=""><?php if(isset($smspadrao["texto"])){echo $smspadrao["texto"];}?></textarea>
        </td>     
    </tr>
</table>
        <?php
        echo '<button style="margin-left: 5px;" onclick="procurarSmsPadrao(false)">Procurar</button>';
        ?>
</form>
<div id="listagemSmsPadrao"></div>