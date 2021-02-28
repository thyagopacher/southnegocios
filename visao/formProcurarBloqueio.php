<form id="fpconta" action="PDF.php" target="_blank" role="form" class="form-horizontal form-groups-bordered" method="POST" onsubmit="return false;">                   
    <table class="tabela_formulario">
        <tr>
            <td>Endereço IP</td>
            <td colspan="8">
                <input type="text" name="enderecoip" size="50" maxlength="250" placeholder="Digite endereço IP aqui" value=""/>
            </td>
        </tr>
        <tr>
            <td>Dt. Inicio</td>
            <td><input type="date" class="data" name="data1"/></td>
            <td>Dt. Fim</td>
            <td><input type="date" class="data" name="data2"/></td>
        </tr>
    </table>
    <button onclick="procurarBloqueio(false)" class="btn btn-info">Procurar</button>
</form>
<?php include("./carregando.php");?>
<div id="listagem"></div>
