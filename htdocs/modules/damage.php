<?PHP
if (@$config['user_login'] == 'ok') {

$db->Execute("Update cash set  Cash = Cash - ? where Id = ?", array($config['Damage'],$user_auth->username));
echo "1.000 de cash retirado de sua conta!";

$db->Execute("Update game set  AccumDamage = ? where Id = ?", array($config['AccumDamage'],$user_auth->username));

$db->Execute("Update game set  AccumShot = ? where Id = ?", array($config['AccumShot'],$user_auth->username));
echo "<br>Damage resetado com Sucesso";

echo 'Manutencao Realizada <br> Redirecionando em 2 segundos';
header('Refresh: 5; url=stats.jsp');
} 
?>

