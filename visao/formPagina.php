<style>
    form{
        text-transform: initial;
    }
    form input{
        text-transform: initial;
    }
</style>

<form id="fpagina" role="form" autocomplete="off" class="form-horizontal form-groups-bordered" method="POST" onsubmit="return false;">
    <input type="hidden" name="codpagina" id="codpagina"  value="<?php if (isset($pagina["codpagina"])) {
    echo $pagina["codpagina"];
} else {
    echo "";
} ?>"/>   
    <p>
        <label>Módulo</label>
        <select name="codmodulo" id="codmodulo" required title="Selecione aqui o módulo ao qual pertence a funcionalidade">
            <?php
            $res = $conexao->comando("select * from modulo order by nome");
            $qtd = $conexao->qtdResultado($res);
            if($qtd > 0){
                echo '<option value="">--Selecione--</option>';
                while($modulo = $conexao->resultadoArray($res)){
                    echo '<option value="',$modulo["codmodulo"],'">',$modulo["nome"],'</option>';
                }
            }else{
                echo '<option value="">Nada encontrado</option>';
            }
            ?>
        </select>
    </p>
    <p>
        <label>Nome</label>
        <input type="text" required name="nome" id="nomePagina" size="50" maxlength="250" placeholder="Digite seu nome aqui" value="<?php if (isset($pagina["nome"])) {
    echo $pagina["nome"];
} else {
    echo "";
} ?>">
    </p>
    <p>
        <label>Título</label>
        <input type="text" required name="titulo" id="titulo" size="50" maxlength="250" placeholder="Digite seu título aqui" value="<?php if (isset($pagina["titulo"])) {
    echo $pagina["titulo"];
} else {
    echo "";
} ?>">
    </p>
    <p>
        <label>Link</label>
        <input type="text" required name="link" id="link" livre="sim" size="50" maxlength="250" placeholder="Digite um link para página" value="<?php if (isset($pagina["titulo"])) {echo $pagina["titulo"];}?>">
    </p>
   
<?php
if (!isset($pagina["codpagina"])) {
    $display = "style='display: none'";
} elseif (isset($pagina["codpagina"])) {
    $display = "";
}
?>
    <button onclick="inserir()" id="btinserirPagamento" class="btn btn-info">Cadastrar</button>
    <button <?=$display?> id="btatualizarPagamento" onclick="atualizar()" class="btn btn-info">Atualizar</button>
    <button <?=$display?> id="btexcluirPagamento" onclick="excluir()" class="btn btn-info">Excluir</button>        
</form>
