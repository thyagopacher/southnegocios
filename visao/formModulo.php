<form id="fmodulo" name="fmodulo" role="form" autocomplete="off" class="form-horizontal form-groups-bordered" method="POST" onsubmit="return false;">
    <input type="hidden" name="codmodulo" id="codmodulo"  value="<?php if(isset($modulo["codmodulo"])){echo $modulo["codmodulo"];}else { echo "";} ?>"/>                       
    <p>
        <label>Nome</label>
        <input type="text" required name="nome" id="nome" size="50" maxlength="250" placeholder="Digite nome aqui" value="<?php if(isset($modulo["nome"])){echo $modulo["nome"];}else { echo "";} ?>">
    </p>
    <p>
        <label>Título</label>
        <input type="text" required name="titulo" id="titulo" size="50" maxlength="250" placeholder="Digite titulo aqui" value="<?php if(isset($modulo["titulo"])){echo $modulo["titulo"];}else { echo "";} ?>">
    </p>
<?php
if (!isset($pagina["codpagina"])) {
    $display = "style='display: none'";
} elseif (isset($pagina["codpagina"])) {
    $display = "";
}
?>
        <button id="btinserirModulo" onclick="inserirModulo()">Cadastrar</button>
        <button id="btatualizarModulo" <?=$display?> onclick="atualizarModulo()">Atualizar</button>
        <button id="btexcluirModulo" <?=$display?> onclick="excluirModulo()">Excluir</button>
        <button onclick="btNovoModulo()">Novo</button>
</form>
<div id="listagemModulo"></div>