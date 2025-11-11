<?php

class GeradorBackendHomeService
{
    private $validator;
    private $transfer;
    private $mensagem = [];

    public function __construct($transfer) 
    {
        $this->validator = new GeradorBackendHomeValidator();
        $this->transfer = $transfer; 
    }

    public function executarGerador() 
    {   
        $resultado = []; 
        
        try {
            
            $gerador = $this->estabelecerEstrutura(
                $this->transfer->getProjeto(),  // string
                $this->transfer->getPacote(),   // string
                $this->transfer->getModulo(),  // array
                $this->transfer->getCamada(),  // array
                $this->transfer->getPagina(),  // string
                $this->transfer->getArquivo() // string
            );

            if ($this->validator->validarArray($gerador)) {

                $resultado = $gerador;

            } 

        } catch (Exception $e) {
            $this->mensagem[] = GeradorBackendHomeException::incorreto(__METHOD__, 'service.incorreto=' . $e->getMessage());
        } 

        return $resultado;
    }
    
    private function estabelecerEstrutura(
        string $projeto,
        string $pacote,
        array $modulos,
        array $camadas,
        string $pagina,
        string $arquivo
    )
    {
        $resultado = [
            'sucesso' => true,
            'projeto_criado' => '',
            'pacote_criado' => '',
            'modulos_criados' => [],
            'camadas_criadas' => [],
            'arquivos_criados' => [],
            'diretorios_existentes' => [],
            'arquivos_existentes' => [],
            'erros' => []
        ];
        
        try {

            $projeto = rtrim($projeto, '/'); 
            $caminhoPacote = $projeto . '/' . $pacote;

            // cria o projeto
            $statusProjeto = $this->criarDiretorio($projeto, $resultado);
            if ($statusProjeto === 1) {
                
                $resultado['projeto_criado'] = $projeto;
            }

            // cria o pacote depois - se projeto foi criado ou ja existe
            if ($statusProjeto === 1 || $statusProjeto === 2) {

                $statusPacote = $this->criarDiretorio($caminhoPacote, $resultado);

                if ($statusPacote === 1) {
                    $resultado['pacote_criado'] = $caminhoPacote;
                }
            }

            // cria modulos
            foreach ($modulos as $modulo) {

                $caminhoModulo = $caminhoPacote . '/' . $modulo;
                
                $statusModulo = $this->criarDiretorio($caminhoModulo, $resultado);
                
                // so adiciona se foi criado
                if ($statusModulo === 1) {
                    $resultado['modulos_criados'][] = $caminhoModulo;
                }
                
                // continua se criado ou ja existe
                if ($statusModulo === 1 || $statusModulo === 2) {
                    
                    // cria arquivo no modulo
                    $this->criarArquivoModulo($caminhoModulo, $arquivo, $resultado);
                    
                    // cria camadas
                    foreach ($camadas as $camada) {

                        $caminhoCamada = $caminhoModulo . '/' . $camada;
                        
                        $statusCamada = $this->criarDiretorio($caminhoCamada, $resultado);
                        
                        // so adiciona se foi criado
                        if ($statusCamada === 1) {
                            $resultado['camadas_criadas'][] = $caminhoCamada;
                        }
                        
                        // continua se criado ou ja existe
                        if ($statusCamada === 1 || $statusCamada === 2) {
                            $this->criarArquivoCamada($caminhoCamada, $pagina, $resultado);
                        }
                    }
                }
            }

        } catch (Exception $e) {
            $this->mensagem[] = GeradorBackendHomeException::incorreto(__METHOD__, 'service.incorreto=' . $e->getMessage());
        } 

        return $resultado;
    }

    // @return int 
    // 0 = erro 
    // 1 = criado 
    // 2 = existente
    private function criarDiretorio(string $caminho, array &$resultado): int
    {
        try {

            if (file_exists($caminho)) {
                
                $resultado['diretorios_existentes'][] = $caminho;
                return 2;
            }
            
            if (mkdir($caminho, 0755, true)) {

                return 1;

            } else {
                
                $resultado['erros'][] = "ERRO AO CRIAR DIRETORIO: {$caminho}";
                return 0;
            }
            
        } catch (Exception $e) {
            $this->mensagem[] = GeradorBackendHomeException::incorreto(__METHOD__, 'service.incorreto=' . $e->getMessage());
            return 0;
        } 
    }

    private function criarArquivoCamada(
        string $caminhoDiretorio, 
        string $pagina, 
        array &$resultado
    ): void
    {
        try {

            $partes = explode('/', $caminhoDiretorio);

            if (count($partes) === 4) {
                
                $pacote = $partes[1];
                $modulo = $partes[2];
                $camada = $partes[3];

                $nomeArquivo = ucfirst($pacote) 
                        . ucfirst($modulo) 
                        . ucfirst($pagina) 
                        . ucfirst($camada) 
                        . '.php';

                $caminhoCompleto = $caminhoDiretorio . '/' . $nomeArquivo;

                if (file_exists($caminhoCompleto)) {
                    $resultado['arquivos_existentes'][] = $caminhoCompleto;
                    return;
                }

                $arquivo = fopen($caminhoCompleto, 'w');
                
                if ($arquivo !== false) {

                    fclose($arquivo);
                    $resultado['arquivos_criados'][] = $caminhoCompleto;

                } else {
                    $resultado['erros'][] = "ERRO AO CRIAR ARQUIVO = {$caminhoCompleto}";
                }

            } else {
                $resultado['erros'][] = "CAMINHO INVALIDO: {$caminhoDiretorio}";
            }

        } catch (Exception $e) {
            $this->mensagem[] = GeradorBackendHomeException::incorreto(__METHOD__, 'service.incorreto=' . $e->getMessage());
        } 
    }

    private function criarArquivoModulo(
        string $caminhoModulo, 
        string $arquivo, 
        array &$resultado
    ): void
    {
        try {

            $caminhoCompleto = $caminhoModulo . '/' . $arquivo . '.php';

            if (file_exists($caminhoCompleto)) {
                $resultado['arquivos_existentes'][] = $caminhoCompleto;
                return;
            }

            $arquivoHandle = fopen($caminhoCompleto, 'w');
            
            if ($arquivoHandle !== false) {

                fclose($arquivoHandle);
                $resultado['arquivos_criados'][] = $caminhoCompleto;
                
            } else {
                $resultado['erros'][] = "ERRO AO CRIAR ARQUIVO = {$caminhoCompleto}";
            }

        } catch (Exception $e) {
            $this->mensagem[] = GeradorBackendHomeException::incorreto(__METHOD__, 'service.incorreto=' . $e->getMessage());
        } 
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