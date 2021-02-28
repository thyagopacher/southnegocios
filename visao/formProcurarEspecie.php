<form id="fpespecie" action="../control/ProcurarEspecieRelatorio.php" target="_blank" method="POST" onsubmit="return false;">                    
    <table class="tabela_formulario">
        <input type="hidden" name="tipo" id="tipo" value="pdf"/>
        <tr>
            <td style="width: 80px;">Nome</td>
            <td colspan="8"><input style="width: 580px;" type="text" name="nome" size="50" maxlength="250" placeholder="Digite nome aqui" value=""></td>
        </tr>
        <tr>
            <td style="width: 80px;">Dt. Inicio</td>
            <td style="width: 100px;"><input style="width: 200px;" type="date" class="data" name="data1"/></td>
            <td style="width: 80px;">Dt. Fim</td>
            <td style="width: 100px;"><input style="width: 222px;" type="date" class="data" name="data2"/></td>
        </tr>
        
    </table>
    <button onclick="procurarEspecie(false)">Procurar</button>
    <button onclick="abreRelatorioEspecie()">Gera PDF</button>
    <button onclick="abreRelatorio2Especie()">Gera Excel</button>    
    
</form>
<?php include("./carregando.php");?>
<div id="listagem"></div>
