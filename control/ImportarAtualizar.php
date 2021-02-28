<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();

function __autoload($class_name) {
    if (file_exists("../model/" . $class_name . '.php')) {
        include "../model/" . $class_name . '.php';
    } elseif (file_exists("../visao/" . $class_name . '.php')) {
        include "../visao/" . $class_name . '.php';
    } elseif (file_exists("./" . $class_name . '.php')) {
        include "./" . $class_name . '.php';
    }
}

$conexao = new Conexao();
$beneficio = new BeneficioCliente($conexao);
$pessoa = new Pessoa($conexao);
$sql = 'select cep, bairro, cidade, estado, codpessoa, logradouro, cpf from pessoa where codempresa = ' . $_SESSION["codempresa"] . ' and codpessoa = "' . $_POST["codpessoa"] . '"';
$pessoap = $conexao->comandoArray($sql);
$num = $beneficio->consultaCpfInss2($pessoap["cpf"]);

for($i = 0; $i < count($num); $i++){
    $chave = $beneficio->consultaBenInss2($num[$i]);

    /*     * atualizando informações pessoais */
    if (!isset($pessoap["cep"]) || $pessoap["cep"] == NULL || $pessoap["cep"] == "" || !isset($pessoap["bairro"]) || $pessoap["bairro"] == NULL || $pessoap["bairro"] == "" || !isset($pessoap["cidade"]) || $pessoap["cidade"] == NULL || $pessoap["cidade"] == "" || !isset($pessoap["uf"]) || $pessoap["uf"] == NULL || $pessoap["uf"] == "" || !isset($pessoap["cpf"]) || $pessoap["cpf"] == NULL || $pessoap["cpf"] == "" || !isset($pessoap["logradouro"]) || $pessoap["logradouro"] == NULL || $pessoap["logradouro"] == "") {
        $pessoa = new Pessoa($conexao);
        $pessoa->codempresa = $_SESSION["codempresa"];
        $pessoa->codpessoa = $pessoap["codpessoa"];
        if (!isset($pessoap["cep"]) || $pessoap["cep"] == NULL || $pessoap["cep"] == "") {
            $pessoa->cep = $chave->dados_cadastrais->cep;
        }
        if (!isset($pessoap["bairro"]) || $pessoap["bairro"] == NULL || $pessoap["bairro"] == "") {
            $pessoa->bairro = $chave->dados_cadastrais->bairro;
        }
        if (!isset($pessoap["cidade"]) || $pessoap["cidade"] == NULL || $pessoap["cidade"] == "") {
            $pessoa->cidade = $chave->dados_cadastrais->cidade;
        }
        if (!isset($pessoap["uf"]) || $pessoap["uf"] == NULL || $pessoap["uf"] == "") {
            $pessoa->estado = $chave->dados_cadastrais->uf;
        }
        if (!isset($pessoap["logradouro"]) || $pessoap["logradouro"] == NULL || $pessoap["logradouro"] == "") {
            $pessoa->logradouro = $chave->dados_cadastrais->logradouro;
        }
        if (!isset($pessoap["cpf"]) || $pessoap["cpf"] == NULL || $pessoap["cpf"] == "") {
            $pessoa->cpf = $chave->dados_cadastrais->cpf;
        }
        $resAtualizarPessoa = $pessoa->atualizar();
        if ($resAtualizarPessoa == FALSE) {
            die(json_encode(array('mensagem' => 'Erro ao atualizar pessoa causado por:' . mysqli_error($conexao->conexao), 'situacao' => false)));
        }
    }

    $beneficiop = $conexao->comandoArray('select codbanco, codbeneficio from beneficiocliente as beneficio where codempresa = ' . $_SESSION["codempresa"] . ' and codpessoa = ' . $pessoap["codpessoa"] . ' and numbeneficio = "' . $num[$i] . '"');
    if (!isset($beneficiop["codbanco"]) || $beneficiop["codbanco"] == NULL || $beneficiop["codbanco"] == "") {
        $beneficio = new BeneficioCliente($conexao);
        if (!isset($beneficiop["codbanco"]) || $beneficiop["codbanco"] == NULL || $beneficiop["codbanco"] == "") {
            $bancop = $conexao->comandoArray('select codbanco from banco where numbanco = "' . $chave->dados_cadastrais->banco_pagto . '"');
            if (isset($bancop["codbanco"]) && $bancop["codbanco"] != NULL && $bancop["codbanco"] != "") {
                $beneficio->codbanco = $bancop["codbanco"];
            } else {
                $banco = new Banco($conexao);
                $banco->codfuncionario = 6;
                $banco->dtcadastro = date("Y-m-d H:i:s");
                $banco->numbanco = $chave->dados_cadastrais->banco_pagto;
                $resInserirBanco = $banco->inserir();
                if ($resInserirBanco == FALSE) {
                    die(json_encode(array('mensagem' => 'Erro ao inserir banco novo causado por:' . mysqli_error($conexao->conexao), 'situacao' => false)));
                } else {
                    $codigo_banco = mysqli_insert_id($conexao->conexao);
                }
                $beneficio->codbanco = $codigo_banco;
            }
        }
    } elseif (!isset($beneficiop["codbeneficio"]) || $beneficiop["codbeneficio"] == NULL || $beneficiop["codbeneficio"] == "") {/*     * cadastrando o beneficio pois não encontrou o mesmo na consulta */
        $beneficio = new BeneficioCliente($conexao);
        $beneficio->agencia = $chave->dados_cadastrais->agencia_pagto;
        $bancop = $conexao->comandoArray('select codbanco from banco where numbanco = "' . $chave->dados_cadastrais->banco_pagto . '"');
        if (isset($bancop["codbanco"]) && $bancop["codbanco"] != NULL && $bancop["codbanco"] != "") {
            $beneficio->codbanco = $bancop["codbanco"];
        } else {
            $banco = new Banco($conexao);
            $banco->codfuncionario = 6;
            $banco->dtcadastro = date("Y-m-d H:i:s");
            $banco->numbanco = $chave->dados_cadastrais->banco_pagto;
            $resInserirBanco = $banco->inserir();
            if ($resInserirBanco == FALSE) {
                die(json_encode(array('mensagem' => 'Erro ao inserir banco novo causado por:' . mysqli_error($conexao->conexao), 'situacao' => false)));
            } else {
                $codigo_banco = mysqli_insert_id($conexao->conexao);
            }
            $beneficio->codbanco = $codigo_banco;
        }
        $beneficio->codempresa = $_SESSION["codempresa"];
        $especiep = $conexao->comandoArray('select codespecie from especie where numinss = "' . $chave->dados_cadastrais->esp . '"');
        if (isset($especiep["codespecie"]) && $especiep["codespecie"] != NULL && $especiep["codespecie"] != "") {
            $beneficio->codespecie = $especiep["codespecie"];
        } else {
            $especie = new Especie($conexao);
            $especie->dtcadastro = date("Y-m-d H:i:s");
            $especie->numinss = $chave->dados_cadastrais->esp;
            $especie->nome = $chave->adicionais->especie_desc;
            $resInserirEspecie = $especie->inserir();
            if ($resInserirEspecie == FALSE) {
                die(json_encode(array('mensagem' => 'Erro ao inserir especie novo causado por:' . mysqli_error($conexao->conexao), 'situacao' => false)));
            } else {
                $codigo_especie = mysqli_insert_id($conexao->conexao);
            }
            $beneficio->codespecie = $codigo_especie;
        }
        $beneficio->codfuncionario = $_SESSION["codpessoa"];
        $beneficio->codorgao = 5;
        $beneficio->codpessoa = $pessoap["codpessoa"];
        $beneficio->contacorrente = $chave->dados_cadastrais->conta_pagto;
        $beneficio->dtcadastro = date("Y-m-d H:i:s");
        $beneficio->margem = $chave->dados_cadastrais->margemdisp;
        $beneficio->matricula = $num[$i];
        $beneficio->meio = $chave->dados_cadastrais->tipo_pagto;
        $beneficio->numbeneficio = $num[$i];
        $beneficio->salariobase = $chave->dados_cadastrais->mr;
        $beneficio->situacao = 'ativo';
        $resInserirBeneficio = $beneficio->inserir();
        if ($resInserirBeneficio == FALSE) {
            die(json_encode(array('mensagem' => 'Erro ao inserir beneficio causado por:' . mysqli_error($conexao->conexao), 'situacao' => false)));
        }
    }

    /*     * inserindo telefones */
    foreach ($chave->fones->fone as $key => $fone) {
        if ($fone->status == 1 || $fone->status == 7) {
            $telefonep = $conexao->comandoArray('select codtelefone from telefone where codempresa = ' . $_SESSION["codempresa"] . ' and codpessoa = ' . $pessoap["codpessoa"] . ' and numero = "' . $fone->telefone . '"');
            if (!isset($telefonep["codtelefone"]) || $telefonep["codtelefone"] == NULL || $telefonep["codtelefone"] == "") {
                $telefone = new Telefone($conexao);
                $telefone->codempresa = $_SESSION["codempresa"];
                $telefone->codfuncionario = $_SESSION["codpessoa"];
                if ($telefone->identificaCelular($fone->telefone)) {
                    $telefone->codtipo = 3;
                } else {
                    $telefone->codtipo = 1;
                }
                $telefone->dtcadastro = date("Y-m-d H:i:s");
                $telefone->numero = $fone->telefone;
                $telefone->codpessoa = $pessoap["codpessoa"];
                $resInserirTelefone = $telefone->inserir();
                if ($resInserirTelefone == FALSE) {
                    die(json_encode(array('mensagem' => 'Erro ao inserir telefone causado por:' . mysqli_error($conexao->conexao), 'situacao' => false)));
                }
            }
        }
    }

    /*     * inserindo empréstimos */
    foreach ($chave->consighome_vlfins->consighome_vlfin as $key => $consignacao) {
        $emprestimop = $conexao->comandoArray('select codemprestimo from emprestimo where codempresa = ' . $_SESSION["codempresa"] . ' and codpessoa = ' . $pessoap["codpessoa"] . ' and contrato = "' . $consignacao->contrato_info->contrato . '"');
        if (!isset($emprestimop["codemprestimo"]) || $emprestimop["codemprestimo"] == NULL || $emprestimop["codemprestimo"] == "") {
            $emprestimo = new Emprestimo($conexao);
            $emprestimo->agencia = '';
            $bancop = $conexao->comandoArray('select codbanco from banco where numbanco = "' . $consignacao->banco . '"');
            if (isset($bancop["codbanco"]) && $bancop["codbanco"] != NULL && $bancop["codbanco"] != "") {
                $emprestimo->codbanco = $bancop["codbanco"];
            } else {
                $banco = new Banco($conexao);
                $banco->codfuncionario = 6;
                $banco->dtcadastro = date("Y-m-d H:i:s");
                $banco->numbanco = $consignacao->banco;
                $resInserirBanco = $banco->inserir();
                if ($resInserirBanco == FALSE) {
                    die(json_encode(array('mensagem' => 'Erro ao inserir banco novo causado por:' . mysqli_error($conexao->conexao), 'situacao' => false)));
                } else {
                    $codigo_banco = mysqli_insert_id($conexao->conexao);
                }
                $emprestimo->codbanco = $codigo_banco;
            }
            $beneficiop = $conexao->comandoArray('select codbanco, codbeneficio from beneficiocliente as beneficio where codempresa = ' . $_SESSION["codempresa"] . ' and codpessoa = ' . $pessoap["codpessoa"] . ' and numbeneficio = "' . $num[$i] . '"');
            $emprestimo->codbeneficio = $beneficiop["codbeneficio"];
            $emprestimo->codempresa = $_SESSION["codempresa"];
            $emprestimo->codfuncionario = $_SESSION["codpessoa"];
            $emprestimo->dtcadastro = date("Y-m-d H:i:s");
            $emprestimo->codpessoa = $pessoap["codpessoa"];
            $emprestimo->contacorrente = '';
            $emprestimo->dtparcela = $consignacao->contrato_info->iniciorepasse;
            $emprestimo->contrato = $consignacao->contrato_info->contrato;
            $emprestimo->quitacao = $consignacao->quitacao;
            $emprestimo->vlparcela = $consignacao->valor_parcela;
            $emprestimo->portabilidade = $consignacao->contrato_info->viabilidade;
            $emprestimo->parcelasrestantes = $consignacao->contrato_info->parcelasrestantes;
            $emprestimo->qtdpagas = $consignacao->qtypagas;
            $resInserirEmprestimio = $emprestimo->inserir();
            if ($resInserirEmprestimio == FALSE) {
                die(json_encode(array('mensagem' => 'Erro ao inserir emprestimo causado por:' . mysqli_error($conexao->conexao), 'situacao' => false)));
            }
        }
    }
}
die(json_encode(array('mensagem' => 'Importação realizada com sucesso!!!', 'situacao' => true, 'codpessoa' => $pessoap["codpessoa"])));

