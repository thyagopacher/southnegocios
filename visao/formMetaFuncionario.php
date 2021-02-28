<form id="fmeta" action="" onsubmit="return false;" method="POST">
    <input type="hidden" name="codmeta" id="codmeta"  value="<?php if (isset($meta["codmeta"])) {
    echo $meta["codmeta"];
} else {
    echo "";
} ?>"/>                            
    <table class="tabela_formulario">
        <tr>
            <td>Colaborador</td>
            <td>
                <select name="codfuncionario" id="codfuncionario">
                    <?php
                    $resFuncionario = $conexao->comando("select codpessoa, nome from pessoa where codcategoria not in(1,6) and status = 'a' order by nome");
                    $qtdFuncionario = $conexao->qtdResultado($resFuncionario);
                    if ($qtdFuncionario > 0) {
                        echo '<option value="">--Selecione--</option>';
                        while ($funcionario = $conexao->resultadoArray($resFuncionario)) {
                            if (isset($meta["codfuncionario"]) && $meta["codfuncionario"] == $funcionario["codpessoa"]) {
                                echo '<option selected value="', $funcionario["codpessoa"], '">', $funcionario["nome"], '</option>';
                            } else {
                                echo '<option value="', $funcionario["codpessoa"], '">', $funcionario["nome"], '</option>';
                            }
                        }
                    } else {
                        echo '<option value="">--Nada encontrado--</option>';
                    }
                    ?>
                </select>
            </td>
            <td>Meta</td>
            <td>
                <input type="text" name="valor" id="valorMeta" class="real" value="<?php if (isset($meta["valor"])) {
                        echo number_format($meta["valor"], 2, ",", "");
                    } ?>"/>
            </td>
        </tr>
        <tr>
            <td>Dt. Inicio</td>
            <td>
                <input type="date" name="dtinicio" id="dtinicio" value="<?php if (isset($meta["dtinicio"])) {
                        echo $meta["dtinicio"];
                    } else {
                        echo date('Y-m-d');
                    } ?>"/>
            </td>
            <td>Dt. Fim</td>
            <td>
                <input type="date" name="dtfim" id="dtfim" value="<?php if (isset($meta["dtfim"])) {
        echo $meta["dtfim"];
    } else {
        echo date('Y-m-d');
    } ?>"/>
            </td>
        </tr>
    </table>
<?php
if ($nivelp["inserir"] == 1) {
    echo '<input type="button" name="submit" id="btinserirMetaFuncionario" value="Cadastrar" onclick="inserirMetaFuncionario()"/>';
}
if ($nivelp["atualizar"] == 1) {
    echo '<input style="margin-left: 5px; display: none" type="button" name="submit" value="Atualizar" id="btatualizarMetaFuncionario" onclick="atualizarMetaFuncionario()"/>';
}
if ($nivelp["excluir"] == 1) {
    echo '<button style="margin-left: 5px; display: none" id="btexcluirMetaFuncionario" onclick="excluirMetaFuncionario()">Excluir</button>';
}
echo '<button style="margin-left: 5px; display: none" id="btnovoMetaFuncionario" onclick="btNovoMetaFuncionario()">Novo</button>';
?>
</form>

<div class="progress">
    <div class="bar"></div>
    <div class="percent">0%</div>
</div>
<div id="status"></div>
