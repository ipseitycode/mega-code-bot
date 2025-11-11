<?php

class GeradorBackendHomeView
{
    private $validator;
    private $mensagem = [];
    
    public function __construct() {   

        $this->validator = new GeradorBackendHomeValidator();
    }

    public function visualizarRelatorioGerador($relatorio)  
    {
        $resultado = $relatorio;
 
        try {
            
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($relatorio, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        } catch (Exception $e) {
            $this->mensagem[] = GeradorBackendHomeException::incorreto(__METHOD__, 'view.incorreto=' . $e->getMessage());
        }

        return $resultado;
    }
    
    public function visualizarMensagem()
    {
        foreach ($this->mensagem as $key => $msg) {
            print_r($msg);
        }

        return $this->mensagem;
    }

}  