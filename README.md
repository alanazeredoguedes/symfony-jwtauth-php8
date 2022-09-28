PROJECT ADMIN BASE

framework:
symfony 6.0
Sonata Admin 
php 8.0


configuration: 

composer install - instala dependencias

bin/console doctrine:schema:update --force - cria estrutura banco de dados

lexik:jwt:generate-keypair - gera chave publica e privada jwt


symfony server:start - inicia servidor









git reset --hard

Commands ->

bin/console create:database
create user in database and set password: bin/console security:hash-password
