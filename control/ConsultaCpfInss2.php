<?php
    session_start();
    $cpf = $_POST["cpf"];
    if(isset($_POST["cpf"]) && $_POST["cpf"] != NULL && $_POST["cpf"] != ""){
        function __autoload($class_name) {
            if(file_exists("../model/".$class_name . '.php')){
                include "../model/".$class_name . '.php';
            }elseif(file_exists("../visao/".$class_name . '.php')){
                include "../visao/".$class_name . '.php';
            }elseif(file_exists("./".$class_name . '.php')){
                include "./".$class_name . '.php';
            }
        }
        $conexao   = new Conexao();
        $beneficio = new BeneficioCliente($conexao);
        $pessoa    = new Pessoa($conexao);
        /**limpando cpf para pesquisar*/
        $cpf       = str_replace(".", "", $cpf);
        $cpf       = str_replace("-", "", $cpf);
        $consulta_cpf = $beneficio->consultaCpfInss($cpf);
        $sql = "select codpessoa, nome, dtnascimento, mae, nit from pessoa where (cpf = '{$cpf}' or cpf = '{$_POST["cpf"]}') and codempresa = '{$_SESSION['codempresa']}'";
        $pessoap = $conexao->comandoArray($sql);

        if(isset($consulta_cpf->consulta->ok) && $consulta_cpf->consulta->ok != NULL && $consulta_cpf->consulta->ok != ""){
            $qtdbeneficio = count($consulta_cpf->consulta->consulta_cpf->resultado);
            $linhaConsulta = 0;
            foreach ($consulta_cpf->consulta->consulta_cpf->resultado as $key => $resultado2) {
                $sql        = "select * from beneficiocliente where codempresa = '{$_SESSION['codempresa']}' and numbeneficio = '{$resultado2->beneficio}'";
//                echo "<pre>{$sql}</pre>";
                $beneficiop = $conexao->comandoArray($sql);
                
                if(!isset($beneficiop["numbeneficio"]) || $beneficiop["numbeneficio"] == NULL || $beneficiop["numbeneficio"] == ""){
                    $beneficio                 = new BeneficioCliente($conexao);
                    $beneficio->codempresa     = $_SESSION['codempresa'];
                    $beneficio->codfuncionario = $_SESSION['codpessoa'];
                    $beneficio->codorgao       = 3;
                    $beneficio->codbanco       = 0;
                    $beneficio->numbeneficio   = $resultado2->beneficio;
                    $beneficio->codpessoa      = $pessoap["codpessoa"];
                    $sql = "select * from especie where numinss = '{$resultado2->especie}'";
                    $especiep = $conexao->comandoArray($sql);
                    if(isset($especiep["codespecie"]) && $especiep["codespecie"] != NULL && $especiep["codespecie"] != "" && $especiep["codespecie"] != "0"){
                        $beneficio->codespecie = $especiep["codespecie"];
                    }else{
                        $especie = new Especie($conexao);
                        $especie->nome       = "";
                        $especie->numinss    = $especiep["codespecie"];
                        $especie->dtcadastro = date("Y-m-d H:i:s");
                        $especie->inserir();
                        $beneficio->codespecie = mysqli_insert_id($conexao->conexao);
                    }    
                    if(isset($resultado2->data_inicio_beneficio) && $resultado2->data_inicio_beneficio != NULL && $resultado2->data_inicio_beneficio != "" && $resultado2->data_inicio_beneficio != "null"){
                        $beneficio->dtinicio = implode("-",array_reverse(explode("/",$resultado2->data_inicio_beneficio)));
                    }
                    $resInserirBeneficio = $beneficio->inserir();
                    if($resInserirBeneficio == FALSE){
                        die(json_encode(array('mensagem' => "Erro ao cadastrar beneficio causado por:". mysqli_error($conexao->conexao), 'situacao' => false)));
                    }                    
                }
                
                if((!isset($pessoap["mae"]) || $pessoap["mae"] == NULL || $pessoap["mae"] == "") && (isset($resultado2->mae) && $resultado2->mae != NULL && $resultado2->mae != "" && $resultado2->mae != "null")){
                    $pessoa->mae = $resultado2->mae;
                }
                if((isset($resultado2->data_nascimento) && $resultado2->data_nascimento != NULL && $resultado2->data_nascimento != "")){
                    $pessoa->dtnascimento = $resultado2->data_nascimento;
                }
                if((!isset($pessoap["nit"]) || $pessoap["nit"] == NULL || $pessoap["nit"] == "") && (isset($resultado2->nit) && $resultado2->nit != NULL && $resultado2->nit != "")){
                    $pessoa->nit = $resultado2->nit;
                }
                $pessoa->nome       = $pessoap["nome"];
                $pessoa->codpessoa  = $pessoap["codpessoa"];
                $resAtualizarPessoa = $pessoa->atualizar();
                if($resAtualizarPessoa == FALSE){
                    die(json_encode(array('mensagem' => "Erro ao atualizar pessoa causado por:". mysqli_error($conexao->conexao), 'situacao' => false)));
                }                
                $linhaConsulta++;
            }
            die(json_encode(array('mensagem' => "Consulta realizada com sucesso!!!", 'situacao' => true)));
        }else{
           die(json_encode(array('mensagem' => "Problemas no viper - sem créditos!!!", 'situacao' => false)));
        }
    }else{
        die(json_encode(array('mensagem' => "Sem CPF!!!", 'situacao' => false)));
    }