<?php
    
    function __autoload($class_name) {
        if(file_exists("../model/".$class_name . '.php')){
            include "../model/".$class_name . '.php';
        }elseif(file_exists("../visao/".$class_name . '.php')){
            include "../visao/".$class_name . '.php';
        }elseif(file_exists("./".$class_name . '.php')){
            include "./".$class_name . '.php';
        }
    }
    
    date_default_timezone_set('America/Sao_Paulo');
    session_start();
        //validação caso a sessão caia
    if(!isset($_SESSION)){
        die("<script>alert('Sua sessão caiu, por favor logue novamente!!!');window.close();</script>");
    }  
    
    $conexao = new Conexao();
    $arquivo  = new ArquivoConta($conexao);
    $arquivo->codempresa = $_SESSION['codempresa'];
    $arquivo->codconta  = $_POST["codconta"];
    $arquivo->codfuncionario = $_SESSION['codpessoa'];
    $arquivo->dtcadastro = date("Y-m-d H:i:s");
    $inputValue = $_POST["imagem"];
    $nome_arquivo = "image_webcam_conta_emp{$_SESSION["codconta"]}_{$_POST["codconta"]}".date("Ymd").".png";
    if (isset($inputValue)) {
        if (strpos($inputValue, "data:image/png;base64,") === 0) {
            $fd = fopen("../arquivos/{$nome_arquivo}", "wb");
            $data = base64_decode(substr($inputValue, strlen("data:image/png;base64,")));
        } else if (strpos($inputValue, "data:image/jpg;base64,") === 0) {
            $fd = fopen("../arquivos/{$nome_arquivo}", "wb");
            $data = base64_decode(substr($inputValue, strlen("data:image/jpg;base64,")));
        }

        if ($fd) {
            fwrite($fd, $data);
            fclose($fd);
        } else {
            die(json_encode(array('mensagem' => "Erro ao transferir arquivo para servidor!!!", 'situacao' => false)));
        }
    }
    
    $arquivo->link = $nome_arquivo;
    $resInserirConta = $arquivo->inserir();
    include "../model/Log.php";
    $log = new Log($conexao);
    $log->codpessoa  = $_SESSION['codpessoa'];
    $log->codempresa = $_SESSION['codempresa'];
    $log->acao       = "procurar";
    $log->observacao = "Salvo foto conta {$arquivo->nome} - em ". date('d/m/Y'). " - ". date('H:i');
    $log->codpagina  = "0";
    $log->data = date('Y-m-d');
    $log->hora = date('H:i:s');
    $log->inserir();     
    if($resInserirConta !== FALSE){
        die(json_encode(array('mensagem' => "Sucesso ao salvar imagem", 'situacao' => true)));
    }else{
        die(json_encode(array('mensagem' => "Erro ao salvar imagem causado por:". mysqli_error($conexao->conexao), 'situacao' => false)));
    }