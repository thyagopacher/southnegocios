<form id="fstatusproposta" role="form" autocomplete="off" method="get" onsubmit="return false;">
    <input type="hidden" name="codstatus" id="codigoStatus"  value="<?php if(isset($status["codstatus"])){echo $status["codstatus"];}else { echo "";} ?>"/>                       
    <p>
        <label>Nome</label>
        <input type="text" name="nome" id="nomeStatus" size="50" maxlength="250" value="<?php if(isset($status["nome"])){echo $status["nome"];}else { echo "";} ?>"/>
    </p>
    <p>
        <label>Cor</label>
        <select name="cor" id="cor">
            <option <?php if(isset($status["cor"]) && $status["cor"] == "azul"){echo "selected";}?>>azul</option>
            <option <?php if(isset($status["cor"]) && $status["cor"] == "preto"){echo "selected";}?>>preto</option>
            <option <?php if(isset($status["cor"]) && $status["cor"] == "vermelho"){echo "selected";}?>>vermelho</option>
            <option <?php if(isset($status["cor"]) && $status["cor"] == "verde"){echo "selected";}?>>verde</option>
            <option <?php if(isset($status["cor"]) && $status["cor"] == "amarelo"){echo "selected";}?>>amarelo</option>
            <option <?php if(isset($status["cor"]) && $status["cor"] == "laranja"){echo "selected";}?>>laranja</option>
            <option <?php if(isset($status["cor"]) && $status["cor"] == "roxo"){echo "selected";}?>>roxo</option>
            <option <?php if(isset($status["cor"]) && $status["cor"] == "rosa"){echo "selected";}?>>rosa</option>
        </select>
    </p>
    <?php if(isset($nivelp["inserir"]) && $nivelp["inserir"] == 1 && !isset($_GET["codstatus"])){?>
    <button onclick="inserirStatus()" id="btinserirStatusProposta">Cadastrar</button>
    <?php }?>
    <?php if(isset($nivelp["atualizar"]) && $nivelp["atualizar"] == 1 && isset($_GET["codstatus"])){?>
    <button id="btatualizarStatusProposta" onclick="atualizarStatus()">Atualizar</button>
    <?php }?>
    <?php if(isset($nivelp["excluir"]) && $nivelp["excluir"] == 1 && isset($_GET["codstatus"])){?>
    <button id="btexcluirStatusProposta" onclick="excluirStatus()">Excluir</button>    
    <?php }?>
    <button onclick="btNovoStatus()">Novo</button>
</form>
