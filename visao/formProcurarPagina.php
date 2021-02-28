<form id="fppagina" role="form" class="form-horizontal form-groups-bordered" method="POST" onsubmit="return false;">
    <p>
        <label>Nome</label>
        <input type="text" name="nome" size="50" maxlength="250" placeholder="Digite nome aqui" value="">
    </p>
    <p>
        <button onclick="procurarPagina(false)" class="btn btn-info">Procurar</button>
    </p>
</form>
<?php include("./carregando.php");?>
<div id="listagemPagina"></div>
