<?php
  $useragent = $_SERVER['HTTP_USER_AGENT'];
 $mesAnterior =  date('m', strtotime('-1 months', strtotime(date('Y-m-d'))));
  if (preg_match('|MSIE ([0-9].[0-9]{1,2})|',$useragent,$matched)) {
    $browser_version=$matched[1];
    $browser = 'IE';
    $dtant   = "20/{$mesAnterior}/".date("Y");
    $dtfinal = "21".date("/m/Y");
  } elseif (preg_match( '|Opera/([0-9].[0-9]{1,2})|',$useragent,$matched)) {
    $browser_version=$matched[1];
    $browser = 'Opera';
    $dtant   = "20/{$mesAnterior}/".date("Y");
    $dtfinal    = "21".date("/m/Y");
  } elseif(preg_match('|Firefox/([0-9\.]+)|',$useragent,$matched)) {
    $browser_version=$matched[1];
    $browser = 'Firefox';
    $dtant   = "20/{$mesAnterior}/".date("Y");
    $dtfinal    = "21".date("/m/Y");
  } elseif(preg_match('|Chrome/([0-9\.]+)|',$useragent,$matched)) {
    $browser_version=$matched[1];
    $browser = 'Chrome';
    $dtant   = "20/{$mesAnterior}/".date("Y");
    $dtfinal = "21".date("/m/Y");
  } elseif(preg_match('|Safari/([0-9\.]+)|',$useragent,$matched)) {
    $browser_version=$matched[1];
    $dtant   = "20/{$mesAnterior}/".date("Y");
    $dtfinal    = "21".date("/m/Y");
    $browser = 'Safari';
  } else {
    // browser not recognized!
    $browser_version = 0;
    $browser= 'other';
  }
?>
<form id="fpregistro" role="form" class="form-horizontal form-groups-bordered" method="POST" target="_blank" action="../control/ProcurarRegistroRelatorio.php" onsubmit="return false;">
    <input type="hidden" name="tipo" id="tipoRegistro" value="pdf"/>
    <table class="tabela_formulario">
        <tr>
            <td style="width: 100px;">Dt. Inicio:</td>
            <td><input style="width: 205px;" type="text" class="data" name="data1" title="Data inicial de seu cadastro" value="<?=$dtant?>"/></td>
            <td>Dt. Fim:</td>
            <td><input style="width: 205px;" type="text" class="data" name="data2" title="Data final de seu cadastro" value="<?=$dtfinal?>"/></td>
        </tr>
    </table>
    <button onclick="procurarRegistro(false)">Procurar</button>
    <button onclick="abreRelatorioRegistro()">Gera PDF</button>
    <button onclick="abreRelatorio2Registro()">Gera Excel</button>    
</form>
<div id="listagem"></div>
