<?php

ini_set('memory_limit', '2048M');
ini_set('mysql.connect_timeout', '0');
ini_set('max_execution_time', '0');
set_time_limit(0);
session_start();
//validação caso a sessão caia
if (!isset($_SESSION)) {
    if (isset($_POST["retorno_especial"]) && $_POST["retorno_especial"] != NULL && $_POST["retorno_especial"] == "s") {
        die('<script>alert("Sua sessão caiu, por favor logue novamente!!!");window.close();</script>');
    } else {
        die(json_encode(array('mensagem' => 'Sua sessão caiu, por favor logue novamente!!!', 'situacao' => false)));
    }
}
if (isset($_FILES['arquivo'])) {
    header('Content-Type: text/html; charset=utf-8');
    date_default_timezone_set('America/Sao_Paulo');

    function __autoload($class_name) {
        if (file_exists("../model/" . $class_name . '.php')) {
            include "../model/" . $class_name . '.php';
        } elseif (file_exists("../visao/" . $class_name . '.php')) {
            include "../visao/" . $class_name . '.php';
        } elseif (file_exists("./" . $class_name . '.php')) {
            include "./" . $class_name . '.php';
        }
    }

    include("./excel/reader.php");
    $data = new Spreadsheet_Excel_Reader();
    $conexao = new Conexao();

    $qtdNovo = 0;
    $qtdJaTinha = 0;
    $qtdCpfInvalido = 0;
    $sit_retorno = true;
    $first_row = true;

    if (!isset($_POST["nome"])) {

        if (isset($_POST["retorno_especial"]) && $_POST["retorno_especial"] != NULL && $_POST["retorno_especial"] == "s") {
            die('<script>alert("Por favor defina um nome para a carteira de clientes!!!");window.close();</script>');
        } else {
            die(json_encode(array('mensagem' => 'Por favor defina um nome para a carteira de clientes!!!', 'situacao' => false)));
        }
    }
    if (!empty($_FILES['arquivo']) && $_FILES['arquivo']['type'] != "application/vnd.ms-excel" && $_FILES["arquivo"]["type"] != "application/octet-stream") {
        if (isset($_POST["retorno_especial"]) && $_POST["retorno_especial"] != NULL && $_POST["retorno_especial"] == "s") {
            die('<script>alert("Só pode arquivo em formado XLS!");window.close();</script>');
        } else {
            die(json_encode(array('mensagem' => "Só pode arquivo em formado XLS!", 'situacao' => false)));
        }
    }

    /*     * lendo o arquivo xls */
    $data->setOutputEncoding('UTF-8');
    $data->read($_FILES['arquivo']['tmp_name']);

    $importacao = new Importacao($conexao);
    $importacao->codempresa = $_SESSION['codempresa'];
    $importacao->codfuncionario = $_SESSION['codpessoa'];
    $importacao->data = date('Y-m-d');
    if (isset($_POST["nome"]) && $_POST["nome"] != NULL && $_POST["nome"] != "") {

        $carteira = new Carteira($conexao);
        $carteira->codempresa = $_SESSION['codempresa'];
        $carteira->codfuncionario = $_SESSION['codpessoa'];
        $carteira->nome = $_POST["nome"];
        $carteira->dtcadastro = date("Y-m-d H:i:s");
        $carteirap = $conexao->comandoArray("select * from carteira where codempresa = '{$_SESSION['codempresa']}' and nome = '{$_POST["nome"]}'");
        if (isset($carteirap) && isset($carteirap["nome"]) && $carteirap["nome"] != NULL && $carteirap["nome"] != "") {
            $resInserirCarteira = $carteira->atualizar();
            $codigo_carteira = $carteirap["codcarteira"];
        } else {
            $resInserirCarteira = $carteira->inserir();
            $codigo_carteira = mysqli_insert_id($conexao->conexao);
        }
        if ($resInserirCarteira == FALSE) {
            mail("thyago.pacher@gmail.com", "Erro ao inserir carteira", "Erro ao inserir novo nome de carteira causado por:" . mysqli_error($conexao->conexao));
        }
    }
    $importacao->codcarteira = $codigo_carteira;
    $importacao->qtdimportado = $qtdNovo;
    $importacao->qtdnimportado = $qtdJaTinha + $qtdCpfInvalido;
    $sql = "select importacao.* 
    from importacao 
    inner join carteira on carteira.codcarteira = importacao.codcarteira
    where importacao.codcarteira = '{$importacao->codcarteira}'";
    $importacaop = $conexao->comandoArray($sql);
    if (isset($importacaop) && isset($importacaop["codimportacao"])) {
        $importacao->codimportacao = $importacaop["codimportacao"];
        $importacao->qtdimportado = $importacao->qtdimportado + $importacaop["qtdimportado"];
        $importacao->qtdnimportado = $importacao->qtdnimportado + $importacaop["qtdnimportado"];
        $importacao->codimportacao = $importacaop["codimportacao"];
        $resImportacaoInserir = $importacao->atualizar();
        $codigo_importacao = $importacao->codimportacao;
    } else {
        $resImportacaoInserir = $importacao->inserir();

        if ($resImportacaoInserir == FALSE) {
            if (isset($_POST["retorno_especial"]) && $_POST["retorno_especial"] != NULL && $_POST["retorno_especial"] == "s") {
                die('<script>alert("Erro ao importar pessoa");window.close();</script>');
            } else {
                die(json_encode(array('mensagem' => "Erro ao importar pessoa.Causado por:" . mysqli_error($conexao), 'situacao' => false)));
            }
        }
        $codigo_importacao = mysqli_insert_id($conexao->conexao);
    }


//    $limite = $data->sheets[0]['numRows'];
//    $inicio = 2;
//    $limite = 1800;
    for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {
        $pessoa = new Pessoa($conexao);
        if (!isset($data->sheets[0]['cells'][$i])) {//break para linha em branco
            break;
        }
        $pessoa->cpf = $pessoa->soNumero(trim($data->sheets[0]['cells'][$i][8])); //retira pontos do cpf
        if (trim($pessoa->cpf) == "" || $pessoa->validaCPF($pessoa->cpf) == FALSE) {
            $qtdCpfInvalido++;
            continue; //pulando linha de cpf inválido
        }
        if (strlen($pessoa->cpf) < 11) {
            $pessoa->cpf = str_pad($pessoa->cpf, 11, "0", STR_PAD_LEFT);
        }

        if (strpos($pessoa->cpf, ".") == FALSE) {
            $cpf1 = $pessoa->cpf{0} . $pessoa->cpf{1} . $pessoa->cpf{2} . '.' . $pessoa->cpf{3} . $pessoa->cpf{4} . $pessoa->cpf{5} . '.' . $pessoa->cpf{6} . $pessoa->cpf{7} . $pessoa->cpf{8} . '-' . $pessoa->cpf{9} . $pessoa->cpf{10}; //com ponto
            $cpf2 = $pessoa->cpf; //sem ponto
        } else {
            $cpf1 = $pessoa->cpf; //com ponto
            $cpf2 = str_replace('.', "", str_replace("-", "", $pessoa->cpf)); //sem ponto
        }

        $pessoa->codimportacao = $codigo_importacao;

        $sql = "select codpessoa, nome 
        from pessoa where (cpf = '{$cpf1}' or cpf = '{$cpf2}')
        and codempresa = '{$_SESSION['codempresa']}'";
        $pessoap = $conexao->comandoArray($sql);
        if (!isset($pessoap['codpessoa'])) {
            $pessoa->nome = str_replace('"', '', trim($data->sheets[0]['cells'][$i][2]));
        } else {
            $pessoa->nome = $pessoap["nome"];
        }

        $pessoa->logradouro = utf8_encode(trim($data->sheets[0]['cells'][$i][3]));
        $pessoa->bairro = utf8_encode(trim($data->sheets[0]['cells'][$i][4]));
        $pessoa->cidade = utf8_encode(trim($data->sheets[0]['cells'][$i][6]));
        $pessoa->cep = trim($data->sheets[0]['cells'][$i][7]);
        $pessoa->estado = trim($data->sheets[0]['cells'][$i][9]);

        $pessoa->dtnascimento = date(trim($data->sheets[0]['cells'][$i][10]));
        $pessoa->dtnascimento = ($pessoa->dtnascimento - 25569) * 86400;
        $pessoa->dtnascimento = gmdate("Y-m-d", $pessoa->dtnascimento);

        $pessoa->codempresa = $_SESSION['codempresa'];

        if (isset($pessoap["codpessoa"]) && $pessoap["codpessoa"] != NULL && $pessoap["codpessoa"] != "") {
            $pessoa->codpessoa = $pessoap["codpessoa"];
            /*
             *  Se o cliente ja existir
             */
            $resInserirPessoa = true;
            if (isset($_POST["atualizar_cliente"]) && $_POST["atualizar_cliente"] != NULL && $_POST["atualizar_cliente"] != "" && isset($pessoap["codpessoa"]) && $pessoap["codpessoa"] != NULL && $pessoap["codpessoa"] != "") {
                $resInserirPessoa = $pessoa->atualizar();
                $codigo_pessoa = $pessoa->codpessoa;
            }
            $qtdJaTinha++;
        } else {
            $pessoa->codcategoria = $_POST["layout"]; //importação de clientes
            $resInserirPessoa = $pessoa->inserir();
            $codigo_pessoa = mysqli_insert_id($conexao->conexao);
            $qtdNovo++;
        }

        if ($resInserirPessoa == FALSE) {
            if (isset($_POST["retorno_especial"]) && $_POST["retorno_especial"] != NULL && $_POST["retorno_especial"] == "s") {
                die('<script>alert("Erro ao importar pessoa!!!");window.close();</script>');
            } else {
                die(json_encode(array('mensagem' => "Erro ao importar pessoa, parou em:{$pessoa->nome} .Causado por:" . mysqli_error($conexao), 'situacao' => false)));
            }
        } else {
            $sql = "select codcarteira from carteiracliente where codcliente = '{$codigo_pessoa}' and codempresa = '{$_SESSION['codempresa']}' and codcarteira = '{$codigo_carteira}'";
            $carteiraClientep = $conexao->comandoArray($sql);
            if (!isset($carteiraClientep) || $carteiraClientep["codcarteira"] == NULL || $carteiraClientep["codcarteira"] == "") {
                $carteiraCliente = new CarteiraCliente($conexao);
                $carteiraCliente->codcarteira = $importacaop["codcarteira"];
                $carteiraCliente->codcliente = $codigo_pessoa;
                $carteiraCliente->codempresa = $_SESSION['codempresa'];
                $carteiraCliente->codfuncionario = $_SESSION['codpessoa'];
                $carteiraCliente->dtcadastro = date("Y-m-d H:i:s");
                /*
                 * Adicionar se ja existir
                 */
                $resInserirCarteira = true;
                if (isset($_POST["adicionar_carteira"]) && $_POST["adicionar_carteira"] != NULL && $_POST["adicionar_carteira"] != "" && isset($pessoap["codpessoa"]) && $pessoap["codpessoa"] != NULL && $pessoap["codpessoa"] != "") {
                    $resInserirCarteira = $carteiraCliente->inserir();
                } elseif (!isset($pessoap["codpessoa"]) && $pessoap["codpessoa"] != NULL && $pessoap["codpessoa"] != "") {
                    $resInserirCarteira = $carteiraCliente->inserir();
                }
                if ($resInserirCarteira == FALSE) {
                    if (isset($_POST["retorno_especial"]) && $_POST["retorno_especial"] != NULL && $_POST["retorno_especial"] == "s") {
                        die('<script>alert("Erro ao importar carteira");window.close();</script>');
                    } else {
                        die(json_encode(array('mensagem' => "Erro ao importar carteira. Causado por:" . mysqli_error($conexao), 'situacao' => false)));
                    }
                }
            }

            //verificando se o telefone da planilha ja tem
            $telefonep = $conexao->comandoArray("select codtelefone from telefone where codpessoa = '{$codigo_pessoa}' and numero = '" . trim($data->sheets[0]['cells'][$i][11]) . "'");
            if (isset($telefonep["codtelefone"]) && $telefonep["codtelefone"] != NULL && $telefonep["codtelefone"] != "") {
                continue; //pulando caso já tenha o telefone cadastrado
            }


            $telefone = new Telefone($conexao);
            $telefone->codempresa = $_SESSION['codempresa'];
            $telefone->codfuncionario = $_SESSION['codpessoa'];
            $telefone->codpessoa = $codigo_pessoa;
            if ($telefone->identificaCelular($telefone->numero)) {
                $telefone->codtipo = "3";
            } else {
                $telefone->codtipo = "1";
            }
            $telefone->dtcadastro = date("Y-m-d H:i:s");
            $telefone->numero = trim($data->sheets[0]['cells'][$i][11]);
            $resInserirTelefone = true;
            if (isset($_POST["atualizar_cliente"]) && $_POST["atualizar_cliente"] != NULL && $_POST["atualizar_cliente"] != "" && isset($pessoap["codpessoa"]) && $pessoap["codpessoa"] != NULL && $pessoap["codpessoa"] != "") {
                $resInserirTelefone = $telefone->inserir();
            } elseif (!isset($pessoap["codpessoa"])) {
                $resInserirTelefone = $telefone->inserir();
            }
            if ($resInserirTelefone == FALSE) {
                if (isset($_POST["retorno_especial"]) && $_POST["retorno_especial"] != NULL && $_POST["retorno_especial"] == "s") {
                    die('<script>alert("Erro ao importar pessoa(telefones - 1), parou em:' . $pessoa->nome . '");window.close();</script>');
                } else {
                    die(json_encode(array('mensagem' => "Erro ao importar pessoa(telefones - 1), parou em:{$pessoa->nome} .Causado por:" . mysqli_error($conexao), 'situacao' => false)));
                }
            }

            $telefone = new Telefone($conexao);
            $telefone->codempresa = $_SESSION['codempresa'];
            $telefone->codfuncionario = $_SESSION['codpessoa'];
            $telefone->codpessoa = $codigo_pessoa;
            if ($telefone->identificaCelular($telefone->numero)) {
                $telefone->codtipo = "3";
            } else {
                $telefone->codtipo = "1";
            }
            $telefone->dtcadastro = date("Y-m-d H:i:s");
            $telefone->numero = trim($data->sheets[0]['cells'][$i][12]);
            if (isset($_POST["atualizar_cliente"]) && $_POST["atualizar_cliente"] != NULL && $_POST["atualizar_cliente"] != "" && isset($pessoap["codpessoa"]) && $pessoap["codpessoa"] != NULL && $pessoap["codpessoa"] != "") {
                $resInserirTelefone = $telefone->inserir();
            } elseif (!isset($pessoap["codpessoa"])) {
                $resInserirTelefone = $telefone->inserir();
            }
            if ($resInserirTelefone == FALSE) {
                if (isset($_POST["retorno_especial"]) && $_POST["retorno_especial"] != NULL && $_POST["retorno_especial"] == "s") {
                    die('<script>alert("Erro ao importar pessoa(telefones - 2), parou em:' . $pessoa->nome . '");window.close();</script>');
                } else {
                    die(json_encode(array('mensagem' => "Erro ao importar pessoa(telefones - 2), parou em:{$pessoa->nome} .Causado por:" . mysqli_error($conexao), 'situacao' => false)));
                }
            }

            if (isset($data->sheets[0]['cells'][$i][13]) && $data->sheets[0]['cells'][$i][13] != NULL && trim($data->sheets[0]['cells'][$i][13]) != "") {
                $telefone = new Telefone($conexao);
                $telefone->codempresa = $_SESSION['codempresa'];
                $telefone->codfuncionario = $_SESSION['codpessoa'];
                $telefone->codpessoa = $codigo_pessoa;
                if ($telefone->identificaCelular($telefone->numero)) {
                    $telefone->codtipo = "3";
                } else {
                    $telefone->codtipo = "1";
                }
                $telefone->dtcadastro = date("Y-m-d H:i:s");
                $telefone->numero = trim($data->sheets[0]['cells'][$i][13]);
                if (isset($_POST["atualizar_cliente"]) && $_POST["atualizar_cliente"] != NULL && $_POST["atualizar_cliente"] != "" && isset($pessoap["codpessoa"]) && $pessoap["codpessoa"] != NULL && $pessoap["codpessoa"] != "") {
                    $resInserirTelefone = $telefone->inserir();
                } elseif (!isset($pessoap["codpessoa"])) {
                    $resInserirTelefone = $telefone->inserir();
                } if ($resInserirTelefone == FALSE) {
                    if (isset($_POST["retorno_especial"]) && $_POST["retorno_especial"] != NULL && $_POST["retorno_especial"] == "s") {
                        die('<script>alert("Erro ao importar pessoa(telefones), parou em:' . $pessoa->nome . '");window.close();</script>');
                    } else {
                        die(json_encode(array('mensagem' => "Erro ao importar pessoa(telefones), parou em:{$pessoa->nome} .Causado por:" . mysqli_error($conexao), 'situacao' => false)));
                    }
                }
            }

            if (isset($data->sheets[0]['cells'][$i][14]) && $data->sheets[0]['cells'][$i][14] != NULL && trim($data->sheets[0]['cells'][$i][14])) {
                $telefone = new Telefone($conexao);
                $telefone->codempresa = $_SESSION['codempresa'];
                $telefone->codfuncionario = $_SESSION['codpessoa'];
                $telefone->codpessoa = $codigo_pessoa;
                if ($telefone->identificaCelular($telefone->numero)) {
                    $telefone->codtipo = "3";
                } else {
                    $telefone->codtipo = "1";
                }
                $telefone->dtcadastro = date("Y-m-d H:i:s");
                $telefone->numero = trim($data->sheets[0]['cells'][$i][14]);
                if (isset($_POST["atualizar_cliente"]) && $_POST["atualizar_cliente"] != NULL && $_POST["atualizar_cliente"] != "" && isset($pessoap["codpessoa"]) && $pessoap["codpessoa"] != NULL && $pessoap["codpessoa"] != "") {
                    $resInserirTelefone = $telefone->inserir();
                } elseif (!isset($pessoap["codpessoa"])) {
                    $resInserirTelefone = $telefone->inserir();
                }
                if ($resInserirTelefone == FALSE) {
                    if (isset($_POST["retorno_especial"]) && $_POST["retorno_especial"] != NULL && $_POST["retorno_especial"] == "s") {
                        die('<script>alert("Erro ao importar pessoa(telefones), parou em:' . $pessoa->nome . '");window.close();</script>');
                    } else {
                        die(json_encode(array('mensagem' => "Erro ao importar pessoa(telefones), parou em:{$pessoa->nome} .Causado por:" . mysqli_error($conexao), 'situacao' => false)));
                    }
                }
            }

            if (isset($data->sheets[0]['cells'][$i][15]) && $data->sheets[0]['cells'][$i][15] != NULL && trim($data->sheets[0]['cells'][$i][15])) {
                $telefone = new Telefone($conexao);
                $telefone->codempresa = $_SESSION['codempresa'];
                $telefone->codfuncionario = $_SESSION['codpessoa'];
                $telefone->codpessoa = $codigo_pessoa;
                if ($telefone->identificaCelular($telefone->numero)) {
                    $telefone->codtipo = "3";
                } else {
                    $telefone->codtipo = "1";
                }
                $telefone->dtcadastro = date("Y-m-d H:i:s");
                $telefone->numero = trim($data->sheets[0]['cells'][$i][15]);
                if (isset($_POST["atualizar_cliente"]) && $_POST["atualizar_cliente"] != NULL && $_POST["atualizar_cliente"] != "" && isset($pessoap["codpessoa"]) && $pessoap["codpessoa"] != NULL && $pessoap["codpessoa"] != "") {
                    $resInserirTelefone = $telefone->inserir();
                } elseif (!isset($pessoap["codpessoa"])) {
                    $resInserirTelefone = $telefone->inserir();
                } if ($resInserirTelefone == FALSE) {
                    if (isset($_POST["retorno_especial"]) && $_POST["retorno_especial"] != NULL && $_POST["retorno_especial"] == "s") {
                        die('<script>alert("Erro ao importar pessoa(telefones), parou em:' . $pessoa->nome . '");window.close();</script>');
                    } else {
                        die(json_encode(array('mensagem' => "Erro ao importar pessoa(telefones), parou em:{$pessoa->nome} .Causado por:" . mysqli_error($conexao), 'situacao' => false)));
                    }
                }
            }

            if (isset($data->sheets[0]['cells'][$i][16]) && $data->sheets[0]['cells'][$i][16] != NULL && trim($data->sheets[0]['cells'][$i][16])) {
                $telefone = new Telefone($conexao);
                $telefone->codempresa = $_SESSION['codempresa'];
                $telefone->codfuncionario = $_SESSION['codpessoa'];
                $telefone->codpessoa = $codigo_pessoa;
                if ($telefone->identificaCelular($telefone->numero)) {
                    $telefone->codtipo = "3";
                } else {
                    $telefone->codtipo = "1";
                }
                $telefone->dtcadastro = date("Y-m-d H:i:s");
                $telefone->numero = trim($data->sheets[0]['cells'][$i][16]);
                if (isset($_POST["atualizar_cliente"]) && $_POST["atualizar_cliente"] != NULL && $_POST["atualizar_cliente"] != "" && isset($pessoap["codpessoa"]) && $pessoap["codpessoa"] != NULL && $pessoap["codpessoa"] != "") {
                    $resInserirTelefone = $telefone->inserir();
                } elseif (!isset($pessoap["codpessoa"])) {
                    $resInserirTelefone = $telefone->inserir();
                } if ($resInserirTelefone == FALSE) {
                    if (isset($_POST["retorno_especial"]) && $_POST["retorno_especial"] != NULL && $_POST["retorno_especial"] == "s") {
                        die('<script>alert("Erro ao importar pessoa(telefones), parou em:' . $pessoa->nome . '");window.close();</script>');
                    } else {
                        die(json_encode(array('mensagem' => "Erro ao importar pessoa(telefones), parou em:{$pessoa->nome} .Causado por:" . mysqli_error($conexao), 'situacao' => false)));
                    }
                }
            }

            //apagando quando tiver importado em branco o nb
            $resExcluirBeneficioErrado = $conexao->comando("delete from beneficiocliente where codpessoa = '{$codigo_pessoa}' and codempresa = '{$_SESSION['codempresa']}' and (numbeneficio = '' or numbeneficio is null)");
            if ($resExcluirBeneficioErrado == FALSE) {
                if (isset($_POST["retorno_especial"]) && $_POST["retorno_especial"] != NULL && $_POST["retorno_especial"] == "s") {
                    die('<script>alert("Erro ao apagar beneficios em branco");window.close();</script>');
                } else {
                    die(json_encode(array('mensagem' => "Erro ao apagar beneficios em branco, causado por:" . mysqli_error($conexao->conexao), 'situacao' => false)));
                }
            }

            $beneficiop = $conexao->comandoArray("select codbeneficio from beneficiocliente where codpessoa = '{$codigo_pessoa}' and codempresa = '{$_SESSION['codempresa']}' and numbeneficio = '" . trim($data->sheets[0]['cells'][$i][1]) . "'");
            $beneficio = new BeneficioCliente($conexao);
            $beneficio->codorgao = 3;
            $beneficio->codempresa = $_SESSION['codempresa'];
            $beneficio->codfuncionario = $_SESSION['codpessoa'];
            $beneficio->codpessoa = $codigo_pessoa;
            $beneficio->dtcadastro = date("Y-m-d H:i:s");
            $codigo_especie = trim($data->sheets[0]['cells'][$i][5]);
            $especiep = $conexao->comandoArray("select codespecie from especie where numinss = '{$codigo_especie}'");
            $beneficio->codespecie = $especiep["codespecie"];
            $beneficio->matricula = trim($data->sheets[0]['cells'][$i][1]);
            $beneficio->numbeneficio = trim($data->sheets[0]['cells'][$i][1]);
            $beneficio->salariobase = trim($data->sheets[0]['cells'][$i][17]);
            $beneficio->margem = trim($data->sheets[0]['cells'][$i][18]);
            $beneficio->meio = trim($data->sheets[0]['cells'][$i][22]);
            $beneficio->codbanco = trim($data->sheets[0]['cells'][$i][19]);
            $beneficio->agencia = trim($data->sheets[0]['cells'][$i][20]);
            $beneficio->contacorrente = trim($data->sheets[0]['cells'][$i][21]);

            if (isset($beneficiop["codbenficio"]) && $beneficiop["codbenficio"] != NULL && $beneficiop["codbenficio"] != "") {
                $resInserirBeneficio = $beneficio->atualizar();
            } else {
                $resInserirBeneficio = $beneficio->inserir();
            }
            $codigo_beneficio = mysqli_insert_id($conexao->conexao);
            if ($resInserirBeneficio === FALSE) {
                if (isset($_POST["retorno_especial"]) && $_POST["retorno_especial"] != NULL && $_POST["retorno_especial"] == "s") {
                    die('<script>alert("Erro ao importar beneficio de cliente");window.close();</script>');
                } else {
                    die(json_encode(array('mensagem' => "Erro ao importar beneficio de cliente causado por:" . mysqli_error($conexao->conexao), 'situacao' => false)));
                }
            }

            if (trim($data->sheets[0]['cells'][$i][23]) != NULL && trim($data->sheets[0]['cells'][$i][23]) != "") {
                $emprestimo = new Emprestimo($conexao);
                $emprestimo->codfuncionario = $_SESSION['codpessoa'];
                $emprestimo->codpessoa = $codigo_pessoa;
                $emprestimo->dtcadastro = date("Y-m-d H:i:s");
                $emprestimo->codempresa = $_SESSION['codempresa'];
                $emprestimo->codbeneficio = $codigo_beneficio;
                $banco = $conexao->comandoArray("select codbanco from banco where numbanco = '" . trim($data->sheets[0]['cells'][$i][23]) . "'");
                $emprestimo->codbanco = $banco["codbanco"];
                $emprestimo->meio = trim($data->sheets[0]['cells'][$i][20]);
                $emprestimo->vlparcela = trim($data->sheets[0]['cells'][$i][24]);
                $emprestimo->dtparcela = gmdate("Y-m-d", (trim($data->sheets[0]['cells'][$i][25]) - 25569) * 86400);
                $emprestimo->prazo = trim($data->sheets[0]['cells'][$i][26]);
                $emprestimo->quitacao = trim($data->sheets[0]['cells'][$i][27]);

                $resInserirEmprestimo = $emprestimo->inserir();
                if ($resInserirEmprestimo === FALSE) {
                    if (isset($_POST["retorno_especial"]) && $_POST["retorno_especial"] != NULL && $_POST["retorno_especial"] == "s") {
                        die('<script>alert("Erro ao importar empréstimo de cliente - 1");window.close();</script>');
                    } else {
                        die(json_encode(array('mensagem' => "Erro ao importar empréstimo de cliente - 1 causado por:" . mysqli_error($conexao->conexao), 'situacao' => false)));
                    }
                }
            }

            if (trim($data->sheets[0]['cells'][$i][28]) != NULL && trim($data->sheets[0]['cells'][$i][28]) != "") {
                $emprestimo = new Emprestimo($conexao);
                $emprestimo->codfuncionario = $_SESSION['codpessoa'];
                $emprestimo->codpessoa = $codigo_pessoa;
                $emprestimo->dtcadastro = date("Y-m-d H:i:s");
                $emprestimo->codempresa = $_SESSION['codempresa'];
                $emprestimo->codbeneficio = $codigo_beneficio;
                $banco = $conexao->comandoArray("select codbanco from banco where numbanco = '" . trim($data->sheets[0]['cells'][$i][28]) . "'");
                $emprestimo->codbanco = $banco["codbanco"];
                $emprestimo->meio = trim($data->sheets[0]['cells'][$i][20]);
                $emprestimo->vlparcela = trim($data->sheets[0]['cells'][$i][29]);
                $emprestimo->dtparcela = gmdate("Y-m-d", (trim($data->sheets[0]['cells'][$i][30]) - 25569) * 86400);
                $emprestimo->prazo = trim($data->sheets[0]['cells'][$i][31]);
                $emprestimo->quitacao = trim($data->sheets[0]['cells'][$i][32]);
                $resInserirEmprestimo = $emprestimo->inserir();
                if ($resInserirEmprestimo === FALSE) {
                    if (isset($_POST["retorno_especial"]) && $_POST["retorno_especial"] != NULL && $_POST["retorno_especial"] == "s") {
                        die('<script>alert("Erro ao importar empréstimo de cliente - 2");window.close();</script>');
                    } else {
                        die(json_encode(array('mensagem' => "Erro ao importar empréstimo de cliente - 2 causado por:" . mysqli_error($conexao->conexao), 'situacao' => false)));
                    }
                }
            }

            if (trim($data->sheets[0]['cells'][$i][33]) != NULL && trim($data->sheets[0]['cells'][$i][33]) != "") {
                $emprestimo = new Emprestimo($conexao);
                $emprestimo->codfuncionario = $_SESSION['codpessoa'];
                $emprestimo->codpessoa = $codigo_pessoa;
                $emprestimo->dtcadastro = date("Y-m-d H:i:s");
                $emprestimo->codempresa = $_SESSION['codempresa'];
                $emprestimo->codbeneficio = $codigo_beneficio;
                $banco = $conexao->comandoArray("select codbanco from banco where numbanco = '" . trim($data->sheets[0]['cells'][$i][33]) . "'");
                $emprestimo->codbanco = $banco["codbanco"];
                $emprestimo->meio = trim($data->sheets[0]['cells'][$i][20]);
                $emprestimo->vlparcela = trim($data->sheets[0]['cells'][$i][34]);
                $emprestimo->dtparcela = gmdate("Y-m-d", (trim($data->sheets[0]['cells'][$i][35]) - 25569) * 86400);
                $emprestimo->prazo = trim($data->sheets[0]['cells'][$i][36]);
                $emprestimo->quitacao = trim($data->sheets[0]['cells'][$i][37]);
                $resInserirEmprestimo = $emprestimo->inserir();
                if ($resInserirEmprestimo === FALSE) {
                    if (isset($_POST["retorno_especial"]) && $_POST["retorno_especial"] != NULL && $_POST["retorno_especial"] == "s") {
                        die('<script>alert("Erro ao importar empréstimo de cliente - 3");window.close();</script>');
                    } else {
                        die(json_encode(array('mensagem' => "Erro ao importar empréstimo de cliente - 3 causado por:" . mysqli_error($conexao->conexao), 'situacao' => false)));
                    }
                }
            }

            if (trim($data->sheets[0]['cells'][$i][38]) != NULL && trim($data->sheets[0]['cells'][$i][38]) != "") {
                $emprestimo = new Emprestimo($conexao);
                $emprestimo->codfuncionario = $_SESSION['codpessoa'];
                $emprestimo->codpessoa = $codigo_pessoa;
                $emprestimo->dtcadastro = date("Y-m-d H:i:s");
                $emprestimo->codempresa = $_SESSION['codempresa'];
                $emprestimo->codbeneficio = $codigo_beneficio;
                $banco = $conexao->comandoArray("select codbanco from banco where numbanco = '" . trim($data->sheets[0]['cells'][$i][38]) . "'");
                $emprestimo->codbanco = $banco["codbanco"];
                $emprestimo->meio = trim($data->sheets[0]['cells'][$i][20]);
                $emprestimo->vlparcela = trim($data->sheets[0]['cells'][$i][39]);
                $emprestimo->dtparcela = gmdate("Y-m-d", (trim($data->sheets[0]['cells'][$i][40]) - 25569) * 86400);
                $emprestimo->prazo = trim($data->sheets[0]['cells'][$i][41]);
                $emprestimo->quitacao = trim($data->sheets[0]['cells'][$i][42]);
                $resInserirEmprestimo = $emprestimo->inserir();
                if ($resInserirEmprestimo === FALSE) {
                    if (isset($_POST["retorno_especial"]) && $_POST["retorno_especial"] != NULL && $_POST["retorno_especial"] == "s") {
                        die('<script>alert("Erro ao importar empréstimo de cliente - 4");window.close();</script>');
                    } else {
                        die(json_encode(array('mensagem' => "Erro ao importar empréstimo de cliente - 4 causado por:" . mysqli_error($conexao->conexao), 'situacao' => false)));
                    }
                }
            }

            if (trim($data->sheets[0]['cells'][$i][43]) != NULL && trim($data->sheets[0]['cells'][$i][43]) != "") {
                $emprestimo = new Emprestimo($conexao);
                $emprestimo->codfuncionario = $_SESSION['codpessoa'];
                $emprestimo->codpessoa = $codigo_pessoa;
                $emprestimo->dtcadastro = date("Y-m-d H:i:s");
                $emprestimo->codempresa = $_SESSION['codempresa'];
                $emprestimo->codbeneficio = $codigo_beneficio;
                $banco = $conexao->comandoArray("select codbanco from banco where numbanco = '" . trim($data->sheets[0]['cells'][$i][43]) . "'");
                $emprestimo->codbanco = $banco["codbanco"];
                $emprestimo->meio = trim($data->sheets[0]['cells'][$i][20]);
                $emprestimo->vlparcela = trim($data->sheets[0]['cells'][$i][44]);
                $emprestimo->dtparcela = gmdate("Y-m-d", (trim($data->sheets[0]['cells'][$i][45]) - 25569) * 86400);
                $emprestimo->prazo = trim($data->sheets[0]['cells'][$i][46]);
                $emprestimo->quitacao = trim($data->sheets[0]['cells'][$i][47]);
                $resInserirEmprestimo = $emprestimo->inserir();
                if ($resInserirEmprestimo === FALSE) {
                    if (isset($_POST["retorno_especial"]) && $_POST["retorno_especial"] != NULL && $_POST["retorno_especial"] == "s") {
                        die('<script>alert("Erro ao importar empréstimo de cliente - 5");window.close();</script>');
                    } else {
                        die(json_encode(array('mensagem' => "Erro ao importar empréstimo de cliente - 5 causado por:" . mysqli_error($conexao->conexao), 'situacao' => false)));
                    }
                }
            }

            if (trim($data->sheets[0]['cells'][$i][48]) != NULL && trim($data->sheets[0]['cells'][$i][48]) != "") {
                $emprestimo = new Emprestimo($conexao);
                $emprestimo->codfuncionario = $_SESSION['codpessoa'];
                $emprestimo->codpessoa = $codigo_pessoa;
                $emprestimo->dtcadastro = date("Y-m-d H:i:s");
                $emprestimo->codempresa = $_SESSION['codempresa'];
                $emprestimo->codbeneficio = $codigo_beneficio;
                $banco = $conexao->comandoArray("select codbanco from banco where numbanco = '" . trim($data->sheets[0]['cells'][$i][48]) . "'");
                $emprestimo->codbanco = $banco["codbanco"];
                $emprestimo->meio = trim($data->sheets[0]['cells'][$i][20]);
                $emprestimo->vlparcela = trim($data->sheets[0]['cells'][$i][49]);
                $emprestimo->dtparcela = gmdate("Y-m-d", (trim($data->sheets[0]['cells'][$i][50]) - 25569) * 86400);
                $emprestimo->prazo = trim($data->sheets[0]['cells'][$i][51]);
                $emprestimo->quitacao = trim($data->sheets[0]['cells'][$i][52]);
                $resInserirEmprestimo = $emprestimo->inserir();
                if ($resInserirEmprestimo == FALSE) {
                    if (isset($_POST["retorno_especial"]) && $_POST["retorno_especial"] != NULL && $_POST["retorno_especial"] == "s") {
                        die('<script>alert("Erro ao importar empréstimo de cliente - 6");window.close();</script>');
                    } else {
                        die(json_encode(array('mensagem' => "Erro ao importar empréstimo de cliente - 6 causado por:" . mysqli_error($conexao->conexao), 'situacao' => false)));
                    }
                }
            }
        }
        if (isset($data->sheets[0]['cells'][$i][54]) && $data->sheets[0]['cells'][$i][54] != NULL && trim($data->sheets[0]['cells'][$i][54])) {
            $observacaoCliente = new ObservacaoCliente($conexao);
            $observacaoCliente->codempresa = $_SESSION['codempresa'];
            $observacaoCliente->codfuncionario = $_SESSION['codpessoa'];
            $observacaoCliente->codpessoa = $codigo_pessoa;
            $observacaoCliente->dtcadastro = date("Y-m-d H:i:s");
            $observacaoCliente->texto = trim($data->sheets[0]['cells'][$i][54]);
            $resInserirObservacao = $observacaoCliente->inserir();
            if ($resInserirObservacao == FALSE) {
                if (isset($_POST["retorno_especial"]) && $_POST["retorno_especial"] != NULL && $_POST["retorno_especial"] == "s") {
                    die('<script>alert("Erro ao importar observação de cliente - 1");window.close();</script>');
                } else {
                    die(json_encode(array('mensagem' => "Erro ao importar observação de cliente - 1 causado por:" . mysqli_error($conexao->conexao), 'situacao' => false)));
                }
            }
        }
    }
    if ($sit_retorno) {
        $msg_quantidade = " Foram importados:\n";
        $msg_quantidade .= "\n-Novos clientes {$qtdNovo}\n";
        $msg_quantidade .= "\n-Já cadastrados {$qtdJaTinha} e atualizados\n";
        $msg_quantidade .= "\n-CPF inválido {$qtdCpfInvalido}\n";
        if ($resImportacaoInserir == FALSE) {
            mail("thyago.pacher@gmail.com", "Erro ao gravar log de importação XLS - South Negócios", "Erro causado por:" . mysqli_error($conexao->conexao));
        } else {
            $qtdNImportado = $qtdJaTinha + $qtdCpfInvalido;
            $conexao->comando("update importacao set qtdimportado = '{$qtdNovo}', qtdnimportado = '{$qtdNImportado}' where codimportacao = '{$codigo_importacao}'");
            if (isset($_POST["retorno_especial"]) && $_POST["retorno_especial"] != NULL && $_POST["retorno_especial"] == "s") {
                die('<script>alert("Importação realizada com sucesso!!!");window.close();</script>');
            } else {
                die(json_encode(array('mensagem' => "Importação realizada com sucesso!!!" . $msg_quantidade, 'situacao' => true)));
            }
        }
    }
} else {
    die(json_encode(array('mensagem' => "Não pode realizar importação sem arquivo!!!", 'situacao' => false)));
}


