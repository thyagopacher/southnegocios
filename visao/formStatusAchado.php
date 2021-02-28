<form id="fstatuscorrespondencia" role="form" autocomplete="off" method="get" onsubmit="return false;">
    <input type="hidden" name="codstatus" id="codigoStatus"  value="<?php if(isset($status["codstatus"])){echo $status["codstatus"];}else { echo "";} ?>"/>                       
    <p>
        <label>Nome</label>
        <input type="text" name="nome" id="nomeStatus" size="50" maxlength="250" value="<?php if(isset($status["nome"])){echo $status["nome"];}else { echo "";} ?>"/>
    </p>
    <button onclick="inserirStatus()" id="btinserirStatusAchado">Cadastrar</button>
    <button id="btatualizarStatusMensagem" onclick="atualizarStatus()">Atualizar</button>
    <button id="btexcluirStatusMensagem" onclick="excluirStatus()">Excluir</button>    
    <button onclick="btNovoStatus()">Novo</button>
</form>
<div id="listagemStatusAchado"></div>