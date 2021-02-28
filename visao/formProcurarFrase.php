<form id="fpcomunicado" action="../control/ProcurarFraseRelatorio.php" target="_blank" method="POST" onsubmit="return false;">                   
    <table class="tabela_formulario">
        <input type="hidden" name="tipo" id="tipo" value="pdf"/>
        <tr>
            <td>Dt. Inicio</td>
            <td style="width: 320px;"><input style="width: 205px;" type="date" class="data" name="data1"/></td>
            <td>Dt. Fim</td>
            <td><input style="width: 200px" type="date" class="data" name="data2"/></td>
        </tr>
    </table>
    <button onclick="procurarFrase(false)">Procurar</button>
    <button onclick="abreRelatorioFrase()">Gerar PDF</button>
    <button onclick="abreRelatorio2Frase()">Gerar Excel</button>    
</form>
<?php include("./carregando.php");?>
* Para uma pesquisa mais rápida use os filtros e um periodo pequeno<br>
<div id="listagemFrase"></div>
