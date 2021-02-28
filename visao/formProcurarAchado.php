<form id="fpachado" action="../control/ProcurarAchadoRelatorio.php" target="_blank" role="form" class="form-horizontal form-groups-bordered" method="POST" onsubmit="return false;">                       
    <table class="tabela_formulario">
        <input type="hidden" name="html" id="html" value=""/>
        <input type="hidden" name="tipo" id="tipo" value="pdf"/>
        <input type="hidden" name="nome_pagina" id="nome_pagina" value="Relatório de Achados e perdidos"/>
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
        <tr>
            <td>Tipo</td>
            <td>
                <select style="width: 185px;" name="codtipo" id="codtipo">
                    <?php
                    $restipo = $conexao->comando("select * from tipoachado where codempresa = '{$_SESSION['codempresa']}' order by nome");
                    $qtdtipo = $conexao->qtdResultado($restipo);
                    if($qtdtipo > 0){
                        echo '<option value="">--Selecione--</option>';
                        while($tipo = $conexao->resultadoArray($restipo)){
                            echo '<option value="',$tipo["codtipo"],'">',$tipo["nome"],'</option>';
                        }
                    }else{
                        echo '<option value="">--Nada encontrado--</option>';
                    }
                    ?>
                </select>
            </td>
            <td>Status</td>
            <td>
                <select style="width: 185px;"  name="codstatus" id="codstatus">
                    <?php
                    $resstatus = $conexao->comando("select * from statusachado order by nome");
                    $qtdstatus = $conexao->qtdResultado($resstatus);
                    if($qtdtipo > 0){
                        echo '<option value="">--Selecione--</option>';
                        while($status = $conexao->resultadoArray($resstatus)){
                            echo '<option value="',$status["codstatus"],'">',$status["nome"],'</option>';
                        }
                    }else{
                        echo '<option value="">--Nada encontrado--</option>';
                    }
                    ?>
                </select>                
            </td>            
        </tr>
    </table>
    <button onclick="procurarAchado(false)">Procurar</button>
    <button onclick="abreRelatorioAchado()">Gera PDF</button>
    <button onclick="abreRelatorio2Achado()">Gera Excel</button>
</form>
<?php include("./carregando.php");?>
<div id="listagem"></div>

<form action="Excel.php" method="post" target="_blank" id="fpachado2" name="fpachado2">
    <input type="hidden" name="descrição_pagina" id="descrição_pagina" value="Relatório de Achados e perdidos"/>
    <input type="hidden" name="html" id="html2" value=""/>
</form>