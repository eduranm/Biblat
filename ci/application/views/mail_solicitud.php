<b><?php _e('A quien corresponda:');?></b><br/><br/>
<?php _e('El usuario con los siguientes datos:');?><br/>
<?php _e('Nombre:');?> <?php echo $from;?><br/>
<?php _e('Correo electrónico:');?> <a target="_blank" href="mailto:<?php echo $email;?>"><?php echo $email;?></a><br/>
<?php _e('Teléfono:');?> <?php echo $telefono;?><br/>
<?php _e('Instituto:');?> <?php echo $instituto;?><br/><br/>
<?php _e('Ha solicitado el siguiente documento:');?><br/>
<?php echo $fichaDocumento;?>