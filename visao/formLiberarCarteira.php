<form id="facesso" autocomplete="on" action="<?=$action?>" method="POST" onsubmit="return false;">                   
    <table class="tabela_formulario">
    <input type="hidden" name="codacesso" id="codacesso" value="<?php if(isset($acesso["codacesso"])){echo $acesso["codacesso"];}?>"/>    
    <tr>
        <td>Carteira</td>
        <td>
            <select name="codcarteira" id="codcarteira">
                <?php
                $resCarteira = $conexao->comando("select * from carteira where codempresa = '{$_SESSION['codempresa']}' and nome <> ''");
                $qtdCarteira = $conexao->qtdResultado($resImportacao);
                if($qtdCarteira > 0){
                    echo '<option value="">--Selecione--</option>';
                    while($carteira = $conexao->resultadoArray($resCarteira)){
                        echo '<option value="',$carteira["codcarteira"],'">',$carteira["nome"],'</option>';
                    }
                }else{
                    echo '<option value="">Nada encontrado</option>';
                }
                ?>
            </select>
        </td>
        <td>Operador</td>
        <td>
            <select name="codoperador" id="codoperador">
                <?php
                    $sql = "select pessoa.codpessoa, pessoa.nome 
                    from pessoa 
                    inner join nivel on nivel.codnivel = pessoa.codnivel
                    where pessoa.codempresa = '{$_SESSION['codempresa']}' 
                    order by nome";
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
    <?php 
    echo '<button style="margin-left: 10px" id="btinserirAcessoOperador" onclick="inserirAcessoOperador()">Cadastrar</button>';
    echo '<button style="margin-left: 10px; display: none" id="btatualizarAcessoOperador" onclick="atualizarAcessoOperador()">Atualizar</button>';
    echo '<button style="margin-left: 10px; display: none" id="btexcluirAcessoOperador" onclick="excluirAcessoOperador()">Excluir</button>';
    echo '<button style="margin-left: 10px; display: none" id="btnovoAcessoOperador" onclick="btNovoAcessoOperador()">Novo</button>';
    ?>
</form>
