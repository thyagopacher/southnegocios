<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Class Importacao{
    
    public $codimportacao;
    public $codcarteira;
    public $data;
    public $codfuncionario;
    public $codempresa;
    public $qtdimportado;
    public $qtdnimportado;
    private $conexao;
    
    public function __construct($conn) {
        $this->conexao = $conn;
    }
    
    public function __destruct() {
        unset($this);
    }
    
    public function inserir(){
        return $this->conexao->inserir("importacao", $this);
    }
    
    public function atualizar(){
        return $this->conexao->atualizar("importacao", $this);
    }  
    
    public function excluir(){
        return $this->conexao->excluir("importacao", $this);
    }
    
    public function excluirCarteira($codcarteira){
        return $this->conexao->comando("delete from importacao where codcarteira = '{$codcarteira}'");
    }
    
    public function procuraCodigo($codimportacao){
        return $this->conexao->comandoArray(("select * from importacao where codimportacao = '{$codimportacao}' and codempresa = '{$this->codempresa}'"));
    }

    public function procuraData($data1, $data2){
        return $this->conexao->comando("select * from importacao where data >= '{$data1}' and data <= '{$data2}' and codempresa = '{$this->codempresa}' order by data");
    } 
    
}