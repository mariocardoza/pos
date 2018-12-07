<?php
@session_start(); 
require_once('mensajes.php');

/***array para el menu*/

$template = array(
    'name'              => 'Sistema Informático: AAES',
    'version'           => '1',
    'author'            => 'Estudio Agil',
    'robots'            => 'noindex, nofollow',
    'title'             => 'Asociación Azucarera de El Salvador',
    'description'       => 'Sistema Informatico para la Gestión de contenedores de la Asociación Azucarera de El Salvador',
    'page_preloader'    => false,

    // true                     enable main menu auto scrolling when opening a submenu

    // false                    disable main menu auto scrolling when opening a submenu

    'menu_scroll'       => true,

    // 'navbar-default'         for a light header

    // 'navbar-inverse'         for a dark header

    'header_navbar'     => 'navbar-default',

    // ''                       empty for a static layout

    // 'navbar-fixed-top'       for a top fixed header / fixed sidebars

    // 'navbar-fixed-bottom'    for a bottom fixed header / fixed sidebars

    'header'            => '',

    // ''                                               for a full main and alternative sidebar hidden by default (> 991px)

    // 'sidebar-visible-lg'                             for a full main sidebar visible by default (> 991px)

    // 'sidebar-partial'                                for a partial main sidebar which opens on mouse hover, hidden by default (> 991px)

    // 'sidebar-partial sidebar-visible-lg'             for a partial main sidebar which opens on mouse hover, visible by default (> 991px)

    // 'sidebar-mini sidebar-visible-lg-mini'           for a mini main sidebar with a flyout menu, enabled by default (> 991px + Best with static layout)

    // 'sidebar-mini sidebar-visible-lg'                for a mini main sidebar with a flyout menu, disabled by default (> 991px + Best with static layout)

    // 'sidebar-alt-visible-lg'                         for a full alternative sidebar visible by default (> 991px)

    // 'sidebar-alt-partial'                            for a partial alternative sidebar which opens on mouse hover, hidden by default (> 991px)

    // 'sidebar-alt-partial sidebar-alt-visible-lg'     for a partial alternative sidebar which opens on mouse hover, visible by default (> 991px)

    // 'sidebar-partial sidebar-alt-partial'            for both sidebars partial which open on mouse hover, hidden by default (> 991px)

    // 'sidebar-no-animations'                          add this as extra for disabling sidebar animations on large screens (> 991px) - Better performance with heavy pages!

    'sidebar'           => 'sidebar-partial sidebar-visible-lg sidebar-no-animations',

    // ''                       empty for a static footer

    // 'footer-fixed'           for a fixed footer

    'footer'            => '',

    // ''                       empty for default style

    // 'style-alt'              for an alternative main style (affects main page background as well as blocks style)

    'main_style'        => '',

    // ''                           Disable cookies (best for setting an active color theme from the next variable)

    // 'enable-cookies'             Enables cookies for remembering active color theme when changed from the sidebar links (the next color theme variable will be ignored)

    'cookies'           => '',

    // 'night', 'amethyst', 'modern', 'autumn', 'flatie', 'spring', 'fancy', 'fire', 'coral', 'lake',

    // 'forest', 'waterlily', 'emerald', 'blackberry' or '' leave empty for the Default Blue theme

    'theme'             => '',

    // ''                       for default content in header

    // 'horizontal-menu'        for a horizontal menu in header

    // This option is just used for feature demostration and you can remove it if you like. You can keep or alter header's content in page_head.php

    'header_content'    => '',

    'active_page'       => basename($_SERVER['PHP_SELF'])

);



/* Primary navigation array (the primary navigation will be created automatically based on this array, up to 3 levels deep) */



if($_SESSION['nivel']=='1'){

    $primary_nav = array(

        array(

            'name'  => 'Home',
            'url'   => '../home/index.php?date='.date("Yidisus"),
            'icon'  => 'gi gi-stopwatch',
            'url_real' => 'index.php'

        ),
        array(
            'name'  => 'Usuarios',
            'icon'  => 'gi gi-group',
            'url'   => '../personas/actualizar_personas.php?date='.date("Yidisus"),
            'url_real' => 'actualizar_personas.php'
             
        ),
        array(
            'name'  => 'CONSAA',
            'icon'  => 'gi gi-group',
            'url'   => '../consaa/perfil_consaa.php?date='.date("Yidisus"),
            'url_real'   => 'perfil_consaa.php'
            /*'sub'   => array(
                array(
                    'name'  => 'Registro de CONSAA',
                    'url'   => '../consaa/ingreso_consaa.php?date='.date("Yidisus"),
                    'url_real'   => 'ingreso_consaa.php'
                ),
                array(
                    'name'  => 'Perfil CONSAA',
                    'url'   => '../consaa/perfil_consaa.php?date='.date("Yidisus"),
                    'url_real'   => 'perfil_consaa.php'
                ),
                 
            )*/
        ),
        array(
            'name'  => 'Traders',
            'icon'  => 'gi gi-group',
            'sub'   => array(
                array(
                    'name'  => 'Nuevo Trader',
                    'url'   => '../traders/nuevo_trader.php?date='.date("Yidisus"),
                    'url_real'   => 'nuevo_trader.php'
                ),
                array(
                    'name'  => 'Administrar Traders',
                    'url'   => '../traders/actualizar_trader.php?date='.date("Yidisus"),
                    'url_real'   => 'actualizar_trader.php'
                ),
                 
            )
        ),
        array(
            'name'  => 'Ingenios',
            'icon'  => 'gi gi-building',
            'sub'   => array(
                array(
                    'name'  => 'Nuevo Ingenio',
                    'url'   => '../ingenios/nuevo_ingenio.php?date='.date("Yidisus"),
                    'url_real'   => 'nuevo_ingenio.php'
                ),
                array(
                    'name'  => 'Administrar Ingenios',
                    'url'   => '../ingenios/actualizar_ingenio.php?date='.date("Yidisus"),
                    'url_real'   => 'actualizar_ingenio.php'
                ),
                 
            )
        ),
        array(
            'name'  => 'Asociación AAES',
            'icon'  => 'gi gi-bank',
            'sub'   => array(
                array(
                    'name'  => 'Registro Asociación',
                    'url'   => '../asociacion_aaes/registro_AAES.php?date='.date("Yidisus"),
                    'url_real'   => 'registro_AAES.php'
                ),
                array(
                    'name'  => 'Administrar Asociación',
                    'url'   => '../asociacion_aaes/administrar_AAES.php?date='.date("Yidisus"),
                    'url_real'   => 'administrar_AAES.php'
                ),
                array(
                    'name'  => 'Agregar Empleados',
                    //'url'   => 'actualizar_trader.php'
                    
                ),
                 
            )
        ),
        array(
            'name'  => 'Empresas',
            'icon'  => 'fa fa-building',
            'sub'   => array(
                array(
                    'name'  => 'Registro Empresa',
                    'url'   => '../empresas/nueva_empresa.php?date='.date("Yidisus"),
                    'url_real'   => 'nueva_empresa.php'
                ),
                array(
                    'name'  => 'Administrar Bancos',
                    'url'   => '../empresas/actualizar_banco.php?date='.date("Yidisus"),
                    'url_real'   => 'actualizar_banco.php'
                ),
                array(
                    'name'  => 'Administrar Empresas Publicas',
                    'url'   => '../empresas/actualizar_publica.php?date='.date("Yidisus"),
                    'url_real'   => 'actualizar_publica.php'
                ),
                array(
                    'name'  => 'Administrar Couriers',
                    'url'   => '../empresas/actualizar_courier.php?date='.date("Yidisus"),
                    'url_real'   => 'actualizar_courier.php'
                ),
                array(
                    'name'  => 'Administrar Laboratorios',
                    'url'   => '../empresas/actualizar_laboratorio.php?date='.date("Yidisus"),
                    'url_real'   => 'actualizar_laboratorio.php'
                ),
                
                 
            )
        ),
        array(
            'name'  => 'Operadores Carga',
            'icon'  => 'fa fa-ship',
            'sub'   => array(
                array(
                    'name'  => 'Registro Operador',
                    'url'   => '../empresas/nuevo_operador_carga.php?date='.date("Yidisus"),
                    'url_real'   => 'nuevo_operador_carga.php'
                ),
                array(
                    'name'  => 'Administrar Operadores',
                    'url'   => '../empresas/actualizar_operadores_carga.php?date='.date("Yidisus"),
                    'url_real'   => 'actualizar_operadores_carga.php'
                ),
                
                 
            )
        ),
        array(
            'name'  => 'Transportista',
            'icon'  => 'fa fa-truck',
            'sub'   => array(
                array(
                    'name'  => 'Registro Transportista',
                    'url'   => '../transporte/nuevo_transporte.php?date='.date("Yidisus"),
                    'url_real'   => 'nuevo_transporte.php'
                ),
                array(
                    'name'  => 'Administrar Transportistas',
                    'url'   => '../transporte/actualizar_transporte.php?date='.date("Yidisus"),
                    'url_real'   => 'actualizar_transporte.php'
                ),
                
                 
            )
        ),
        array(
            'name'  => 'Tramitante',
            'icon'  => 'fa fa-truck',
            'sub'   => array(
                array(
                    'name'  => 'Registro Tramitante',
                    'url'   => '../tramitantes/registro_tramitante.php?date='.date("Yidisus"),
                    'url_real'   => 'nuevo_transporte.php'
                ),
                array(
                    'name'  => 'Administrar Tramitante',
                    'url'   => '../tramitantes/administrar_tramitante.php?date='.date("Yidisus"),
                    'url_real'   => 'actualizar_transporte.php'
                ),
                
                 
            )
        ),
        array(
            'name'  => 'Salir',
            'icon'  => 'gi gi-exit',
            'url'   => '../home/destruir.php?date='.date("Yidisus")
                
                 
            )
        

    );

}
