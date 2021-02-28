<form id="fsmspadrao" autocomplete="on" method="POST" onsubmit="return false;">
    <input type="hidden" name="codsmspadrao" id="codsmspadrao"  value="<?php if(isset($smspadrao["codsmspadrao"])){echo $smspadrao["codsmspadrao"];}?>"/>                            
<table class="tabela_formulario">
    <tr>
        <td>Texto</td>
        <td>
            <textarea name="texto" id="texto" required style="margin: 0px; width: 700px; height: 130px;"><?php if(isset($smspadrao["texto"])){echo $smspadrao["texto"];}?></textarea>
        </td>     
    </tr>
</table>
        <?php
        if (!isset($smspadrao["codsmspadrao"])) {
            if($nivelp["inserir"] == 1){
                echo '<button style="margin-left: 5px;" onclick="inserirSmsPadrao()">Cadastrar</button>';
            }
        } elseif (isset($smspadrao["codsmspadrao"])) {
            if($nivelp["atualizar"] == 1){
                echo '<button style="margin-left: 5px;" onclick="atualizarSmsPadrao()">Atualizar</button>';
            }
            if($nivelp["excluir"] == 1){
                echo '<button style="margin-left: 5px;" onclick="excluirSmsPadrao()">Excluir</button>';
            }
            echo '<button style="margin-left: 5px;" onclick="btNovoSmsPadrao()">Novo</button>';
        } 
        ?>
</form>

<div class="progress">
    <div class="bar"></div>
    <div class="percent">0%</div>
</div>
<div id="status"></div>
