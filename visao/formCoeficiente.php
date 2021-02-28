<form id="fcoeficiente" autocomplete="on" method="get" onsubmit="return false;">    
    <table class="tabela_formulario">
        <input type="hidden" name="codcoeficiente" id="codcoeficiente" value="<?php if (isset($coeficiente["codcoeficiente"])) {
    echo $coeficiente["codcoeficiente"];
} ?>"/>
        <tr>
            <td>Coeficiente</td>
            <td>
                <input type="text" name="valor" id="valor" title="Digite aqui o coeficiente do dia" value="<?php if (isset($coeficiente["valor"])) {echo str_replace(".", ",", $coeficiente["valor"]);} ?>"/>
            </td>        
            <td style="width: 50px;"></td>
            <td></td>
        </tr>

    </table>
<?php
if(isset($nivelp["inserir"]) && $nivelp["inserir"] == 1 && !isset($_GET["codcoeficiente"])){
    echo '<button id="btIniciarChat" onclick="inserirCoeficiente();">Cadastrar</button> ';
}
if(isset($_GET["codcoeficiente"])){
    if(isset($nivelp["atualizar"]) && $nivelp["atualizar"] == 1){
        echo '<button id="btIniciarChat" onclick="atualizarCoeficiente();">Atualizar</button> ';
    }
    if(isset($nivelp["excluir"]) && $nivelp["excluir"] == 1){
        echo '<button id="btIniciarChat" onclick="excluirCoeficiente();">Excluir</button> ';
    }
}
echo '<button id="btIniciarChat" onclick="novoCoeficiente();">Novo</button>';
?>
</form>