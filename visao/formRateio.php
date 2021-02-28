<form id="frateio" role="form" autocomplete="off" class="form-horizonsumol form-groups-bordered" method="get" onsubmit="return false;">
    <input type="hidden" name="codrateio" id="codrateio"  value="<?php if(isset($rateio["codrateio"])){echo $rateio["codrateio"];}else { echo "";} ?>"/>                       
    <table class="tabela_formulario">
        <tr> 
            <td>Data</td>
            <td><input style="width: 205px;" type="date" name="dtrateio" class="data" required value="<?php if(isset($rateio["dtrateio"])){echo $rateio["dtrateio"];}else { echo date('Y-m-d');} ?>" title="Digite aqui data" placeholder="Digite aqui data"/></td>   
            <td>Valor</td>
            <td>
                <input style="width: 200px;" type="text" name="valor" class="real" size="10" maxlength="10" title="Coloque valor rateio" value="<?php if(isset($rateio["valor"])){echo number_format($rateio["leitura"], 2, ",", "");}else { echo "";} ?>"/>
            </td>        
        </tr>
    </table>
        <?php 
        if (!isset($rateio["codrateio"])) {   
            if($nivelp["inserir"] == 1){
                echo '<button style="margin-left: 5px;" onclick="inserirRateio()">Cadastrar</button>';
            }
        } elseif (isset($rateio["codrateio"])) {
            if($nivelp["atualizar"] == 1){
                echo '<button style="margin-left: 5px;" onclick="atualizarRateio()" style="margin-left: 10px;">Atualizar</button>';
            }
            if($nivelp["excluir"] == 1){
                echo '<button style="margin-left: 5px;" onclick="excluirRateio()" style="margin-left: 10px;">Excluir</button>';
            }
            echo '<button style="margin-left: 5px;" onclick="btNovoRateio()" style="margin-left: 10px;">Novo</button>';
        } 
        ?>    
</form>
<?php include("./carregando.php");?>
<div id="listagemMorador"></div>