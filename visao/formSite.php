<?php
    $site = $conexao->comandoArray("select * from site where codsite = 1");
    if(isset($site) && isset($site["codsite"])){
        $action = "../control/AtualizarSite.php";
    }else{
        $action = "../control/InserirSite.php";
    }
?>
<form id="fsite" action="<?= $action ?>" autocomplete="off" method="POST">
    <table class="tabela_formulario">
        <input type="hidden" name="codsite" id="codsite"  value="<?php if (isset($site["codsite"])) {echo $site["codsite"]; }?>"/>  
        <tr>
            <td>Nome</td>
            <td colspan="3"><input type="text" name="nome" id="nome"  value="<?php if (isset($site["nome"])) {echo $site["nome"]; }?>"/></td>
        </tr>
        <tr>
            <td>Imagem</td>
            <td colspan="3">
                <input type="file" name="logo" id="input_logo"/>
                <div id="logoCarregada">
                    <?php
                    if (isset($site["logo"]) && $site["logo"] != NULL && $site["logo"] != "") {
                        echo '<img id="input_img_carregada" width="150" src="../visao/recursos/img/', $site["logo"], '" alt="Imagem do site ', $site["nome"], '"/>';
                    }
                    ?>
                </div>   
            </td>
        </tr>
        <tr>
            <td>E-mail</td>
            <td colspan="3">
                <input type="email" style="width: 588px;"  autocomplete="off" required name='email' id="email" size="50" maxlength="250" value="<?php
                if (isset($site["email"])) {
                    echo $site["email"];
                } else {
                    echo "Digite e-mail";
                }
                ?>" placeholder="Digite e-mail">
            </td>
        </tr>    
        <tr>
            <td>Telefone fixo</td>
            <td>
                <input style="width: 225px;" type="text" name="telefone" id="telefone" class="telefone"   value="<?php if (isset($site["telefone"])) {
                    echo $site["telefone"];}?>" title="Digite aqui telefone fixo" placeholder="(00)0000-0000">
            </td>
            <td>Celular</td>
            <td colspan="3">
                <input style="width: 214px;" required type="text" name="celular" id="celular" class="telefone"   value="<?php if (isset($site["celular"])) {echo $site["celular"];} else { echo ""; }?>" title="Digite aqui celular" placeholder="(00)0000-0000">
            </td>
        </tr>
        <tr>
            <td>Skype</td>
            <td>
                <input style="width: 225px;" type="text" name="skype" id="skype"   value="<?php
                if (isset($site["skype"])) {
                    echo $site["skype"];
                } else {
                    echo "";
                }
                ?>" title="Digite aqui skype">
            </td>
        <td>Facebook</td>
        <td>
            <input style="width: 214px;" type="text" name="facebook" id="facebook"   value="<?php
            if (isset($site["facebook"])) {
                echo $site["facebook"];
            } else {
                echo "";
            }
            ?>" title="Digite aqui facebook">
        </td>
        <tr>
            <td>Palavra chave</td>
            <td colspan="3">
                <textarea style="width: 595px; max-width: 595px;  min-width: 595px;" title="boas palavras chave fazem seu site subir rapidamente em visitação" name="palavrachave"><?php if(isset($site["palavrachave"])){echo $site["palavrachave"];}?></textarea>
            </td>
        </tr>
        <tr>
            <td>Descrição</td>
            <td colspan="3">
                <textarea style="width: 595px; max-width: 595px;  min-width: 595px;" name="descricao"><?php if(isset($site["descricao"])){echo $site["descricao"];}?></textarea>               
            </td>
        </tr>
        </tr>
        <?php
        if (!isset($site["codsite"])) {
            $display = "style='display: none'";
        } elseif (isset($site["codsite"])) {
            $display = "";
        }
        ?>    

    </table>
            <?php
            if (!isset($site["codsite"])) {
                if ($nivelp["inserir"] == 1) {
                    echo '<input type="submit" name="submit" id="btinserirSite" value="Cadastrar"/>';
                }
            } else {
                if ($nivelp["atualizar"] == 1) {
                    echo '<input style="margin-left: 5px;" type="submit" name="submit" id="btatualizarSite" value="Atualizar"/>';
                }
                if ($nivelp["excluir"] == 1) {
                    echo '<button style="margin-left: 5px;" onclick="excluirSite()" id="btexcluirPessoa">Excluir</button>';
                }
                if ($nivelp["inserir"] == 1) {
                    echo '<button style="margin-left: 5px;" onclick="btNovoSite()" id="btnovoPessoa">Novo</button>';
                }
            }
            ?>       
</form>


<div class="progress">
    <div class="bar"></div>
    <div class="percent">0%</div>
</div>

<div id="status"></div>
