<form id="fcspecie" role="form" autocomplete="on" method="post" onsubmit="return false;">
    <table class="tabela_formulario">
        <input type="hidden" name="codcspecie" id="codcspecie"  value="<?php if (isset($cspecie["codcspecie"])) {echo $cspecie["codcspecie"];}?>"/>                       
        <tr>
            <td style="width: 50px;">Nome</td>
            <td colspan="3">
                <input style="width: 582px;" type="text" list="especies" required name="nome" id="nome" size="50" maxlength="250" placeholder="Digite seu nome aqui" value="<?php if (isset($especie["nome"]) && $especie["nome"] != NULL && $especie["nome"] != "") {echo $especie["nome"];}?>"/>
                <datalist id="especies">
                    <?php
                    $resnome = $conexao->comando("select distinct nome from cspecie where codespecie = '{$_SESSION["codespecie"]}'");
                    $qtdnome = $conexao->qtdResultado($resnome);
                    if ($qtdnome > 0) {
                        while ($nome = $conexao->resultadoArray($resnome)) {
                            echo '<option>', $nome["nome"], '</option>';
                        }
                    }
                    ?>
                </datalist>                
            </td>
        </tr>

        <tr>
            <td>Num.</td>
            <td colspan="3">
                <input type="text" name="numinss" id="numinss" value="<?php if(isset($especie["numinss"]) && $especie["numinss"] != NULL && $especie["numinss"] != ""){echo $especie["numinss"];}?>"/>
            </td>
        </tr>
    </table>
        <?php
        if (!isset($especie["codespecie"])) {
            if ($nivelp["inserir"] == 1) {
               echo '<button style="margin-left: 10px;" onclick="inserirEspecie()">Inserir</button>';
            }
        } elseif (isset($especie["codespecie"])) {
            if ($nivelp["atualizar"] == 1) {
                echo '<button style="margin-left: 10px;" onclick="atualizarEspecie()">Atualizar</button>';
            }
            if ($nivelp["excluir"] == 1) {
                echo '<button style="margin-left: 10px;" onclick="excluirEspecie()">Excluir</button>';
            }
            echo '<button style="margin-left: 10px;" onclick="btNovoEspecie()">Novo</button>';
        }
        ?>    
</form>