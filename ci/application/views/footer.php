  <div id="site">
        <div class="site_col">
        	<a href="<?=site_url('sobre-biblat');?>"><?php _e('¿Qué es Biblat?');?></a>  <br>
         	<a href="<?=site_url('clase-y-periodica');?>"><?php _e('Clase y Periódica');?></a><br> 
         	<a href="javascript:;"><?php _e('Manual de indización');?></a><br> 
	        <a href="<?=site_url('scielo');?>"><?php _e('ScIELO');?></a> <br>
	        <a href="javascript:;"><?php _e('Tutoriales');?></a><br> 
	        <a href="<?=site_url('materiales-de-difusion');?>"><?php _e('Materiales de difusión');?></a><br>
        </div> 
        <div class="site_col">
	        <a href="<?=site_url('bibliometria/descripcion-biblat');?>"><?php _e('Descripción');?></a><br>
	        <a href="<?=site_url('bibliometria/metodologia-biblat');?>"><?php _e('Metodología');?></a><br> 
	        <a href="javascript:;"><?php _e('Frecuencias');?></a><br> 
	        <a href="<?=site_url('indicadores');?>"><?php _e('Indicadores');?></a> <br>
	        <a href="javascript:;"><?php _e('Indicadores ScIELO');?></a><br> 
	        <a href="javascript:;"><?php _e('Indicadores por revista');?></a><br>
        </div> 
        <div class="site_col">
         <a href="<?=site_url('postular-revista/criterios-de-seleccion');?>"><?php _e('Criterios de selección de revistas');?></a>  <br>
         <a href="javascript:;"><?php _e('Políticas de acceso');?></a><br> 
         <a href="<?=site_url('documentos/bibliografia');?>"><?php _e('Bibliografía');?></a><br> 
         <a href="javascript:;"><?php _e('Presentaciones PPT');?></a> <br>
         <a href="javascript:;"><?php _e('Archivos multimedia');?></a><br> 
        </div>
        <br class="cf">
       </div><!--end site-->
	<div id="footer">
  		<p><?php _printf('® Derechos reservados. 2009 - %d. Dirección General de Bibliotecas, Universidad Nacional Autónoma de México (UNAM). Esta página y sus contenidos pueden ser utilizados y reproducidos con fines no lucrativos, siempre y cuando no se mutile, se cite la fuente completa y su dirección electrónica. De otra forma, requiere permiso previo por escrito de la institución.', date('Y'));?> <a href="<?=site_url('creditos');?>"><?php _e('CRÉDITOS');?></a></p>
	</div><!--end footer-->
<?php if(ENVIRONMENT === "production"):?>
<!-- Piwik -->
<script type="text/javascript">
  var _paq = _paq || [];
  _paq.push(["trackPageView"]);
  _paq.push(["enableLinkTracking"]);

  (function() {
    var u=(("https:" == document.location.protocol) ? "https" : "http") + "://132.248.67.111/piwik/";
    _paq.push(["setTrackerUrl", u+"piwik.php"]);
    _paq.push(["setSiteId", "2"]);
    var d=document, g=d.createElement("script"), 
s=d.getElementsByTagName("script")[0]; g.type="text/javascript";
    g.defer=true; g.async=true; g.src=u+"piwik.js"; 
s.parentNode.insertBefore(g,s);
  })();
</script>
<!-- End Piwik Code -->
<?php endif;?>
</body>
</html>