<form id="ftipoachado" role="form" autocomplete="off" class="form-horizontal form-groups-bordered" method="POST" onsubmit="return false;">
    <input type="hidden" name="codtipo" id="codtipo"  value="<?php if(isset($tipoachado["codtipo"])){echo $tipoachado["codtipo"];}else{ echo "";}?>"/>                            
    <p>
        <label>Nome</label>
        <input type="text" required size="50" name="nome" id="nomeTipo" placeholder="Digite nome aqui" value="<?php if(isset($tipoachado["nome"])){echo $tipoachado["nome"];}else{ echo "";}?>">
    </p>
    <p>
        <?php 
        echo '<button onclick="inserirTipo()"  id="btinserirtipoAchado">Cadastrar</button>';
        echo '<button style="display: none;margin-left: 10px;" onclick="atualizarTipo()" id="btatualizartipoAchado">Atualizar</button>';
        echo '<button style="display: none;margin-left: 10px;" onclick="excluirTipo()" id="btexcluirtipoAchado">Excluir</button>';
        echo '<button style="margin-left: 10px;" onclick="btNovoTipoAchado()" id="btnovotipoAchado">Novo</button>';        
        ?>
    </p>
</form>
<div id="listagemTipoAchado"></div>