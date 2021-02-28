<form id="fprateio" action="../control/ProcurarRateioRelatorio.php" target="_blank" role="form" class="form-horizontal form-groups-bordered" method="POST" onsubmit="return false;">               
    <table class="tabela_formulario">
        <input type="hidden" name="rateio" id="rateio" value="s"/>
        <input type="hidden" name="movimentacao" id="movimentacao" value="R"/>
        <input type="hidden" name="tipo" id="tipo" value="pdf"/>
        <tr>
            <td style="width: 80px;">Nome</td>
            <td colspan="8"><input style="width: 580px;" type="text" name="nome" size="50" maxlength="250" placeholder="Digite nome aqui" value=""></td>
        </tr>
        <tr>
            <td style="width: 80px;">Dt. Inicio</td>
            <td style="width: 100px;"><input style="width: 200px;" type="date" class="data" name="data"/></td>
            <td style="width: 80px;">Dt. Fim</td>
            <td style="width: 100px;"><input style="width: 222px;" type="date" class="data" name="data2"/></td>
        </tr>
        <tr>
            <td>Tipo</td>
            <td>
                <select style="width: 205px;" name="codtipo" title="Escolha aqui o tipo de sua conta">
                    <?php
                    $restipo = $conexao->comando("select * from tipoconta");
                    $qtdtipo = $conexao->qtdResultado($restipo);
                    if ($qtdtipo > 0) {
                        echo '<option value="">--Selecione--</option>';
                        while ($tipo = $conexao->resultadoArray($restipo)) {
                            echo '<option value="', $tipo["codtipo"], '">', $tipo["nome"], '</option>';
                        }
                    } else {
                        echo '<option value="">Nada encontrado</option>';
                    }
                    ?>
                </select>                 
            </td>
            <td>Valor</td>
            <td>
                <input style="width: 222px" type="text" name="valor" id="valor" class="real" maxlength="6"/>
            </td>
        </tr>
    </table>
    <button onclick="procurarRateio(false)">Procurar</button>
    <button onclick="abreRelatorioRateio()">Gera PDF</button>
    <button onclick="abreRelatorio2Rateio()" title="Geração com gráfico">Gera Excel</button>    
</form>
<?php include("./carregando.php");?>
<div id="listagemRateio"></div>
