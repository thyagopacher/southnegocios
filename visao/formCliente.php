<?php
    include "./Utilitario.php";
?>
<form id="fpessoa" action="<?= $action ?>" autocomplete="off" novalidate method="POST">
    <?php
    if (!isset($_GET["codpessoa"])) {
        $_GET["codpessoa"] = $pessoa["codpessoa"];
    }
    ?>
    <table style="width: 940px;" class="tabela_formulario">
        <input type="hidden" name="codempresa" id="codempresa"  value="<?php
        if (isset($_GET["codempresa"])) {
            echo $_GET["codempresa"];
        }
        ?>"/>
        <input type="hidden" name="codpessoa" id="codpessoa"  value="<?php
               if (isset($pessoa["codpessoa"])) {
                   echo $pessoa["codpessoa"];
               }
               ?>"/>  
               <?php
               if (isset($_GET["callcenter"]) && $_GET["callcenter"] == "true") {
                   echo '<input type="hidden" name="codcategoria" id="categoria" value="6"/>';
               } else {
                   echo '<input type="hidden" name="codcategoria" id="categoria" value="1"/>';
               }
               ?>
        <tr>
            <td>NOME</td>
            <td>
                <input type="text" style="width: 225px;" required name="nome" id="nome" size="50" maxlength="250" placeholder="Digite seu nome aqui" value="<?php if (isset($pessoa["nome"])) {echo $pessoa["nome"];}?>">
            </td>             
            <td style="width: 120px;">Status</td>
            <td>
                <select style="width: 230px;border: 1px solid red;" name="status" id="statusPessoa">
                    <option value="">--Selecione--</option>
                    <option selected value="a" <?php
               if (isset($pessoa["status"]) && trim($pessoa["status"]) == "a") {
                   echo "selected";
               }
               ?>>Ativo</option>
                    <option value="i" <?php
               if (isset($pessoa["status"]) && trim($pessoa["status"]) == "i") {
                   echo "selected";
               }
               ?>>Inativo</option>
                </select>
            </td>

        </tr>       
        <tr>
            <td>CPF</td>
            <td>
                <input style="width: 225px;" type="text" autocomplete="off" required name="cpf" id="cpf" class="cpf" value="<?php
                if (isset($pessoa["cpf"])) {
                    echo $pessoa["cpf"];
                }
               ?>" placeholder="CPF">
                <a href="javascript: consultaCpf()" class="botao">Consultar</a>
            </td>
            <td>RG</td>
            <td>
                <input style="width: 225px;" type="text" autocomplete="off"  <?= $requireForm ?> name="rg" id="rg" value="<?php
                    if (isset($pessoa["rg"])) {
                        echo $pessoa["rg"];
                    }
                    ?>" placeholder="RG">
            </td>            
        </tr>
        <tr>
            <td>ORG. EMISSOR</td>
            <td><input style="width: 225px;" type="text" name="orgaoemissor" id="orgaoemissor" value="<?php
                    if (isset($pessoa["orgaoemissor"])) {
                        echo $pessoa["orgaoemissor"];
                    }
                    ?>"/></td>
            <td>UF</td>
            <td>
                <select style="width: 230px;" name="ufrg" id="ufrg">
<?php
$resestado = $conexao->comando("select * from estado order by nome");
$qtdestado = $conexao->qtdResultado($resestado);
if ($qtdestado > 0) {
    echo '<option value="">--Selecione--</option>';
    while ($estado = $conexao->resultadoArray($resestado)) {
        if (isset($pessoa["ufrg"]) && $pessoa["ufrg"] == $estado["codestado"]) {
            echo '<option selected value="', $estado["codestado"], '">', $estado["nome"], '</option>';
        } else {
            echo '<option value="', $estado["codestado"], '">', $estado["nome"], '</option>';
        }
    }
} else {
    echo '<option value="">--Nada encontrado--</option>';
}
?>
                </select>
            </td>
        </tr>
        <tr>
            <td>DT. EMISSÃO</td>
            <td>
                <input style="width: 225px;" type="text" name="dtemissaorg" id="dtemissaorg" class="data" value="<?php
                    if (isset($pessoa["dtemissaorg"])) {
                        echo implode("/", array_reverse(explode("-", $pessoa["dtemissaorg"])));
                    }
?>" title="Digite aqui a data de emissão do RG"/>
            </td>
            <td>SEXO</td>
            <td>
                <select style="width: 230px;" name="sexo" id="sexo" <?= $requireForm ?>>
                    <option value="">--Selecione--</option>
                    <option value="m" <?php
                if (isset($pessoa["sexo"]) && $pessoa["sexo"] == "m") {
                    echo "selected";
                }
?>>Masculino</option>
                    <option value="f" selected  <?php
                       if (isset($pessoa["sexo"]) && $pessoa["sexo"] == "f") {
                           echo "selected";
                       }
                       ?>>Feminino</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>NASCIMENTO</td>
            <td><input style="width: 225px;" type="text" name="dtnascimento" id="dtnascimento" class="data" value="<?php
                       if (isset($pessoa["dtnascimento"])) {
                           echo implode("/", array_reverse(explode("-", $pessoa["dtnascimento"])));
                       }
                       ?>" title="Digite aqui a data de nascimento"/></td>
            <td>LOCAL NASCIMENTO</td>
            <td><input style="width: 225px;" type="text" name="localnascimento" id="localnascimento" value="<?php
                       if (isset($pessoa["localnascimento"])) {
                           echo $pessoa["localnascimento"];
                       }
                       ?>"/></td>
        </tr>
        <tr>
            <td>CEP</td>
            <td colspan="3">
                <input style="width: 225px;max-width: 225px;" <?= $requireForm ?> type="text" name="cep" id="cep" value="<?php if (isset($pessoa["cep"])) {echo $pessoa["cep"];} ?>" title="Digite aqui cep" placeholder="Digite CEP">            
            </td>
        </tr>
        <tr>
            <td>TIPO LOG.</td>
            <td>
                <input list="tiposlogradouro" style="width: 225px;max-width: 225px;" <?= $requireForm ?> type="text" name="tipologradouro" id="tipologradouro" value="<?php
                       if (isset($pessoa["tipologradouro"])) {
                           echo $pessoa["tipologradouro"];
                       }
                       ?>" title="Digite aqui tipo logradouro" placeholder="rua, bairro, avenida, etc...">            
                <datalist id="tiposlogradouro">
                    <option>AEROPORTO</option>
                    <option>ALAMEDA</option>
                    <option>APARTAMENTO</option>
                    <option>AVENIDA</option>
                    <option>BECO</option>
                    <option>BLOCO</option>
                    <option>CAMINHO</option>
                    <option>ESCADINHA</option>
                    <option>ESTAÇÃO</option>
                    <option>ESTRADA</option>
                    <option>FAZENDA</option>
                    <option>FORTALEZA</option>
                    <option>GALERIA</option>
                    <option>LADEIRA</option>
                    <option>LARGO</option>
                    <option>PRAÇA</option>
                    <option>PARQUE</option>
                    <option>PRAIA</option>
                    <option>QUADRA</option>
                    <option>QUILÔMETRO</option>
                    <option>QUINTA</option>
                    <option>RODOVIA</option>
                    <option>RUA</option>
                    <option>SUPER QUADRA</option>
                    <option>TRAVESSA</option>
                    <option>VIADUTO</option>
                    <option>VILA</option>                    
                </datalist>
            </td>
            <td>NÚMERO</td>
            <td>
                <input style="width: 225px;max-width: 225px;" <?= $requireForm ?> type="text" name="numero" id="numero" value="<?php
                    if (isset($pessoa["numero"])) {
                        echo $pessoa["numero"];
                    }
                    ?>" title="Digite aqui numero" placeholder="Digite aqui numero">
            </td>            

        </tr>
        <tr>
            <td>LOGRADOURO</td> 
            <td>
                <input style="width: 225px;max-width: 225px;" <?= $requireForm ?> type="text" name="logradouro" id="logradouro" value="<?php
                    if (isset($pessoa["logradouro"])) {
                        echo $pessoa["logradouro"];
                    }
                    ?>" title="Digite aqui logradouro" placeholder="Digite aqui logradouro">
            </td>
            <td>BAIRRO</td>
            <td>
                <input style="width: 225px;max-width: 225px;" <?= $requireForm ?> type="text" name="bairro" id="bairro" value="<?php
                    if (isset($pessoa["bairro"])) {
                        echo $pessoa["bairro"];
                    }
                    ?>" title="Digite aqui bairro" placeholder="Digite aqui bairro">
            </td>
        </tr>
        <tr>
            <td>CIDADE</td>
            <td>
                <input style="width: 225px;max-width: 225px;" <?= $requireForm ?> type="text" name="cidade" id="cidade" value="<?php
                    if (isset($pessoa["cidade"])) {
                        echo $pessoa["cidade"];
                    }
                    ?>" title="Digite aqui cidade" placeholder="Digite aqui cidade">
            </td>
            <td>ESTADO</td>
            <td>
                <select style="width: 230px;" name="estado" id="uf">
                    <?php
                    $resestado = $conexao->comando("select * from estado order by nome");
                    $qtdestado = $conexao->qtdResultado($resestado);
                    if ($qtdestado > 0) {
                        echo '<option value="">--Selecione--</option>';
                        while ($estado = $conexao->resultadoArray($resestado)) {
                            if (isset($pessoa["estado"]) && strtolower($pessoa["estado"]) == strtolower($estado["sigla"])) {
                                echo '<option sigla="', $estado["sigla"], '" selected value="', $estado["sigla"], '">', strtoupper($estado["nome"]), '</option>';
                            } else {
                                echo '<option sigla="', $estado["sigla"], '" value="', $estado["sigla"], '">', strtoupper($estado["nome"]), '</option>';
                            }
                        }
                    } else {
                        echo '<option value="">--Nada encontrado--</option>';
                    }
                    ?>
                </select>                
            </td>
        </tr>
        <tr>
            <td>EST. CIVIL</td>
            <td>
                <select style="width: 230px;max-width: 230px;" name="estadocivil" id="estadocivil" <?= $requireForm ?>>
                    <?php
                    $resestado = $conexao->comando("select * from estadocivil order by nome");
                    $qtdestado = $conexao->qtdResultado($resestado);
                    if ($qtdestado > 0) {
                        echo '<option value="">--Selecione--</option>';
                        while ($estado = $conexao->resultadoArray($resestado)) {
                            if (isset($pessoa["estadocivil"]) && $pessoa["estadocivil"] == $estado["codestado"]) {
                                echo '<option selected value="', $estado["codestado"], '">', $estado["nome"], '</option>';
                            } else {
                                echo '<option value="', $estado["codestado"], '">', $estado["nome"], '</option>';
                            }
                        }
                    } else {
                        echo '<option value="">--Nada encontrado--</option>';
                    }
                    ?>
                </select>
            </td>
            <td>PAI</td>
            <td>
                <input style="width: 225px;" type="text" name="pai" id="pai" value="<?php
                    if (isset($pessoa["pai"])) {
                        echo $pessoa["pai"];
                    }
                    ?>"/>
            </td>
        </tr>
        <tr>
            <td>MÃE</td>
            <td><input style="width: 225px;" type="text" name="mae" id="mae" value="<?php
                    if (isset($pessoa["mae"])) {
                        echo $pessoa["mae"];
                    }
                    ?>"/></td>
            <td>E-MAIL</td>
            <td><input style="width: 225px;" type="email" name='email' id="email" value="<?php
                if (isset($pessoa["email"])) {
                    echo $pessoa["email"];
                }
                    ?>"/></td>
        </tr>
        <tr>
            <td>Categoria</td>
            <td>
                <select style="width: 225px;" name="codcategoria" id="codcategoria">
            <?php
            if (!isset($_GET["callcenter"])) {
                $andCategoria = " and codcategoria = 1;";
            } else {
                $andCategoria = "and codcategoria in(1,6)";
            }
            $rescategoria3 = $conexao->comando("select * from categoriapessoa where 1 = 1 {$andCategoria}");
            $qtdcategoria3 = $conexao->qtdResultado($rescategoria3);
            if ($qtdcategoria3 > 0) {
                while ($categoria3 = $conexao->resultadoArray($rescategoria3)) {
                    if (isset($pessoa["codcategoria"]) && $pessoa["codcategoria"] == $categoria3["codcategoria"]) {
                        echo '<option selected value="', $categoria3["codcategoria"], '">', strtoupper($categoria3["nome"]), '</option>';
                    } else {
                        echo '<option value="', $categoria3["codcategoria"], '">', strtoupper($categoria3["nome"]), '</option>';
                    }
                }
            } else {
                echo '<option value="">--Nada encontrado--</option>';
            }
            ?>
                </select>
            </td>
            <td></td>
            <td></td>
        </tr>
    </table>
    <div id="consignacoes" style="height: auto;border-top: 1px solid black;width: 100%;float: left;">
        <a href="javascript: abreHistoricoConsignacoes();" style="float: left;margin-top: 0px;margin-right: 70%;" title="Clique para exibir ou fechar">
            <img style="width: 20px; float: left;" src="../visao/recursos/img/exibe_consignacao.png" alt="Exibir Consignações"/>
            <div style="width: 310px; margin-top: 5px;">
                EXIBIR CONSIGNAÇÕES
            <?php
            $ultimaAtualizacao = $conexao->comandoArray("select DATE_FORMAT(beneficiocliente.dtconsulta, '%d/%m/%Y') as dtconsulta2 from beneficiocliente  where codempresa = '{$_SESSION['codempresa']}' and codpessoa = '{$pessoa["codpessoa"]}' and dtconsulta <> '0000-00-00 00:00:00'");
            echo 'Última consulta: ', $ultimaAtualizacao["dtconsulta2"];
            ?>
            </div>
        </a>
        <div id="historico_consignacoes" style="">
            <?php
            $coeficiente = new Coeficiente($conexao);
            $coeficientep = $coeficiente->procuraCoeficienteHoje();
            $coeficienteEmprestimoFinal = str_replace(".", ",", $coeficientep["valor"]);            
            
            $sql = "select especie.nome as beneficiocliente, beneficiocliente.codbeneficio, banco.nome as banco, beneficiocliente.meio, beneficiocliente.salariobase, 
            beneficiocliente.agencia, beneficiocliente.contacorrente, beneficiocliente.margem, especie.numinss as especie, beneficiocliente.codbeneficio
            from beneficiocliente 
            left join especie on especie.codespecie = beneficiocliente.codespecie
            left join banco on banco.codbanco = beneficiocliente.codbanco
            where beneficiocliente.codpessoa = '{$_GET["codpessoa"]}' and (beneficiocliente.situacao = 'ativo' or beneficiocliente.situacao = '') and beneficiocliente.codempresa = '{$_SESSION['codempresa']}'";
            $resbeneficios = $conexao->comando($sql);
            $qtdbeneficios = $conexao->qtdResultado($resbeneficios);
            if ($qtdbeneficios > 0) {
                $linhaBeneficio = 0;
                echo '<input type="hidden" name="qtd_beneficio" id="qtd_beneficio" value="', $qtdbeneficios, '"/>';
                while ($beneficio = $conexao->resultadoArray($resbeneficios)) {
                    echo '<table class="tabela_formulario" style="width: 100%;float: left;">';
                    echo '<tr>';
                    echo '<td title="', $beneficio["codbeneficio"], '">Espécie(', $beneficio["especie"], ')</td>';
                    echo '<td colspan="4">BANCO PAGADOR</td>';
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td>', $beneficio["beneficiocliente"], '</td>';
                    echo '<td>', $beneficio["meio"], '</td>';
                    echo '<td>', $beneficio["banco"], '</td>';
                    echo '<td> AG:', $beneficio["agencia"], '</td>';
                    echo '<td> C/C:', $beneficio["contacorrente"], '</td>';
                    echo '<td> Salário:', number_format($beneficio["salariobase"], 2, ",", ""), '</td>';
                    echo '</tr>';
                    echo '</table>';
                    $sql = "select distinct emprestimo.*, banco.nome as banco
                    from emprestimo
                    left join beneficiocliente as beneficio on beneficio.codpessoa = emprestimo.codpessoa and beneficio.codempresa = emprestimo.codempresa 
                    left join banco on banco.codbanco = emprestimo.codbanco
                    where emprestimo.codempresa = '{$_SESSION['codempresa']}' 
                    and emprestimo.codbeneficio = '{$beneficio["codbeneficio"]}'    
                    and emprestimo.codpessoa = '{$_GET["codpessoa"]}' order by dtparcela";
      
                    $resemprestimo = $conexao->comando($sql);
                    $qtdemprestimo = $conexao->qtdResultado($resemprestimo);
                    if ($qtdemprestimo > 0) {

                        $linhaEmprestimo = 0;
                        $totalCoeficiente = 0.0;
                        $totalTroco = 0.0;
                        echo '<table  class="tabela_formulario" style="width: 100%;float: left;">';
                        echo '<tr>';
                        echo '<td colspan="7" style="text-align: center;background: orange; color: white; font-size: 15px;">PORTABILIDADE</td>';
                        echo '</tr>';
                        echo '<tr>';
                        echo '<td>Banco</td>';
                        echo '<td>Parcela</td>';
                        echo '<td>Quitação</td>';
                        echo '<td>Prazo</td>';
                        echo '<td>Restante</td>';
                        echo '<td>Coeficiente</td>';
                        echo '<td>Liberado</td>';
                        echo '</tr>';
                        while ($emprestimo = $conexao->resultadoArray($resemprestimo)) {
                            if($emprestimo["quitacao"] != $emprestimo["saldo_aproximado"]){
                                $emprestimo["quitacao"] = $emprestimo["saldo_aproximado"];
                                $sql = "update emprestimo set quitacao = '".$emprestimo["saldo_aproximado"]."' where codemprestimo = '{$emprestimo["codemprestimo"]}'";
                                $conexao->comando($sql);
                            }
                            echo '<tr>';
                            echo '<td title="banco empréstimo">', $emprestimo["banco"], '</td>';
                            echo '<td id="vl_parcela_', $linhaBeneficio, '_', $linhaEmprestimo, '" title="vl parcela">', number_format($emprestimo["vlparcela"], 2, ",", ""), '</td>';
                            echo '<td id="vl_quitacao_', $linhaBeneficio, '_', $linhaEmprestimo, '" title="vl para quitação">', number_format($emprestimo["quitacao"], 2, ",", ""), '</td>';
                            echo '<td title="prazo">', $emprestimo["prazo"], '</td>';
                            echo '<td title="prazo">', $emprestimo["parcelas_aberto"], '</td>';
                            if (!isset($emprestimo["coeficiente"]) || $emprestimo["coeficiente"] == NULL || $emprestimo["coeficiente"] == "" || $emprestimo["coeficiente"] == 0) {
                                $emprestimo["coeficiente"] = $coeficienteEmprestimoFinal;
                            }
                            echo '<td><input type="text" class="coeficiente" name="coeficiente[]" id="coeficiente_', $linhaBeneficio, '_', $linhaEmprestimo, '" title="Coeficiente" placeholder="Coeficiente" value="', $emprestimo["coeficiente"], '"/></td>';
                            if (isset($emprestimo["coeficiente"]) && $emprestimo["coeficiente"] != NULL && $emprestimo["coeficiente"] != "" && $emprestimo["coeficiente"] > 0) {
                                $troco = $emprestimo["vlparcela"] / ($emprestimo["coeficiente"] - $emprestimo["quitacao"]);
                            }
                            $totalCoeficiente += $emprestimo["coeficiente"];
                            $totalTroco += $troco;
                            echo '<td><input type="text" disabled class="troco" name="troco[]" id="troco_', $linhaBeneficio, '_', $linhaEmprestimo, '" title="Troco do cliente" placeholder="troco" value="', $troco, '"/></td>';
                            echo '</tr>';
                            $linhaEmprestimo++;
                        }

                        echo '</tbody>';
                        echo '<tfoot>';
                        echo '<tr>';
                        echo '<td>--</td>';
                        echo '<td>--</td>';
                        echo '<td>--</td>';
                        echo '<td>--</td>';
                        echo '<td>--</td>';
                        echo '<td>Total da renovação</td>';
                        echo '<td id="totalTroco', $linhaBeneficio, '" title="Total troco do cliente">R$ ', number_format($totalTroco, 2, ",", ""), '</td>';
                        echo '</tr>';
                        echo '</tfoot>';
                        echo '</table>';
                    }
                    echo '<table  class="tabela_formulario" style="width: 100%;float: left;">';
                    echo '<tr>';
                    echo '<td colspan="6" style="text-align: center;background: orange; color: white; font-size: 15px;">MARGEM ESTIMADA</td>';
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td style="width:265px;">--</td>';
                    echo '<td style="width:75px;">--</td>';
                    echo '<td style="width:95px;">--</td>';
                    echo '<td id="margem', $linhaBeneficio, '" style="width:60px;">R$ ', number_format($beneficio["margem"], 2, ",", ""), '</td>';
                    echo '<td style="width: 245px;"><input type="text" class="coeficiente_margem" name="coeficiente_margem[]" id="coeficiente_margem', $linhaBeneficio, '" title="Coeficiente" placeholder="Coeficiente" value="', $coeficienteEmprestimoFinal, '"/></td>';
                    echo '<td id="total_margem', $linhaBeneficio, '">R$ 0,00</td>';
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td style="width:265px;">--</td>';
                    echo '<td style="width:75px;">--</td>';
                    echo '<td style="width:95px;">--</td>';
                    echo '<td style="width:60px;">--</td>';
                    echo '<td style="width: 245px;">Total Liberado</td>';
                    echo '<td id="total_liberado', $linhaBeneficio, '">R$ 0,00</td>';
                    echo '</tr>';
                    echo '</table>';
                    $linhaBeneficio++;
                }
            } else {
                echo '<div>Nada encontrado!!!</div>';
            }
            ?>
        </div> 
    </div>
<!--        <table class="tabela_formulario">
        <tr>
            <td>Agendamento</td>
            <td>
                <input type="text" name="dtagenda" id="dtagenda" class="data" value=""  <?php
        if (!isset($pessoa["codpessoa"])) {
            echo "title='Quando é cliente novo o agendamento será salvo no cadastrar!!!'";
        }
        ?>/>
<?php if (isset($pessoa["codpessoa"])) { ?>
                        <a href="javascript:inserirAgenda()" class="botao" title="Clique aqui para agendar retorno ao cliente" onclick="">Agendar</a>
                <?php } ?>
            </td>            
        </tr>
    </table>-->

    <div id="observacao" style="border-top: 1px solid black;">
        <p>OBSERVAÇÃO</p>
        <p>
            <textarea style="margin: 0px; width: 790px; height: 70px;" name="observacao" id="observacao" placeholder="Digite aqui observação ao cliente"></textarea>     
        </p>
        <div id="observacao_anterior">
                <?php
                $sql = "select observacaocliente.texto, DATE_FORMAT(observacaocliente.dtcadastro, '%d/%m/%Y') as dtcadastro2, pessoa.nome as funcionario 
            from observacaocliente 
            inner join pessoa on pessoa.codpessoa = observacaocliente.codfuncionario and pessoa.codempresa = observacaocliente.codempresa
            where observacaocliente.codpessoa = '{$_GET["codpessoa"]}' and observacaocliente.codempresa = '{$_SESSION['codempresa']}' and texto <> ''";
                $resobservacao = $conexao->comando($sql);
                $qtdobservacao = $conexao->qtdResultado($resobservacao);
                if ($qtdobservacao > 0) {
                    echo $qtdobservacao, ' - observações encontradas:<br>';
                    echo '<ul>';
                    while ($observacao = $conexao->resultadoArray($resobservacao)) {
                        echo '<li style="list-style-type: initial;">';
                        echo $observacao["texto"], '<br>';
//                    echo 'Dt. Cadastro:', $observacao["dtcadastro2"], ' - Funcionário:', $observacao["funcionario"];
                        echo '</li>';
                    }
                    echo '</ul>';
                }
                ?>
        </div>
    </div>
    <div id="telefones" style="border-top: 1px solid black;">
        <p>TELEFONE(s) DE CONTATO</p>
                <?php
                $sql = "select * from telefone where codpessoa = '{$pessoa["codpessoa"]}' and numero <> '' and codempresa = '{$_SESSION['codempresa']}'";
                $restelefone = $conexao->comando($sql);
                $qtdtelefone = $conexao->qtdResultado($restelefone);
                if ($qtdtelefone > 0) {
                    $linha = 1;
                    while ($telefone = $conexao->resultadoArray($restelefone)) {
                        ?>
                <p id="linhaTelefone1">
                    <select name="tipotelefone[]" id="tipotelefone<?= $linha ?>">
                        <?php
                        $restipo = $conexao->comando("select * from tipotelefone order by nome");
                        $qtdtipo = $conexao->qtdResultado($restipo);
                        if ($qtdtipo > 0) {
                            $optionTipoTelefone = '<option value="">--Selecione--</option>';
                            while ($tipo = $conexao->resultadoArray($restipo)) {
                                if (isset($telefone["codtipo"]) && $telefone["codtipo"] == $tipo["codtipo"]) {
                                    $optionTipoTelefone .= '<option selected value="' . $tipo["codtipo"] . '">' . $tipo["nome"] . '</option>';
                                } else {
                                    $optionTipoTelefone .= '<option value="' . $tipo["codtipo"] . '">' . $tipo["nome"] . '</option>';
                                }
                            }
                        } else {
                            $optionTipoTelefone .= '<option value="">--Nada encontrado--</option>';
                        }
                        echo $optionTipoTelefone;
                        ?>
                    </select>
                    -
                    <input type="hidden" name="optionTipoTelefone" id="optionTipoTelefone" value='<?php if (isset($optionTipoTelefone)) {echo $optionTipoTelefone;}?>'/>
                    <input style="width: 225px;" <?= $requireForm ?> type="text" name="telefone[]" id="telefone<?= $linha ?>" value="<?= reestruturandoTelefone($telefone["numero"]) ?>" title="Digite aqui telefone" placeholder="(00)0000-0000">
                    <a class="botao" href="#" onclick="inserirTelefone(<?= $linha ?>);" title="Adiciona novo telefone">+</a>
                    <a class="botao" href="#" onclick="removeTelefone(<?= $linha ?>);" title="Remove telefone da linha">-</a>
                    <a href='javascript:abrirPopUp("EnvioSMS2.php?numero=<?= $telefone["numero"] ?>")'><img style='width: 41px;margin-bottom: -10px;padding: 0;height: auto;' src='../visao/recursos/img/SMS.png' alt='SMS telefone'/></a>            
                </p>
            <?php
            $linha++;
        }
    } else {
        ?>
            <p id="linhaTelefone1">
                <select name="tipotelefone[]" id="tipotelefone1">
        <?php
        $restipo = $conexao->comando("select * from tipotelefone order by nome");
        $qtdtipo = $conexao->qtdResultado($restipo);
        if ($qtdtipo > 0) {
            $optionTipoTelefone = '<option value="">--Selecione--</option>';
            while ($tipo = $conexao->resultadoArray($restipo)) {
                $optionTipoTelefone .= '<option value="' . $tipo["codtipo"] . '">' . $tipo["nome"] . '</option>';
            }
        } else {
            $optionTipoTelefone .= '<option value="">--Nada encontrado--</option>';
        }
        echo $optionTipoTelefone;
        ?>
                </select>
                -
                <input type="hidden" name="optionTipoTelefone" id="optionTipoTelefone" value='<?php
        if (isset($optionTipoTelefone)) {
            echo $optionTipoTelefone;
        }
        ?>'/>
                <input style="width: 225px;" <?= $requireForm ?> type="text" name="telefone[]" id="telefone1" class="telefone"   value="" title="Digite aqui telefone" placeholder="(00)0000-0000">
                <a class="botao" onclick="inserirTelefone(1);" title="Adiciona novo telefone">+</a>
                <a class="botao" onclick="removeTelefone(1);" title="Remove telefone da linha">-</a>
                <a href='javascript:abrirPopUp("EnvioSMS2.php?numero=telefone1.value")'><img style='width: 40px;margin-bottom: -10px;padding: 0;height: auto;' src='../visao/recursos/img/SMS.png' alt='SMS telefone'/>SMS</a>            
            <?php } ?>
    </div>
<?php
//chamando seleção para beneficios do cliente e verificando se checa o checkbox
$resbeneficio = $conexao->comando("select * from beneficiocliente where codpessoa = '{$pessoa["codpessoa"]}' and codempresa = '{$_SESSION['codempresa']}'");
$qtdbeneficio = $conexao->qtdResultado($resbeneficio);
if ($qtdbeneficio > 0) {
    $checkedAposentado = "checked";
    $estiloAposentado = "margin-bottom: 5px;";
} else {
    $checkedAposentado = "";
    $estiloAposentado = "margin-bottom: 5px;display: none";
}

//chamando seleção para servidor cliente e verificando se checa o checkbox
$restrabalho = $conexao->comando("select * from trabalho where codempresa = '{$_SESSION['codempresa']}' and codpessoa = '{$_GET["codpessoa"]}' and codtipo = 1");
$qtdtrabalho = $conexao->qtdResultado($restrabalho);
if ($qtdtrabalho > 0) {
    $estiloTrabalho = "border-top: 1px solid black;  margin-bottom: 5px;";
    $checkedServidor = "checked";
} else {
    $estiloTrabalho = "border-top: 1px solid black;  margin-bottom: 5px;display: none";
    $checkedServidor = "";
}

//chamando seleção para servidor cliente e verificando se checa o checkbox
$restrabalho2 = $conexao->comando("select * from trabalho where codempresa = '{$_SESSION['codempresa']}' and codpessoa = '{$_GET["codpessoa"]}' and codtipo = 2");
$qtdtrabalho2 = $conexao->qtdResultado($restrabalho);
if ($qtdtrabalho > 0) {
    $estiloTrabalho2 = "border-top: 1px solid black;  margin-bottom: 5px;  margin-top: 5px;";
    $checkedServidor2 = "checked";
} else {
    $estiloTrabalho2 = "border-top: 1px solid black;  margin-bottom: 5px;  display: none";
    $checkedServidor2 = "";
}
?>    
    <div style="border-top: 1px solid black;width: 100%;float: left;">
        <p style="width: 400px; float: left;">
            <label>TIPO</label>
            <input type="checkbox" name="aposentado1" id="aposentado1" value="s" <?= $checkedAposentado ?>/>APOSENTADO
            <input type="checkbox" name="aposentado2" id="aposentado2" value="n" <?= $checkedServidor ?>/>SERVIDOR
            <input type="checkbox" name="aposentado3" id="aposentado3" value="n" <?= $checkedServidor2 ?>/>ASSALARIADO
        <div style="width: 270px; float: left;margin-right: 260px;">
            <a href="javascript: ConsultaCpfInss2()">
                <img style="width: 20px;" src="../visao/recursos/img/NB.png" alt="Importação de beneficios"/>
                <span>
                    IMPORTAR NB
                </span>
            </a>
                    <?php if (isset($_GET["codpessoa"]) && $_SESSION["codnivel"] == 1) { ?>
                <a href="javascript: consultaBeneficioInss3(<?= $_GET["codpessoa"] ?>)">
                    <img style="width: 20px;" src="../visao/recursos/img/NB.png" alt="Detalhamento de beneficios"/>
                    <span>
                        DETALHAMENTO NB
                    </span>
                </a>
                    <?php } ?>
        </div>
        </p> 
    </div>
    <div id="beneficio_aposentado" style="margin-bottom: 5px; float: left;<?= $estiloAposentado ?>">
                    <?php
                    if ($qtdbeneficio > 0) {
                        $linhaBeneficio = 1;
                        while ($beneficio = $conexao->resultadoArray($resbeneficio)) {
                            ?>
                <div id="beneficio_aposentado<?= $linhaBeneficio ?>" style="width: 100%;float: left;">
                    <div id="orgao_pagador<?= $linhaBeneficio ?>" style="width: 200px; float: left;">
                        Órgão Pagador
                        <select name="orgaopagador[]" id="orgaopagador<?= $linhaBeneficio ?>" title="Órgão pagador de aposentadoria" onclick="orgaoPagadorChange(<?= $linhaBeneficio ?>)">
                        <?php
                               $resorgao = $conexao->comando("select * from orgaopagador order by nome");
                               $qtdorgao = $conexao->qtdResultado($resorgao);
                               if ($qtdorgao > 0) {
                                   $optionorgaopagador = '<option value="">--Selecione--</option>';
                                   while ($orgao = $conexao->resultadoArray($resorgao)) {
                                       if (isset($beneficio["codorgao"]) && $beneficio["codorgao"] == $orgao["codorgao"]) {
                                           $optionorgaopagador .= '<option selected value="' . $orgao["codorgao"] . '">' . $orgao["nome"] . '</option>';
                                       } else {
                                           $optionorgaopagador .= '<option value="' . $orgao["codorgao"] . '">' . $orgao["nome"] . '</option>';
                                       }
                                   }
                               } else {
                                   $optionorgaopagador .= '<option value="">--Nada encontrado--</option>';
                               }
                               echo $optionorgaopagador;
                               ?>
                        </select>
                        <input type="hidden" name="optionorgaopagador" id="optionorgaopagador" value='<?php
                        if (isset($optionorgaopagador)) {
                            echo $optionorgaopagador;
                        }
                        ?>'/>
                    </div>
                    <div id="beneficio_inss<?= $linhaBeneficio ?>" style="width: 380px;float: left;">
                        ESPÉCIE
                        <select style="width: 100px;" name="especie[]" id="especie<?= $linhaBeneficio ?>">
                    <?php
                    $resespecie = $conexao->comando("select * from especie order by nome");
                    $qtdespecie = $conexao->qtdResultado($resespecie);
                    if ($qtdespecie > 0) {
                        $optionespecie .= '<option value="">--Selecione--</option>';
                        while ($especie = $conexao->resultadoArray($resespecie)) {
                            if (isset($beneficio["codespecie"]) && $beneficio["codespecie"] == $especie["codespecie"]) {
                                $optionespecie .= '<option selected value="' . $especie["codespecie"] . '">' . $especie["nome"] . '</option>';
                            } else {
                                $optionespecie .= '<option value="' . $especie["codespecie"] . '">' . $especie["nome"] . '</option>';
                            }
                        }
                    } else {
                        $optionespecie .= '<option value="">--Nada encontrado--</option>';
                    }
                    echo $optionespecie;
                    ?>
                            <input type="hidden" name="optionespecie" id="optionespecie" value='<?php
                            if (isset($optionespecie)) {
                                echo $optionespecie;
                            }
                            ?>'/>
                        </select>
                        NUM. BENEFICIO
                        <input type="text" name="numbeneficio[]" id="numbeneficio<?= $linhaBeneficio ?>" value="<?php
                    if (isset($beneficio["numbeneficio"])) {
                        echo $beneficio["numbeneficio"];
                    }
                            ?>"/>
                    </div>
        <?php
        if ((isset($beneficio["numbeneficio"]) && $beneficio["numbeneficio"] != NULL && $beneficio["numbeneficio"] != "") || (isset($beneficio["codorgao"]) && $beneficio["codorgao"] == 3)) {
            $displayMatricula = "display: none;";
        } else {
            $displayMatricula = "";
        }
        ?>
                    <div id="beneficio_outro<?= $linhaBeneficio ?>" style="<?= $displayMatricula ?>width: 205px;float: left;">
                        MATRICULA
                        <input type="text" name="matricula[]" id="matricula<?= $linhaBeneficio ?>" value="<?php
                            if (isset($beneficio["matricula"])) {
                                echo $beneficio["matricula"];
                            }
                            ?>"/>
                    </div> 
                    <div id="salario_base<?= $linhaBeneficio ?>" style="float: left;">
                        SALÁRIO BASE
                        <input type="text" name="salariobase[]" id="salariobase<?= $linhaBeneficio ?>" class="real" value="<?php
                                   if (isset($beneficio["salariobase"])) {
                                       echo number_format($beneficio["salariobase"], 2, ",", "");
                                   }
                                   ?>"/>
                        <button onclick="inserirBeneficio(<?= $linhaBeneficio ?>);" title="Adiciona novo beneficio">+</button>
                        <button onclick="removeBeneficio(<?= $linhaBeneficio ?>);" title="Remove beneficio da linha">-</button>            
                    </div>
        <?php if (isset($beneficio["numbeneficio"])) { ?>
                        <div id="consulta_beneficio<?= $linhaBeneficio ?>" style="width: 70px;  height: 15px;  float: left;">
                            <a class="botao" href="javascript: consultaBeneficioInss2(<?= $beneficio["numbeneficio"] ?>)" title="Clique aqui para consultar o histórico de empréstimos do beneficio">Consulta</a>
                        </div>
        <?php } ?>
                </div>        
        <?php
        $linhaBeneficio++;
    }
} else {//caso não tenha nenhum beneficio ainda cadastrado
    ?>
            <div id="beneficio_aposentado1">
                <div id="orgao_pagador1" style="display: none; width: 195px; float: left;">
                    Órgão Pagador
                    <select name="orgaopagador[]" id="orgaopagador1" title="Órgão pagador de aposentadoria" onclick="orgaoPagadorChange(1)">
            <?php
            $resorgao = $conexao->comando("select * from orgaopagador order by nome");
            $qtdorgao = $conexao->qtdResultado($resorgao);
            if ($qtdorgao > 0) {
                $optionorgaopagador = '<option value="">--Selecione--</option>';
                while ($orgao = $conexao->resultadoArray($resorgao)) {
                    $optionorgaopagador .= '<option value="' . $orgao["codorgao"] . '">' . $orgao["nome"] . '</option>';
                }
            } else {
                $optionorgaopagador .= '<option value="">--Nada encontrado--</option>';
            }
            echo $optionorgaopagador;
            ?>
                    </select>
                    <input type="hidden" name="optionorgaopagador" id="optionorgaopagador" value='<?php
                    if (isset($optionorgaopagador)) {
                        echo $optionorgaopagador;
                    }
                    ?>'/>
                </div>
                <div id="beneficio_inss1" style="width: 380px;float: left; display: none">
                    ESPÉCIE
                    <select style="width: 100px;" name="especie[]" id="especie1">
                    <?php
                    $resespecie = $conexao->comando("select * from especie order by nome");
                    $qtdespecie = $conexao->qtdResultado($resespecie);
                    if ($qtdespecie > 0) {
                        $optionespecie .= '<option value="">--Selecione--</option>';
                        while ($especie = $conexao->resultadoArray($resespecie)) {
                            $optionespecie .= '<option value="' . $especie["codespecie"] . '">' . $especie["nome"] . '</option>';
                        }
                    } else {
                        $optionespecie .= '<option value="">--Nada encontrado--</option>';
                    }
                    echo $optionespecie;
                    ?>
                        <input type="hidden" name="optionespecie" id="optionespecie" value='<?php
                    if (isset($optionespecie)) {
                        echo $optionespecie;
                    }
                    ?>'/>
                    </select>
                    NUM. BENEFICIO
                    <input type="text" name="numbeneficio[]" id="numbeneficio1" value=""/>
                </div>
                <div id="beneficio_outro1" style="width: 205px;float: left; display: none">
                    MATRICULA
                    <input type="text" name="matricula[]" id="matricula1"/>
                </div> 
                <div id="salario_base1" style="display: none;  float: left;">
                    SALÁRIO BASE
                    <input type="text" name="salariobase[]" id="salariobase1" class="real" value=""/>
                    <button onclick="inserirBeneficio(1);" title="Adiciona novo beneficio">+</button>
                    <button onclick="removeBeneficio(1);" title="Remove beneficio da linha">-</button>            
                </div>
            </div>

                    <?php
                }
                ?>
    </div>        
    <div id="nao_aposentado" style="<?= $estiloTrabalho ?>">
<?php
if ($qtdtrabalho > 0) {
    $linhaTrabalho = 1;
    while ($trabalho = $conexao->resultadoArray($restrabalho)) {
        ?>        
                <div id="nao_aposentado<?= $linhaTrabalho ?>" style="margin-top: 5px;">
                    LOCAL
                    <select style='width: 185px;' name="localtrabalho[]" id="localtrabalho<?= $linhaTrabalho ?>">
                <?php
                $reslocal = $conexao->comando("select * from localservidor order by nome");
                $qtdlocal = $conexao->qtdResultado($reslocal);
                if ($qtdlocal > 0) {
                    echo '<option value="">--Selecione--</option>';
                    while ($local = $conexao->resultadoArray($reslocal)) {
                        if (isset($trabalho["local"]) && $trabalho["local"] == $local["codlocal"]) {
                            echo '<option selected value="', $local["codlocal"], '">', $local["nome"], '</option>';
                        } else {
                            echo '<option value="', $local["codlocal"], '">', $local["nome"], '</option>';
                        }
                    }
                } else {
                    echo '<option value="">--Nada encontrado--</option>';
                }
                ?>
                    </select> 
                    DEPARTAMENTO
                    <select style='width: 110px;' name="departamento[]" id="departamento<?= $linhaTrabalho ?>">
                        <?php
                        $resdepartamento = $conexao->comando("select * from departamento order by nome");
                        $qtddepartamento = $conexao->qtdResultado($resdepartamento);
                        if ($qtddepartamento > 0) {
                            echo '<option value="">--Selecione--</option>';
                            while ($departamento = $conexao->resultadoArray($resdepartamento)) {
                                if (isset($trabalho["coddepartamento"]) && $trabalho["coddepartamento"] == $departamento["coddepartamento"]) {
                                    echo '<option selected value="', $departamento["coddepartamento"], '">', $departamento["nome"], '</option>';
                                } else {
                                    echo '<option value="', $departamento["coddepartamento"], '">', $departamento["nome"], '</option>';
                                }
                            }
                        } else {
                            echo '<option value="">--Nada encontrado--</option>';
                        }
                        ?>
                    </select>  
                    CARGO
                    <select style='width: 110px;' name="codcargo[]" id="codcargo<?= $linhaTrabalho ?>">
                        <?php
                        $rescargo = $conexao->comando("select * from cargo order by nome");
                        $qtdcargo = $conexao->qtdResultado($rescargo);
                        if ($qtdcargo > 0) {
                            echo '<option value="">--Selecione--</option>';
                            while ($cargo = $conexao->resultadoArray($rescargo)) {
                                if (isset($trabalho["codcargo"]) && $trabalho["codcargo"] == $cargo["codcargo"]) {
                                    echo '<option selected value="', $cargo["codcargo"], '">', $cargo["nome"], '</option>';
                                } else {
                                    echo '<option value="', $cargo["codcargo"], '">', $cargo["nome"], '</option>';
                                }
                            }
                        } else {
                            echo '<option value="">--Nada encontrado--</option>';
                        }
                        ?>
                    </select>       
                    MATRICULA
                    <input style="width: 140px;" type="text" name="matriculaservidor[]" id="matriculaservidor<?= $linhaTrabalho ?>" value="<?= $trabalho["matricula"] ?>"/>     
                    SALÁRIO BASE
                    <input style='width: 130px;' type="text" name="salariobaseservidor[]" id="salariobaseservidor<?= $linhaTrabalho ?>" class="real" value="<?= number_format($trabalho["salariobase"], 2, ",", "") ?>"/>
                    <a class="botao" href="#" onclick="adicionarEmprego();">+</a>
                    <a class="botao" href="#" onclick="removerEmprego();">-</a>

                </div>
                <?php
                $linhaTrabalho++;
            }
        } else {//caso não tenha nenhum trabalho como servidor gravado inicia vazio...
            ?>
            <div id="nao_aposentado<?= $linhaTrabalho ?>" style="margin-top: 5px;">
                LOCAL
                <select style='width: 185px;' name="localtrabalho[]" id="localtrabalho1">
    <?php
    $reslocal = $conexao->comando("select * from localservidor order by nome");
    $qtdlocal = $conexao->qtdResultado($reslocal);
    if ($qtdlocal > 0) {
        echo '<option value="">--Selecione--</option>';
        while ($local = $conexao->resultadoArray($reslocal)) {
            echo '<option value="', $local["codlocal"], '">', $local["nome"], '</option>';
        }
    } else {
        echo '<option value="">--Nada encontrado--</option>';
    }
    ?>
                </select> 
                DEPARTAMENTO
                <select style='width: 110px;' name="departamento[]" id="departamento1">
                    <?php
                    $resdepartamento = $conexao->comando("select * from departamento order by nome");
                    $qtddepartamento = $conexao->qtdResultado($resdepartamento);
                    if ($qtddepartamento > 0) {
                        echo '<option value="">--Selecione--</option>';
                        while ($departamento = $conexao->resultadoArray($resdepartamento)) {
                            echo '<option value="', $departamento["coddepartamento"], '">', $departamento["nome"], '</option>';
                        }
                    } else {
                        echo '<option value="">--Nada encontrado--</option>';
                    }
                    ?>
                </select>  
                CARGO
                <select style='width: 110px;' name="codcargo[]" id="codcargo1">
    <?php
    $rescargo = $conexao->comando("select * from cargo order by nome");
    $qtdcargo = $conexao->qtdResultado($rescargo);
    if ($qtdcargo > 0) {
        echo '<option value="">--Selecione--</option>';
        while ($cargo = $conexao->resultadoArray($rescargo)) {
            echo '<option value="', $cargo["codcargo"], '">', $cargo["nome"], '</option>';
        }
    } else {
        echo '<option value="">--Nada encontrado--</option>';
    }
    ?>
                </select>       
                MATRICULA
                <input style="width: 140px;" type="text" name="matriculaservidor[]" id="matriculaservidor1" value=""/>     
                SALÁRIO BASE
                <input style='width: 130px;' type="text" name="salariobaseservidor[]" id="salariobaseservidor1" class="real" value=""/>
                <a class="botao" href="#" onclick="inserirEmpregoServidor(1);">+</a>
                <a class="botao" href="#" onclick="removerEmpregoServidor(1);">-</a>     
            </div>
    <?php
}
?>
    </div>
    <div id="assalariado" style="<?= $estiloTrabalho2 ?>">
    <?php
    if ($qtdtrabalho2 > 0) {
        $linhaTrabalho2 = 1;
        while ($trabalho2 = $conexao->resultadoArray($restrabalho2)) {
            ?>
                <div id="assalariado<?= $linhaTrabalho2 ?>" style="margin-top: 5px;">
                    EMPRESA <input type="text" name="empresa[]" id="empresa<?= $linhaTrabalho2 ?>" placeholder="Empresa" value="<?= $trabalho2["empresa"] ?>"/>
                    ENDEREÇO <input type="text" name="endereco[]" id="endereco<?= $linhaTrabalho2 ?>" placeholder="endereco" value="<?= $trabalho2["local"] ?>"/>
                    CARGO 
                    <select style='width: 110px;' name="codcargoAssalariado[]" id="codcargoAssalariado<?= $linhaTrabalho2 ?>">
            <?php
            $rescargo = $conexao->comando("select * from cargo order by nome");
            $qtdcargo = $conexao->qtdResultado($rescargo);
            if ($qtdcargo > 0) {
                echo '<option value="">--Selecione--</option>';
                while ($cargo = $conexao->resultadoArray($rescargo)) {
                    if (isset($trabalho2["codcargo"]) && $trabalho2["codcargo"] == $cargo["codcargo"]) {
                        echo '<option selected value="', $cargo["codcargo"], '">', $cargo["nome"], '</option>';
                    } else {
                        echo '<option value="', $cargo["codcargo"], '">', $cargo["nome"], '</option>';
                    }
                }
            } else {
                echo '<option value="">--Nada encontrado--</option>';
            }
            ?>
                    </select>                 
                    TEMPO <input type="number" min="0" max="999" name="tempoAssalariado[]" id="tempoAssalariado<?= $linhaTrabalho2 ?>" value="<?= $trabalho2["tempo"] ?>"/>         
                    SALÁRIO BASE <input style='width: 130px;' type="text" name="salariobasetrabalho[]" id="salariobasetrabalho<?= $linhaTrabalho2 ?>" class="real" value="<?= number_format($trabalho2["salariobase"], 2, ",", "") ?>"/>
                    <a class="botao" href="#" onclick="inserirEmprego2(<?= $linhaTrabalho2 ?>);">+</a>
                    <a class="botao" href="#" onclick="removerEmprego2(<?= $linhaTrabalho2 ?>);">-</a>
                </div>        
                <?php
                $linhaTrabalho2++;
            }
        } else {
            ?>
            <div id="assalariado1" style="margin-top: 5px;">
                EMPRESA <input type="text" name="empresa[]" id="empresa1" placeholder="Empresa"/>
                ENDEREÇO <input type="text" name="endereco[]" id="endereco1" placeholder="endereco"/>
                CARGO 
                <select style='width: 110px;' name="codcargoAssalariado[]" id="codcargoAssalariado1">
            <?php
            $rescargo = $conexao->comando("select * from cargo order by nome");
            $qtdcargo = $conexao->qtdResultado($rescargo);
            if ($qtdcargo > 0) {
                echo '<option value="">--Selecione--</option>';
                while ($cargo = $conexao->resultadoArray($rescargo)) {
                    echo '<option value="', $cargo["codcargo"], '">', $cargo["nome"], '</option>';
                }
            } else {
                echo '<option value="">--Nada encontrado--</option>';
            }
            ?>
                </select>                 
                TEMPO <input type="number" min="0" max="999" name="tempoAssalariado[]" id="tempoAssalariado1"/>         
                SALÁRIO BASE <input style='width: 130px;' type="text" name="salariobasetrabalho[]" id="salariobasetrabalho1" class="real" value=""/>
                <a class="botao" href="#" onclick="inserirEmprego2(1);">+</a>
                <a class="botao" href="#" onclick="removerEmprego2(1);">-</a>
            </div>
                    <?php } ?>
    </div>
                    <?php
                    if (!isset($pessoa["codpessoa"])) {
                        $codigo_pessoa = $_GET["codpessoa"];
                    } else {
                        $codigo_pessoa = $pessoa["codpessoa"];
                    }
                    if (isset($codigo_pessoa) && $codigo_pessoa != NULL && $codigo_pessoa != "") {
                        $sql = "select agenda.*, DATE_FORMAT(agenda.dtcadastro, '%d/%m/%Y') as dtcadastro2, pessoa.nome as funcionario, status.nome as status,
        DATE_FORMAT(agenda.dtagenda, '%d/%m/%Y') as dtagenda2    
        from agenda
        left join pessoa on pessoa.codpessoa = agenda.codfuncionario and pessoa.codempresa = agenda.codempresa
        inner join statuspessoa as status on status.codstatus = agenda.codstatus
        where agenda.codempresa = '{$_SESSION['codempresa']}' and agenda.codpessoa = '{$codigo_pessoa}' order by agenda.dtagenda desc";
                        $resobservacaoLigacao = $conexao->comando($sql)or die("Erro ao procurar histórico de chamadas!!! Causado por:" . mysqli_error($conexao->conexao));
                        $qtdobservacaoLigacao = $conexao->qtdResultado($resobservacaoLigacao);
                    } else {
                        $qtdobservacaoLigacao = 0;
                    }
                    ?>
    <div style="float: left;  width: 100%;">
        <a href="javascript: abrirObservacaoLigacao();">
            <h3 style="background: orange;  color: white;  width: 100%;  margin-left: 0;"><?= $qtdobservacaoLigacao ?> Contato(s) Anteriore(s)</h3>
        </a>
    </div>
    <div id="div_observacao_ligacao" style="display: none">
<?php
if ($qtdobservacaoLigacao > 0) {
    echo '<table class="responstable">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Data</th>';
    echo '<th>Data Agendado</th>';
    echo '<th>Atendente</th>';
    echo '<th>Status</th>';
    echo '<th>Observação</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    while ($observacaoLigacao = $conexao->resultadoArray($resobservacaoLigacao)) {
        echo '<tr>';
        echo '<td>', $observacaoLigacao["dtcadastro2"], '</td>';
        echo '<td>', $observacaoLigacao["dtagenda2"], '</td>';
        echo '<td>', $observacaoLigacao["funcionario"], '</td>';
        echo '<td>', $observacaoLigacao["status"], '</td>';
        echo '<td>', $observacaoLigacao["observacao"], '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
}
?> 
    </div>
    <table class="tabela_formulario" style="width: 900px;">
        <tr>
            <td>Situação</td>
            <td>
                <select name="codstatus" id="codstatus">
<?php
$resstatus = $conexao->comando("select * from statuspessoa order by nome");
$qtdstatus = $conexao->qtdResultado($resstatus);
if ($qtdstatus > 0) {
    echo '<option value="">--Selecione--</option>';
    while ($status = $conexao->resultadoArray($resstatus)) {
        if (isset($pessoa["codstatus"]) && $pessoa["codstatus"] == $status["codstatus"]) {
            echo '<option selected value="', $status["codstatus"], '">', $status["nome"], '</option>';
        } else {
            echo '<option value="', $status["codstatus"], '">', $status["nome"], '</option>';
        }
    }
} else {
    echo '<option value="">--Nada encontrado--</option>';
}
?>
                </select>
            </td>            
            <td>Agendamento</td>
            <td>
                <input type="date" name="dtagenda" id="dtagenda" min="<?=date('Y-m-d')?>" value=""/>
                <input type="time" name="horaagenda" id="horaagenda" value=""/>
                <a href="javascript:inserirAgenda()" onclick="inserirAgenda();" class="botao" title="Clique aqui para agendar retorno ao cliente" onclick="">Agendar</a>
            </td>
        </tr>
        <tr>
            <td>Observação ligação</td>
            <td colspan="3">
                <textarea style="margin: 0px; width: 790px; height: 70px;" name="observacaoligacao" id="observacaoligacao" placeholder="Digite aqui observação da ligação"></textarea>
            </td>
        </tr>
    </table>
<?php
if (!isset($_GET["codpessoa"]) && !isset($pessoa)) {
    if ($nivelp["inserir"] == 1) {
        echo '<input type="submit" name="submit" id="btinserirPessoa" value="Cadastrar"/>';
    }
} else {
    if ($nivelp["atualizar"] == 1) {
        echo '<input style="margin-left: 5px;" type="submit" name="submit" id="btatualizarPessoa" value="Atualizar"/>';
    }
    if ($nivelp["excluir"] == 1) {
        echo '<button style="margin-left: 5px;" onclick="excluir()" id="btexcluirPessoa">EXCLUIR</button>';
    }
    if ($nivelp["inserir"] == 1) {
        echo '<button style="margin-left: 5px;" onclick="btNovoPessoa()" id="btnovoPessoa">NOVO</button>';
    }
}
$nivel_operador = $conexao->comandoArray("select * from nivel where codnivel = '{$_SESSION["codnivel"]}' and codempresa = '{$_SESSION['codempresa']}' and nome = 'OPERADOR'");
if (isset($_GET["callcenter"])) {
    echo '<a style="margin-left: 5px; display: none" id="btProximoCliente" class="botao" href="javascript: proximoFila()">Próximo</a>';
} elseif (!isset($nivel_operador)) {
    echo '<a style="margin-left: 5px;" id="btProximoCliente" class="botao" href="javascript: proximoCliente(', $pessoa["codpessoa"], ')">Próximo Cliente</a>';
}
?>       
</form>


<div class="progress">
    <div class="bar"></div>
    <div class="percent">0%</div>
</div>

<div id="status"></div>
