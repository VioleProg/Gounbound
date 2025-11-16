<?PHP
// Banco de dados Config.
$config['db_host'] = 'localhost';
$config['db_name'] = 'gbwc';
$config['db_user'] = 'root';
$config['db_pass'] = '';


// WebSite Config.
$config['server_name'] = "GBrasil - Onde o melhor й vocк!";        // Titulo para o site.
$config['site_link'] = "69.162.78.199";
$config['server_ip'] = "69.162.78.199";                // Ip do servidor.
$config['brokerport'] = "8372";                   // Porta do Broker.
$config['buddycenter'] = "8391";                // Ip do servidor.
$config['buddyserv'] = "8353";                   // Porta do Broker.
$config['centerport'] = "8372";                   // Porta do center.
$config['server8360'] = "8360";                   // Porta do servidor1
$config['server8361'] = "8361";                   // Porta do servidor1
$config['server8362'] = "8362";                   // Porta do servidor1
$config['server8363'] = "8363";                   // Porta do servidor1
$config['default_mod'] = 'home';
$config['template'] = 'gbetools';
$config['reg_mail_check'] = 0;
$config['adm_logs'] = 'logs';
$config['language'] = 'English';

// Registro Config.
$config['reg_min_len'] = 4;
$config['reg_max_len'] = 20;
$config['reg_max_mail'] = 50;
$config['reg_allow'] = true;
$config['reg_mail_check'] = 0;
$config['user_gold'] = "500000";                 // Quantia em Gold que o jogador irб comeзar a jogar (Max 999999999)
$config['user_cash'] = "60000";                    // Quantia em Cash que o jogador irб comeзar a jogar (Max 999999999)


// Ranking / Clгs config.
$config['rank_pp'] = 20;
$config['rank_page_limit'] = 5;
$config['rank_exclude'] = 'Preto Negro'; 
$config['show_gm'] = true; 
$config['show_admin'] = true; 
$config['guild_exclude'] = 'johan'; 
$config['forum_pp'] = 20;
$config['forum_page_limit'] = 5;

// Top Rank Config.
$config['toprank_pp'] = 4; 
$config['topban_pp'] = 5; 
$config['toprank_page_limit'] = 7;
$config['toprank_exclude'] = 'Preto Negro'; 
$config['topshow_gm'] = true;
$config['topshow_admin'] = true; 
$config['topguild_exclude'] = 'johan'; 

// E-Mail Config.
$config['mail_host'] = '127.0.0.1';
$config['mail_pass'] = '';
$config['mail_user'] = '';
$config['admin_mail'] = 'romulojohan@gmail.com';

// Clг Config.
$config['guild_rank_create'] = 12;
$config['guild_rank_join'] = 14;
$config['guild_money_create'] = 30000;

// Gold x Cash Config.
$config['Gold2Cash'] = 100000000; // Ex. 30 GOLD = 1 CASH
// Preзo para a troca de nick.
$config['NickX_Pay'] = 10000; // Quantia em GOLD
// Preзo para a troca de pais.
$config['CountryX_Pay'] = 20000; // Quantia em Gold
// Preзo para a troca de sexo
$config['Gender_Pay'] = 50000; // Quantia em Gold

$config['Evento'] = 200; // 
$config['compra'] = 2000; // 

// Preзo para participaзгo do evento - GoldFacil
$config['GoldFacil'] = 23; // Nivel que possibilita a participaзгo do usuario.
$config['Encerra_GoldFacil'] = '00/00/0000';

// Info - Admin Page Config.
$config['Show_Money'] = true;
$config['Show_Avatar'] = true;

// Preзo para resetar Damage.
$config['Damage'] = 10000; // Quantia em GOLD
// Resetar Damage.
$config['AccumDamage'] = 0; // Resetar a tabela AccumDamage (nгo editar)
// Resetar Damage.
$config['AccumShot'] = 0; // Resetar a tabela AccumShot (nгo editar)
//Pontos de eventos necessбrios para trocar por avatar
$config['evento_avatar'] = '300';


?>