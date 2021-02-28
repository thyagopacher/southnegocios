<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Class Acesso{
    
    public $codacesso;
    public $codpessoa;
    public $data;
    public $dtsaida;
    public $quantidade;
    public $enderecoip;
    public $codempresa;
    private $conexao;
    private $tabela = "acesso";
    
    
    public function __construct($conn) {
        $this->conexao = $conn;
    }
    
    public function __destruct() {
        unset($this);
    }

    public function salvar(){
        $acessoHoje = $this->procuraAcessoPessoaHoje($this->codpessoa, $this->codempresa);
        if(isset($acessoHoje) && $acessoHoje != NULL && isset($acessoHoje["codpessoa"])){
            $this->data = $acessoHoje["data"];
            $this->codacesso = $acessoHoje["codacesso"];
            $this->dtsaida = ' ';
            $this->codacesso = $acessoHoje["codacesso"];
            $this->quantidade = $acessoHoje["quantidade"] + 1;
            $retorno = $this->atualizar();
        }else{
            $this->quantidade = 1;
            $this->data = date("Ymd");
            $retorno = $this->inserir();
        }
        return $retorno;
    }
    
    public function inserir(){
        return $this->conexao->inserir("acesso", $this);
    }
    
    public function atualizar(){
        return $this->conexao->atualizar("acesso", $this);
    }  
    
    public function excluir($codacesso){
        return $this->conexao->comando("delete from {$this->tabela} where codacesso = '{$codacesso}' and codempresa = '{$this->codempresa}'");
    }
    
    public function procuraCodigo($codacesso){
        return $this->conexao->comandoArray(("select * from {$this->tabela} where codacesso = '{$codacesso}' and codempresa = '{$this->codempresa}'"));
    }
    
    public function procuraCodpessoa($codpessoa){
        return $this->conexao->comando("select * from {$this->tabela} where codpessoa = '{$codpessoa}' and codempresa = '{$this->codempresa}' order by data");
    } 
    
    public function procuraAcessoPessoaHoje($codpessoa){
        return $this->conexao->comandoArray("select * from {$this->tabela} where codpessoa = '{$codpessoa}' and data = CURRENT_DATE() and codempresa = '{$this->codempresa}' order by data");
    }
    
    public function procuraData($data1, $data2){
        return $this->conexao->comando("select * from {$this->tabela} where data >= '{$data1}' and data <= '{$data2}' and codempresa = '{$this->codempresa}' order by data");
    } 
    
}