<form id="fporgao" action="../control/ProcurarOrgaoPagadorRelatorio.php" target="_blank" method="POST" onsubmit="return false;">                       
    <table class="tabela_formulario">
        <input type="hidden" name="html" id="html" value=""/>
        <input type="hidden" name="tipo" id="tipo" value="pdf"/>
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
    <button onclick="procurarOrgaoPagador(false)">Procurar</button>
    <button onclick="abreRelatorioOrgaoPagador()">Gera PDF</button>
    <button onclick="abreRelatorio2OrgaoPagador()">Gera Excel</button>
</form>
<?php include("./carregando.php");?>
<div id="listagemOrgaoPagador"></div>
