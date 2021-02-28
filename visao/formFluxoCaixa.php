<form id="ffluxo" target="_blank" method="POST" action="../control/ProcurarFluxoCaixaRelatorio.php" onsubmit="return false;">   
    <input type="hidden" name="html" id="html" value=""/>
    <input type="hidden" name="tipo" id="tipo" value="pdf"/>
    <input type="hidden" name="nome_pagina" id="nome_pagina" value="Relatório Fluxo de Caixa"/> 
    <table class="tabela_formulario">
        <tr>
            <td>Movimentação</td>
            <td>
                <select style="width: 205px;" name="movimentacao" id="movimentacao" title="Selecione aqui a movimentação do caixa">
                    <option value="T" title="Traz créditos e débitos juntos">Todos</option>
                    <option value="R" title="Traz somente créditos">Crédito</option>
                    <option value="D" title="Traz somente débitos">Débito</option>
                </select>
            </td>
            <td>Nome</td>
            <td colspan="8">
                <input style="width: 200px;" type="text" name="nome" size="25" maxlength="250" title="Pesquisa por descrição da conta" placeholder="Digite nome aqui" value=""/>
            </td>
        </tr>
        <tr>
            <td>Dt. Inicio</td>
            <td><input type="date" class="data" name="data" title="Digite aqui a data de inicio para o periodo de pesquisa"/></td>
            <td>Dt. Fim</td>
            <td><input type="date" class="data" name="data2" title="Digite aqui a data de final para o periodo de pesquisa"/></td>
        </tr>
        <?php if($_SESSION["codnivel"] == 1){?>
        <tr>
            <td>Unidade</td>
            <td>
                <select name="unidade" id="unidade">
                <?php
                $sql = "select codempresa, razao from empresa order by razao";
                $resempresa2 = $conexao->comando($sql);
                $qtdempresa2 = $conexao->qtdResultado($resempresa2);
                if($qtdempresa2 > 0){
                    echo '<option value="">--Selecione--</option>';
                    while($empresa2 = $conexao->resultadoArray($resempresa2)){
                        echo '<option value="',$empresa2["codempresa"],'">',$empresa2["razao"],'</option>';
                    }
                }else{
                    echo '<option value="">--Nada encontrado--</option>';
                }
                ?>
                </select>
            </td>
            <td></td>
            <td></td>
        </tr>
        <?php }?>
    </table>
    <?php 
    if($nivelp["procurar"] == 1){?>
        <button onclick="procurarFluxo(false)" class="btn btn-info">Procurar</button>
        <button onclick="abreRelatorioFluxo()">Gera PDF</button>
        <button onclick="abreRelatorio2Fluxo()">Gera Excel</button>
    <?php }?>    
</form>
<?php include("./carregando.php");?>
<div id="listagem"></div>

<form action="Excel.php" method="post" target="_blank" id="ffluxo2" name="ffluxo2">
    <input type="hidden" name="html" id="html2" value=""/>
    <input type="hidden" name="nome_pagina" id="nome_pagina" value="Relatório Fluxo de Caixa"/> 
</form>