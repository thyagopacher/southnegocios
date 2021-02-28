<form action="<?=$action?>" id="fmanual" role="form" autocomplete="on" method="post">
    <table class="tabela_formulario">
        <input type="hidden" name="codmanual" id="codmanual"  value="<?php if (isset($manual["codmanual"])) {echo $manual["codmanual"];}?>"/>                       
        <tr>
            <td>Código</td>   
            <td>
                <input type="text" name="codbanco1" id="codbanco1" value="" title="Digite aqui para buscar o banco"/>
            </td>
            <td>Banco</td>
            <td>
                <select name="codbanco" id="codbanco" required style="width: 230px;">
                    <?php
                    $resbanco = $conexao->comando("select * from banco where nome <> '' order by nome");
                    $qtdbanco = $conexao->qtdResultado($resbanco);
                    if ($qtdbanco > 0) {
                        echo '<option value="">--Selecione--</option>';
                        while ($banco = $conexao->resultadoArray($resbanco)) {
                            echo '<option value="', $banco["codbanco"], '">', $banco["nome"], '</option>';
                        }
                    } else {
                        echo '<option value="">--Nada encontrado--</option>';
                    }
                    ?>
                </select>
            </td>            
        </tr>            
        <tr>
            <td style="width: 50px;">Nome</td>
            <td colspan="3">
                <input style="width: 590px;" type="text" required name="nome" id="nome" size="50" maxlength="50" placeholder="Digite seu nome aqui" value="<?php if (isset($manual["nome"])) {echo $manual["nome"];}?>"/>                
            </td>
        </tr>
        
        <tr>
            <td>Arquivo</td>
            <td colspan="3">
                <input type="file" name="arquivo" id="arquivo"/>
                <?php
                if(isset($manual["arquivo"]) && $manual["arquivo"] != NULL && $manual["arquivo"] != ""
                    && (strstr($manual["arquivo"], '.png') || strstr($manual["arquivo"], '.jpg') || strstr($manual["arquivo"], '.jpeg'))){
                    echo '<a id="link_imagem" target="_blank" href="../arquivos/',$manual["arquivo"],'"><img width="150" src="../arquivos/',$manual["arquivo"],'" alt="Imagem da manual"/></a>';
                    
                }
                ?>
            </td>
        </tr>

    </table>
        <?php
        
        if (!isset($manual["codmanual"])) {
            if ($nivelp["inserir"] == 1) {
                echo '<input type="submit" name="submit" value="Cadastrar"/>';
            }
        } elseif (isset($manual["codmanual"])) {
            if ($nivelp["atualizar"] == 1) {
                echo '<input type="submit" name="submit" value="Atualizar"/>';
            }
            if ($nivelp["excluir"] == 1) {
                echo '<button style="margin-left: 10px;" onclick="excluirManual()">Excluir</button>';
            }
            echo '<button style="margin-left: 10px;" onclick="btNovoManual()">Novo</button>';
        }
        ?>    
</form>