# Instalação do ambiente para uso da aplicação

Para que seja possível o uso do backend será necessário o uso do Docker, para que o ambiente seja emulado corretamente e suba todos os seus recursos, como NGinx, MariaDB, PHP-fpm e Laravel.

## Instalação do Docker
Para instalar o Docker basta baixar do site oficial do [Doker](https://hub.docker.com/?overlay=onboarding).

## Configuração do Docker para uso do ambiente
Para que usar o ambiente será necessário estar no diretório `\docker` e executar o seguinte comando:
```
$ sudo docker-compose up -d
```
Irá começar a instalação dos pacotes e e configuração do ambiente para o uso dos serviços.
Ao término será exibido um resultado semelhante ao abaixo:
```
Creating network "docker_static_network" with the default driver
Creating wedevbr_php_fpm ...
Creating wedevbr_php_fpm ... done
Creating wedevbr_mysql_db ...
Creating wedevbr_nginx ...
Creating wedevbr_nginx ... done
```

Após o passo anterior será necesário a execução dos seguintes comandos:
Instalar as dependencias para o o uso da aplicação (composer)
```
docker exec wedevbr_php_fpm composer install
```
Renomear o arquivo de configurações
```
docker exec wedevbr_php_fpm mv .env.example .env
```
Será necessário configurar o arquivo ".env" informando as configurações de conexão com o Banco de Dados, conforme o exemplo:
```
DB_CONNECTION=mysql
DB_HOST=1wedevbr_mariadb
DB_PORT=3306
DB_DATABASE=wedevbr
DB_USERNAME=admin
DB_PASSWORD=admin
```
Gerar nova Key para o Laravel
```
docker exec wedevbr_php_fpm php artisan key:generate
```
Limpar o cache para o uso
```
docker exec wedevbr_php_fpm php artisan config:cache
```
Executar as Migrations do Banco de Dados
```
docker exec wedevbr_php_fpm php artisan migrate
```
