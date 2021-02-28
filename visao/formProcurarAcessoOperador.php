<form id="fpacesso" autocomplete="on" action="<?= $action ?>" method="POST" onsubmit="return false;">                   
    <table class="tabela_formulario">
        <tr>
            <td>Dt. Inicio</td>
            <td><input type="date" name="data1" id="data1" class="data" style="width: 210px;"/></td>
            <td>Dt. Fim</td>
            <td><input type="date" name="data2" id="data2" class="data" style="width: 210px;"/></td>
        </tr>
        <tr>
            <td>Carteira</td>
            <td>
                <select style="width: 215px;" name="carteira" id="carteira">
                    <?php
                    $resImportacao = $conexao->comando("select distinct nome from importacao order by nome");
                    $qtdImportacao = $conexao->qtdResultado($resImportacao);
                    if ($qtdImportacao > 0) {
                        echo '<option value="">--Selecione--</option>';
                        while ($importacao = $conexao->resultadoArray($resImportacao)) {
                            echo '<option>', $importacao["nome"], '</option>';
                        }
                    } else {
                        echo '<option value="">Nada encontrado</option>';
                    }
                    ?>
                </select>
            </td>
            <td>Operador</td>
            <td>
                <select name="operador" id="operador" style="width: 215px;">
                    <?php
                    $sql = "select pessoa.codpessoa, pessoa.nome 
                from pessoa 
                inner join nivel on nivel.codnivel = pessoa.codnivel and nivel.codempresa = pessoa.codempresa 
                where pessoa.codempresa = '{$_SESSION['codempresa']}' and nivel.nome = 'OPERADOR' order by nome";
                    $resOperador = $conexao->comando($sql);
                    $qtdOperador = $conexao->qtdResultado($resOperador);
                    if ($qtdOperador > 0) {
                        echo '<option value="">--Selecione--</option>';
                        while ($operador = $conexao->resultadoArray($resOperador)) {
                            echo '<option value="', $operador["codpessoa"], '">', $operador["nome"], '</option>';
                        }
                    } else {
                        echo '<option value="">Nada encontrado</option>';
                    }
                    ?>
                </select>
            </td>
        </tr>

    </table>
    <?php echo '<button id="btprocurarAcessoOperador" onclick="procurarAcessoOperador(false)">Procurar</button>';?>
</form>

<div id="listagemAcessoOperador"></div>
