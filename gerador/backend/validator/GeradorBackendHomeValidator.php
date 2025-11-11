<?php

// projeto = string: letras minusculas separado por hifens. Exemplo: projeto-teste-api.
// pacote = string: letras minusculas, sem caracteres especiais. Exemplo: database.
// modulo = array: so pode haver no maximo 10 itens.
// camada = array: so pode haver no maximo 10 itens.
// pagina = string: letras minusculas, sem caracteres especiais.
// arquivo = string: pode ser maisuculas ou minusculos, sem caracteres epeciais.

class GeradorBackendHomeValidator
{
    /**
     * Valida o campo "projeto".
     * Deve conter apenas letras minúsculas e hifens.
     * Exemplo válido: projeto-teste-api
     */
    public function validarProjeto(string $projeto): bool
    {
        return preg_match('/^[a-z]+(-[a-z]+)*$/', $projeto) === 1;
    }

    /**
     * Valida o campo "pacote".
     * Deve conter apenas letras minúsculas, sem caracteres especiais.
     * Exemplo válido: database
     */
    public function validarPacote(string $pacote): bool
    {
        return preg_match('/^[a-z]+$/', $pacote) === 1;
    }

    /**
     * Valida o campo "modulo".
     * Deve ser um array com no máximo 30 itens.
     */
    public function validarModulo(array $modulo): bool
    {
        return count($modulo) <= 30;
    }

    /**
     * Valida o campo "pagina".
     * Deve conter apenas letras minúsculas, sem caracteres especiais.
     * Exemplo válido: home, contato
     */
    public function validarPagina(string $pagina): bool
    {
        return preg_match('/^[a-z]+$/', $pagina) === 1;
    }

    /**
     * Valida o campo "camada".
     * Deve ser um array com no máximo 30 itens.
     */
    public function validarCamada(array $camada): bool
    {
        return count($camada) <= 30;
    }

    /**
     * Valida o campo "arquivo".
     * Pode conter letras maiúsculas ou minúsculas, sem caracteres especiais.
     * Exemplo válido: Usuario, produto, Relatorio
     */
    public function validarArquivo(string $arquivo): bool
    {
        return preg_match('/^[A-Za-z]+$/', $arquivo) === 1;
    }

    public function validarClasseMetodo($classe, $metodo)
    {
        if (is_object($classe) && method_exists($classe, $metodo)) {
            return true;
        } else {
            return false;
        }
    }
    public function validarArray($array)
    {
        return is_array($array) && !empty($array);
    }

}