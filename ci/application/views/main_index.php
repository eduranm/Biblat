<div id="envolvente">
	<div id="top"><img src="<?php echo base_url();?>img/top2.jpg" width="997" height="96" alt="cabecera" /></div>
	<div menu>
		<table width="998px" height="35px" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width="825">
					<ul id="menu">
						<li><a href="#">¿Qu&eacute; es Biblat?</a>
							<ul>
								<li><a href="biblat.html">Biblat</a></li>
								<li><a href="clase-periodica.html">Clase y Peri&oacute;dica</a></li>
								<li><a href="tutoriales.html">Tutoriales</a></li>
								<li><a href="difusion.html">Materiales de difusi&oacute;n</a></li>
								<li><a target="_blank" href="http://bibliotecas.unam.mx/eventos/manual/manual17feb2012.pdf">Manual de indizaci&oacute;n</a></li>
							</ul>
						</li>
						<!--AQUI INICIA EL RUBRO DE SERVICIOS -->
						<li><a href="#">Bibliometr&iacute;a</a>
							<ul>
								<li><a href="descripciÃ³n.html">Descripci&oacute;n</a></li>
								<li><a href="metodologia.html">Metodolog&iacute;a</a></li>
								<li><a href="#">Frecuencias</a>
									<ul>
										<li><a href="frecuencias/ind_autor.php">Autor</a></li>
										<li><a href="frecuencias/ind_institucion.php">Instituci&oacute;n</a></li>
										<li><a href="frecuencias/ind_paisins.php">Pa&iacute;s de la instituci&oacute;n de afiliaci&oacute;n del autor</a></li>
										<li><a href="frecuencias/ind_revista.php">Revista</a></li>
										<li><a href="frecuencias/ind_paisrev.php">Pa&iacute;s de la revista</a></li>
										<li><a href="frecuencias/ind_fechapub.php">A&ntilde;o de publicaci&oacute;n</a></li>
										<li><a href="frecuencias/ind_coautpais.php">Colaboraci&oacute;n entre pa&iacute;ses</a></li>
										<li><a href="frecuencias/ind_coautinst.php">Colaboraci&oacute;n Interinstitucional</a></li>
									</ul>
									<li><a href="bibliometria/form_bibliometria.html">Indicadores</a></li>
								</ul>
							</li>
							<!--AQUI TERMINA EL RUBRO DE SERVICIOS-->

							<li><a href="#">Postular una revista</a>
								<ul>
									<li><a href="criterios.html">Criterios de selecci&oacute;n de revistas</a></li>
									<li><a href="contacto.html">Contacto</a></li>
								</ul>
							</li>

							<!--AQUI TERMINA EL RUBRO DE SERVICIOS-->

							<li><a href="politicas.html">Pol&iacute;ticas de copyright</a></li>

							<!--AQUI TERMINA EL RUBRO DE SERVICIOS-->

							<li><a href="#">Documentos</a>
								<ul>
									<li><a href="bibliografia.html">Bibliograf&iacutea</a></li>
									<li><a href="presentaciones.html">Presentaciones PPT</a></li>
									<li><a href="multimedia.html">Archivos multimedia</a></li>
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
						<script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>
						<script type="text/javascript" src="http://s7.addthis.com/js/300/addthis_widget.js#pubid=ra-50914e71704bc5f9"></script>
					</div>
				</td>
			</tr>
		</table>
	</div>
	<div id="submenu"> Espa&ntilde;ol / <a href="index-english.html">English</a> / <a href="index-portugues.html">Portugu&ecirc;s</a> / <a href="index-francais.html">Fran&ccedil;ais</a> | <img src="<?php echo base_url();?>img/ayuda.png" width="16" height="16" alt="ayuda" /> <a href="ayuda.html">Ayuda</a> | <img src="<?php echo base_url();?>img/mapasitio.gif" width="19" height="16" alt="mapa de sitio" /> <a href="ayuda.html">Mapa de sitio</a> |  <a href="ayuda.html">FAQ</a> | <img src="<?php echo base_url();?>img/contacto.gif" width="20" height="12" alt="contacto" /> <a href="contacto.html">Contacto</a></div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td width="51%" valign="top">
				<div id="buscador">
					<div id="titulobusq">B&uacute;squeda:</div>
					<br />
					<form name="findex" id="form" action="buscador.php">

						<select name="jumpMenu" id="jumpMenu">
							<option value='' selected>Seleccionar disciplina(obligatorio)</option>
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
							<td width="38" height="22">Tema


								<label for="articulo"></label>
								<label for="tema"></label>
								<label for="autor"></label>
								<label for="institucion"></label></td>
								<td width="57">Art&iacute;culo</td>
								<td width="36">Autor</td>
								<td width="87">Instituci&oacute;n</td>
								<td width="54">Revista</td>
								<td width="200">S&oacute;lo texto completo      </td>
							</tr>
						</table>
						<br />
					</form>
					<br /><br />
				</div>
			</td>
			<td width="49%" rowspan="2" valign="top"><div id="bienvenida">
				<span class="titulo">Biblat</span> ofrece: referencias bibliogr&aacute;ficas de documentos publicados en revistas cient&iacute;ficas y acad&eacute;micas latinoamericanas indizadas en CLASE y Peri&oacute;dica, acceso al texto completo de revistas en acceso abierto, indicadores bibliom&eacute;tricos e informaci&oacute;n sobre los derechos de copyright de las revistas. <br /><br />
				<span class="titulo">Disponibles</span>:<br />
				<br />
				<span class="disponibles"><?php echo number_format($totales['revistas']); ?></span> revistas<br />
				<span class="disponibles"><?php echo number_format($totales['documentos']); ?></span> documentos<br />
				<span class="disponibles"><?php echo number_format($totales['enlaces']); ?></span> textos completos<br />
				<span class="disponibles"><?php echo number_format($totales['hevila']); ?></span> art&iacute;culos en texto completo en repositorio HEVILA </div>
				<div id="logos">
					Enlace a las bases de datos  <br />
					<img src="<?php echo base_url();?>img/claseperiodica.gif" alt="clase y periodica" width="268" height="67" border="0" usemap="#Map" /></div>
				</td>
			</tr>
			<tr>
				<td height="42">
					<div id="alfabetico"><br />
						Revistas por orden alfab&eacute;tico:<br /><br />	
<?php foreach (range('A', 'Z') as $i):?>
						<a href="ind_alfabetico.php?alfabeto=<?php echo $i;?>"><?php echo $i;?></a>
<?php endforeach;?>
					</div>
			</td>
		</tr>
	</table>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td width="39%" valign="top">
				<div id="disciplina"><span class="titulo">Revistas por disciplina</span>:<br /><br />
					<div id="tagCloudContainer">
						<canvas width="350" height="300" id="tagCloud">
							<p>Anything in here will be replaced on browsers that support the canvas element</p>
							<ul>
<?php foreach ($disciplinas as $disciplina):?>
								<li><a href="rev_disciplinas.php?id_disciplina=<?php echo $disciplina['id_disciplina'];?>&area=<?php echo $disciplina['disciplina'];?>"><?php echo $disciplina['disciplina'];?></a></li>
<?php endforeach;?>
							</ul>
					</canvas>
				</div>
			</div>
		</td>
		<td width="25%">
			<div id="pais"><span class="titulo">Revistas por pa&iacute;s</span>:<br />
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
			<div id="accesos"><span class="titulos"><span class="titulo">Estad&iacute;sticas</span>:<br /><br />
				<!--      <a href="http://statcounter.com/p5215750/summary/" target="_blank"><img src="<?php echo base_url();?>img/grafica.gif" width="340" height="114" alt="accesos" /></a>--> 

				<a href="ind_topten.php"><img src="<?php echo base_url();?>img/estadisticas.jpg" width=350 heigth=350 border=0><br>Ver Top Ten</a>


				<br /><br />
			</div>
		</td>
	</tr>
</table>

<div id="creditos">
	<a href="creditos.html">Cr&eacute;ditos</a></div>

</div><!---Aqui cierra el envolvente---->

<map name="argentina" id="argentina">
	<area shape="rect" coords="2,2,26,17" href="#" alt="argentina" />
</map>

<map name="barbados" id="barbados">
	<area shape="rect" coords="-1,-1,26,18" href="#" alt="barbados" />
</map>

<map name="bolivia" id="bolivia">
	<area shape="rect" coords="0,0,26,18" href="#" alt="bolivia" />
</map>

<map name="brasil" id="brasil">
	<area shape="rect" coords="0,0,26,18" href="#" alt="brasil" />
</map>

<map name="chile" id="chile">
	<area shape="rect" coords="0,0,26,18" href="#" alt="chile" />
</map>

<map name="colombia" id="colombia">
	<area shape="rect" coords="1,0,26,18" href="#" alt="colombia" />
</map>

<map name="costarica" id="costarica">
	<area shape="rect" coords="1,0,26,18" href="#" alt="costarica" />
</map>

<map name="cuba" id="cuba">
	<area shape="rect" coords="1,1,27,18" href="#" alt="cuba" />
</map>

<map name="ecuador" id="ecuador">
	<area shape="rect" coords="1,1,26,18" href="#" alt="ecuador" />
</map>

<map name="elsalvador" id="elsalvador">
	<area shape="rect" coords="1,1,26,18" href="#" alt="elsalvador" />
</map>

<map name="guatemala" id="guatemala">
	<area shape="rect" coords="1,1,25,17" href="#" alt="guatemala" />
</map>

<map name="haiti" id="haiti">
	<area shape="rect" coords="0,0,48,29" href="#" alt="haiti" />
</map>

<map name="honduras" id="honduras">
	<area shape="rect" coords="1,1,26,17" href="#" alt="honduras" />
</map>

<map name="jamaica" id="jamaica">
	<area shape="rect" coords="1,1,25,17" href="#" alt="jamaica" />
</map>

<map name="mexico" id="mexico">
	<area shape="rect" coords="1,1,25,17" href="#" alt="mexico" />
</map>

<map name="nicaragua" id="nicaragua">
	<area shape="rect" coords="1,1,26,18" href="#" alt="nicaragua" />
</map>

<map name="internacionales" id="internacionales">
	<area shape="rect" coords="1,1,25,17" href="#" alt="internacionales" />
</map>

<map name="panama" id="panama">
	<area shape="rect" coords="1,1,26,17" href="#" alt="panama" />
</map>

<map name="paraguay" id="paraguay">
	<area shape="rect" coords="1,1,25,17" href="#" alt="paraguay" />
</map>

<map name="peru" id="peru">
	<area shape="rect" coords="1,1,25,17" href="#" alt="peru" />
</map>

<map name="puertorico" id="puertorico">
	<area shape="rect" coords="1,1,26,17" href="#" alt="puertorico" />
</map>

<map name="repdominicana" id="repdominicana">
	<area shape="rect" coords="1,1,25,17" href="#" alt="repdominicana" />
</map>

<map name="uruguay" id="uruguay">
	<area shape="rect" coords="1,1,26,17" href="#" alt="uruguay" />
</map>

<map name="venezuela" id="venezuela">
	<area shape="rect" coords="1,1,25,17" href="#" alt="venezuela" />
</map>

<map name="Map" id="Map">
	<area shape="rect" coords="7,6,92,61" href="http://clase.unam.mx/" target="_blank" />
	<area shape="rect" coords="139,5,262,60" href="http://periodica.unam.mx/" target="_blank" />
</map>