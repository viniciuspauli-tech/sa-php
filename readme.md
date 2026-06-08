#  Sistema de Gerenciamento de Usuários — sa-php

##  Objetivo do Sistema

O **sa-php** é uma aplicação web desenvolvida em PHP puro com banco de dados MySQL que implementa um sistema completo de autenticação e gerenciamento de usuários. O sistema permite que um administrador faça login, cadastre novos usuários, edite informações existentes e exclua registros, tudo com controle de sessão para garantir que apenas usuários autenticados acessem as páginas protegidas.

---

##  Tecnologias Utilizadas

| Tecnologia | Versão Recomendada | Finalidade |
|---|---|---|
| PHP | 8.0+ | Linguagem backend principal |
| MySQL | 8.0+ | Banco de dados relacional |
| MySQLi | (nativa do PHP) | Extensão de conexão com o banco |
| HTML5 | — | Estrutura das páginas |
| Apache / Nginx | — | Servidor web (ex: XAMPP, WAMP, Laragon) |

---

##  Estrutura de Pastas

```
sa-php/
│
├── index.php                   # Página de login (ponto de entrada da aplicação)
│
├── infra/
│   └── db/
│       ├── connect.php         # Configuração e conexão com o banco de dados
│       └── script.sql          # Script SQL para criação do banco e tabelas
│
└── public/
    ├── home.php                # Página principal (cadastro + listagem de usuários)
    ├── editar.php              # Formulário de edição de usuário
    ├── excluir.php             # Lógica de exclusão de usuário
    ├── logout.php              # Encerramento de sessão
    └── components/
        └── table.php           # Componente reutilizável: tabela de usuários
```

---

##  Funcionalidades

###  Login (`index.php`)
- Formulário com campos de **usuário** e **senha**
- Autenticação via consulta no banco de dados
- Utiliza `session_start()` para iniciar e manter a sessão do usuário autenticado
- Redireciona para `public/home.php` após login bem-sucedido
- Exibe mensagem de erro em caso de credenciais inválidas

###  Página Principal (`public/home.php`)
- Verifica se o usuário está logado via `$_SESSION`; caso contrário, redireciona para o login
- Exibe mensagem de boas-vindas com o nome do usuário logado
- Formulário de **cadastro de novo usuário** (nome e senha) via POST
- Lista todos os usuários cadastrados através do componente `table.php`
- Link para logout

###  Editar Usuário (`public/editar.php`)
- Recebe o `id` do usuário via parâmetro GET (`?id=X`)
- Busca os dados atuais do usuário no banco de dados
- Exibe formulário pré-preenchido com nome e senha do usuário
- Ao submeter, executa `UPDATE` no banco e redireciona para `home.php`
- Protegido por verificação de sessão

###  Excluir Usuário (`public/excluir.php`)
- Recebe o `id` do usuário via parâmetro GET (`?id=X`)
- Executa `DELETE` no banco de dados
- Redireciona automaticamente para `home.php` após a exclusão
- Protegido por verificação de sessão

###  Logout (`public/logout.php`)
- Destrói a sessão com `session_destroy()`
- Redireciona o usuário para a tela de login

###  Tabela de Usuários (`public/components/table.php`)
- Componente reutilizável incluído na `home.php`
- Consulta todos os usuários da tabela `usuarios`
- Exibe: ID, Nome do Usuário, Senha, e botões de ação (Editar / Excluir)
- Os links de ação passam o `id` via GET para as respectivas páginas

---

##  Melhorias Implementadas

As seguintes melhorias foram identificadas e/ou aplicadas em relação a uma implementação básica inicial:

1. **Uso de sessões em todas as páginas protegidas** — `session_start()` e verificação de `$_SESSION["usuario"]` implementados em `home.php`, `editar.php` e `excluir.php`, impedindo acesso não autorizado.

2. **Redirecionamento após ações (Post/Redirect/Get)** — Após cadastro, edição e exclusão, o sistema redireciona o usuário, evitando reenvio acidental de formulários ao atualizar a página.

3. **Componentização com `include`** — A tabela de listagem de usuários foi extraída para `components/table.php`, tornando o código mais organizado e reutilizável.

4. **Separação de responsabilidades por camadas** — A conexão com o banco está isolada em `infra/db/connect.php`, separando a infraestrutura da lógica de apresentação.

5. **Script SQL documentado** — O arquivo `infra/db/script.sql` contém os comandos completos para criação do banco, tabela e inserção de um usuário padrão (`admin/123`), facilitando o setup do ambiente.

>  **Pontos de atenção para produção:** O sistema em seu estado atual utiliza queries SQL sem prepared statements (vulnerável a SQL Injection) e armazena senhas em texto puro. Para uso em produção, recomenda-se usar `PDO` com prepared statements e `password_hash()` / `password_verify()` para as senhas.

---

##  Instruções para Execução

### Pré-requisitos

- **PHP 8.0+** instalado localmente
- **MySQL 8.0+** ou MariaDB
- Servidor web local: [XAMPP](https://www.apachefriends.org/), [WAMP](https://www.wampserver.com/), [Laragon](https://laragon.org/) ou similar

---

### Passo 1 — Clonar o Repositório

```bash
git clone https://github.com/viniciuspauli-tech/sa-php.git
cd sa-php
```

---

### Passo 2 — Configurar o Banco de Dados

1. Abra o **phpMyAdmin** ou um cliente MySQL (DBeaver, MySQL Workbench, etc.)
2. Execute o script SQL localizado em:

```
infra/db/script.sql
```

Isso irá:
- Criar o banco de dados `sistema_simples_m1`
- Criar a tabela `usuarios`
- Inserir o usuário padrão `admin` com senha `123`

---

### Passo 3 — Configurar a Conexão com o Banco

Abra o arquivo `infra/db/connect.php` e ajuste as credenciais conforme seu ambiente:

```php
$host = "localhost";
$user = "root";       // seu usuário MySQL
$pass = "root";       // sua senha MySQL
$db   = "sistema_simples_m1";
```

---

### Passo 4 — Mover o Projeto para o Servidor Local

Copie a pasta `sa-php` para o diretório raiz do seu servidor:

| Servidor | Diretório |
|---|---|
| XAMPP (Windows) | `C:/xampp/htdocs/sa-php` |
| WAMP (Windows) | `C:/wamp64/www/sa-php` |
| Laragon | `C:/laragon/www/sa-php` |
| Linux/Mac | `/var/www/html/sa-php` |

---

### Passo 5 — Acessar no Navegador

Abra o navegador e acesse:

```
http://localhost/sa-php/
```

### Credenciais padrão

| Campo | Valor |
|---|---|
| Usuário | `admin` |
| Senha | `123` |

---

##  Licença