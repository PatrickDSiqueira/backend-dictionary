# Backend Dictionary API

API RESTful para gerenciamento de dicionário, desenvolvida como parte do desafio técnico da Coodesh.

## 📝 Descrição

Este projeto é uma API RESTful que permite gerenciar um dicionário de palavras, oferecendo funcionalidades para adicionar, consultar, atualizar e remover palavras e suas definições. A API foi desenvolvida seguindo as melhores práticas de desenvolvimento e padrões de projeto.

## 🛠️ Tecnologias Utilizadas

- PHP 8.2
- Laravel 12
- Laravel Passport (Autenticação OAuth2)
- Redis (Cache)
- SQLite (Banco de dados)
- PHPUnit (Testes)
- Laravel Pint (Padronização de código)
- Laravel Sail (Ambiente de desenvolvimento Docker)

## 🚀 Instalação e Uso

1. Clone o repositório:
```bash
git clone [URL_DO_REPOSITÓRIO]
cd backend-dictionary
```

2. Instale as dependências do PHP:
```bash
composer install
```

3. Configure o ambiente:
```bash
cp .env.example .env
php artisan key:generate
```

4. Configure o banco de dados:
```bash
php artisan migrate
```

5. Instale as dependências do Node.js (se necessário):
```bash
npm install
```

6. Inicie o servidor de desenvolvimento:
```bash
php artisan serve
```

Para executar os testes:
```bash
php artisan test
```

## 🔑 Autenticação

A API utiliza Laravel Passport para autenticação OAuth2. Para obter um token de acesso:

1. Registre um novo usuário através do endpoint `/api/register`
2. Faça login através do endpoint `/api/login`
3. Use o token retornado no header `Authorization: Bearer {token}` para as requisições subsequentes

## 📚 Documentação da API

A documentação completa da API está disponível através do endpoint `/api/documentation` quando o servidor estiver em execução.

## 🤝 Contribuição

Este projeto foi desenvolvido como parte do desafio técnico da Coodesh. Para contribuir:

1. Faça um fork do projeto
2. Crie uma branch para sua feature (`git checkout -b feature/AmazingFeature`)
3. Commit suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Push para a branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request

## 📄 Licença

Este projeto está sob a licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.

---

Desenvolvido como parte do desafio técnico da [Coodesh](https://coodesh.com/) 