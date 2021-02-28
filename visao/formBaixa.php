<form id="fbaixa" method="POST">
    <input type="hidden" name="codbaixa" id="codbaixa"  value="<?php if(isset($baixa["codbaixa"])){echo $baixa["codbaixa"];}else{ echo "";}?>"/>                            
<table class="tabela_formulario">
    <tr>
        <td>CPF</td>
        <td><input type="text" name="cpf" id="cpf" class="cpf" value="<?php if(isset($baixa["cpf"])){echo $baixa["cpf"];}?>"/></td>     
        <td>Valor</td>
        <td><input type="text" name="valor" id="valor" class="real" placeholder="Digite valor" value="<?php if(isset($baixa["valor"])){echo $baixa["valor"];}?>"></td>   
    </tr>
    <tr>
        <td>Data</td>
        <td>
            <input type="date" name="dtcadastro" id="dtcadastro" value="<?php if(isset($baixa["valor"])){echo $baixa["valor"];}else{echo date('Y-m-d');}?>"/>
        </td>
        <td></td>
        <td></td>
    </tr>
</table>
        <?php
if($nivelp["inserir"] == 1){
    echo '<input type="button" name="submit" value="Cadastrar" id="btinserirBaixa" onclick="inserir();"/>';
}            
if($nivelp["atualizar"] == 1){
    echo '<input style="margin-left: 5px; display: none" type="button" name="submit" id="btatualizarBaixa" value="Atualizar" onclick="atualizar();"/>';
}
if($nivelp["excluir"] == 1){
    echo '<button style="margin-left: 5px; display: none" onclick="excluirBaixa()" id="btexcluirBaixa">Excluir</button>';
}
echo '<button style="margin-left: 5px; display: none" onclick="btNovoBaixa()" id="btnovoBaixa">Novo</button>';
        ?>
</form>

<div class="progress">
    <div class="bar"></div>
    <div class="percent">0%</div>
</div>
<div id="status"></div>
