<form id="fpachado" action="../control/ProcurarDiaRelatorio.php" target="_blank" role="form" class="form-horizontal form-groups-bordered" method="POST" onsubmit="return false;">                       
    <table class="tabela_formulario">
        <input type="hidden" name="tipo" id="tipo" value="pdf"/>
        <tr>
            <td>Dt. Inicio</td>
            <td style="width: 300px;"><input type="date" class="data" name="data1"/></td>
            <td>Dt. Fim</td>
            <td><input type="date" class="data" name="data2"/></td>
        </tr>
       
    </table>
    <button onclick="procurarDia(false)">Procurar</button>
    <button onclick="abreRelatorioDia()">Gera PDF</button>
    <button onclick="abreRelatorio2Dia()">Gera Excel</button>
</form>
<?php include("./carregando.php");?>
<div id="listagemDia"></div>
