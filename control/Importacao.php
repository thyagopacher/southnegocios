<?php
if(isset($_FILES['arquivo']) && $_FILES['arquivo'] != NULL){
    if(isset($_POST["somente_telefone"]) && $_POST["somente_telefone"] != NULL && $_POST["somente_telefone"] == "s"){
        include("./ImportacaoTelefone.php");
    }else{
        $separador = explode(".", $_FILES['arquivo']["name"]);
        if($separador[1] == "xls"){
            include("./ImportacaoXLS.php");
        }elseif($separador[1] == "csv"){
            include("./ImportacaoCSV.php");
        }else{
            die(json_encode(array('mensagem' => "Tipo de aquivo errado, corrija para XLS!!!", 'situacao' => false)));
        }
    }
}else{
    die(json_encode(array('mensagem' => "Arquivo não encontrado, por favor selecione algum!!!", 'situacao' => false)));
}
