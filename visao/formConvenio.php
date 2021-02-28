<form id="fconvenio" autocomplete="on" role="form" action="<?=$action?>" autocomplete="off" class="form-horizontal form-groups-bordered" method="POST">
    <input type="hidden" name="codconvenio" id="codconvenio"  value="<?php if(isset($convenio["codconvenio"])){echo $convenio["codconvenio"];}?>"/>                            
<table class="tabela_formulario">
    <tr>
        <td>Nome</td>
        <td colspan="3"><input type="text" style="width: 600px;" name="nome" value="<?php if(isset($convenio["nome"])){echo $convenio["nome"];}?>"/></td>     
    </tr>
</table>
        <?php
        if (!isset($convenio["codconvenio"])) {
            if($nivelp["inserir"] == 1){
                echo '<input type="submit" name="submit" value="Cadastrar"/>';
            }
        } elseif (isset($convenio["codconvenio"])) {
            if($nivelp["atualizar"] == 1){
                echo '<input style="margin-left: 5px;" type="submit" name="submit" value="Atualizar"/>';
            }
            if($nivelp["excluir"] == 1){
                echo '<button style="margin-left: 5px;" onclick="excluirConvenio()">Excluir</button>';
            }
            echo '<button style="margin-left: 5px;" onclick="btNovoConvenio()">Novo</button>';
        } 
        ?>
</form>

<div class="progress">
    <div class="bar"></div>
    <div class="percent">0%</div>
</div>
<div id="status"></div>
