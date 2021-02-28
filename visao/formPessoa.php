<form id="fpessoa" action="<?= $action ?>" autocomplete="off" method="POST">
    <table class="tabela_formulario">
        <input type="hidden" name="codempresa" id="codempresa"  value="<?php if (isset($_GET["codempresa"])) {
    echo $_GET["codempresa"];
} else {
    echo "";
} ?>"/>
        <input type="hidden" name="codpessoa" id="codpessoa"  value="<?php
        if (isset($pessoa["codpessoa"])) {
            echo $pessoa["codpessoa"];
        }
        ?>"/>  
        <tr>
            <td>Nível</td>
            <td>
                <select style="width: 225px;" name="codnivel" id="codnivel" <?php if(isset($_SESSION["codnivel"]) && $_SESSION["codnivel"] != 1){echo "disabled";}?> required>
                    <?php
                    
                    $sql = "select * from nivel where (nivel.padrao = 's' or nivel.codempresa = '{$_SESSION['codempresa']}') order by nivel.nome";
                    $resnivel = $conexao->comando($sql);
                    $qtdnivel = $conexao->qtdResultado($resnivel);
                    if ($qtdnivel > 0) {
                        echo '<option value="">--Selecione--</option>';
                        while ($nivel = $conexao->resultadoArray($resnivel)) {
                            if (isset($pessoa["codnivel"]) && $pessoa["codnivel"] == $nivel["codnivel"]) {
                                echo '<option selected value="', $nivel["codnivel"], '">', $nivel["nome"], '</option>';
                            } else {
                                echo '<option value="', $nivel["codnivel"], '">', $nivel["nome"], '</option>';
                            }
                        }
                    } else {
                        echo '<option value="">Nada encontrado</option>';
                    }
                    ?>
                </select>
            </td>
            <td style="width: 120px;">Status</td>
            <td>
                <select style="width: 218px;border: 1px solid red;" name="status" id="status">
                    <option value="a" <?php if (isset($pessoa["status"]) && trim($pessoa["status"]) == "a") {
                        echo "selected";
                    } ?>>Ativo</option>
                    <option value="i" <?php if (isset($pessoa["status"]) && trim($pessoa["status"]) == "i") {
                        echo "selected";
                    } ?>>Inativo</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Imagem</td>
            <td colspan="3">
                <input type="file" name="imagem" id="input_imagem"/>
                <a class="botao" href="javascript: abreTiraFoto(<?=$pessoa["codpessoa"]?>);">Foto da webcam</a>
                <a class="botao" href="javascript: excluirFoto(<?=$pessoa["codpessoa"]?>);">Excluir img</a>
                <div id="imagemCarregada">
<?php
if (isset($pessoa["imagem"]) && $pessoa["imagem"] != NULL && $pessoa["imagem"] != "") {
    if(file_exists("../arquivos/". $pessoa["imagem"])){
        echo '<img id="input_img_carregada" width="150" src="../arquivos/', $pessoa["imagem"], '" alt="Imagem da pessoa ', $pessoa["nome"], '"/>';
    }
}
?>
                </div>   
            </td>
        </tr>
        <tr>
            <td>Login</td>
            <td colspan="3">
                <input type="text" style="width: 625px;  text-transform: lowercase;"  autocomplete="off" required name="login" id="login" size="50" maxlength="250" value="<?php
                if (isset($pessoa["login"])) {echo $pessoa["login"];}else{echo 'Digite seu login';}?>" placeholder="Digite e-mail">
            </td>
        </tr>    
        <tr>
            <td>E-mail</td>
            <td colspan="3">
                <input type="email" style="width: 625px;  text-transform: lowercase;"  autocomplete="off" required name='email' id="email" size="50" maxlength="250" value="<?php
                if (isset($pessoa["email"])) {echo $pessoa["email"];}else{echo 'E-mail';}?>" placeholder="Digite e-mail">
            </td>
        </tr>    
        <tr>
            <td>Senha</td>
            <td>
                <input style="width: 225px;  text-transform: initial;" type="password " autocomplete="off"   required name='senha' id="senha" value="<?php
                if (isset($pessoa["senha"])) {
                    echo base64_decode($pessoa["senha"]);
                } else {
                    echo "";
                }
?>" placeholder="Senha">
            </td>
            <td>Recebe msg</td>
            <td>
                <select style="width: 218px;" name="recebemsg" id="recebemsg">
                    <option value="s" <?php if (isset($pessoa["recebemsg"]) && $pessoa["recebemsg"] == "s") {
                    echo "selected";
                } ?>>Sim</option>
                    <option value="n" <?php if (isset($pessoa["recebemsg"]) && $pessoa["recebemsg"] == "n") {
                    echo "selected";
                } ?>>Não</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>RG</td>
            <td>
                <input style="width: 225px;" type="text" autocomplete="off"   required name="rg" id="rg" value="<?php
                if (isset($pessoa["rg"])) {
                    echo $pessoa["rg"];
                } else {
                    echo "";
                }
                ?>" placeholder="RG">
            </td>
            <td>CPF</td>
            <td>
                <input style="width: 214px;" type="text" required name="cpf" id="cpf" maxlength="15" value="<?php
                if (isset($pessoa["cpf"])) {echo $pessoa["cpf"];}?>" placeholder="CPF">
            </td>
        </tr>
        <tr>
            <td>Sexo</td>
            <td colspan="3">
                <select style="width: 230px" name="sexo" id="sexo" required>
                    <option value="">--Selecione--</option>
                    <option value="m" <?php if (isset($pessoa["sexo"]) && $pessoa["sexo"] == "m") {
                    echo "selected";
                } ?>>Masculino</option>
                    <option value="f" <?php if (isset($pessoa["sexo"]) && $pessoa["sexo"] == "f") {
                        echo "selected";
                    } ?>>Feminino</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Nome</td>
            <td colspan="3">
                <input type="text" style="width: 625px;" required name="nome"   id="nome" size="50" maxlength="250" placeholder="Digite seu nome aqui" value="<?php
                    if (isset($pessoa["nome"])) {echo $pessoa["nome"];}
                    ?>">
            </td>
        </tr>
        <tr>
            <td>Sistema</td>
            <td colspan="3">
                <select style="width: 230px" name="sistema" id="sistema" required>
                    <option value="">--Selecione--</option>
                    <option value="1" <?php if (isset($pessoa["sistema"]) && $pessoa["sistema"] == "1") {
                    echo "selected";
                } ?>>Velho</option>
                    <option value="2" <?php if (isset($pessoa["sistema"]) && $pessoa["sistema"] == "2") {
                        echo "selected";
                    } ?>>Novo</option>
                </select>
            </td>
        </tr>
<!--        <tr>
            <td>Telefone fixo</td>
            <td>
                <input style="width: 225px;" class="telefone" type="text" name="telefone[]" id="telefone1" value="<?php if (isset($pessoa["telefone"])) {echo $pessoa["telefone"];}?>" title="Digite aqui telefone fixo" placeholder="(00)0000-0000">
            </td>
            <td>Celular</td>
            <td colspan="3">
                <input style="width: 214px;" class="telefone" type="text" name="celular[]" id="celular2" value="<?php if (isset($pessoa["celular"])) {echo $pessoa["celular"];}?>" title="Digite aqui celular" placeholder="(00)0000-0000">
            </td>
        </tr>-->
        


<?php
if (!isset($pessoa["codpessoa"])) {
    $display = "style='display: none'";
} elseif (isset($pessoa["codpessoa"])) {
    $display = "";
}
?>    

    </table>
<?php
if (!isset($_GET["codpessoa"])) {
    if ($nivelp["inserir"] == 1) {
        echo '<input type="submit" name="submit" id="btinserirPessoa" value="Cadastrar"/>';
    }
} else {
    if ($nivelp["atualizar"] == 1 || ($_GET["codpessoa"] == $_SESSION['codpessoa'])) {
        echo '<input style="margin-left: 5px;" type="submit" name="submit" id="btatualizarPessoa" value="Atualizar"/>';
    }
    if ($nivelp["excluir"] == 1) {
        echo '<button style="margin-left: 5px;" onclick="excluir()" id="btexcluirPessoa">Excluir</button>';
    }
    if ($nivelp["inserir"] == 1) {
        echo '<button style="margin-left: 5px;" onclick="btNovoPessoa()" id="btnovoPessoa">Novo</button>';
    }
}
?>       
</form>


<div class="progress">
    <div class="bar"></div>
    <div class="percent">0%</div>
</div>

<div id="status"></div>
