<?php
    session_start();
    //validação caso a sessão caia
    if(!isset($_SESSION)){
        die(json_encode(array('mensagem' => 'Sua sessão caiu, por favor logue novamente!!!', 'situacao' => false)));
    }       
    include "../model/Conexao.php";
    include "../model/Agenda.php";
    
    $conexao = new Conexao();
    $agenda  = new Agenda($conexao);
    
    $msg_retorno = "";
    $sit_retorno = true; 
    
    $variables = (strtolower($_SERVER["REQUEST_METHOD"]) == "GET") ? $_GET : $_POST;
    foreach($variables as $key => $value){
        $agenda->$key = $value;
    }  
    $agenda->codempresa     = $_SESSION['codempresa'];    
    $agenda->data           = implode("-",array_reverse(explode("/",$agenda->data)));   
    $res = $agenda->atualizar();   
    if($res !== FALSE){
        $msg_retorno = "Agenda atualizada com sucesso!!!";
    }else{
        $msg_retorno = "Erro ao agendar causado por:". mysqli_error($conexao->conexao);
        $sit_retorno = false;
    }
    include "../model/Log.php";
    $log = new Log($conexao);
    $log->codpessoa  = $_SESSION['codpessoa'];
    $log->codempresa = $_SESSION['codempresa'];
    $log->acao       = "procurar";
    $log->observacao = "Atualizado agenda - em ". date('d/m/Y'). " - ". date('H:i');
    $log->codpagina  = "0";
    $log->data = date('Y-m-d');
    $log->hora = date('H:i:s');
    $log->inserir();          
    echo json_encode(array('mensagem' => $msg_retorno, 'situacao' => $sit_retorno));