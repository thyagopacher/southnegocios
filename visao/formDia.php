<form id="fdia" onsubmit="return false;" method="POST">
    <input type="hidden" name="coddia" id="coddia"  value="<?php if(isset($dia["coddia"])){echo $dia["coddia"];}else{ echo "";}?>"/>                            
<table class="tabela_formulario">
    <tr>
        <td>Data</td>
        <td colspan="3"><input type="date" name="data" id="data" value="<?php if(isset($dia["data"])){echo $dia["data"];}?>"/></td>     
    </tr>
  
</table>
        <?php
        if (!isset($dia["coddia"])) {
            if($nivelp["inserir"] == 1){
                echo '<input type="submit" name="button" id="Cadastrar" value="Cadastrar" onclick="inserirDia()"/>';
            }
        } elseif (isset($dia["coddia"])) {
            if($nivelp["atualizar"] == 1){
                echo '<input style="margin-left: 5px;" type="submit" name="submit" value="Atualizar" onclick="atualizarDia()"/>';
            }
            if($nivelp["excluir"] == 1){
                echo '<button style="margin-left: 5px;" onclick="excluirDia()">Excluir</button>';
            }
            echo '<button style="margin-left: 5px;" onclick="btNovoDia()">Novo</button>';
        } 
        ?>
</form>

<div class="progress">
    <div class="bar"></div>
    <div class="percent">0%</div>
</div>
<div id="status"></div>
