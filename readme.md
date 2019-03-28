<p align="center"><img src="/public/images/readme/title-readme.png"></p>

<h1 align="center">Biblioteca</h1>

## Como iniciar

- Crie uma base de dados com o nome **biblioteca** no MySQL.
- Copie o arquivo **.env.example** com o nome **.env** (cp .env.example .env).
- Rode o comando **composer install**.
- Rode o comando **php artisan migrate**.
- Rode o comando **php artisan serve**.
- Acesse via navegador o endereço http://127.0.0.1:8000/.

## Sobre

Um sistema para controle de locação de livros na biblioteca, com controle de usuários e datas para entrega. Possibilitando o aluguel de mais de um livro por aluno e com nível de permissão para cadastro de livros e autores.

## Características

- Nível de permissão (0 - Aluno/1000 - Administrador).
- Aluno = somente locação e devolução de livros, Administrador = cadastro, edição e exclusão de livros.
- O aluno pode alugar mais de 1 livro.
- Os livros conter autores e 1 imagem.
- Locação (data aluguel, data devolução, data entrega).
- Data devolução é fixa em data aluguel + 7 dias.
- Um livro pode conter mais de 1 autor.
- Uma locação pode conter mais de 1 livro
