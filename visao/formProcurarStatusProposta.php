<form id="fpconta" action="" role="form" class="form-horizontal form-groups-bordered" method="POST" onsubmit="return false;">                     
    <table class="tabela_formulario">
        <input type="hidden" name="tipo" id="tipo" value="pdf"/>
        <tr>
            <td style="width: 80px;">Nome</td>
            <td colspan="8"><input style="width: 580px;" type="text" name="nome" size="50" maxlength="250" placeholder="Digite nome aqui" value=""></td>
        </tr>
        <tr>
            <td style="width: 80px;">Dt. Inicio</td>
            <td style="width: 100px;"><input style="width: 200px;" type="text" class="data" name="data" value="<?php if(isset($_GET["data1"])){echo $_GET["data1"];}?>"/></td>
            <td style="width: 80px;">Dt. Fim</td>
            <td style="width: 100px;"><input style="width: 222px;" type="text" class="data" name="data2" value="<?php if(isset($_GET["data2"])){echo $_GET["data2"];}?>"/></td>
        </tr>         
    </table>
    <button onclick="formProcurarStatusProposta(false)">Procurar</button>
</form>
<?php include("./carregando.php");?>
<div id="listagemStatusProposta"></div>
