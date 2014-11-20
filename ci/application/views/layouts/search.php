    <form action="<?=site_url('buscar');?>" id="searchform" method="post" role="search" autocomplete="off">
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-addon">
                    <div class="btn-group">
                        <button type="button" class="btn btn-search dropdown-toggle" data-toggle="dropdown">
                            <span id="search-type" class="fa fa-cloud fa-fw"> </span><span class="caret"></span>
                        </button>
                        <ul id="search-opts" class="dropdown-menu" role="menu">
                        <li rel="todos"><a href="#"><span id="todos" class="fa fa-cloud fa-fw"></span> {_('Buscar en todos los campos')}</a></li>
                        <li rel="palabra-clave"><a href="#"><span id="palabra-clave" class="fa fa-key fa-fw"></span> {_('Buscar por palabra clave')}</a></li>
                        <li rel="autor"><a href="#"><span id="autor" class="fa fa-user fa-fw"></span> {_('Buscar por autor')}</a></li>
                        <li rel="revista"><a href="#"><span id="revista" class="fa fa-book fa-fw"></span> {_('Buscar por revista')}</a></li>
                        <li rel="institucion"><a href="#"><span id="institucion" class="fa fa-building fa-fw"></span> {_('Buscar por institución')}</a></li>
                        <li rel="articulo"><a href="#"><span id="articulo" class="fa fa-file-text-o fa-fw"></span> {_('Buscar por artículo')}</a></li>
                        <li rel="avanzada"><a href="#"><span id="avanzada" class="fa fa-search-plus fa-fw"></span> {_('Búsqueda avanzada')}</a></li>
                        </ul>
                    </div>
                </div>
                <textarea class="form-control" id="slug" name="slug" placeholder="{_('Buscar en Biblat')}">{if $search.slug}{$search.slug}{/if}</textarea>
                <div id="advsearch" class="form-control"></div>
                <div class="input-group-addon">
                    <button type="submit" class="btn btn-search"><span class="fa fa-search"></span></button>
                </div>
            </div><!--input-group-->
            <input type="hidden" name="disciplina" value=""/>
            <input type="hidden" name="filtro" id="filtro" value="todos"/>
        </div><!--form-group-->
    </form>