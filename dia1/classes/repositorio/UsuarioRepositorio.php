<?php

namespace App\Repositorio;

class UsuarioRepositorio
{
    
    protected $conexao;

    public function __construct($conexao)
    {
        $this->conexao = $conexao;
    }

    public function salvar(array $dados)
    {   

        $sql = "INSERT INTO usuario (nome, email, senha, admin)
                VALUES (?, ?, ?, 0)";
        
        $smtp = $this->conexao->prepare($sql);
        $smtp->bind_param('sss', $dados['nome'], $dados['email'], md5($dados['senha']));
        $smtp->execute();
        //var_dump(get_class_methods($smtp));

        if ($smtp->affected_rows > 0) {
            return true;
        } 
        
        return false;
    }

    public function validarEmailExiste(string $email)
    {
        $sql = "SELECT * FROM usuario WHERE email = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            return true;
        }
        
        return false;
    }

    public function update($id, $dados)
    {
        
        $sql = "UPDATE usuario set nome = ?, email = ?, senha = ? where id = ?";
        $smtp = $this->conexao->prepare($sql);
        $smtp->bind_param('sssi', $dados['nome'], $dados['email'], md5($dados['senha']), $id);
        $smtp->execute();

        if($smtp->affected_rows > 0) {
            return true;
        }

        return false;
    }
    
}