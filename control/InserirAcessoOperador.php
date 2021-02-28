<?php
    session_start();
        //validação caso a sessão caia
    if(!isset($_SESSION)){
        die(json_encode(array('mensagem' => 'Sua sessão caiu, por favor logue novamente!!!', 'situacao' => false)));
    }   
    date_default_timezone_set('America/Sao_Paulo');
    include "../model/Conexao.php";
    include "../model/AcessoOperador.php";
    
    $conexao = new Conexao();
    $acesso  = new AcessoOperador($conexao);
    
    $msg_retorno = "";
    $sit_retorno = true; 
    
    $variables = (strtolower($_SERVER["REQUEST_METHOD"]) == "GET") ? $_GET : $_POST;
    foreach($variables as $key => $value){
        $acesso->$key = $value;
    }  
    $acesso->codempresa     = $_SESSION['codempresa'];    
    $acesso->dtcadastro     = date("Y-m-d H:i:s");
    $res = $acesso->inserir();   
    if($res !== FALSE){
        $msg_retorno = "Acesso operador inserido com sucesso!!!";
    }else{
        $msg_retorno = "Erro ao inserir acesso de operador causado por:". mysqli_error($conexao->conexao);
        $sit_retorno = false;
    }
    echo json_encode(array('mensagem' => $msg_retorno, 'situacao' => $sit_retorno));