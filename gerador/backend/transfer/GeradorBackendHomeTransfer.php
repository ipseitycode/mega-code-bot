<?php

class GeradorBackendHomeTransfer {

    private $projeto;
    private $pacote;
    private $modulo;
    private $pagina;
    private $camada;
    private $arquivo;

    public function __construct() {
        
    }

    public function getProjeto() {
        return $this->projeto;
    }

    public function setProjeto($projeto) {
        $this->projeto = $projeto;
    }

    public function getPacote() {
        return $this->pacote;
    }

    public function setPacote($pacote) {
        $this->pacote = $pacote;
    }

    public function getModulo() {
        return $this->modulo;
    }

    public function setModulo($modulo) {
        $this->modulo = $modulo;
    }

    public function getPagina() {
        return $this->pagina;
    }

    public function setPagina($pagina) {
        $this->pagina = $pagina;
    }

    public function getCamada() {
        return $this->camada;
    }

    public function setCamada($camada) {
        $this->camada = $camada;
    }

    public function getArquivo() {
        return $this->arquivo;
    }

    public function setArquivo($arquivo) {
        $this->arquivo = $arquivo;
    }

}