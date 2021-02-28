<?php
try{
    session_cache_expire(180000);
    session_start();
    
    header ('Content-type: text/html; charset=UTF-8');
    function __autoload($class_name) {
        if(file_exists("../model/".$class_name . '.php')){
            include "../model/".$class_name . '.php';
        }elseif(file_exists("../visao/".$class_name . '.php')){
            include "../visao/".$class_name . '.php';
        }elseif(file_exists("./".$class_name . '.php')){
            include "./".$class_name . '.php';
        }
    }
    $conexao  = new Conexao();
    $pessoa   = new Pessoa($conexao);
    
    $variables = (strtolower($_SERVER["REQUEST_METHOD"]) == "GET") ? $_GET : $_POST;
    foreach($variables as $key => $value){
        $pessoa->$key = str_replace("select", "", str_replace("insert", "", str_replace("update", "", str_replace("or 1 = 1", "", $value))));
    }    
    $pessoa2 = $pessoa->login();
    
    if(!isset($pessoa2["codpessoa"])){
        echo '<script>alert("Erro ao logar pessoa! Causado por:',  mysqli_error($conexao->conexao),'"); window.history.back();</script>';
    }else{
        if($pessoa2["status"] == "i"){
            echo '<script>alert("Login inativo!!!"); window.history.back();</script>';
        }
        $_SESSION["nome"]       = $pessoa2["nome"];
        $_SESSION["codnivel"]   = $pessoa2["codnivel"];
        $_SESSION['codpessoa']  = $pessoa2["codpessoa"]; 
        $_SESSION['codempresa'] = $pessoa2["codempresa"];
        $_SESSION["imagem"]     = $pessoa2["imagem"];
        
        $acesso             = new Acesso($conexao);
        $acesso->codempresa = $_SESSION['codempresa'];
        $acesso->codpessoa  = $_SESSION['codpessoa'];
        $acesso->data       = date('Y-m-d');
        $acesso->enderecoip = $_SERVER["REMOTE_ADDR"];
        $acesso->salvar();
        echo '<script>document.location.href="../sistema/index.php";</script>';
    }
}catch(Exception $ex){
    echo '<script>alert("Erro ao realizar login causado por: ',$ex,'!");window.history.back();</script>';
}
 