<form id="ftipoconta" role="form" autocomplete="off" class="form-horizontal form-groups-bordered" method="POST" onsubmit="return false;">
    <input type="hidden" name="codtipo" id="codtipo"  value="<?php if(isset($tipoconta["codtipo"])){echo $tipoconta["codtipo"];}else{ echo "";}?>"/>                            
    <p>
        <label style="width: 60px;">Nome</label>
        <input type="text" required size="50" name="nome" id="nomeTipo" placeholder="Digite nome aqui" value="<?php if(isset($tipoconta["nome"])){echo $tipoconta["nome"];}else{ echo "";}?>">
    </p>
    <p>
        <?php 
        echo '<button onclick="inserirTipo()"  id="btinserirtipoConta">Cadastrar</button>';
        echo '<button style="display: none;margin-left: 10px;" onclick="atualizarTipo()" id="btatualizartipoConta">Atualizar</button>';
        echo '<button style="display: none;margin-left: 10px;" onclick="excluirTipo()" id="btexcluirtipoConta">Excluir</button>';
        echo '<button style="margin-left: 10px;" onclick="btNovoTipoConta()" id="btnovotipoConta">Novo</button>';        
        ?>
    </p>
</form>
<div id="listagemTipoConta"></div>