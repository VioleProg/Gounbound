# Mapeamento do Banco de Dados - Gunbound

Este documento descreve as principais tabelas do banco de dados `gunbound` e suas funções.

## 📋 Tabelas Principais

### 🔐 **gunwcuser** (Tabela Principal de Contas)
**Responsabilidade:** Gerencia as contas de usuários do sistema web
- `Id` - ID único do usuário (varchar 16)
- `user` - Nome de usuário para login (varchar 16)
- `NickName` - Apelido/nickname do jogador (varchar 16)
- `Password` - Senha do usuário (varchar 16)
- `E_Mail` - Email do usuário (varchar 50)
- `Gender` - Gênero (0=Masculino, 1=Feminino)
- `Status` - Status da conta ('1'=Ativo, '0'=Inativo)
- `Authority` - Nível de autoridade (1=Normal, 98+=Admin)
- `Authority2` - Autoridade secundária
- `Country` - Código do país (char 3)
- `User_Level` - Nível do usuário
- `MuteTime` - Tempo de mute
- `RestrictTime` - Tempo de restrição
- `imagem_perfil` - URL da imagem de perfil
- `birthdate` - Data de nascimento
- `datareg` - Data de registro

**Uso:** Esta é a tabela PRINCIPAL para autenticação e gerenciamento de contas no site.

---

### 🎮 **game** (Dados do Jogo)
**Responsabilidade:** Armazena dados de progresso e estatísticas do jogador no jogo
- `Id` - ID do jogador (chave primária, varchar 16)
- `Nickname` - Apelido do jogador (varchar 16)
- `Money` - Gold/Moeda do jogo (int)
- `TotalScore` - Pontuação total acumulada (int)
- `SeasonScore` - Pontuação da temporada atual (int)
- `TotalGrade` - Grade/Level total (smallint)
- `SeasonGrade` - Grade da temporada (smallint)
- `CountryGrade` - Grade do país (int)
- `TotalRank` - Ranking total (int)
- `SeasonRank` - Ranking da temporada (int)
- `CountryRank` - Ranking do país (int)
- `Guild` - Nome da guilda/clã (varchar 8)
- `GuildRank` - Posição na guilda (int)
- `MemberCount` - Número de membros na guilda (smallint)
- `EventScore0-3` - Pontos de eventos (int)
- `Country` - Código do país (int)
- `AccumShot` - Tiros acumulados (int)
- `AccumDamage` - Dano acumulado (int)
- `LastUpdateTime` - Última atualização (timestamp)

**Uso:** Contém todas as estatísticas e progresso do jogador no jogo.

---

### 👤 **user** (Usuários do Sistema)
**Responsabilidade:** Tabela auxiliar de usuários (pode ser usada pelo servidor do jogo)
- `Id` - ID do usuário (varchar 16)
- `user` - Nome de usuário (varchar 16)
- `NickName` - Apelido (varchar 16)
- `Password` - Senha (varchar 16)
- `E_Mail` - Email (varchar 50)
- `Gender` - Gênero (smallint)
- `Status` - Status da conta (varchar 10)
- `Authority` - Autoridade (int)
- `Authority2` - Autoridade secundária (int)
- `Country` - País (char 3)
- `User_Level` - Nível do usuário (int)
- `token` - Token de autenticação (varchar 200)
- `token_expira` - Expiração do token (datetime)
- `datareg` - Data de registro (datetime)
- `imagem_perfil` - Imagem de perfil (varchar 200)
- `birthdate` - Data de nascimento (date)

**Uso:** Tabela complementar, pode ser usada pelo servidor do jogo.

---

### 💰 **cash** (Moeda Virtual)
**Responsabilidade:** Gerencia a moeda virtual (Cash) dos jogadores
- `ID` - ID do jogador (varchar, chave primária)
- `Cash` - Quantidade de cash (int)

**Uso:** Armazena a moeda virtual dos jogadores.

---

### 🏆 **country_reference** (Referência de Países)
**Responsabilidade:** Tabela de referência com nomes de países
- `Country_Count` - ID do país (auto increment)
- `Country_Number` - Número do país (int)
- `Country_Name` - Nome do país (varchar 200)

**Uso:** Conversão de códigos de país para nomes.

---

### 👥 **guildweb** (Guildas/Clãs)
**Responsabilidade:** Gerencia informações de guildas no site
- `Id` - ID da guilda
- `guild` - Nome da guilda
- `G_Master` - Mestre da guilda (ID do líder)
- `Descripcion` - Descrição da guilda
- `Requerimientos` - Requisitos para entrar
- `WebSite` - Site da guilda
- `foto` - Foto da guilda

**Uso:** Gerencia informações de guildas/clãs.

---

### 📦 **chest** (Inventário)
**Responsabilidade:** Armazena itens dos jogadores
- `Owner` - ID do dono (varchar)
- `Item` - Código do item (varchar)
- Outros campos relacionados a itens

**Uso:** Inventário de itens dos jogadores.

---

### 📝 **gbnews** (Notícias)
**Responsabilidade:** Armazena notícias do site
- `Id` - ID da notícia (auto increment)
- `Title` - Título (varchar)
- `Text` - Conteúdo (text)
- `Date` - Data de publicação (datetime)
- `Author` - Autor (varchar)

**Uso:** Sistema de notícias do site.

---

### 📝 **gbevents** (Eventos)
**Responsabilidade:** Armazena eventos do jogo
- `Id` - ID do evento (auto increment)
- `Title` - Título (varchar)
- `Text` - Conteúdo (text)
- `Date` - Data (datetime)

**Uso:** Sistema de eventos.

---

### 💬 **gbcomments** (Comentários)
**Responsabilidade:** Comentários em posts/notícias
- `Id` - ID do comentário (auto increment)
- `NickName` - Nickname do autor
- `Text` - Texto do comentário
- `Date` - Data (datetime)
- `Author` - Autor (varchar)
- `Msg_Id` - ID da mensagem relacionada

**Uso:** Sistema de comentários.

---

### 🔒 **ban** (Banimentos)
**Responsabilidade:** Registra banimentos de jogadores
- `Id` - ID do jogador banido
- `Reason` - Motivo do ban
- `Time` - Data/hora do ban
- `Admin` - Admin que aplicou o ban

**Uso:** Sistema de banimentos.

---

### 📊 **currentuser** (Usuários Online)
**Responsabilidade:** Rastreia usuários atualmente online
- `Id` - ID do usuário (chave primária)
- `ServerIp` - IP do servidor
- `ServerPort` - Porta do servidor
- `LoggingTime` - Hora de login

**Uso:** Monitora jogadores online.

---

### 📈 **game_info** (Estatísticas do Jogo)
**Responsabilidade:** Estatísticas agregadas do jogo por hora do dia
- `day` - Data (datetime)
- `avg_0` a `avg_23` - Média de jogadores por hora (0-23)
- `max_0` a `max_23` - Máximo de jogadores por hora
- `new_id` - Contador de novos IDs

**Uso:** Análise de estatísticas e picos de jogadores.

---

### 🎁 **gift** (Presentes)
**Responsabilidade:** Sistema de presentes entre jogadores
- `Id` - ID do presente
- `From` - Remetente
- `To` - Destinatário
- `Item` - Item presenteado
- `Time` - Data/hora

**Uso:** Sistema de envio de presentes.

---

### 📋 **loginlog** (Log de Logins)
**Responsabilidade:** Registra tentativas de login
- `Id` - ID do usuário
- `Time` - Data/hora do login
- `IP` - IP de origem
- `Success` - Sucesso (0/1)

**Uso:** Auditoria e segurança.

---

## 🔗 Relacionamentos Principais

```
gunwcuser (Id) ←→ game (Id)
    ↓
  cash (ID)
    ↓
  chest (Owner)
```

- **gunwcuser** é a tabela PRINCIPAL para autenticação no site
- **game** contém dados de progresso do jogador
- **cash** armazena moeda virtual
- **user** é uma tabela auxiliar (pode ser usada pelo servidor do jogo)

## ⚠️ Importante

- **Para autenticação no site:** Use `gunwcuser`
- **Para dados do jogo:** Use `game`
- **Para moeda virtual:** Use `cash`
- **Authority >= 98** = Administrador

