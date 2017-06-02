<h1>Bienvenido: <?php echo ($this->data["username"]); ?></h1>
<h3>Sus P&aacute;ginas: </h3>
<?php foreach ($this->data["paginas"] as $pagina) {
	if (is_numeric($pagina)) {?>
		<a href="/web/user/render?pagina=<?php echo $pagina; ?>"><?php echo "P&aacute;gina: " . $pagina; ?></a><br/>
	<?php }
}?>
<br/><br/>
<a href="/web/user/logout">Cerrar Sesi&oacute;n</a><br/>
