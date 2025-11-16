<?PHP

define('_Register_Message','Please complete the form above with the right data inorder for you to start playing in our FREE gunbound server.<br>');
define('_Register_Message_Title','Welcome New User');

define('_Guild01','
A. To create a guild, you have to meet 2 conditions.<br />
B. First, you need to have a rank of '.getgrade($config['guild_rank_create']). ' ('.$config['guild_rank_create'].') or higher.<br />
C. Second, you need to have ('.$config['guild_money_create'].') Gold of creation fee.<br />
D. If you create a guild while logged onto Gunbound, you have to reconnect to the game to update<br />
E. The information and show the guild\'s name above the game ID.<br />
E. If there is a user who wants to join your guild, the user has to submit a request form (available<br />
E. from the website) and be accepted by you to become a guild member.<br />
E. * If the guild master\'s Internet Explorer version is low, the request forms may not appear, so it is<br />
E. * important that the Internet Explorer is updated to the latest version.<br />
E. * If you use special characters for guild names, it may not appear properly.');

define('_Guild02','
      A. First, if there is a guild you want to join, go to the Guild List of the website search for the guild\'s<br />
A. Name or the ID of the guild master.<br />
B. If you find the guild you\'re looking for, click it and submit a request form.<br />
C. the user has to have a rank of '.getgrade($config['guild_rank_join']). ' ('.$config['guild_rank_join'].') or higher.<br />');


define('_Ranking_Message','Welcome '.$config['server_name'].' Rankings. <br> Here you can see all players in our server.');
define('_Guild_Message','Welcome '.$config['server_name'].' Guild Rankings. <br> Here you can see all Guilds in our server.');

define('_Guild_Invite','You can get invited by asking the Guild Master for a personal Invitation Code. <br> With the Invitation Code you can then input it in your My Guild form and then you will automatically be IN the guild');
?>

