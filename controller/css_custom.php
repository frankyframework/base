<?=header('Content-Type: text/css; charset=utf-8');?>
body ._btn._btn-primary, body .btn.btn-primary, body a._btn._btn-primary, body a.btn.btn-primary, body button._btn._btn-primary, body button.btn.btn-primary, body input._btn._btn-primary, body input.btn.btn-primary {
    <?php if(!empty(getCoreConfig('base/theme/button-primary-color-text'))): ?>
        color: <?=getCoreConfig('base/theme/button-primary-color-text')?>;
    <?php endif; ?>
    <?php if(!empty(getCoreConfig('base/theme/button-primary-background-color'))): ?>
        background-color: <?=getCoreConfig('base/theme/button-primary-background-color')?>;
        border: <?=getCoreConfig('base/theme/button-primary-background-color')?>;
    <?php endif; ?>
}
body ._btn._btn-default:hover, body ._btn._btn-primary:hover, body .btn.btn-default:hover, body .btn.btn-primary:hover, body a:hover._btn._btn-default, body a:hover._btn._btn-primary, body a:hover.btn.btn-default, body a:hover.btn.btn-primary, body button:hover._btn._btn-default, body button:hover._btn._btn-primary, body button:hover.btn.btn-default, body button:hover.btn.btn-primary, body input:hover._btn._btn-default, body input:hover._btn._btn-primary, body input:hover.btn.btn-default, body input:hover.btn.btn-primary {

    <?php if(!empty(getCoreConfig('base/theme/button-primary-background-color-hover'))): ?>
        background-color: <?=getCoreConfig('base/theme/button-primary-background-color-hover')?>;
        border: <?=getCoreConfig('base/theme/button-primary-background-color-hover')?>;
    <?php endif; ?>
}
a {
    <?php if(!empty(getCoreConfig('base/theme/a-color'))): ?>
        color: <?=getCoreConfig('base/theme/a-color')?>;
    <?php endif; ?>
}
a:hover {
    <?php if(!empty(getCoreConfig('base/theme/a-color'))): ?>
        color: <?=getCoreConfig('base/theme/a-color-hover')?>;
    <?php endif; ?>
}

footer a {
    <?php if(!empty(getCoreConfig('base/theme/a-footer-color'))): ?>
        color: <?=getCoreConfig('base/theme/a-footer-color')?>;
    <?php endif; ?>
}
footer a:hover {
    <?php if(!empty(getCoreConfig('base/theme/a-footer-color-hover'))): ?>
        color: <?=getCoreConfig('base/theme/a-footer-color-hover')?>;
    <?php endif; ?>
}
header .content_header .menu_web ._nav_menu li._nav_catalog ul li a, header .content_header .menu_web ._nav_menu li._menu_section ul li a {
    <?php if(!empty(getCoreConfig('base/theme/a-header-color'))): ?>
        color: <?=getCoreConfig('base/theme/a-header-color')?>;
    <?php endif; ?>
}
header .content_header .menu_web ._nav_menu li._nav_catalog ul li a:hover, header .content_header .menu_web ._nav_menu li._menu_section ul li a:hover {
    <?php if(!empty(getCoreConfig('base/theme/a-header-color-hover'))): ?>
        color: <?=getCoreConfig('base/theme/a-header-color-hover')?>;
    <?php endif; ?>
}
header .content_header ._ul_login li a {
    <?php if(!empty(getCoreConfig('base/theme/a-header-color'))): ?>
        color: <?=getCoreConfig('base/theme/a-header-color')?>;
    <?php endif; ?>
}
header .content_header ._ul_login li a:hover {
    <?php if(!empty(getCoreConfig('base/theme/a-header-color-hover'))): ?>
        color: <?=getCoreConfig('base/theme/a-header-color-hover')?>;
    <?php endif; ?>
}
header .content_header {
    <?php if(!empty(getCoreConfig('base/theme/background-header'))): ?>
        background-color: <?=getCoreConfig('base/theme/background-header')?>;
    <?php endif; ?>
}

footer .footer_wrapper {
    <?php if(!empty(getCoreConfig('base/theme/background-footer'))): ?>
        background: <?=getCoreConfig('base/theme/background-footer')?>;
    <?php endif; ?>
}
footer .footer_wrapper .footer_2 {
    <?php if(!empty(getCoreConfig('base/theme/background-footer2'))): ?>
        background: <?=getCoreConfig('base/theme/background-footer2')?>;
    <?php endif; ?>
}