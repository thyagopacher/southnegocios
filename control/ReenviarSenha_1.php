<?php
//ini_set('display_errors',1);
//ini_set('display_startup_erros',1);
//error_reporting(E_ALL);
    include "../sistema/model/Conexao.php";
    include "../sistema/model/Pessoa.php";
    include "../sistema/model/FilaEmail.php";
    include "../sistema/model/Log.php";
    $conexao = new Conexao(); 
    $pessoa  = new Pessoa($conexao);
    $pessoap = $conexao->comandoArray("select codpessoa, nome, codempresa, morador, acessapainel, senha from pessoa where email = '{$_POST["email"]}'");
    $empresa = $conexao->comandoArray("select razao, email, sitemorador from empresa where codempresa = '{$pessoap["codempresa"]}'");
    if(isset($pessoap) && isset($pessoap["codpessoa"]) && $pessoap["codpessoa"] != NULL && $pessoap["codpessoa"] != "" && $pessoap["codempresa"] && $pessoap["codempresa"] != ""){
        $fila = new FilaEmail($conexao);
        $fila->assunto        = "Reenvio de senha para acesso ao GestCCon";
        $fila->codempresa     = $pessoap["codempresa"];
        $fila->codfuncionario = 6;
        $fila->codpessoa      = $pessoap["codpessoa"];
        $fila->dtcadastro     = date("Y-m-d H:i:s");
        $fila->situacao       = "n";
        $fila->texto          = "Olá caro usuário {$pessoap["nome"]} sua senha é ".base64_decode($pessoap["senha"])."<br>";
        if(isset($pessoap["morador"]) && $pessoap["morador"] != NULL && $pessoap["morador"] == "s"){
            if(isset($empresa["sitemorador"]) && $empresa["sitemorador"] != NULL && $empresa["sitemorador"] != ""){
                $fila->texto .= "Link de acesso {$empresa["razao"]}: <a href='{$empresa["sitemorador"]}'>Acesso Portal</a><br>";
            }
        }
        if(isset($pessoap["acessapainel"]) && $pessoap["acessapainel"] != NULL && $pessoap["acessapainel"] == "s"){
            $fila->texto .= "Link de acesso {$empresa["razao"]}: <a href='http://gestccon.com.br/'>Acesso Painel ADM</a><br>";
        }           

        $resInserirFila = $fila->inserir();


        include "../model/Log.php";
        $log             = new Log($conexao);
        $log->acao       = "atualizar";
        $log->codempresa = $pessoap["codempresa"];
        $log->codpagina  = 4;
        $log->codpessoa  = $pessoap["codpessoa"];
        $log->data       = date('Y-m-d');
        $log->hora       = date('H:i:s');
        $log->observacao =  $fila->assunto."<br>".$fila->texto;
        $log->inserir();

        if($resInserirFila != FALSE){
            die(json_encode(array('mensagem' => "Senha enviada para o seu e-mail!!!", 'situacao' => true)));
        }else{
            die(json_encode(array('mensagem' => "Erro ao enviar senha para o e-mail causado por:". mysqli_error($conexao->conexao), 'situacao' => false)));
        }
    }else{
        die(json_encode(array('mensagem' => "Não achou ninguém cadastrado com esse e-mail no sistema!!!", 'situacao' => false)));
    }
?>