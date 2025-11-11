<?php

class GeradorBackendHomeController
{
    private $validator; 
    private $configuration; 
    private $transfer; 
    private $service; 
    private $view;   
    private $mensagem = []; 
 
    public function __construct() 
    {   
        $this->validator = new GeradorBackendHomeValidator();
        $this->configuration = new GeradorBackendHomeConfiguration();
        $this->transfer = new GeradorBackendHomeTransfer();
        $this->view = new GeradorBackendHomeView();
    } 
 
    public function obterGerador()
    {
        $resultado = null;
 
        try { 

            $transfer = $this->obterConfiguracoes();

            $this->service = new GeradorBackendHomeService($transfer);

            if ($this->validator->validarClasseMetodo($this->service, 'executarGerador')) 
            { 
                $relatorio = $this->service->executarGerador();

                if ($this->validator->validarClasseMetodo($this->view, 'visualizarRelatorioGerador')) 
                {
                    $resultado = $this->view->visualizarRelatorioGerador($relatorio);

                } else {
                    $this->mensagem[] = GeradorBackendHomeException::inexistente(__METHOD__, 'visualizarRelatorioGerador.inexistente');
                }

            } else {
                $this->mensagem[] = GeradorBackendHomeException::inexistente(__METHOD__, 'executarGerador.inexistente');
            }

        } catch (Exception $e) {
            $this->mensagem[] = GeradorBackendHomeException::incorreto(__METHOD__, 'controller.incorreto=' . $e->getMessage());
        }

        return $resultado;
    }

    // valida transfer e configuration
    public function obterConfiguracoes()  
    {
        try {

            if (
                //configuration
                $this->validator->validarClasseMetodo($this->configuration, 'getProjeto') &&
                $this->validator->validarClasseMetodo($this->configuration, 'getPacote') &&
                $this->validator->validarClasseMetodo($this->configuration, 'getModulo') &&
                $this->validator->validarClasseMetodo($this->configuration, 'getCamada') &&
                $this->validator->validarClasseMetodo($this->configuration, 'getPagina') &&
                $this->validator->validarClasseMetodo($this->configuration, 'getArquivo') &&

                //transfer
                $this->validator->validarClasseMetodo($this->transfer, 'setProjeto') &&
                $this->validator->validarClasseMetodo($this->transfer, 'setPacote') &&
                $this->validator->validarClasseMetodo($this->transfer, 'setModulo') &&
                $this->validator->validarClasseMetodo($this->transfer, 'setCamada') &&
                $this->validator->validarClasseMetodo($this->transfer, 'setPagina') &&
                $this->validator->validarClasseMetodo($this->transfer, 'setArquivo')) 
            { 

                // -- projeto
                if ($this->validator->validarProjeto($this->configuration->getProjeto())) {
                    $this->transfer->setProjeto($this->configuration->getProjeto());
                } else {
                    $this->transfer->setProjeto('projeto-criar-erro');
                }

                // -- pacote
                if ($this->validator->validarPacote($this->configuration->getPacote())) {
                    $this->transfer->setPacote($this->configuration->getPacote());
                } else {
                    $this->transfer->setPacote('pacote1');
                }

                // -- modulo
                if ($this->validator->validarModulo($this->configuration->getModulo())) {
                    $this->transfer->setModulo($this->configuration->getModulo());
                } else {
                    $this->transfer->setModulo(['modulo1', 'modulo2', 'modulo3']);
                }

                // -- camada
                if ($this->validator->validarCamada($this->configuration->getCamada())) {
                    $this->transfer->setCamada($this->configuration->getCamada());
                } else {
                    $this->transfer->setCamada(['erro1', 'erro2']);
                }

                // -- pagina
                if ($this->validator->validarPagina($this->configuration->getPagina())) {
                    $this->transfer->setPagina($this->configuration->getPagina());
                } else {
                    $this->transfer->setPagina('erro');
                }

                // -- arquivo
                if ($this->validator->validarArquivo($this->configuration->getArquivo())) {
                    $this->transfer->setArquivo($this->configuration->getArquivo());
                } else {
                    $this->transfer->setArquivo('arquivo');
                }
            
            } else {
                
                //configuration
                if (!$this->validator->validarClasseMetodo($this->configuration, 'getProjeto')) {
                    $this->mensagem[] = GeradorBackendHomeException::inexistente(__METHOD__, 'configuration.getProjeto.inexistente');
                }
                if (!$this->validator->validarClasseMetodo($this->configuration, 'getPacote')) {
                    $this->mensagem[] = GeradorBackendHomeException::inexistente(__METHOD__, 'configuration.getPacote.inexistente');
                }
                if (!$this->validator->validarClasseMetodo($this->configuration, 'getModulo')) {
                    $this->mensagem[] = GeradorBackendHomeException::inexistente(__METHOD__, 'configuration.getModulo.inexistente');
                }
                if (!$this->validator->validarClasseMetodo($this->configuration, 'getCamada')) {
                    $this->mensagem[] = GeradorBackendHomeException::inexistente(__METHOD__, 'configuration.getCamada.inexistente');
                }
                if (!$this->validator->validarClasseMetodo($this->configuration, 'getPagina')) {
                    $this->mensagem[] = GeradorBackendHomeException::inexistente(__METHOD__, 'configuration.getPagina.inexistente');
                }
                if (!$this->validator->validarClasseMetodo($this->configuration, 'getArquivo')) {
                    $this->mensagem[] = GeradorBackendHomeException::inexistente(__METHOD__, 'configuration.getArquivo.inexistente');
                }

                //transfer
                if (!$this->validator->validarClasseMetodo($this->transfer, 'setProjeto')) {
                    $this->mensagem[] = GeradorBackendHomeException::inexistente(__METHOD__, 'transfer.setProjeto.inexistente');
                }
                if (!$this->validator->validarClasseMetodo($this->transfer, 'setPacote')) {
                    $this->mensagem[] = GeradorBackendHomeException::inexistente(__METHOD__, 'transfer.setPacote.inexistente');
                }
                if (!$this->validator->validarClasseMetodo($this->transfer, 'setModulo')) {
                    $this->mensagem[] = GeradorBackendHomeException::inexistente(__METHOD__, 'transfer.setModulo.inexistente');
                }
                if (!$this->validator->validarClasseMetodo($this->transfer, 'setCamada')) {
                    $this->mensagem[] = GeradorBackendHomeException::inexistente(__METHOD__, 'transfer.setCamada.inexistente');
                }
                if (!$this->validator->validarClasseMetodo($this->transfer, 'setPagina')) {
                    $this->mensagem[] = GeradorBackendHomeException::inexistente(__METHOD__, 'transfer.setPagina.inexistente');
                }
                if (!$this->validator->validarClasseMetodo($this->transfer, 'setArquivo')) {
                    $this->mensagem[] = GeradorBackendHomeException::inexistente(__METHOD__, 'transfer.setArquivo.inexistente');
                }
            }

        } catch (Exception $e) {
            $this->mensagem[] = GeradorBackendHomeException::incorreto(__METHOD__, 'controller.incorreto=' . $e->getMessage());
        } 

        return $this->transfer;
    }

    public function visualizarMensagem(bool $exibir = true)
    {
        if ($exibir) {
            foreach ($this->mensagem as $msg) {
                echo $msg . PHP_EOL;
            }
        }

        return $this->mensagem;
    }

}