<form id="fbanco" autocomplete="on" role="form" action="<?=$action?>" autocomplete="off" class="form-horizontal form-groups-bordered" method="POST">
    <input type="hidden" name="codbanco" id="codbanco"  value="<?php if(isset($banco["codbanco"])){echo $banco["codbanco"];}else{ echo "";}?>"/>                            
<table class="tabela_formulario">
    <tr>
        <td>Nome</td>
        <td colspan="3"><input type="text" style="width: 600px;" name="nome" value="<?php if(isset($banco["nome"])){echo $banco["nome"];}?>"/></td>     
    </tr>
    <tr>
        <td>CNPJ</td>
        <td><input type="text" name="cnpj" placeholder="Digite cnpj" value="<?php if(isset($banco["cnpj"])){echo $banco["cnpj"];}?>"></td>
        <td>Num Banco</td>
        <td>
            <input type="text" name="numbanco" id="numbanco" value="<?php if(isset($banco["numbanco"])){echo $banco["numbanco"];}?>"/>
        </td>    
    </tr>
    <tr>
        <td>Site</td>
        <td colspan="3">
            <input type="url" style="width: 600px;" name="site" id="site" value="<?php if(isset($banco["site"])){echo $banco["site"];}?>"/>
        </td>
    </tr>
</table>
        <?php
        if (!isset($banco["codbanco"])) {
            if($nivelp["inserir"] == 1){
                echo '<input type="submit" name="submit" value="Cadastrar"/>';
            }
        } elseif (isset($banco["codbanco"])) {
            if($nivelp["atualizar"] == 1){
                echo '<input style="margin-left: 5px;" type="submit" name="submit" value="Atualizar"/>';
            }
            if($nivelp["excluir"] == 1){
                echo '<button style="margin-left: 5px;" onclick="excluirBanco()">Excluir</button>';
            }
            echo '<button style="margin-left: 5px;" onclick="btNovoBanco()">Novo</button>';
        } 
        ?>
</form>

<div class="progress">
    <div class="bar"></div>
    <div class="percent">0%</div>
</div>
<div id="status"></div>
