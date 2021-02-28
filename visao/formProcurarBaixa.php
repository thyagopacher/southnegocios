<form id="fPbaixa" action="../control/ProcurarBaixaRelatorio.php" target="_blank" role="form" class="form-horizontal form-groups-bordered" method="POST" onsubmit="return false;">                       
    <table class="tabela_formulario">
        <input type="hidden" name="tipo" id="tipo" value="pdf"/>
        <tr>
            <td>Dt. Inicio</td>
            <td style="width: 300px;"><input type="date" name="data1"/></td>
            <td>Dt. Fim</td>
            <td><input type="date" name="data2"/></td>
        </tr>
        <tr>
            <td>CPF</td>
            <td><input type="text" name="cpf" maxlength="250" placeholder="Digite cpf aqui" value=""></td>
            <td>Colaborador</td>
            <td>
                <select name="codfuncionario" id="codfuncionario">
                    <?php
                    $resFuncionario = $conexao->comando("select codpessoa, nome from pessoa where codcategoria not in(1,6)");
                    $qtdFuncionario = $conexao->qtdResultado($resFuncionario);
                    if($qtdFuncionario > 0){
                        echo '<option value="">--Selecione--</option>';
                        while($funcionario = $conexao->resultadoArray()){
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
    <button onclick="procurarBaixa(false)">Procurar</button>
    <button onclick="abreRelatorioBaixa()">Gera PDF</button>
    <button onclick="abreRelatorio2Baixa()">Gera Excel</button>
</form>
<?php include("./carregando.php");?>
<div id="listagemBaixa"></div>
