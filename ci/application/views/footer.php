		<div class="push"></div>
	</div>
	<div class="footer">
		<div class="footerRight"></div>
		<div class="bannerFooter">
			<div class="copyright">
				<?php _printf('® Derechos reservados. 2009 - %d. Dirección General de Bibliotecas, Universidad Nacional Autónoma de México (UNAM). Esta página y sus contenidos pueden ser utilizados y reproducidos con fines no lucrativos, siempre y cuando no se mutile, se cite la fuente completa y su dirección electrónica. De otra forma, requiere permiso previo por escrito de la institución.', date('Y'));?>
			</div>
		</div>
	</div>
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