<h1>P&aacute;gina: 1</h1>
<h3>Hola: <?php echo $this->data["username"]; ?></h3>
<?php foreach ($this->data["paginas"] as $pagina) {
	if (is_numeric($pagina)) {?>
		<a href="/web/user/render?pagina=<?php echo $pagina; ?>"><?php echo "P&aacute;gina: " . $pagina; ?></a>&nbsp;&nbsp;&nbsp;
<?php }
	}?>
<br/><br/>
<a href="/web/user/logout">Cerrar Sesi&oacute;n</a><br/>