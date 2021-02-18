<?php declare(strict_types = 1 );

namespace App\Validacoes;

use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Validation;

class Usuarios
{

    protected array $dados;

    protected $nome;

    public function __construct(array $input)
    {
        $this->dados = $input;
    }

    public function valid(): array
    {
        $validator = Validation::createValidator();

        $this->nome;

        $regras = [
            "allowMissingFields" => true,
            "fields" => [
                'nome' => [
                    new NotBlank([
                        "message" => 'Campo nome é obrigatório',
                    ]),
                    new Length(
                        [
                            "min" => 5,
                            "max" => 200,
                            "minMessage" => "Nome precisar ter no mínimo 5 caracteres",
                            "maxMessage" => "Nome só poder ter no máximo 200 caracteres",
                        ]
                    ),
                ],
                'email' => [
                    new NotBlank([
                        "message" => 'Campo email é obrigatório',
                    ]),
                    new Email(
                        [
                            "message" => 'Email {{ value }} não é valido',
                        ]
                    ),
                ],
                'senha' => [
                    new NotBlank([
                        "message" => 'Campo senha é obrigatório',
                    ]),
                    new Length(
                        [
                            "min" => 5,
                            "max" => 8,
                            "minMessage" => "Senha precisar ter no mínimo 4 caracteres",
                            "maxMessage" => "Senha só poder ter no máximo 8 caracteres",
                        ]
                    ),
                ],
                
            ]

        ];

        $validacoes = new Collection($regras);

        $violations = $validator->validate($this->dados, $validacoes);

        $errors = [];

        if (0 !== count($violations)) {
            // there are errors, now you can show them
            foreach ($violations as $violation) {
                $errors[] = $violation->getMessage();
            }
        };


        return $errors;
    }
}
