<form id="fpachado" action="../control/ProcurarBancoRelatorio.php" target="_blank" role="form" class="form-horizontal form-groups-bordered" method="POST" onsubmit="return false;">                       
    <table class="tabela_formulario">
        <input type="hidden" name="html" id="html" value=""/>
        <input type="hidden" name="tipo" id="tipo" value="pdf"/>
        <input type="hidden" name="nome_pagina" id="nome_pagina" value="Relatório de Bancos e perdidos"/>
        <tr>
            <td>Nome</td>
            <td colspan="8"><input style="width: 588px;" type="text" name="descricao" size="50" maxlength="250" placeholder="Digite descrição aqui" value=""></td>
        </tr>
        <tr>
            <td>Dt. Inicio</td>
            <td style="width: 300px;"><input type="date" class="data" name="data1"/></td>
            <td>Dt. Fim</td>
            <td><input type="date" class="data" name="data2"/></td>
        </tr>
       
    </table>
    <button onclick="procurarRamal(false)">Procurar</button>
    <button onclick="abreRelatorioRamal()">Gera PDF</button>
    <button onclick="abreRelatorio2Ramal()">Gera Excel</button>
</form>
<?php include("./carregando.php");?>
<div id="listagem"></div>
