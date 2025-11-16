<?PHP include "header.php"; 
include("verify.php");
?>
					<div id="main">

<div id="main">

<a name="maincontent"></a>



	<h1>User administration</h1>

	<p><b>REMEMBER:</b> Search user by Login ID</p>

	<form id="select_user" action='account.php' method='get'">

	<fieldset>
		<legend>Select a user</legend>

	<dl>
		<dt><label for="username">Find a member:</label></dt>
		<dd><input class="text medium" type="text" id="username" name="search"></dd>

	</dl>

	<p class="quick">
		<input type="submit" name="submit" value="submit" class="button1">
	</p>
	</fieldset>

	</form> 

</div>
				</div>


			<span class="corners-bottom"><span></span></span>
			<div class="clear"></div>
		</div>
		</div>
	</div>
<?PHP include "footer.php"; ?>