<br/><br/>
<form method="post" action="/web/user/login">
	<table>
		<tr>
			<td>Usuario: </td>
			<td><input type="text" name="user"></td>
		</tr>
		<tr>
			<td>Password:</td>
			<td><input type="password" name="password"></td>
		</tr>
		<tr>
			<td>
				<input type="hidden" name="controller" value="<?php echo $this->data['controller'];?>"><br>
	    		<input type="hidden" name="action" value="<?php echo $this->data["action"];?>"><br>
	  			<input type="submit" value="Ingresar">
			</td>
		</tr>
	</table>     
</form>