<form action="<?=$action?>" id="fcomunicado" role="form" autocomplete="on" method="post">
    <table class="tabela_formulario">
        <input type="hidden" name="codcomunicado" id="codcomunicado"  value="<?php if (isset($comunicado["codcomunicado"])) {echo $comunicado["codcomunicado"];}?>"/>                                   
        <tr>
            <td style="width: 50px;">Nome</td>
            <td colspan="3">
                <input style="width: 590px;" type="text" required name="nome" id="nome" size="50" maxlength="50" placeholder="Digite seu nome aqui" value="<?php if (isset($comunicado["nome"])) {echo $comunicado["nome"];}?>"/>                
            </td>
        </tr>
        
        <tr>
            <td>Arquivo</td>
            <td colspan="3">
                <input type="file" name="arquivo" id="arquivo"/>
                <?php
                if(isset($comunicado["arquivo"]) && $comunicado["arquivo"] != NULL && $comunicado["arquivo"] != ""
                    && (strstr($comunicado["arquivo"], '.png') || strstr($comunicado["arquivo"], '.jpg') || strstr($comunicado["arquivo"], '.jpeg'))){
                    echo '<a id="link_imagem" target="_blank" href="../arquivos/',$comunicado["arquivo"],'"><img width="150" src="../arquivos/',$comunicado["arquivo"],'" alt="Imagem da comunicado"/></a>';
                    
                }
                ?>
            </td>
        </tr>

    </table>
        <?php
        
        if (!isset($comunicado["codcomunicado"])) {
            if ($nivelp["inserir"] == 1) {
                echo '<input type="submit" name="submit" value="Cadastrar"/>';
            }
        } elseif (isset($comunicado["codcomunicado"])) {
            if ($nivelp["atualizar"] == 1) {
                echo '<input type="submit" name="submit" value="Atualizar"/>';
            }
            if ($nivelp["excluir"] == 1) {
                echo '<button style="margin-left: 10px;" onclick="excluirComunicado()">Excluir</button>';
            }
            echo '<button style="margin-left: 10px;" onclick="btNovoComunicado()">Novo</button>';
        }
        ?>    
</form>