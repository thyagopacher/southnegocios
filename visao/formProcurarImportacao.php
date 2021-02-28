<form id="fpimportacao" name="fpmportacao" action="../control/ProcurarImportacaoRelatorio.php" target="_blank" method="POST" onsubmit="return false;">
    <input type="hidden" name="nome_pagina" id="nome_pagina" value="Relatório de Importação"/> 
    <input type="hidden" name="tipo" id="tipo" value="pdf"/>
    <table class="tabela_formulario">
        <tr>
            <td>Nome</td>
            <td colspan="8"><input style="width: 588px;max-width: 588px;" type="text" name="nome" size="50" maxlength="250" placeholder="Digite nome da mportacao" value=""></td>
        </tr>
        <tr>
            <td>Dt. Inicio</td>
            <td><input style="width: 120px;" type="date" class="data" name="data1"/></td>
            <td>Dt. Fim</td>
            <td><input style="width: 120px;" type="date" class="data" name="data2"/></td>
        </tr>
    </table>
    <input type="hidden" name="html" id="html" value=""/>
    <button onclick="procurarImportacao()" class="btn btn-info">Procurar</button>
    <button onclick="abreRelatorio()">Gera PDF</button>
    <button onclick="abreRelatorio2()">Gera Excel</button>    
</form>
<?php include("./carregando.php");?>
<div id="listagem"></div>
