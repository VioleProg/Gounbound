# Gunbound - Site Profissional

Site moderno e profissional para o servidor Gunbound (Gunbound).

## Características

- ✅ Design moderno e responsivo
- ✅ Tema branco com animações suaves
- ✅ Sistema de login e registro
- ✅ Painel administrativo para gerenciar contas
- ✅ Ranking de jogadores
- ✅ Perfil de usuário
- ✅ Interface intuitiva e animada

## Requisitos

- PHP 7.4 ou superior
- MariaDB/MySQL
- Servidor web (Apache/Nginx)

## Instalação

1. Certifique-se de que o banco de dados `gunbound` está criado e populado com o arquivo `gunbound.sql`

2. Configure as credenciais do banco de dados no arquivo `config.php`:
   ```php
   define('DB_HOST', '127.0.0.1');
   define('DB_USER', 'root');
   define('DB_PASS', 'viole123');
   define('DB_NAME', 'gunbound');
   ```

3. Coloque a logo em `Assets/logo.png`

4. Acesse o site através do navegador

## Estrutura de Arquivos

```
/
├── admin/              # Painel administrativo
│   ├── index.php      # Lista de usuários
│   └── edit.php       # Editar usuário
├── assets/            # Recursos estáticos
│   ├── css/
│   │   └── style.css  # Estilos principais
│   └── js/
│       └── main.js    # JavaScript principal
├── includes/          # Arquivos PHP compartilhados
│   ├── functions.php  # Funções auxiliares
│   ├── header.php     # Cabeçalho
│   └── footer.php     # Rodapé
├── Assets/            # Logo e imagens
│   └── logo.png
├── config.php         # Configuração do banco de dados
├── index.php          # Página principal
├── login.php          # Página de login
├── register.php       # Página de registro
├── logout.php         # Logout
├── ranking.php        # Ranking de jogadores
└── profile.php        # Perfil do usuário
```

## Funcionalidades

### Sistema de Autenticação
- Login com usuário e senha
- Registro de novos usuários com validação
- Sessões seguras
- Logout

### Painel Administrativo
- Lista de todos os usuários
- Edição de status (Ativo/Inativo)
- Edição de autoridade (nível de admin)
- Paginação de resultados

### Ranking
- Lista de jogadores ordenados por ranking
- Exibição de pontos, gold e posição
- Paginação

### Perfil
- Visualização de estatísticas do jogador
- Informações da conta

## Permissões de Administrador

Usuários com `Authority >= 98` na tabela `user` têm acesso ao painel administrativo.

## Tecnologias Utilizadas

- PHP 7.4+
- MySQLi (prepared statements para segurança)
- CSS3 com animações
- JavaScript ES6+
- Google Fonts (Inter)

## Segurança

- Prepared statements para prevenir SQL injection
- Validação de dados no servidor e cliente
- Proteção de sessões
- Sanitização de saída (htmlspecialchars)

## Suporte

Para problemas ou dúvidas, verifique:
1. Conexão com o banco de dados
2. Permissões de arquivo
3. Logs de erro do PHP

