
<form id="ffrase" autocomplete="on" action="" method="POST" onsubmit="return false;">
    <input type="hidden" name="codfrase" id="codfrase"  value="<?php if (isset($fraseForm["codfrase"])) {echo $fraseForm["codfrase"];} ?>"/>                       
    <table class="tabela_formulario">
        <tr> 
            <td>Chave</td>
            <td>
                <select name="chave" id="chave">
                    <option value="">--Selecione--</option>
                    <option value="[data]">Data</option>
                    <option value="[nome_colaborador]">Colaborador</option> 
                    <option value="[meta_colaborador]">Meta</option>                 
                    <option value="[meta_falta]">Meta Falta</option>                 
                    <option value="[soma_operador]">Soma operador</option>                 
                    <option value="[tabela_diario]">Tabela diário</option>                 
                    <option value="[vendas_dia]">Vendas dia</option>                 
                </select>
            </td>
            <td>Popup</td>
            <td>
                <select name="popup" id="popup">
                    <option value="">--Selecione--</option>
                    <option value="s" <?php if(isset($fraseForm["popup"]) && $fraseForm["popup"] == "s"){echo "selected";}?>>SIM</option>
                    <option value="n" <?php if(isset($fraseForm["popup"]) && $fraseForm["popup"] == "n"){echo "selected";}?>>NÃO</option>
                </select>
            </td>            
        </tr>
        <tr class="frase_popup" style="<?php if(!isset($fraseForm["popup"]) || $fraseForm["popup"] == "n"){echo "display: none";}else{echo "";}?>">
            <td>Periodo</td>
            <td>
                <select name="periodo" id="periodo">
                    <option value="1" <?php if(isset($fraseForm["periodo"]) && $fraseForm["periodo"] == "1"){echo "selected";}?>>manhã</option>
                    <option value="2" <?php if(isset($fraseForm["periodo"]) && $fraseForm["periodo"] == "2"){echo "selected";}?>>tarde</option>
                    <option value="3" <?php if(isset($fraseForm["periodo"]) && $fraseForm["periodo"] == "3"){echo "selected";}?>>noite</option>
                </select>
            </td>
            <td>
                <a href="javascript: visualizaPopup();" class="botao">Visualizar POPUP</a>
            </td>
        </tr>
        <tr> 
            <td>Texto</td>
            <td colspan="3"><textarea placeholder="Digite nome" style="width: 602px;" name="texto" id="textoFrase" cols="70" rows="10"><?php if (isset($fraseForm["texto"]) && $fraseForm["texto"] != NULL && $fraseForm["texto"] != "") {echo $fraseForm["texto"];} ?></textarea></td>
        </tr>
    </table>
    <?php
    if ($nivelp["inserir"] == 1 && !isset($_GET["codfrase"])) {
        echo '<input type="button" name="submit" value="Cadastrar" id="btInserirFrase" onclick="inserirFrase()"/> ';
    }
    if(isset($_GET["codfrase"])){
        if ($nivelp["atualizar"] == 1) {
            echo '<input type="button" name="submit" value="Atualizar" id="btAtualizarFrase" style="" onclick="atualizarFrase()"/>'; 
        }
        if ($nivelp["excluir"] == 1) {
            echo '<button style="margin-left: 10px;" onclick="excluirFrase()" id="btExcluirFrase">Excluir</button>';
        }
    }
    echo '<button style="margin-left: 10px;" onclick="btNovoFrase()">Novo</button>';
    ?>
</form>