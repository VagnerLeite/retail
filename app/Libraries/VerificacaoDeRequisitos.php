<?php

namespace App\Libraries;


class VerificacaoDeRequisitos
{
    private $fotosProcessadas;
    private $qtdeMinFotos = 6;
    private $msg;
    private $qtdeFotos;

    public function __construct($msg)
    {
        $this->msg = (array) json_decode(base64_decode($msg));
    }

    /**
     * Verifica se as fotos foram processadas, retorna true ou false
     * @return boolean.
     */
    public function verificaFotosProcessadas()
    {
        return($this->msg['fotos_processadas']);
    }

    /**
     * Verifica se a quantidade de fotos esta ok, retorna true ou false
     * @return boolean.
     */
    public function verificaQtdeFotos()
    {
        $this->qtdeFotos = count((array) $this->msg['array_fotos']);

        return ($this->qtdeFotos >= $this->qtdeMinFotos);
    }

    /**
     * Executo a verificação e retorno true ou false
     * @return boolean.
     */
    public function executaVerificacao()
    {
        if (!$this->verificaFotosProcessadas()){
            // Aqui gravo o Log
            return false;
        }

        if (!$this->verificaQtdeFotos()){
            // Aqui gravo o Log
            return false;
        }

        // Gravo o log de sucesso
        return true;
    }
}
