  <div id="content">
    <div id="encabezado">
      <div id="migas"> 
        <p><a href="<?=base_url('');?>"><?php _e('Inicio');?></a> / <?php _e('SciELO');?></p>
      </div><!--end migas-->
                 
      <div id="share">
        <div id="share1"> 
          <a href="#" target="_blank"><img src="<?=base_url('/img/bt_face_int.jpg');?>" width="22" height="37" alt="facebook"></a>
          <a href="#" target="_blank"><img src="<?=base_url('/img/bt_twit_int.jpg');?>" width="22" height="37" alt="twitter"></a>
          <a href="#" target="_blank"><img src="<?=base_url('/img/bt_ayuda_int.jpg');?>" width="22" height="37" alt="ayuda"></a>
          <a href="mailto:scielo@dgb.unam.mx" target="_blank"><img src="<?=base_url('/img/bt_contact_int.jpg');?>" width="25" height="37" alt="contacto"></a>
          <div>
            <a class="share" href="#">Español</a>
          </div>            
        </div>

        <div id="share2"> 
          <a href="#"><img src="<?=base_url('/img/bt_share_int.jpg');?>" width="23" height="40" alt="share"></a>
          <a href="#"><img src="<?=base_url('/img/bt_aument_int.jpg');?>" width="39" height="40" alt="Aumentar tipografía"></a>
          <a href="#"><img src="<?=base_url('/img/bt_dismin_int.jpg');?>" width="39" height="40" alt="Disminuir tipografía"></a>
          <a href="javascript:window.print();"><img src="<?=base_url('/img/bt_print_int.jpg');?>" width="44" height="40" alt="imprimir pagina"></a>
        </div>
      </div><!--end share-->  

      <div class="titulo_int">
        <h1><?php _e('SciELO');?></h1>
      </div><!--end titulo_int-->
        
        <br class="cf">
    </div><!--end encabezado-->
      
    <div id="content_txt">
      <p><a href="http://www.scielo.org.mx/scielo.php" target="_blank"><img style="float: left; padding-right: 10px;" src="<?=base_url('img/scielo.png');?>" width="100" height="100" /></a><span class="biblat"><acronym title="<?php _e('Bibliografía Latinoamericana');?>">Biblat</acronym></span> <?php _printf('ofrece la visualización gráfica de indicadores bibliométricos aportados por las bases de datos de la red de %s (Scientific Electronic Library Online) conformada por las colecciones de revistas académicas de 15 países:','<a href="http://www.scielo.org.mx" target="_blank"><acronym title="Scientific Electronic Library Online">SciELO</acronym></a>');?><a href="http://www.scielo.org.ar/scielo.php" target="_blank"><?php _e('Argentina');?></a>, <a href="www.scielo.org.bo/scielo.php?lng=en" target="_blank"><?php _e('Bolivia');?></a>, <a href="http://www.scielo.br/?lng=es" target="_blank"><?php _e('Brasil');?></a>, <a href="http://www.scielo.cl/?lng=es" target="_blank"><?php _e('Chile');?></a>, <a href="http://www.scielo.org.co/?lng=es" target="_blank"><?php _e('Colombia');?></a>, <a href="http://www.scielo.sa.cr/scielo.php?lng=es" target="_blank"><?php _e('Costa Rica');?></a>, <a href="http://scielo.sld.cu/scielo.php" target="_blank"><?php _e('Cuba');?></a>, <a href="http://scielo.isciii.es/scielo.php" target="_blank"><?php _e('España');?></a>, <a href="http://www.scielo.org.mx/scielo.php" target="_blank"><?php _e('México');?></a>, <a href="http://scielo.iics.una.py/scielo.php?lng=es" target="_blank"><?php _e('Paraguay');?></a>, <a href="http://www.scielo.org.pe/" target="_blank"><?php _e('Perú');?></a>, <a href="http://www.scielo.gpeari.mctes.pt/?lng=es" target="_blank"><?php _e('Portugal');?></a>, <a href="http://www.scielo.org.za/?lng=es" target="_blank"><?php _e('Sudáfrica');?></a>, <a href="http://www.scielo.edu.uy/scielo.php?lng=es" target="_blank"><?php _e('Uruguay');?></a>, <a href="http://www.scielo.org.ve/scielo.php" target="_blank"><?php _e('Venezuela');?></a>.</p>

      <p><?php _printf('Por otra parte, %s ofrece reportes y gráficas de indicadores bibliométricos de revistas mexicanas y latinoamericanas aportados por otros sistemas de información.','<span class="biblat"><acronym title="'._sprintf('Bibliografía Latinoamericana').'">Biblat</acronym></span>');?></p>
    </div><!--end content_txt-->
            
  </div><!--end content-->
  <br class="cf">
</div><!--end content_int-->