# Testes

- Requisitos: PHP 8.1+, Composer, MySQL para testes.
- Instalação de dev deps: `composer install`
- Executar testes: `./vendor/bin/phpunit -c phpunit.xml.dist`

## Variáveis de ambiente de teste (.env)
Crie um arquivo `.env` com as chaves necessárias ou defina variáveis do ambiente:
```
MYSQL_HOST=127.0.0.1
MYSQL_USERNAME=root
MYSQL_PASSWORD=secret
MYSQL_DATABASE_NAME=ecommerce_test
```

Durante testes de integração com DB, a suíte deve apontar para `ecommerce_test`.
