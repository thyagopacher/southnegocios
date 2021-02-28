<?php
date_default_timezone_set('America/Sao_Paulo');
$useragent = $_SERVER['HTTP_USER_AGENT'];

if (preg_match('|MSIE ([0-9].[0-9]{1,2})|', $useragent, $matched)) {
    $browser_version = $matched[1];
    $browser = 'IE';
    $hoje = date('d/m/Y');
} elseif (preg_match('|Opera/([0-9].[0-9]{1,2})|', $useragent, $matched)) {
    $browser_version = $matched[1];
    $browser = 'Opera';
    $hoje = date('d/m/Y');
} elseif (preg_match('|Firefox/([0-9\.]+)|', $useragent, $matched)) {
    $browser_version = $matched[1];
    $browser = 'Firefox';
    $hoje = date('d/m/Y');
} elseif (preg_match('|Chrome/([0-9\.]+)|', $useragent, $matched)) {
    $browser_version = $matched[1];
    $browser = 'Chrome';
    $hoje = date('d/m/Y');
} elseif (preg_match('|Safari/([0-9\.]+)|', $useragent, $matched)) {
    $browser_version = $matched[1];
    $hoje = date('d/m/Y');
    $browser = 'Safari';
} else {
    // browser not recognized!
    $browser_version = 0;
    $browser = 'other';
}
    $codigoFinal = 0;
    $sql = "select max(codregistro) + 1 as codigo from registro order by codregistro desc";
    $codigo = $conexao->comandoArray($sql);
    if(!isset($codigo) || $codigo["codigo"] == NULL || $codigo["codigo"] == ""){
        $codigoFinal = 1;
    }else{
        $codigoFinal = $codigo["codigo"];
    }
    if(isset($_GET["codregistro"]) && $_GET["codregistro"] != NULL && $_GET["codregistro"] != ""){
        $codigoFinal = $_GET["codregistro"];
    }
?>
<form id="fregistro" action="<?= $action ?>" autocomplete="off" method="POST">
    <table id="tabela_registro" class="tabela_formulario">
        <input type="hidden" name="qtdProcedimento" id="qtdProcedimento" value="1"/>
        <input type="hidden" name="ultValorInserido" id="ultValorInserido"  value=""/>  
        
        <input type="hidden" name="codpessoa" id="codpessoa"  value="<?= $_SESSION['codpessoa'] ?>"/>  
        <tr>
            <td><input style="width: 130px" type="text" name="codregistro" id="codregistro" placeholder="número" title="número auto incrementavel" value="<?=$codigoFinal?>"/></td>
            <td><input style="width: 130px;" type="text" name="data" id="data" class='data' value="<?= $hoje ?>" title="Data do procedimento"/></td>
            <td><input style="width: 120px;" type="text" name="spp" id="spp" placeholder="SPP" title="SPP paciente" value="<?php if (isset($registro["spp"])) {echo $registro["spp"];} ?>"/></td>
            <td><input type="text" style="width: 215px;" name="paciente"   id="paciente" size="50" maxlength="250" placeholder="Paciente" value="<?php if (isset($registro["paciente"])) {echo $registro["paciente"];} ?>"></td>
        </tr>    

    </table>
        
    <div style="width: 1200px" id="procedimentosAdicionar" class="tabela_formulario">
        <p style="margin: 0px 0px 5px 10px;">
            <input type="hidden" name="codigo_procedimento[]" id="codigo_procedimento1">
            <input type="search" onkeyup="procurarProcedimento3(1)" style="width: 130px;" name="procedimento[]" id="procedimento1" placeholder="Procedimento" title="Procedimento">
            <input type="text" style="width: 130px;  margin-left: 4px;" name="codigo[]" id="codigo1" size="50" maxlength="250" placeholder="código" title="Código">
            <input type="text" style="width: 120px;  margin-left: 4px;" name="porte[]" id="porte1" size="50" maxlength="250" placeholder="Porte" title="Porte">
            <input style="width: 90px" type="text" name="valorProcedimento[]" id="valorProcedimento1" class="real" value="" placeholder="integral" title="Valor integral procedimento"/>
            <select onchange="calculoLinha(1);" style="width: 135px; margin-left: 4px;" name="tipo[]" id="tipo1" title="Tipo de cirurgia"><option value="e">eletiva</option><option value="u">urgência</option></select>
            <select onchange="calculoLinha(1);" style="width: 135px; margin-left: 4px;" name="incisao[]" id="incisao1" title="Incisão de cirurgia"><option value="m">Mesma via</option><option value="d">Diferente via</option></select>
            <select style="width: 135px; margin-left: 4px;" name="bilateral[]" id="bilateral1" title="bilateral"><option value="u">Unilateral</option><option value="b">Bilateral</option></select>
            <input style="width: 90px" type="text" name="valorHonorario[]" id="valorHonorario1" class="real" value="" placeholder="calculado" title="Valor calculado procedimento"/>
            <a class="botao" href="javascript: adicionarNovoProcedimento();" id="adicionarNovoProcedimento" title="Adicionar novo procedimento">+</a>
        </p>        
    </div>
    <div id="alfabeto">
        <?php
            for ($letra = ord("A"); $letra <= ord('Z'); $letra++) {
                $letraA = "'".chr($letra)."'";
                echo '<a href="javascript: procurarProcedimentoLetra(',$letraA,')" title="', chr($letra), '">', chr($letra), '</a>';
            }
        ?>        
    </div>
    <table class="tabela_formulario">
        <tr>
            <td>Busca</td>
            <td colspan="3">
                <div id="procedimentos" style="height: 100px; overflow-y:  auto;width: 460px;"></div>
            </td>
        </tr>
        <tr>                
            <td>Valor Final</td>
            <td>
                <input style="width: 130px" type="text" name="valor"   id="valor" class="real" size="10" maxlength="10" placeholder="Digite seu valor aqui" value="<?php if (isset($registro["honorario"])) {
        echo $registro["honorario"];
    } else {
        echo '0,00';
    } ?>">
            </td>
        </tr>        
    </table>    
<?php
if (!isset($_GET["codregistro"])) {
    echo '<input type="button" name="submit" id="btinserirRegistro" value="Cadastrar" onclick="inserirRegistro();"/>';
    echo '<input style="margin-left: 5px;" type="button" name="submit" id="btinserirRegistro" value="Limpar" onclick="limparRegistro();"/>';
} else {
    echo '<input style="margin-left: 5px;" type="button" name="submit" id="btatualizarRegistro" value="Atualizar" onclick="atualizarRegistro();"/>';
    echo '<button style="margin-left: 5px;" onclick="excluirRegistro()" id="btexcluirRegistro">Excluir</button>';
    echo '<button style="margin-left: 5px;" onclick="btNovoRegistro()" id="btnovoRegistro">Novo</button>';
}
?>       
</form>


<div class="progress">
    <div class="bar"></div>
    <div class="percent">0%</div>
</div>

<div id="status"></div>
