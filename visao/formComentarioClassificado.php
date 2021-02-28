<form id="fpclassificado" action="../control/ProcurarComentarioClassificadoRelatorio.php" target="_blank" method="POST" onsubmit="return false;">                   
    <table class="tabela_formulario">
        <input type="hidden" name="ehMorador" id="ehMorador" value="<?php if(isset($ehMorador) && $ehMorador == true){echo "s";}?>"/>
        <input type="hidden" name="nome_pagina" id="nome_pagina" value="Relatório de Comentários Classificados"/>
        <input type="hidden" name="nome_pagina" id="codclassificado" value="<?=$_GET["codclassificado"]?>"/>
        <input type="hidden" name="tipo" id="tipo" value="pdf"/>
        <tr>
            <td>Dt. Inicio</td>
            <td><input type="date" class="data" name="data"/></td>
            <td>Dt. Fim</td>
            <td><input type="date" class="data" name="data2"/></td>
        </tr>
    </table>
    <button onclick="procurarComentarioClassificado(false)" class="btn btn-info">Procurar</button>
    <button onclick="abreRelatorioComentario()">Gera PDF</button>
    <button onclick="abreRelatorio2Comentario()">Gera Excel</button>    
</form>
<?php include("./carregando.php");?>
<div id="listagem"></div>
