<form id="fptabelap" action="../control/ProcurarTabelaRelatorio.php" target="_blank" role="form" class="form-horizontal form-groups-bordered" method="POST" onsubmit="return false;">                       
    <table class="tabela_formulario">
        <input type="hidden" name="html" id="html" value=""/>
        <input type="hidden" name="tipo" id="tipo" value="pdf"/>
        <input type="hidden" name="nome_pagina" id="nome_pagina" value="Relatório de Tabelas e perdidos"/>
        <tr>
            <td>Nome</td>
            <td colspan="8"><input style="width: 588px;" type="text" name="nome" size="50" maxlength="250" placeholder="Digite nome aqui" value=""></td>
        </tr>
        <tr>
            <td>Dt. Inicio</td>
            <td style="width: 300px;"><input type="date" name="data1"/></td>
            <td>Dt. Fim</td>
            <td><input type="date" name="data2"/></td>
        </tr>
       
    </table>
    <button onclick="procurarTabelaPrazo(false)">Procurar</button>
    <button onclick="abreRelatorioTabelaPrazo()">Gera PDF</button>
    <button onclick="abreRelatorio2TabelaPrazo()">Gera Excel</button>
</form>
<?php include("./carregando.php");?>
<div id="listagemTabelaPrazo"></div>
