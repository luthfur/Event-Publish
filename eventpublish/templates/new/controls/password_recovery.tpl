{if $failed_auth}Invalid!{/if}


<div id="login_box">
	
	
	<div id="login_recovery" style="display: block">
		
		<form action="recover.php" method="post">
		
		<p id="login_message">
		Forgot your password?
		</p>
		
		<p  style="{if $show_default_message == 1}display: block;{else}display: none;{/if}">
		Enter your username and email address below to retrieve your account details.
		</p>
		
		<p id="login_error" style="{if $show_recovery_error == 1}display: block;{else}display: none;{/if}">
			Sorry, your username and corresponding email address were not found in file.
		</p>
		
		<p>
		 <label>Username:</label><input type="text" name="user_name" size="35" />
		</p>
		
		<p> 
		<label>Email:</label> <input type="text" name="user_email" size="35" /> 
		</p>
	
		<div id="login_button">
		<input type="submit" value="Email My Password" />
		<div style="clear:both"></div>
		</div>
		
	<div style="clear:both"></div>
	
	</div>
	</form>
	
</div>









