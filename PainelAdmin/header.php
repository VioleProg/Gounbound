<?PHP 
session_start(); 
include("verify.php"); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-gb" xml:lang="en-gb">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Language" content="en-gb" />
<meta http-equiv="imagetoolbar" content="no" />

<title>.::GunBound Omega::. - Staff Control Panel</title>

<link href="style/admin.css" rel="stylesheet" type="text/css" media="screen" />

<script type="text/javascript">
// <![CDATA[
var jump_page = 'Enter the page number you wish to go to:';
var on_page = '';
var per_page = '';
var base_url = '';

var menu_state = 'shown';


/**
* Jump to page
*/
function jumpto()
{
	var page = prompt(jump_page, on_page);

	if (page !== null && !isNaN(page) && page == Math.floor(page) && page > 0)
	{
		if (base_url.indexOf('?') == -1)
		{
			document.location.href = base_url + '?start=' + ((page - 1) * per_page);
		}
		else
		{
			document.location.href = base_url.replace(/&amp;/g, '&') + '&start=' + ((page - 1) * per_page);
		}
	}
}

/**
* Set display of page element
* s[-1,0,1] = hide,toggle display,show
*/
function dE(n, s, type)
{
	if (!type)
	{
		type = 'block';
	}

	var e = document.getElementById(n);
	if (!s)
	{
		s = (e.style.display == '') ? -1 : 1;
	}
	e.style.display = (s == 1) ? type : 'none';
}

/**
* Mark/unmark checkboxes
* id = ID of parent container, name = name prefix, state = state [true/false]
*/
function marklist(id, name, state)
{
	var parent = document.getElementById(id);
	if (!parent)
	{
		eval('parent = document.' + id);
	}

	if (!parent)
	{
		return;
	}

	var rb = parent.getElementsByTagName('input');
	
	for (var r = 0; r < rb.length; r++)
	{
		if (rb[r].name.substr(0, name.length) == name)
		{
			rb[r].checked = state;
		}
	}
}

/**
* Find a member
*/
function find_username(url)
{
	popup(url, 760, 570, '_usersearch');
	return false;
}

/**
* Window popup
*/
function popup(url, width, height, name)
{
	if (!name)
	{
		name = '_popup';
	}

	window.open(url.replace(/&amp;/g, '&'), name, 'height=' + height + ',resizable=yes,scrollbars=yes, width=' + width);
	return false;
}

/**
* Hiding/Showing the side menu
*/
function switch_menu()
{
	var menu = document.getElementById('menu');
	var main = document.getElementById('main');
	var toggle = document.getElementById('toggle');
	var handle = document.getElementById('toggle-handle');

	switch (menu_state)
	{
		// hide
		case 'shown':
			main.style.width = '93%';
			menu_state = 'hidden';
			menu.style.display = 'none';
			toggle.style.width = '20px';
			handle.style.backgroundImage = 'url(images/toggle.gif)';
			handle.style.backgroundRepeat = 'no-repeat';

			
				handle.style.backgroundPosition = '100% 50%';
				toggle.style.left = '0';
			
		break;

		// show
		case 'hidden':
			main.style.width = '76%';
			menu_state = 'shown';
			menu.style.display = 'block';
			toggle.style.width = '5%';
			handle.style.backgroundImage = 'url(images/toggle.gif)';
			handle.style.backgroundRepeat = 'no-repeat';

			
				handle.style.backgroundPosition = '0% 50%';
				toggle.style.left = '15%';
			
		break;
	}
}

// ]]>

</script>
</head>

<body class="ltr">

<div id="wrap">
	<div id="page-header">
		<h1>GunBound Omega Staff Control Panel</h1>
		<p><a href="index.php">CP index</a> &bull; <a href="../">GunBound index</a></p>

		<p id="skip"><a href="#acp">Skip to content</a></p>

	</div>
 <div id="page-body">
		<div id="tabs">
			<ul>
			
				<li id="activetab"><a href="index.php"><span>Dashboard</span></a></li>
			
				<li id="activetab"><a href="#"><span>Server</span></a></li>
		
				<li id="activetab"><a href="#"><span>Site & Content</span></a></li>
 
				<li id="activetab"><a href="user.php"><span>Search Account</span></a></li>
			

			</ul>

		</div>

		<div id="acp">

		<div class="panel">
			<span class="corners-top"><span></span></span>
				<div id="content">
					 
					<div id="toggle">
						<a id="toggle-handle" accesskey="m" title="Hide or display the side menu" onclick="switch_menu(); return false;" href="#"></a></div>
					
					<div id="menu">

						<p>You are logged in as:<br />
			 <?PHP 
       $sql = mysql_query("SELECT * FROM game WHERE ID='".$_SESSION['user']."'");
       $sqlly = mysql_fetch_assoc($sql);
       $grade = $sqlly['TotalGrade'];
       
      
						echo "&nbsp;&nbsp;<strong><img src='../images/v2/arcade/gunbound/levels/s/".$grade.".png' alt='Administrator' /> ".$_SESSION['user']."</strong>"; ?>                                                
            [&nbsp;<a href="http://gbomega.com/?action=logout">Logout</a>&nbsp;]</p>

						<ul>
							<li class="header">Game Master Navigation</li>
							
								<li><a href="gmshop.php"><span>GM Avatar Shop</span></a></li>
								<li><a href="buylog.php"><span>View Purchase Log</span></a></li>
								<li><a href="sell.php"><span>View Sell/Delete Log</span></a></li>
								<li><a href="giftlog.php"><span>View Gift Log</span></a></li>
								<li><a href="gamelog.php"><span>View Game Log</span></a></li>
								<li><a href="user.php"><span>Search for Account</span></a></li>
								<li><a href="batchpw.php"><span>Batch Password Check</span></a></li>
								<li><a href="#"><span>Support Ticket Centre CP</span></a></li>
								<li><a href="#"><span>Mute Log</span></a></li>
								<li><a href="#"><span>Invetory Options</span></a></li>
								<li><a href="#"><span>Guild Management</span></a></li>
								<li><a href="#"><span>Dropped Users</span></a></li>
								<li><a href="#"><span>Login Logs</span></a></li>
								<li><a href="ban.php"><span>Ban & Suspension</span></a></li>
								<li><a href="#"><span>News & Events</span></a></li>
              <?PHP
              $sql = mysql_query("SELECT * FROM game WHERE Id='".$_SESSION['user']."'");
              $sqlly = mysql_fetch_assoc($sql);
              $authority = $sqlly['Authority'];
              if($authority >= 100)
              {
              echo '
              <li class="header">Administrator Navigation</li>
              <li><a href="#"><span>List Of Authority Accounts</span></a></li>
              <li><a href="#"><span>GM Log</span></a></li>
              <li><a href="#"><span>Reset User Account</span></a></li>
              <li><a href="#"><span>Add User As GM</span></a></li>
              <li><a href="#"><span>Update Game Manually</span></a></li>
              
              
              ';              
              }
              
              ?>
								

						</ul>
					</div>