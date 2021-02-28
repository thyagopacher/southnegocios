<form id="fpclassificado" action="../control/ProcurarClassificadoRelatorio.php" target="_blank" method="POST" onsubmit="return false;">                   
    <table class="tabela_formulario">
        <input type="hidden" name="ehMorador" id="ehMorador" value="<?php if(isset($ehMorador) && $ehMorador == true){echo "s";}?>"/>
        <input type="hidden" name="nome_pagina" id="nome_pagina" value="Relatório de Classificados"/>
        <input type="hidden" name="tipo" id="tipo" value="pdf"/>
        <tr>
            <td>Título</td>
            <td colspan="8"><input style="width: 618px;" type="text" name="nome" size="50" maxlength="250" placeholder="Digite nome aqui" value=""></td>
        </tr>
        <tr>
            <td>Dt. Inicio</td>
            <td><input style="width: 205px;" type="date" class="data" name="data"/></td>
            <td>Dt. Fim</td>
            <td><input style="width: 200px" type="date" class="data" name="data2"/></td>
        </tr>
        <?php
        if(isset($ehMorador) && $ehMorador == true){
            include("comboMorador.php"); 
        } 
        ?>
    </table>
    <button onclick="procurarClassificado(false)" class="btn btn-info">Procurar</button>
    <button onclick="abreRelatorio()">Gera PDF</button>
    <button onclick="abreRelatorio2()">Gera Excel</button>    
</form>
<?php include("./carregando.php");?>
<div id="listagem"></div>
