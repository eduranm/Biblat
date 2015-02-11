<div class="contenido">
	<div class="textoJ">
		<form action="{site_url('contacto/submit')}" method="POST" class="contacto">
			<fieldset>
				<label>{_('Nombre')}</label><br/>
				<input type="text" name="from"/><br/>
				<label>{_('Dirección de correo electrónico')}</label><br/>
				<input type="text" name="email" placeholder="me@domain.com"/><br/>
				<label>{_('Asunto')}</label><br/>
				<input type="text" name="subject"/><br/>
				<label>{_('Mensaje')}</label><br/>
				<textarea name="message"></textarea>
				{$recaptcha_html} <input class="fa" type="submit" value="Enviar   &#xf0e0;"/>
			</fieldset>
		</form>
	</div>
</div>