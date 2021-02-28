<form action="<?=$action?>" id="flink" role="form" autocomplete="on" method="post">
    <table class="tabela_formulario">
        <input type="hidden" name="codlink" id="codlink"  value="<?php if (isset($link["codlink"])) {echo $link["codlink"];}?>"/>                                   
        <tr>
            <td style="width: 50px;">Nome</td>
            <td colspan="3">
                <input style="width: 590px;" type="text" required name="nome" id="nome" size="50" maxlength="50" placeholder="Digite seu nome aqui" value="<?php if (isset($link["nome"])) {echo $link["nome"];}?>"/>                
            </td>
        </tr>
        
        <tr>
            <td>Link</td>
            <td colspan="3">
                <input type="url" name="link" id="link" style="width: 600px;" placeholder="http://www.aaa.com.br" value="<?php if(isset($link["link"]) && $link["link"] != NULL && $link["link"] != ""){echo $link["link"];}?>"/>
            </td>
        </tr>

    </table>
        <?php
        
        if (!isset($link["codlink"])) {
            if ($nivelp["inserir"] == 1) {
                echo '<input type="submit" name="submit" value="Cadastrar"/>';
            }
        } elseif (isset($link["codlink"])) {
            if ($nivelp["atualizar"] == 1) {
                echo '<input type="submit" name="submit" value="Atualizar"/>';
            }
            if ($nivelp["excluir"] == 1) {
                echo '<button style="margin-left: 10px;" onclick="excluirLink()">Excluir</button>';
            }
            echo '<button style="margin-left: 10px;" onclick="btNovoLink()">Novo</button>';
        }
        ?>    
</form>