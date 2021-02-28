<?php
    session_start();
        //validação caso a sessão caia
    if(!isset($_SESSION)){
        die(json_encode(array('mensagem' => 'Sua sessão caiu, por favor logue novamente!!!', 'situacao' => false)));
    }   
    include "../model/Conexao.php";
    include "../model/Especie.php";
    include "../visao/Utilitario.php";
    
    $conexao = new Conexao();
    $especie  = new Especie($conexao);
    
    $msg_retorno = "";
    $sit_retorno = true;        
    
    $variables = (strtolower($_SERVER["REQUEST_METHOD"]) == "GET") ? $_GET : $_POST;
    foreach($variables as $key => $value){
        $especie->$key = $value;
    }    

    $especie->codempresa      = $_SESSION['codempresa'];
    $res = $especie->atualizar();
    
    if($res === FALSE){
        $msg_retorno = "Erro ao atualizar espécie! Causado por:". mysqli_error($conexao->conexao);
        mail("thyago.pacher@gmail.com", "Erro sistema - control/AtualizarEspecie.php", $msg_retorno);   
        $sit_retorno = false;
    }else{
        $msg_retorno = "Especie atualizada com sucesso!";
        $sit_retorno = true;
    }
    if(isset($upload->erro) && $upload->erro != NULL && $upload->erro != ""){
        $msg_retorno .= " Problemas com o envio do arquivo: ". $upload->erro;
    }    
    include "../model/Log.php";
    $log = new Log($conexao);
    $log->codpessoa  = $_SESSION['codpessoa'];
    $log->codempresa = $_SESSION['codempresa'];
    $log->acao       = "procurar";
    $log->observacao = "Atualizado especie {$especie->nome} - em ". date('d/m/Y'). " - ". date('H:i');
    $log->codpagina  = "0";
    $log->data = date('Y-m-d');
    $log->hora = date('H:i:s');
    $log->inserir();       
    echo json_encode(array('mensagem' => $msg_retorno, 'situacao' => $sit_retorno));