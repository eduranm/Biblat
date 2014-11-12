            <div id="accordion">
                <h3>{_('Por autor')}</h3>
                <div>
                    <a href="<?=site_url("frecuencias/autor");?>"><span class="amarillo">•</span> {_('Número de documentos publicados por autor')}</a>
                </div>
                <h3>{_('Por institución de afiliación del autor')}</h3>
                <div>
                    <a href="<?=site_url("frecuencias/institucion");?>"><span class="amarillo">•</span> {_('Número de documentos publicados por institución')}</a><br>
                    <a href="<?=site_url("frecuencias/institucion");?>"><span class="amarillo">•</span> {_('Número de documentos publicados por institución según el país de la revista')}</a><br>
                    <a href="<?=site_url("frecuencias/institucion");?>"><span class="amarillo">•</span> {_('Número de documentos publicados por institución según la revista de publicación')}</a><br>
                    <a href="<?=site_url("frecuencias/institucion");?>"><span class="amarillo">•</span> {_('Número de documentos publicados por autor según su institución de afiliación')}</a><br>
                    <a href="<?=site_url("frecuencias/institucion");?>"><span class="amarillo">•</span> {_('Número de documentos publicados por disciplina según la institución')}</a>
                </div>
                
                <h3>{_('Por país de institución de afiliación del autor')}</h3>
                <div>
                    <a href="<?=site_url("frecuencias/pais-afiliacion");?>"><span class="amarillo">•</span> {_('Número de documentos publicados por país de la institución de afiliación del autor')}</a><br>
                    <a href="<?=site_url("frecuencias/pais-afiliacion");?>"><span class="amarillo">•</span> {_('Número de documentos por institución de afiliación por país')}</a><br>
                    <a href="<?=site_url("frecuencias/pais-afiliacion");?>"><span class="amarillo">•</span> {_('Número de documentos por autor según país de institución de afiliación')}</a><br>                    
                    <a href="<?=site_url("frecuencias/pais-afiliacion");?>"><span class="amarillo">•</span> {_('Número de documentos por disciplina según país de la institución del autor')}</a>
                </div>

                <h3>{_('Por disciplina')}</h3>                      
                <div>
                    <a href="<?=site_url("frecuencias/disciplina");?>"><span class="amarillo">•</span> {_('Número de documentos publicados por disciplina')}</a><br>
                    <a href="<?=site_url("frecuencias/disciplina");?>"><span class="amarillo">•</span> {_('Número de documentos publicados por disciplina y revista')}</a><br>
                    <a href="<?=site_url("frecuencias/disciplina");?>"><span class="amarillo">•</span> {_('Número de documentos publicados por disciplina e institución de afiliación del autor')}</a><br>
                    <a href="<?=site_url("frecuencias/disciplina");?>"><span class="amarillo">•</span> {_('Número de documentos publicados por disciplina y país de la revista')}</a><br>
                    <a href="<?=site_url("frecuencias/disciplina");?>"><span class="amarillo">•</span> {_('Número de documentos publicados por disciplina y país de la institución de afiliación del autor')}</a>
                </div> 

                <h3>{_('Por revista')}</h3>
                <div>
                    <a href="<?=site_url("frecuencias/revista");?>"><span class="amarillo">•</span> {_('Número de documentos publicados por revista')}</a><br>
                    <a href="<?=site_url("frecuencias/revista");?>"><span class="amarillo">•</span> {_('Número de documentos publicados por autor y revista')}</a><br>
                    <a href="<?=site_url("frecuencias/revista");?>"><span class="amarillo">•</span> {_('Número de documentos publicados por institución de afiliación del autor en las revistas')}</a><br>
                    <a href="<?=site_url("frecuencias/revista");?>"><span class="amarillo">•</span> {_('Número de artículos publicados por año')}</a>
                </div>
            </div>  