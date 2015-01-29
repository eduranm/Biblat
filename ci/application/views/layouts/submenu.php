                            <ul class="nav navbar-nav">
                                <li><a href="https://www.facebook.com/pages/BIBLAT/188958071154818" title="Facebook"><span class="fa fa-facebook-square"></span><span class="visible-xs-inline"> Facebook</span></a></li>
                                <li><a href="https://twitter.com/Biblat" title="Twitter"><span class="fa fa-twitter"></span><span class="visible-xs-inline"> Twitter</span></a></li>
                                <li><a href="javascript:;" title="{_('Ayuda')}"><span class="fa fa-question-circle"></span><span class="visible-xs-inline"> {_('Ayuda')}</span></a></li>
                                <li><a href="javascript:;" title="{_('Contacto')}"><span class="fa fa-envelope-o"></span><span class="visible-xs-inline"> {_('Contacto')}</span></a></li>
                                <li><a href="javascript:;" onclick="javascript:window.print();" title="{_('Imprimir')}"><span class="fa fa-print"></span><span class="visible-xs-inline"> {_('Imprimir')}</span></a></li>
                                <li class="dropdown">
                                  <a href="#" title="{_('Idioma')}" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-language"></span><span class="visible-xs-inline"> {_('Idioma')}</span><span class="caret"></span></a>
                                  <ul class="dropdown-menu" role="menu">
{foreach supported_langs() key curlang}
                                    <li><a href="{site_url($lang->switch_uri($key))}">{$curlang.title}</a></li>
{/foreach}
                                  </ul>
                                </li>
                            </ul>