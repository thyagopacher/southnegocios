<form id="fremaneja" method="post" onsubmit="return false;">      
    <input type="hidden" name="codramal" value="<?php if(isset($ramal["codramal"])){echo $ramal["codramal"];}?>"/>
    <table class="tabela_formulario">
        <tr>
            <td>Operador</td>
            <td>
                <select style="width: 135px;" name="operador" id="operador">
                    <?php
                    $sql = "select pessoa.nome, pessoa.codpessoa 
                    from pessoa 
                    inner join nivel on nivel.codnivel = pessoa.codnivel
                    where pessoa.codempresa = '{$_SESSION['codempresa']}' and pessoa.codcategoria not in(1,6) and nivel.nome = 'OPERADOR'";
                    $respessoa = $conexao->comando($sql);
                    $qtdpessoa = $conexao->qtdResultado($respessoa);
                    if($qtdpessoa > 0){
                        echo '<option value="">--Selecione--</option>';
                        while($pessoa = $conexao->resultadoArray($respessoa)){
                            echo '<option value="',$pessoa["codpessoa"],'">',$pessoa["nome"],'</option>';
                        }
                    }else{
                        echo '<option value="">--Nada encontrado--</option>';
                    }
                    ?>
                </select>
            </td>
            <td>Cliente</td>
            <td>
                <select name="cliente" id="cliente">
                    <?php
                    $rescliente = $conexao->comando("select pessoa.codpessoa, pessoa.nome from pessoa where pessoa.codcategoria in(1,6) and codempresa = '{$_SESSION['codempresa']}'");
                    $qtdcliente = $conexao->qtdResultado($rescliente);
                    if($qtdcliente > 0){
                        echo '<option value="">--Selecione--</option>';
                        while($cliente = $conexao->resultadoArray($rescliente)){
                            echo '<option value="',$cliente["codpessoa"],'">',$cliente["nome"],'</option>';
                        }
                    }else{
                        echo '<option value="">--Nada encontradoo--</option>';
                    }
                    ?>
                </select>
                <??>
            </td>
        </tr>
        <tr>
            <td>Data</td>
            <td>
                <input style="width: 130px;" type="date" name="dtagenda" id="dtagenda" value=""/>
            </td>
            <td></td>
            <td></td>
        </tr>
   
    </table>
    <?php echo '<input type="button" name="submit" value="Cadastrar" onclick="remanejaAgenda()"/>';?> 
</form>