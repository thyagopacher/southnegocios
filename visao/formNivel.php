<form id="fnivel" role="form" autocomplete="off" class="form-horizontal form-groups-bordered" method="POST" onsubmit="return false;">
    <input type="hidden" name="codnivel" id="codnivel"  value="<?php if(isset($nivel["codnivel"])){echo $nivel["codnivel"];}else { echo "";} ?>"/>   
    <input type="hidden" name="naomaster" id="naomaster" value="<?php if(isset($naomaster) && $naomaster == true){echo 'true';}?>"/>
    <p>
        <label>Nome</label>
        <input type="text" required name="nome" id="nome" size="50" maxlength="250" placeholder="Digite seu nome aqui" value="<?php if(isset($nivel["nome"])){echo $nivel["nome"];}else { echo "";} ?>">
    </p>
    <p>
        <label>Porcentagem</label>
        <input class="real" type="text" required name="porcentagem" id="porcentagem" size="50" maxlength="250" value="<?php if(isset($nivel["porcentagem"])){echo $nivel["porcentagem"];}else { echo "";} ?>">
    </p>
    <p>
        <label>Padrão</label>
        <select name="padrao" id="padrao">
            <option value="s" <?php if(isset($nivel["padrao"]) && $nivel["padrao"] == "s"){echo "selected";}?>>SIM</option>
            <option value="n" <?php if(isset($nivel["padrao"]) && $nivel["padrao"] == "n"){echo "selected";}?>>NÃO</option>
        </select>
    </p>

    <?php 
    if (!isset($nivel["codnivel"])) { 
        if($nivelp["inserir"] == 1){
            echo '<button onclick="inserirNivel()" id="btinserirNivel">Cadastrar</button>';
        }
    } 
    if (isset($nivel["codnivel"]) || (isset($naomaster) && $naomaster == true)) {
        if(isset($naomaster) && $naomaster){
            $disable = "display: none"; 
        }elseif(!isset($naomaster) || $naomaster == false){
            $disable = "";
        }
        if($nivelp["atualizar"] == 1){
            echo '<button style="margin-left: 10px;',$disable,'" id="btatualizarNivel" onclick="atualizarNivel()">Atualizar</button>';
        }
        if($nivelp["excluir"] == 1){
            echo '<button style="margin-left: 10px;',$disable,'" id="btexcluirNivel" onclick="excluirNivel()">Excluir</button>';
        }
        echo '<button style="margin-left: 10px;',$disable,'" id="btnovoNivel" onclick="btNovoNivel()">Novo</button>';
    } ?>
</form>