<form id="frateio" role="form" autocomplete="off" class="form-horizonsumol form-groups-bordered" method="get" onsubmit="return false;">
        <input type="hidden" name="movimentacao" id="movimentacao" value="R"/>
        <input type="hidden" name="nome" id="nome" value="Rateio de contas"/>
        <input type="hidden" name="codconta" id="codconta"  value="<?php if(isset($rateio["codconta"])){echo $rateio["codconta"];}else { echo "";} ?>"/>                       
        <table class="tabela_formulario">
            <tr>
                <td>Ambiente</td>
                <td>
                    <select style="width: 235px;" name="codambiente" id="codambiente">
                        <?php
                        $sql = "select * from ambienterateio where codempresa = '{$_SESSION['codempresa']}' order by nome";
                        $res = $conexao->comando($sql);
                        $qtd = $conexao->qtdResultado($res);
                        if($qtd > 0){
                            echo '<option value="">--Selecione--</option>';
                            while($ambiente = $conexao->resultadoArray($res)){
                                if(isset($rateio["codambiente"]) && $rateio["codambiente"] == $ambiente["codambiente"]){
                                    echo '<option selected value="',$ambiente["codambiente"],'">',$ambiente["nome"],'</option>';
                                }else{
                                    echo '<option value="',$ambiente["codambiente"],'">',$ambiente["nome"],'</option>';
                                }
                            }
                        }else{
                            echo '<option value="">--Nada encontrado--</option>';
                        }
                        ?>
                    </select>
                </td>
                <td>Data</td>
                <td>
                    <input style="width: 230px;" type="date" name="data" id="data" class="data" value="<?php if(isset($rateio["data"])){echo $rateio["data"];}else{echo date('Y-m-d');}?>"/>
                </td>
            </tr>
            <tr>
                <td>Tipo</td>
                <td>
                    <select style="width: 235px;" name="codtipo" title="Escolha aqui o tipo de sua conta">
                        <?php
                        $restipo = $conexao->comando("select * from tipoconta");
                        $qtdtipo = $conexao->qtdResultado($restipo);
                        if ($qtdtipo > 0) {
                            echo '<option value="">--Selecione--</option>';
                            while ($tipo = $conexao->resultadoArray($restipo)) {
                                echo '<option value="', $tipo["codtipo"], '">', $tipo["nome"], '</option>';
                            }
                        } else {
                            echo '<option value="">Nada encontrado</option>';
                        }
                        ?>
                    </select>                 
                </td>                
                <td>Valor</td>
                <td>
                    <input style="width: 230px;" type="text" name="valor" id="valor" class="real" value="<?php if(isset($rateio["valor"])){echo number_format($rateio["valor"], 2, ",", "");}?>"/>
                </td>
            </tr>
        </table>
        <?php 
        if (!isset($rateio["codconta"])) {   
            if($nivelp["inserir"] == 1){
                echo '<button style="margin-left: 5px;" onclick="inserirRateio()">Cadastrar</button>';
            }
        } elseif (isset($rateio["codconta"])) {
            if($nivelp["atualizar"] == 1){
                echo '<button style="margin-left: 5px;" onclick="atualizarRateio()" style="margin-left: 10px;">Atualizar</button>';
            }
            if($nivelp["excluir"] == 1){
                echo '<button style="margin-left: 5px;" onclick="excluirRateio()" style="margin-left: 10px;">Excluir</button>';
            }
            echo '<button style="margin-left: 5px;" onclick="btNovoRateio()" style="margin-left: 10px;">Novo</button>';
        } 
        ?>    
</form>
<?php include("./carregando.php");?>
<div id="listagemMorador"></div>