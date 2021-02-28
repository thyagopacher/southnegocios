<form id="fconteudo" autocomplete="on" action="<?=$action?>" method="POST">
    <input type="hidden" name="ehMorador" id="ehMorador" value="<?php if(isset($ehMorador) && $ehMorador == true){echo "s";}?>"/>
    <input type="hidden" name="codconteudo" id="codconteudo"  value="<?php if(isset($conteudo["codconteudo"])){echo $conteudo["codconteudo"];}else { echo "";} ?>"/>                       
    <p>
        <label>Nome</label>
        <input type="text" style="width: 605px;" name="nome" id="nome" size="50" maxlength="25" value="<?php if(isset($conteudo["nome"])){echo $conteudo["nome"];}else { echo "";} ?>"/>
    </p>
    <p>
        <label>Palavra chave</label><Br>
        <textarea name="palavrachave" style="width: 742px;max-width: 742px;min-width: 742px;" id="palavrachave" maxlength="150"><?php if(isset($conteudo["palavrachave"])){echo $conteudo["palavrachave"];}else { echo "";} ?></textarea>
    </p>
    <p>
        <label>Descrição</label><Br>
        <textarea name="descricao" style="width: 742px;max-width: 742px;min-width: 742px;" id="descricao" maxlength="150"><?php if(isset($conteudo["descricao"])){echo $conteudo["descricao"];}else { echo "";} ?></textarea>
    </p>
    <p> 
        <label>Texto</label><Br>
        <textarea name="texto" id="texto" class="texto" cols="70" rows="10"><?php if(isset($conteudo["texto"])){echo $conteudo["texto"];}else { echo "";} ?></textarea>
    </p>
    <?php 
    if (!isset($conteudo["codconteudo"])) {    
        if($nivelp["inserir"] == 1){
            echo '<input type="submit" name="submit" value="Cadastrar"/>';
        }
    } elseif (isset($conteudo["codconteudo"])) {
        if($nivelp["atualizar"] == 1){
            echo '<input type="submit" name="submit" value="Atualizar"/>';
        }
        if($nivelp["excluir"] == 1){
            echo '<button style="margin-left: 10px" onclick="excluir()">Excluir</button>';
        }
        echo '<button style="margin-left: 10px" onclick="btNovo()">Novo</button>';
    } 
    ?>
</form>