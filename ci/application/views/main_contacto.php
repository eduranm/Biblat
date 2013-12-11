<div class="contenido">
	<div class="textoJ">
		<form action="<?php echo site_url('contacto/submit');?>" method="POST" class="contacto">
			<fieldset>
				<label><?php _e('Nombre');?></label><br/>
				<input type="text" name="from"/><br/>
				<label><?php _e('Dirección de correo electrónico');?></label><br/>
				<input type="text" name="email" placeholder="me@domain.com"/><br/>
				<label><?php _e('Asunto');?></label><br/>
				<input type="text" name="subject"/><br/>
				<label><?php _e('Mensaje');?></label><br/>
				<textarea name="message"></textarea>
				<?php echo $recaptcha_html;?> <input class="fa" type="submit" value="Enviar   &#xf0e0;"/>
			</fieldset>
		</form>
	</div>
</div>