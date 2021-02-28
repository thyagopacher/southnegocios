<form id="fpservico" action="../control/ProcurarServicoRelatorio.php" target="_blank" method="POST" onsubmit="return false;">                   
    <table class="tabela_formulario">
        <input type="hidden" name="html" id="html" value=""/>
        <input type="hidden" name="nome_pagina" id="nome_pagina" value="Relatório de Serviços"/>
        <input type="hidden" name="tipo" id="tipo" value="pdf"/>
        <tr>
            <td style="width: 80px;">Nome</td>
            <td colspan="8"><input style="width: 580px;" type="text" name="nome" id="nome" size="50" maxlength="250" placeholder="Digite nome aqui" value=""></td>
        </tr>
        <tr>
            <td style="width: 80px;">Dt. Inicio</td>
            <td style="width: 100px;"><input style="width: 220px;" type="date" class="data" name="data1" id="data1"/></td>
            <td style="width: 80px;">Dt. Fim</td>
            <td style="width: 100px;"><input style="width: 222px;" type="date" class="data" name="data2" value="<?=date('Y-m-d')?>"/></td>
        </tr>
        <tr>
            <td>Valor</td>
            <td>
                <input style="width: 222px" type="text" name="valor" id="valor" class="real" maxlength="6"/>
            </td>
        </tr>
    </table>
    <button onclick="procurarServico(false)">Procurar</button>
    <button onclick="abreRelatorioServico()">Gera PDF</button>
    <button onclick="abreRelatorio2Servico()">Gera Excel</button>    
</form>
<?php include("./carregando.php");?>
<div id="listagem"></div>
