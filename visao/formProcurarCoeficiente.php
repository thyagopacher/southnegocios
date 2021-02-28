<form id="fpachado" action="../control/ProcurarCoeficienteRelatorio.php" target="_blank" role="form" class="form-horizontal form-groups-bordered" method="POST" onsubmit="return false;">                       
    <table class="tabela_formulario">
        <input type="hidden" name="tipo" id="tipo" value="pdf"/>
        <tr>
            <td>Dt. Inicio</td>
            <td style="width: 300px;"><input type="date" class="data" name="data1"/></td>
            <td>Dt. Fim</td>
            <td><input type="date" class="data" name="data2"/></td>
        </tr>
       
    </table>
    <button onclick="procurarCoeficiente(false)">Procurar</button>
    <button onclick="abreRelatorioCoeficiente()">Gera PDF</button>
    <button onclick="abreRelatorio2Coeficiente()">Gera Excel</button>
</form>
<?php include("./carregando.php");?>
<div id="listagem"></div>

<form action="Excel.php" method="post" target="_blank" id="fpachado2" name="fpachado2">
    <input type="hidden" name="descrição_pagina" id="descrição_pagina" value="Relatório de Coeficientes e perdidos"/>
    <input type="hidden" name="html" id="html2" value=""/>
</form>