<div id="content">
    <div id="encabezado">
        <div id="migas">
            <p><a href="<?=site_url('/');?>"><?php _e('Inicio');?></a> / <?php _e('Bibliometría');?> / <?php _e('Frecuencias');?></p>
        </div><!--End migas-->
        <div id="share">
            <div id="share1">
                <span class="space"><a href="https://www.facebook.com/pages/BIBLAT/188958071154818" target="_blank">&#Xf09a;</a></span>
                <span class="space"><a href="https://twitter.com/Biblat" target="_blank">&#Xf099;</i></i></a></span>
                <span class="space"><a href="#" target="_blank">?</a></span>
                <span class="space"><a href="mailto:scielo@dgb.unam.mx"><i class="fa fa-envelope-o"></i></a></span>
                <div><a class="share" href="#">Español</a></div>
            </div>
            <div id="share2">
                <a href="#">A<sup>+</sup></a>
                <a href="#">A<sup>-</sup></a>
                <a href="javascript:window.print();"><i class="fa fa-print"></i></a>
            </div>
        </div><!--end share-->
        <div class="titulo_int">
            <h1><?php _e('Frecuencias');?></h1>
        </div><!--end titulo_int-->

        <br class="cf">
    </div><!--end encabezado-->
    <div id="content_txt">
        <div id="frecuencia">
            <div id="accordion">
                <h3><?php _e('Por autor');?></h3>
                <div>
                    <a href="<?=site_url("frecuencias/autor");?>"><span class="amarillo">•</span> <?php _e('Número de documentos publicados por autor');?></a>
                </div>
                <h3><?php _e('Por institución de afiliación del autor');?></h3>
                <div>
                    <a href="<?=site_url("frecuencias/institucion");?>"><span class="amarillo">•</span> <?php _e('Número de documentos publicados por institución');?></a><br>
                    <a href="<?=site_url("frecuencias/institucion");?>"><span class="amarillo">•</span> <?php _e('Número de documentos publicados por institución según el país de la revista');?></a><br>
                    <a href="<?=site_url("frecuencias/institucion");?>"><span class="amarillo">•</span> <?php _e('Número de documentos publicados por institución según la revista de publicación');?></a><br>
                    <a href="<?=site_url("frecuencias/institucion");?>"><span class="amarillo">•</span> <?php _e('Número de documentos publicados por autor según su institución de afiliación');?></a><br>
                    <a href="<?=site_url("frecuencias/institucion");?>"><span class="amarillo">•</span> <?php _e('Número de documentos publicados por disciplina según la institución');?></a>
                </div>
                
                <h3><?php _e('Por país de institución de afiliación del autor');?></h3>
                <div>
                    <a href="<?=site_url("frecuencias/pais-afiliacion");?>"><span class="amarillo">•</span> <?php _e('Número de documentos publicados por país de la institución de afiliación del autor');?></a><br>
                    <a href="<?=site_url("frecuencias/pais-afiliacion");?>"><span class="amarillo">•</span> <?php _e('Número de documentos por institución de afiliación por país');?></a><br>
                    <a href="<?=site_url("frecuencias/pais-afiliacion");?>"><span class="amarillo">•</span> <?php _e('Número de documentos por autor según país de institución de afiliación');?></a><br>                    
                    <a href="<?=site_url("frecuencias/pais-afiliacion");?>"><span class="amarillo">•</span> <?php _e('Número de documentos por disciplina según país de la institución del autor');?></a>
                </div>

                <h3><?php _e('Por disciplina');?></h3>                      
                <div>
                    <a href="<?=site_url("frecuencias/disciplina");?>"><span class="amarillo">•</span> <?php _e('Número de documentos publicados por disciplina');?></a><br>
                    <a href="<?=site_url("frecuencias/disciplina");?>"><span class="amarillo">•</span> <?php _e('Número de documentos publicados por disciplina y revista');?></a><br>
                    <a href="<?=site_url("frecuencias/disciplina");?>"><span class="amarillo">•</span> <?php _e('Número de documentos publicados por disciplina e institución de afiliación del autor');?></a><br>
                    <a href="<?=site_url("frecuencias/disciplina");?>"><span class="amarillo">•</span> <?php _e('Número de documentos publicados por disciplina y país de la revista');?></a><br>
                    <a href="<?=site_url("frecuencias/disciplina");?>"><span class="amarillo">•</span> <?php _e('Número de documentos publicados por disciplina y país de la institución de afiliación del autor');?></a>
                </div> 

                <h3><?php _e('Por revista');?></h3>
                <div>
                    <a href="<?=site_url("frecuencias/revista");?>"><span class="amarillo">•</span> <?php _e('Número de documentos publicados por revista');?></a><br>
                    <a href="<?=site_url("frecuencias/revista");?>"><span class="amarillo">•</span> <?php _e('Número de documentos publicados por autor y revista');?></a><br>
                    <a href="<?=site_url("frecuencias/revista");?>"><span class="amarillo">•</span> <?php _e('Número de documentos publicados por institución de afiliación del autor en las revistas');?></a><br>
                    <a href="<?=site_url("frecuencias/revista");?>"><span class="amarillo">•</span> <?php _e('Número de artículos publicados por año');?></a>
                </div>
            </div>  
        </div>
    </div><!--end content_txt-->
</div><!--end content-->