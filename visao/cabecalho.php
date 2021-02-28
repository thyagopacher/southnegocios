<div id="cabecalho">
    <input type="hidden" name="pessoaLogadaCabecalho" id="pessoaLogadaCabecalho" value="<?=$_SESSION['codpessoa']?>"/>
    <input type="hidden" name="chatMinimizado" id="chatMinimizado" value="n"/>
    <div style="width: 340px;  height: 100px;    padding-top: 0px;  text-transform: initial; margin-top: 20px;margin-left: 20px;font-weight: initial; font-size: 13px; color: #34495E;float: left;">
        <?php
        $frase = $conexao->comandoArray("select * from frase where popup = 'n' order by rand()");
        echo trocaFraseTexto($frase["texto"]);
        ?>
    </div>    
    <div id="perfil">
        Operador: <a href="Pessoa.php?codpessoa=<?= $_SESSION['codpessoa'] ?>" title="Clique para visualizar o perfil"><?= ucfirst($_SESSION["nome"]) ?></a><br>
        <?php
        $empresaCabecalho = $conexao->comandoArray("select * from empresa where codempresa = '{$_SESSION['codempresa']}'");
        ?>
        Unidade: 
        <?php
        if ($_SESSION["codnivel"] == 1) {
            ?>
            <select style="width: 140px;" name="mudaEmpresa" id="mudaEmpresa">
                <?php
                $resempresa = $conexao->comando("select razao, codempresa from empresa where codstatus = 3 order by razao");
                $qtdempresa = $conexao->qtdResultado($resempresa);
                if ($qtdempresa > 0) {
                    echo '<option value="">--Selecione--</option>';
                    while ($empresa = $conexao->resultadoArray($resempresa)) {
                        if (isset($_SESSION['codempresa']) && $_SESSION['codempresa'] == $empresa["codempresa"]) {
                            echo '<option selected value="', $empresa["codempresa"], '">', $empresa["razao"], '</option>';
                        } else {
                            echo '<option value="', $empresa["codempresa"], '">', $empresa["razao"], '</option>';
                        }
                    }
                } else {
                    echo '<option value="">--Nada encontrado--</option>';
                }
                ?>
            </select> 
            <?php
        } else {
            echo $empresaCabecalho["razao"];
        }
        ?>
        <br>
        <!--Data: <?= date('d/m/Y') ?> Hora: <span id="horaCabecalho"></span><br>-->
        <a style="font-weight: bolder; text-decoration: underline" href="/visao/Logout.php">Sair</a>
    </div>
    <div style="width: 120px; height: 80px; float: right;">
        <a title="Clique aqui para iniciar o chat" href="/chat2/index2.php" target="_blank" style="float: right;">
            <img style="border: initial;width: 75px;height: auto;" src="../visao/recursos/img/chat.png" alt=""/>
        </a> 
    </div>
    <?php medalhaFuncionario(); ?>
    <div style="width: 140px;  height: 100px;    margin: 0 auto;   padding-top: 0px;  text-transform: capitalize;margin-top: 20px;">

        <img style="width: 126px; border: initial" src="../visao/recursos/img/logo.png" alt=""/>

    </div>

</div>


<?php

function medalhaFuncionario() {
    global $conexao;
    $jaRecebeu = FALSE;
    $mes = date("m");
    $and = " and b2.dtcadastro >= '" . date("Y") . '-' . $mes . "-01'";
    $and .= " and b2.dtcadastro <= '" . date("Y") . '-' . $mes . "-30'";
    $sql = "select distinct pessoa.codpessoa, pessoa.codempresa, pessoa.nome, pessoa.imagem,
        (select sum(b1.valor) as valor from baixa as b1 where b1.codempresa = b2.codempresa and b1.codfuncionario = b2.codfuncionario and b1.dtcadastro = b2.dtcadastro) as total_produzido    
        from baixa as b2
        inner join pessoa on pessoa.codpessoa = b2.codfuncionario
        inner join empresa on empresa.codempresa = b2.codempresa
        where 1 = 1
        {$and} order by b2.valor desc";
    $res = $conexao->comando($sql);
    $qtd = $conexao->qtdResultado($res);
    $ranking = array();
    if ($qtd > 0) {
        $linhaIteracao = 0;
        while ($baixa = $conexao->resultadoArray($res)) {
            $sql = "select sum(b2.valor) as valor from baixa as b2 where b2.codfuncionario = '{$baixa["codpessoa"]}' {$and}";
            $total = $conexao->comandoArray($sql);
            $ranking[$linhaIteracao]["codempresa"] = $baixa["codempresa"];
            $ranking[$linhaIteracao]["nome"] = $baixa["nome"];
            $ranking[$linhaIteracao]["codfuncionario"] = $baixa["codpessoa"];
            $ranking[$linhaIteracao]["valor"] = $total["valor"];
            $ranking[$linhaIteracao]["imagem"] = $baixa["imagem"];
            $linhaIteracao++;
        }
    } else {
        echo '';
    }
    
    usort($ranking, "cmpValor"); 
    if($ranking[0]["codfuncionario"] == $_SESSION['codpessoa']){
        echo '<img style="float: left;" src="./recursos/img/01.png" alt="Parabéns você ficou em primeiro lugar" title="Parabéns você ficou em primeiro lugar"/>';
    }elseif($ranking[1]["codfuncionario"] == $_SESSION['codpessoa']){
        echo '<img style="float: left;" src="./recursos/img/02.png" alt="Parabéns você ficou em segundo lugar" title="Parabéns você ficou em segundo lugar"/>';
    }elseif($ranking[2]["codfuncionario"] == $_SESSION['codpessoa']){
        echo '<img style="float: left;" src="./recursos/img/03.png" alt="Parabéns você ficou em terceiro lugar" title="Parabéns você ficou em terceiro lugar"/>';
    }
}

function trocaFraseTexto($texto) {
    global $conexao;
    $nome = explode(" ", ucfirst($_SESSION["nome"]));
    $texto = str_replace("[nome_colaborador]", $nome[0], str_replace("[data]", date('d/m/Y'), $texto));
    $sql = "select valor from metafuncionario where codfuncionario = '{$_SESSION['codpessoa']}' and dtinicio >= '" . date("Y-m-") . "01' and dtfim <= '" . date("Y-m-") . "30'";
    $meta = $conexao->comandoArray($sql);
    $texto = str_replace("[meta_colaborador]", "R$ " . number_format($meta["valor"], 2, ",", "."), $texto);
    $resultadoFinal = calculaMetaFuncionario();
    $texto = str_replace("[meta_falta]", "R$ " . number_format($resultadoFinal, 2, ",", "."), $texto);
    return $texto;
}

function calculaMetaFuncionario() {
    global $conexao;
    /*     * pegando o valor total da meta do funcionário */
    $sql = "select valor from metafuncionario where codfuncionario = '{$_SESSION['codpessoa']}' 
    and dtcadastro >= '" . date("Y-m-") . "01 00:00:00'    
    and dtcadastro <= '" . date("Y-m-") . "30 23:59:59'            
    order by codmeta desc";
//    echo "<pre>{$sql}</pre>";
    $metaFuncionario = $conexao->comandoArray($sql);
    $diasUteis = 0;

    if (isset($metaFuncionario) && $metaFuncionario["valor"] != NULL && $metaFuncionario["valor"] != "") {

        /*         * somatório valor total vendido */
        $baixaTotal = $conexao->comandoArray("select sum(valor) as valor from baixa 
        where codempresa = '{$_SESSION['codempresa']}' 
        and dtcadastro >= '" . date("Y-m-") . "01'    
        and dtcadastro <= '" . date("Y-m-") . "30'    
        and codfuncionario = '{$_SESSION['codpessoa']}'");

        $ultimo_dia = date("t", mktime(0, 0, 0, date("m"), '01', date("Y")));
        $dia_mes = date("Y-m-");
        $semana = array(
            'Sun' => 'domingo',
            'Mon' => 'segunda',
            'Tue' => 'terca',
            'Wed' => 'quarta',
            'Thu' => 'quinta',
            'Fri' => 'sexta',
            'Sat' => 'sabado'
        );
        for ($i = date("d"); $i <= $ultimo_dia; $i++) {
            if ($i < 10) {
                $dia_mes2 = "0" . $i;
            } else {
                $dia_mes2 = $i;
            }
            $data_selec = $dia_mes . $dia_mes2;
            $sql = "select * from dia where data = '{$data_selec}' and codempresa = '{$_SESSION['codempresa']}'";
            $dia_feriado = $conexao->comandoArray($sql);
            if (isset($dia_feriado) && $dia_feriado["data"] != NULL && $dia_feriado["data"] != "") {
                continue; //tira os feriados
            }

            $dia_semana = date("D", strtotime($data_selec));
            $sql = "select * from horariofilial where codempresa = '{$_SESSION['codempresa']}' and dia = '{$semana[$dia_semana]}'";
            $horarioFilial = $conexao->comandoArray($sql);
            if (isset($horarioFilial["codhorario"]) && $horarioFilial["codhorario"] != NULL && $horarioFilial["codhorario"] != "") {
                $diasUteis++;
            }
        }

        if ($diasUteis == 0) {
            $resultadoFinal = 0;
        } else {
            $resultadoFinal = ($metaFuncionario["valor"] - $baixaTotal["valor"]) / $diasUteis;
        }
    }

    return $resultadoFinal;
}


function cmpValor($a, $b){
    if ($a["valor"] == $b["valor"]) {
        return 0;
    }
    return ($a["valor"] > $b["valor"]) ? -1 : 1;
}