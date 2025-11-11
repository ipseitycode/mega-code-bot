<?php
class GeradorBackendHomeConfiguration
{
    private $projeto;
    private $pacote;
    private $modulo = [];
    private $camada = [];
    private $pagina;
    private $arquivo;

    public function __construct()
    {
        $this->configurarEstrutura(); 
    }

    public function configurarEstrutura()
    {
        $this->projeto = "SEU_PROJETO";
        $this->pacote = "PACOTE";
        $this->modulo = ['MODULO_1', 'MODULO_2', 'MODULO_3'];
        $this->camada = [
                        'CAMADA_1', 
                        'CAMADA_2', 
                        'CAMADA_3',
                        'CAMADA_4', 
                        'CAMADA_5',
                        'CAMADA_6', 
                        'CAMADA_7', 
                        'CAMADA_8', 
                        'CAMADA_9', 
                        'CAMADA_10', 
                    ];
        $this->pagina = "PAGINA";
        $this->arquivo = "ARQUIVO";
    }
        

    public function getProjeto()
    {
        return $this->projeto;
    }
    public function getPacote()
    {
        return $this->pacote;
    }

    public function getModulo()
    {
        return $this->modulo;
    }

    public function getCamada()
    {
        return $this->camada;
    }

    public function getPagina()
    {
        return $this->pagina;
    }

    public function getArquivo()
    {
        return $this->arquivo;
    }

}