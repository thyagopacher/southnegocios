<form id="fpmeta" action="../control/ProcurarMetaFuncionarioRelatorio.php" target="_blank" method="POST" onsubmit="return false;">                       
    <table class="tabela_formulario">
        <input type="hidden" name="html" id="html" value=""/>
        <input type="hidden" name="tipo" id="tipo" value="pdf"/>

        <tr>
            <td>Dt. Inicio</td>
            <td style="width: 300px;"><input type="date" class="data" name="data1"/></td>
            <td>Dt. Fim</td>
            <td><input type="date" class="data" name="data2"/></td>
        </tr>
        <tr>
            <td>Colaborador</td>
            <td>
                <select name="codfuncionario" id="codfuncionario">
                    <?php
                    $resFuncionario = $conexao->comando("select * from pessoa where codcategoria not in(1,6) order by nome");
                    $qtdFuncionario = $conexao->qtdResultado($resFuncionario);
                    if($qtdFuncionario > 0){
                        echo '<option value="">--Selecione--</option>';
                        while($funcionario = $conexao->resultadoArray($resFuncionario)){
                            echo '<option value="',$funcionario["codpessoa"],'">',$funcionario["nome"],'</option>';
                        }
                    }else{
                        echo '<option value="">--Nada encontrado--</option>';
                    }
                    ?>
                </select>                
            </td>
        </tr>       
    </table>
    <button onclick="procurarMetaFuncionario(false)">Procurar</button>
    <button onclick="abreRelatorioMetaFuncionario()">Gera PDF</button>
    <button onclick="abreRelatorio2MetaFuncionario()">Gera Excel</button>
</form>
<?php include("./carregando.php");?>
<div id="listagemMetaFuncionario"></div>
