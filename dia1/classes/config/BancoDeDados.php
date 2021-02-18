<?php

namespace Config;

class BancoDeDados {
    
    protected $host = "127.0.0.1";

    protected $banco = "db_gt";

    protected $usuario = "root";

    protected $senha = "gak1234567890";

    public function conexao()
    {
        $conexao = mysqli_connect($this->host, $this->usuario, $this->senha, $this->banco, '33060');

        if(mysqli_connect_error()){
            $this->mensagemDeError();
            die;
        }
        
        return $conexao;
        
    }

    protected function mensagemDeError()
    {
        echo "Erro na conexao " . mysqli_connect_error();
    }


}