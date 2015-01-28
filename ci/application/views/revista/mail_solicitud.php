<b>{_('A quien corresponda:')}</b><br/><br/>
{_('El usuario con los siguientes datos:')}<br/>
{_('Nombre:')} <?php echo $from;?><br/>
{_('Correo electrónico:')} <a target="_blank" href="mailto:<?php echo $email;?>"><?php echo $email;?></a><br/>
{_('Teléfono:')} <?php echo $telefono;?><br/>
{_('Instituto:')} <?php echo $instituto;?><br/><br/>
{_('Ha solicitado el siguiente documento:')}<br/>
{$fichaDocumento}