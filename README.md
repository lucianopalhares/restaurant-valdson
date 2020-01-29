<p align="center"><img src="https://github.com/lucianopalhares/restaurant-valdson/blob/master/public/frontend/images/logo_github.png" width="400"></p>

<p align="center">
<a href="https://travis-ci.com/lucianopalhares/restaurant-valdson"><img src="https://travis-ci.com/lucianopalhares/restaurant-valdson.svg?branch=master" alt="Build Status"></a>
<a href="https://opensource.org/licenses/MIT"><img src="https://img.shields.io/badge/License-MIT-green.svg" alt="License"></a>
</p>

## Laravel 6 - Restaurant

Front-end com painel administrativo para restaurante. Possui cadastro de cardápio,categoria,reserva de mesa e mensagem de contato.

## Instalação (comandos)

git clone https://github.com/lucianopalhares/restaurant-valdson.git 

composer install

verifique se existe o arquivo .env se nao existir faça uma copia de .env.example com o nome .env 

php artisan key:generate

crie um banco de dados com o nome que desejar

preencha o arquivo .env com os dados do banco de dados na linha:

DB_CONNECTION=mysql<br />
DB_HOST=127.0.0.1<br />
DB_PORT=3306<br />
DB_DATABASE=nomedobancodedados<br />
DB_USERNAME=usuariodobancodedados<br />
DB_PASSWORD=senhadobancodedados

php artisan migrate (ira criar as tabelas no banco de dados)

php artisan db:seed (ira criar o usuario admin para ter acesso ao sistema)

Se os diretorios abaixo nao existirem devem ser criados com permissão para gravar.

dados de acesso:
admin@admin.com
12345678

## License

[MIT license](https://opensource.org/licenses/MIT).
