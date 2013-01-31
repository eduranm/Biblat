<div id="envolvente">
	<div id="top"><img src="<?php echo base_url();?>img/top2.jpg" width="997" height="96" alt="cabecera" /></div>
	<div menu>
		<table width="998px" height="35px" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width="825">
					<ul id="menu">
						<li><a href="#"><?php _e('¿Qué es Biblat?');?></a>
							<ul>
								<li><a href="biblat.html"><?php _e('Biblat');?></a></li>
								<li><a href="clase-periodica.html"><?php _e('Clase y Periódica');?></a></li>
								<li><a href="tutoriales.html"><?php _e('Tutoriales');?></a></li>
								<li><a href="difusion.html"><?php _e('Materiales de difusión');?></a></li>
								<li><a target="_blank" href="http://bibliotecas.unam.mx/eventos/manual/manual17feb2012.pdf"><?php _e('Manual de indización');?></a></li>
							</ul>
						</li>
						<!--AQUI INICIA EL RUBRO DE SERVICIOS -->
						<li><a href="#">Bibliometr&iacute;a</a>
							<ul>
								<li><a href="descripciÃ³n.html"><?php _e('Descripción');?></a></li>
								<li><a href="metodologia.html"><?php _e('Metodología');?></a></li>
								<li><a href="#"><?php _e('Frecuencias');?></a>
									<ul>
										<li><a href="frecuencias/ind_autor.php"><?php _e('Autor');?></a></li>
										<li><a href="frecuencias/ind_institucion.php"><?php _e('Institución');?></a></li>
										<li><a href="frecuencias/ind_paisins.php"><?php _e('País de la institución de afiliación del autor');?></a></li>
										<li><a href="frecuencias/ind_revista.php"><?php _e('Revista');?></a></li>
										<li><a href="frecuencias/ind_paisrev.php"><?php _e('País de la revista');?></a></li>
										<li><a href="frecuencias/ind_fechapub.php"><?php _e('Año de publicación');?></a></li>
										<li><a href="frecuencias/ind_coautpais.php"><?php _e('Colaboración entre paises');?></a></li>
										<li><a href="frecuencias/ind_coautinst.php"><?php _e('Colaboración inter-institucional');?></a></li>
									</ul>
									<li><a href="bibliometria/form_bibliometria.html"><?php _e('Indicadores');?></a></li>
								</ul>
							</li>
							<!--AQUI TERMINA EL RUBRO DE SERVICIOS-->

							<li><a href="#"><?php _e('Postular una revista');?></a>
								<ul>
									<li><a href="criterios.html"><?php _e('Criterios de selección de revistas');?></a></li>
									<li><a href="contacto.html"><?php _e('Contacto');?></a></li>
								</ul>
							</li>

							<!--AQUI TERMINA EL RUBRO DE SERVICIOS-->

							<li><a href="politicas.html"><?php _e('Políticas de copyright');?></a></li>

							<!--AQUI TERMINA EL RUBRO DE SERVICIOS-->

							<li><a href="#">Documentos</a>
								<ul>
									<li><a href="bibliografia.html"><?php _e('Bibliografía');?></a></li>
									<li><a href="presentaciones.html"><?php _e('Presentaciones PPT');?></a></li>
									<li><a href="multimedia.html"><?php _e('Archivos multimedia');?></a></li>
								</ul>
							</li>

						</li>
					</ul>
				</td>
				<td width="173">
					<div id="social">
						<div class="addthis_toolbox addthis_default_style" style="width: 150px; display:block; margin:5px auto;">
							<a class="addthis_button_facebook" style="cursor:pointer"></a>
							<a class="addthis_button_twitter" style="cursor:pointer"></a>
							<a class="addthis_button_email" style="cursor:pointer"></a>
							<a class="addthis_button_print" style="cursor:pointer"></a>
							<a class="addthis_button_compact"></a>
							<a class="addthis_counter addthis_bubble_style"></a>
						</div>
						<script type="text/javascript">var addthis_config = {"data_track_addressbar":false};</script>
						<script type="text/javascript" src="http://s7.addthis.com/js/300/addthis_widget.js#pubid=ra-50914e71704bc5f9"></script>
					</div>
				</td>
			</tr>
		</table>
	</div>
	<div id="submenu"> <?php _e('Español');?> / <a href="index-english.html"><?php _e('English');?></a> / <a href="index-portugues.html"><?php _e('Português');?></a> / <a href="index-francais.html"><?php _e('Français');?></a> | <img src="<?php echo base_url();?>img/ayuda.png" width="16" height="16" alt="ayuda" /> <a href="ayuda.html"><?php _e('Ayuda');?></a> | <img src="<?php echo base_url();?>img/mapasitio.gif" width="19" height="16" alt="mapa de sitio" /> <a href="ayuda.html"><?php _e('Mapa de sitio');?></a> |  <a href="ayuda.html"><?php _e('FAQ');?></a> | <img src="<?php echo base_url();?>img/contacto.gif" width="20" height="12" alt="contacto" /> <a href="contacto.html"><?php _e('Contacto')?></a></div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td width="51%" valign="top">
				<div id="buscador">
					<div id="titulobusq"><?php _e('Búsqueda:');?></div>
					<br />
					<form name="findex" id="form" action="buscador.php">

						<select name="jumpMenu" id="jumpMenu">
							<option value='' selected><?php _e('Seleccionar disciplina(obligatorio)');?></option>
<?php foreach ($disciplinas as $disciplina):?>
							<option value="<?php echo $disciplina['id_disciplina'];?>"><?php echo $disciplina['disciplina'];?></option>
<?php	endforeach;?>
						</select>
					<br /><br />
					<input name="texto" type="text" id="texto" size="60" />
					<input type="button" name="button" id="button" value="Buscar" onclick="validadatos()"/>
					<br />
					<br />
					<label for="textocompleto"></label>
					<label for="revista"></label>
					<table id="buscadortabla" width="472" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td height="22"><input type="radio" name="indice" id="tema" value="tema" checked/></td>
							<td><input type="radio" name="indice" id="articulo" value="articulo" /></td>
							<td><input type="radio" name="indice" id="autor" value="autor" /></td>
							<td><input type="radio" name="indice" id="institucion" value="institucion" /></td>
							<td><input type="radio" name="indice" id="revista" value="revista" /></td>
							<td><input type="checkbox" name="textocompleto" id="textocompleto" /></td>
						</tr>
						<tr>
							<td width="38" height="22"><?php _e('Tema');?></td>
								<td width="57"><?php _e('Artículo');?></td>
								<td width="36"><?php _e('Autor');?></td>
								<td width="87"><?php _e('Institución');?></td>
								<td width="54"><?php _e('Revista');?></td>
								<td width="200"><?php _e('Sólo texto completo');?></td>
							</tr>
						</table>
						<br />
					</form>
					<br /><br />
				</div>
			</td>
			<td width="49%" rowspan="2" valign="top"><div id="bienvenida">
				<?php _e('<span class="titulo">Biblat</span> ofrece: referencias bibliográficas de documentos publicados en revistas científicas y académicas latinoamericanas indizadas en CLASE y Periódica, acceso al texto completo de revistas en acceso abierto, indicadores bibliométricos e información sobre los derechos de copyright de las revistas.');?> <br /><br />
				<span class="titulo"><?php _e('Disponibles');?></span>:<br />
				<br />
				<span class="disponibles"><?php echo number_format($totales['revistas']); ?></span> <?php _e('revistas');?><br />
				<span class="disponibles"><?php echo number_format($totales['documentos']); ?></span> <?php _e('documentos');?><br />
				<span class="disponibles"><?php echo number_format($totales['enlaces']); ?></span> <?php _e('textos completos');?><br />
				<span class="disponibles"><?php echo number_format($totales['hevila']); ?></span> <?php _e('artículos en texto completo en repositorio HEVILA');?> </div>
				<div id="logos">
					<?php _e('Enlace a las bases de datos');?>  <br />
					<img src="<?php echo base_url();?>img/claseperiodica.gif" alt="clase y periodica" width="268" height="67" border="0" usemap="#Map" /></div>
				</td>
			</tr>
			<tr>
				<td height="42">
					<div id="alfabetico"><br />
						<?php _e('Revistas por orden alfabético');?><br /><br />	
<?php foreach (range('A', 'Z') as $i):?>
						<a href="<?php echo site_url("indice/alfabetico/".strtolower($i));?>"><?php echo $i;?></a>
<?php endforeach;?>
					</div>
			</td>
		</tr>
	</table>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td width="39%" valign="top">
				<div id="disciplina"><span class="titulo"><?php _e('Revistas por disciplina');?></span>:<br /><br />
					<div id="tagCloudContainer">
						<canvas width="350" height="300" id="tagCloud">
							<ul>
<?php foreach ($disciplinas as $disciplina):?>
								<li>
									<a href="<?php echo site_url("indice/disciplina/{$disciplina['slug']}");?>"><?php echo $disciplina['disciplina'];?></a></li>
<?php endforeach;?>
							</ul>
					</canvas>
				</div>
			</div>
		</td>
		<td width="25%">
			<div id="pais"><span class="titulo"><?php _e('Revistas por país');?></span>:<br />
				<table width="10" border="0" align="center" cellpadding="0" cellspacing="6">
					<tr>
						<td><a href=ind_paisrev_rev.php?paisrev=Argentina><img src="<?php echo base_url();?>img/banderas/argentina.gif" title="Argentina" width="26" height="18" border="0" usemap="argentina"/></a></td>
						<td><a href=ind_paisrev_rev.php?paisrev=Ecuador><img src="<?php echo base_url();?>img/banderas/ecuador.gif" title="Ecuador" width="26" height="18" border="0" usemap="ecuador" /></a></td>
						<td><a href=ind_paisrev_rev.php?paisrev=Internacional><img src="<?php echo base_url();?>img/banderas/internacionales.png" title="Organismos Internacionales" width="26" height="18" border="0" usemap="internacionales" /></a></td>
					</tr>
					<tr>
						<td><a href=ind_paisrev_rev.php?paisrev=Barbados><img src="<?php echo base_url();?>img/banderas/barbados.gif" title="Barbados" width="26" height="18" border="0" usemap="barbados" /></a></td>
						<td><a href=ind_paisrev_rev.php?paisrev=El+Salvador><img src="<?php echo base_url();?>img/banderas/elsalvador.gif" title="El salvador" width="26" height="18" border="0" usemap="elsalvador" /></a></td>
						<td><a href=ind_paisrev_rev.php?paisrev=Panama><img src="<?php echo base_url();?>img/banderas/panama.gif" title="Panam&aacute;" width="26" height="18" border="0" usemap="panama" /></a></td>
					</tr>
					<tr>
						<td><a href=ind_paisrev_rev.php?paisrev=Bolivia><img src="<?php echo base_url();?>img/banderas/bolivia.gif" title="Bolivia" width="26" height="18" border="0" usemap="bolivia" /></a></td>
						<td><a href=ind_paisrev_rev.php?paisrev=Guatemala><img src="<?php echo base_url();?>img/banderas/guatemala.gif" title="Guatemala" width="26" height="18" border="0" usemap="guatemala" /></a></td>
						<td><a href=ind_paisrev_rev.php?paisrev=Paraguay><img src="<?php echo base_url();?>img/banderas/paraguay.gif" title="Paraguay" width="26" height="18" border="0" usemap="paraguay" /></a></td>
					</tr>
					<tr>
						<td><a href=ind_paisrev_rev.php?paisrev=Brasil><img src="<?php echo base_url();?>img/banderas/brasil.gif" title="Brasil" width="26" height="18" border="0" usemap="brasil" /></a></td>
						<td><a href=ind_paisrev_rev.php?paisrev=Haiti><img src="<?php echo base_url();?>img/banderas/haiti.gif" title="Hait&iacute;" width="26" height="18" border="0" usemap="haiti" /></a></td>
						<td><a href=ind_paisrev_rev.php?paisrev=Peru><img src="<?php echo base_url();?>img/banderas/peru.gif" title="Per&uacute;" width="26" height="18" border="0" usemap="peru" /></a></td>
					</tr>
					<tr>
						<td><a href=ind_paisrev_rev.php?paisrev=Chile><img src="<?php echo base_url();?>img/banderas/chile.gif" title="Chile" width="26" height="18" border="0" usemap="chile" /></a></td>
						<td><a href=ind_paisrev_rev.php?paisrev=Honduras><img src="<?php echo base_url();?>img/banderas/honduras.gif" title="Honduras" width="26" height="18" border="0" usemap="honduras" /></a></td>
						<td><a href=ind_paisrev_rev.php?paisrev=Puerto+Rico><img src="<?php echo base_url();?>img/banderas/puertorico.gif" title="Puerto Rico" width="26" height="18" border="0" usemap="puertorico" /></a></td>
					</tr>
					<tr>
						<td><a href=ind_paisrev_rev.php?paisrev=Colombia><img src="<?php echo base_url();?>img/banderas/colombia.gif" title="Colombia" width="26" height="18" border="0" usemap="colombia" /></a></td>
						<td><a href=ind_paisrev_rev.php?paisrev=Jamaica><img src="<?php echo base_url();?>img/banderas/jamaica.gif" title="Jamaica" width="26" height="18" border="0" usemap="jamaica" /></a></td>
						<td><a href=ind_paisrev_rev.php?paisrev=Republica+Dominicana><img src="<?php echo base_url();?>img/banderas/republicadominicana.gif" title="Rep&uacute;blica Dominicana" width="26" height="18" border="0" usemap="repdominicana" /></a></td>
					</tr>
					<tr>
						<td><a href=ind_paisrev_rev.php?paisrev=Costa+Rica><img src="<?php echo base_url();?>img/banderas/costarica.gif" title="Costa Rica" width="26" height="18" border="0" usemap="costarica" /></a></td>
						<td><a href=ind_paisrev_rev.php?paisrev=Mexico><img src="<?php echo base_url();?>img/banderas/mexico.gif" title="M&eacute;xico" width="26" height="18" border="0" usemap="mexico" /></a></td>
						<td><a href=ind_paisrev_rev.php?paisrev=Uruguay><img src="<?php echo base_url();?>img/banderas/uruguay.gif" title="Uruguay" width="26" height="18" border="0" usemap="uruguay" /></a></td>
					</tr>
					<tr>
						<td><a href=ind_paisrev_rev.php?paisrev=Cuba><img src="<?php echo base_url();?>img/banderas/cuba.gif" title="Cuba" width="26" height="18" border="0" usemap="cuba" /></a></td>
						<td><a href=ind_paisrev_rev.php?paisrev=Nicaragua><img src="<?php echo base_url();?>img/banderas/nicaragua.gif" title="Nicaragua" width="26" height="18" border="0" usemap="nicaragua" /></a></td>
						<td><a href=ind_paisrev_rev.php?paisrev=Venezuela><img src="<?php echo base_url();?>img/banderas/venezuela.gif" title="Venezuela" width="26" height="18" border="0" usemap="venezuela" /></a></td>
					</tr>
				</table>
			</div>
		</td>
		<td width="36%" valign="top">
			<div id="accesos"><span class="titulos"><span class="titulo"><?php _e('Estadísticas');?></span>:<br /><br />
				<!--      <a href="http://statcounter.com/p5215750/summary/" target="_blank"><img src="<?php echo base_url();?>img/grafica.gif" width="340" height="114" alt="accesos" /></a>--> 

				<a href="ind_topten.php"><img src="<?php echo base_url();?>img/estadisticas.jpg" width=350 heigth=350 border=0><br><?php _e('Ver Top Ten');?></a>


				<br /><br />
			</div>
		</td>
	</tr>
</table>

<div id="creditos">
	<a href="creditos.html"><?php _e('Créditos');?></a></div>

</div><!---Aqui cierra el envolvente---->
