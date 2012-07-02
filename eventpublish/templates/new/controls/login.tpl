{if $failed_auth}Invalid!{/if}


<div id="login_box">
	
	<img src="{$template_dir}/images/logo.gif" />
	
	<p id="login_message" style="{if $show_login_message == 1}display: block;{else}display: none;{/if}">
		Welcome. Please take a moment to sign in...
	</p>
	
	<p id="login_error" style="{if $show_login_error == 1}display: block;{else}display: none;{/if}">
		<img src="{$template_dir}images/warning.gif" />You have entered an invalid username or password.
	</p>
	
	<form action="authenticate.php" method="post">
	
	<div id="login_fields">
		<p>
		 <label>Username:</label><input type="text" class="login_fields_input" name="user_name" size="30" />
		</p>
		
		<p> 
		<label>Password:</label> <input type="password" class="login_fields_input" name="user_password" size="30" /> 
		</p>
		
		<p>
		
		<input type="submit" value="Sign In" id="login_button" />
		<a href="recoverform.php">( I forgot my password )</a>
		
		
		</p>
		
		
		<!--
		
		<div id="login_recovery">
		
			<a href="recoverform.php">( I forgot my password )</a>
			<div style="clear:both"></div>
			
		</div>
		
		<div id="login_button">
		
			<input type="submit" value="Sign In" />
			<div style="clear:both"></div>
			
		</div>
	
		
		<div id="login_button">
		<input type="submit" value="Sign In" />
		<div style="clear:both"></div>
		</div>
	
		<div id="login_recovery">
		<a href="recoverform.php">( I forgot my password )</a>
		<div style="clear:both"></div>
		</div>
		-->
		
		<div style="clear:both"></div>
	
	</div>
	
	
	</form>
	
</div>









