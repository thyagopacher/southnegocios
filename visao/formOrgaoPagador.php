<form id="forgao" action="<?=$action?>" method="POST">
    <input type="hidden" name="codorgao" id="codorgao"  value="<?php if(isset($orgao["codorgao"])){echo $orgao["codorgao"];}else{ echo "";}?>"/>                            
<table class="tabela_formulario">
    <tr>
        <td>Nome</td>
        <td colspan="3"><input type="text" style="width: 600px;" name="nome" value="<?php if(isset($orgao["nome"])){echo $orgao["nome"];}?>"/></td>     
    </tr>
   
</table>
        <?php
        if (!isset($orgao["codorgao"])) {
            if($nivelp["inserir"] == 1){
                echo '<input type="submit" name="submit" value="Cadastrar"/>';
            }
        } elseif (isset($orgao["codorgao"])) {
            if($nivelp["atualizar"] == 1){
                echo '<input style="margin-left: 5px;" type="submit" name="submit" value="Atualizar"/>';
            }
            if($nivelp["excluir"] == 1){
                echo '<button style="margin-left: 5px;" onclick="excluirOrgaoPagador()">Excluir</button>';
            }
            echo '<button style="margin-left: 5px;" onclick="btNovoOrgaoPagador()">Novo</button>';
        } 
        ?>
</form>

<div class="progress">
    <div class="bar"></div>
    <div class="percent">0%</div>
</div>
<div id="status"></div>
