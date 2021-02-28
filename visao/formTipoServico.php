<form id="ftiposervico" role="form" autocomplete="off" class="form-horizontal form-groups-bordered" method="POST" onsubmit="return false;">
    <input type="hidden" name="codtipo" id="codtipo"  value="<?php if(isset($tiposervico["codtipo"])){echo $tiposervico["codtipo"];}else{ echo "";}?>"/>                            
    <p>
        <label>Nome</label>
        <input type="text" required size="50" name="nome" id="nomeTipo" placeholder="Digite nome aqui" value="<?php if(isset($tiposervico["nome"])){echo $tiposervico["nome"];}else{ echo "";}?>">
    </p>
    <p>
        <?php 
        echo '<button onclick="inserirTipo()"  id="btinserirtipoServico">Cadastrar</button>';
        echo '<button style="display: none;margin-left: 10px;" onclick="atualizarTipo()" id="btatualizartipoServico">Atualizar</button>';
        echo '<button style="display: none;margin-left: 10px;" onclick="excluirTipo()" id="btexcluirtipoServico">Excluir</button>';
        echo '<button style="margin-left: 10px;" onclick="btNovoTipoServico()" id="btnovotipoServico">Novo</button>';        
        ?>
    </p>
</form>
<div id="listagemTipoServico"></div>