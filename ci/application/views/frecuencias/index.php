            <div id="frecuencias-accordion" class="text-left">
                <h4>{_('Por autor')}</h4>
                <div>
                    <ul class="orange-list">
                        <li><a href="{site_url("frecuencias/autor")}">{_('Número de documentos publicados por autor')}</a></li>
                    </ul>
                </div>
                <h4>{_('Por institución de afiliación del autor')}</h4>
                <div>
                    <ul class="orange-list">
                        <li><a href="{site_url("frecuencias/institucion")}">{_('Número de documentos publicados por institución')}</a></li>
                        <li><a href="{site_url("frecuencias/institucion")}">{_('Número de documentos publicados por institución según el país de la revista')}</a></li>
                        <li><a href="{site_url("frecuencias/institucion")}">{_('Número de documentos publicados por institución según la revista de publicación')}</a></li>
                        <li><a href="{site_url("frecuencias/institucion")}">{_('Número de documentos publicados por autor según su institución de afiliación')}</a></li>
                        <li><a href="{site_url("frecuencias/institucion")}">{_('Número de documentos publicados por disciplina según la institución')}</a></li>
                    </ul>
                </div>
                
                <h4>{_('Por país de institución de afiliación del autor')}</h4>
                <div>
                    <ul class="orange-list">
                        <li><a href="{site_url("frecuencias/pais-afiliacion")}">{_('Número de documentos publicados por país de la institución de afiliación del autor')}</a></li>
                        <li><a href="{site_url("frecuencias/pais-afiliacion")}">{_('Número de documentos por institución de afiliación por país')}</a></li>
                        <li><a href="{site_url("frecuencias/pais-afiliacion")}">{_('Número de documentos por autor según país de institución de afiliación')}</a></li>
                        <li><a href="{site_url("frecuencias/pais-afiliacion")}">{_('Número de documentos por disciplina según país de la institución del autor')}</a></li>
                    </ul>               
                </div>

                <h4>{_('Por disciplina')}</h4>                      
                <div>
                    <ul class="orange-list">
                        <li><a href="{site_url("frecuencias/disciplina")}">{_('Número de documentos publicados por disciplina')}</a></li>
                        <li><a href="{site_url("frecuencias/disciplina")}">{_('Número de documentos publicados por disciplina y revista')}</a></li>
                        <li><a href="{site_url("frecuencias/disciplina")}">{_('Número de documentos publicados por disciplina e institución de afiliación del autor')}</a></li>
                        <li><a href="{site_url("frecuencias/disciplina")}">{_('Número de documentos publicados por disciplina y país de la revista')}</a></li>
                        <li><a href="{site_url("frecuencias/disciplina")}">{_('Número de documentos publicados por disciplina y país de la institución de afiliación del autor')}</a></li>
                    </ul>
                </div> 

                <h4>{_('Por revista')}</h4>
                <div>
                    <ul>
                        <li><a href="{site_url("frecuencias/revista")}">{_('Número de documentos publicados por revista')}</a></li>
                        <li><a href="{site_url("frecuencias/revista")}">{_('Número de documentos publicados por autor y revista')}</a></li>
                        <li><a href="{site_url("frecuencias/revista")}">{_('Número de documentos publicados por institución de afiliación del autor en las revistas')}</a></li>
                        <li><a href="{site_url("frecuencias/revista")}">{_('Número de artículos publicados por año')}</a></li>
                    </ul>
                </div>
            </div>  