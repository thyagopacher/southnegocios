<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Class Telefone{
    
    public $codtelefone;
    public $numero;
    public $codtipo;
    public $codpessoa;
    public $dtcadastro;
    public $codempresa;
    public $codfuncionario;
    public $configuracao;
    public $url = 'http://USERNAME:PASSWORD@vpn.multibr.com/sys/index.php/api/call_now?telefone=[telefone]&key=[key]&contentType=json';
    private $conexao;
    
    public function __construct($conn) {
        $this->conexao       = $conn;
        $configuracao        = $this->conexao->comandoArray('select usuarioMultiBR, senhaMultiBR, keyMultiBR from pessoa where codpessoa = '.$_SESSION["codpessoa"].' codempresa = '. $_SESSION["codempresa"]);  
        if(!isset($configuracao["usuarioMultiBR"]) || $configuracao["usuarioMultiBR"] == NULL || $configuracao["usuarioMultiBR"] == ""){
            $configuracao        = $this->conexao->comandoArray('select usuarioMultiBR, senhaMultiBR, keyMultiBR from configuracao where codempresa = '. $_SESSION["codempresa"]);   
        }
        $this->url           = str_replace('USERNAME', $configuracao["usuarioMultiBR"], $this->url);
        $this->url           = str_replace('PASSWORD', $configuracao["senhaMultiBR"], $this->url);
        $this->url           = str_replace('[key]', $configuracao["keyMultiBR"], $this->url);
    }
    
    public function __destruct() {
        unset($this);
    }    
    
    public function inserir(){
        if(!isset($this->dtcadastro) || $this->dtcadastro == NULL || $this->dtcadastro == ""){
            $this->dtcadastro = date("Ymd");
        }
        if(!isset($this->codtipo) || $this->codtipo == NULL || $this->codtipo == ""){
            $this->codtipo = 1;
        }
        if(!isset($this->codempresa) || $this->codempresa == NULL || $this->codempresa == ""){
            $this->codempresa = $_SESSION['codempresa'];
        }
        return $this->conexao->inserir("telefone", $this);
    }
    
    public function atualizar(){
        return $this->conexao->atualizar("telefone", $this);
    }  
    
    public function excluir($codtelefone){
        return $this->conexao->excluir("telefone", $this);
    }
    
    public function procuraCodigo($codtelefone){
        return $this->conexao->comandoArray(("select * from telefone where codtelefone = '{$codtelefone}' and codempresa='{$this->codempresa}'"));
    }
    
    public function procuraData($liberado1, $liberado2){
        return $this->conexao->comando("select telefone.*,  DATE_FORMAT(dtcadastro, '%d/%m/%Y') as dtcadastro2 from telefone where dtcadastro >= '{$liberado1}' and dtcadastro <= '{$liberado2}' and codempresa='{$this->codempresa}' order by dtcadastro");
    } 
    
    public function procuraNumero($numero){
        return $this->conexao->comando("select * from telefone where numero like '%{$numero}%' and codempresa='{$this->codempresa}' order by numero");
    } 
    

    public function soNumero($str) {
        return preg_replace("/[^0-9]/", "", $str);
    }       
    
    
    public function identificaCelular($numero) {
        $numero = $this->soNumero($numero);
        if(strlen($numero) >= 8 && strlen($numero) <= 9){
            if ($numero{0} == 7 || $numero{0} == 8 || $numero{0} == 9) {
                return true;
            } elseif ($numero{0} == 2 || $numero{0} == 3 || $numero{0} == 4) {
                return false;
            }
        }elseif(strlen($numero) > 9 && $numero{0} != 0){
            
            if ($numero{2} == 7 || $numero{2} == 8 || $numero{2} == 9) {
                return true;
            } elseif ($numero{2} == 2 || $numero{2} == 3 || $numero{2} == 4) {
                return false;
            }            
        }elseif($numero{0} == 0){
            if ($numero{3} == 7 || $numero{3} == 8 || $numero{3} == 9) {
                return true;
            } elseif ($numero{3} == 2 || $numero{3} == 3 || $numero{3} == 4) {
                return false;
            }            
        }
    } 
    
    public function ligaTelefone($telefone){
        $this->url = str_replace('[telefone]', $telefone, $this->url);
        $conteudo = file_get_contents($this->url);
        return json_decode(strtolower($conteudo));             
    }
}