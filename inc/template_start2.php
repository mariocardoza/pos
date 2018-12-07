<?php
date_default_timezone_set('America/El_Salvador');
/**

 * Author: eleangel
 *
 * Inicio de Sistema
 *
 */
?>
<!DOCTYPE html>
<!--[if IE 9]>         <html class="no-js lt-ie10" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">

        <title><?php echo $template['title'] ?></title>

        <meta name="description" content="<?php echo $template['description'] ?>">
        <meta name="author" content="<?php echo $template['author'] ?>">
        <meta name="robots" content="<?php echo $template['robots'] ?>">
        <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0">

        <!-- Icons -->
        <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
        <link rel="shortcut icon" href="img/favicon.png">
        <link rel="apple-touch-icon" href="img/icon57.png" sizes="57x57">
        <link rel="apple-touch-icon" href="img/icon72.png" sizes="72x72">
        <link rel="apple-touch-icon" href="img/icon76.png" sizes="76x76">
        <link rel="apple-touch-icon" href="img/icon114.png" sizes="114x114">
        <link rel="apple-touch-icon" href="img/icon120.png" sizes="120x120">
        <link rel="apple-touch-icon" href="img/icon144.png" sizes="144x144">
        <link rel="apple-touch-icon" href="img/icon152.png" sizes="152x152">
        <link rel="apple-touch-icon" href="img/icon180.png" sizes="180x180">
        <!-- END Icons -->

        <!-- Stylesheets -->
        <!-- Bootstrap is included in its original form, unaltered -->
        <link rel="stylesheet" href="../../css/bootstrap.min.css">

        <!-- Related styles of various icon packs and plugins -->
        <link rel="stylesheet" href="../../css/plugins.css">

        <!-- The main stylesheet of this template. All Bootstrap overwrites are defined in here -->
        <link rel="stylesheet" href="../../css/main.css">

        <!-- Include a specific file here from css/themes/ folder to alter the default theme of the template -->
        <?php if ($template['theme']) { ?><link id="theme-link" rel="stylesheet" href="../../css/themes/<?php echo $template['theme']; ?>.css"><?php } ?>

        <!-- END Stylesheets -->
        <link rel="stylesheet" type="text/css" href="../../css/izitoast/iziToast.min.css?v=130c">
        <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.3/css/rowReorder.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.1/css/responsive.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
        <link rel="stylesheet" href="../../js/vendor/bootstrap-select/v2.2.css">
        <!-- Modernizr (browser feature detection library) -->
        <script src="../../js/vendor/modernizr.min.js"></script>
        <link rel="stylesheet" href="../../css/animate.min.css">
        <!--script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.28.5/dist/sweetalert2.all.min.js"></script-->
     
    <style>
        .notificaciones_dashbord{
            width: 107.203px !important;
        }
        .color-rojo{
            background: #e74c3c  !important;
        }
        .color-naranja{
            background: #e67e22  !important;
        }
        a.btn-floating img{
          width: 75px !important;
        }
          
        a.btn-floating{
          margin-right: -15px;
          margin-top: 0px;
        } 
        .fixed-action-btn {
            position: fixed;
            right: 23px;
            bottom: 23px;
            margin-bottom: 0;
            z-index: 998;
            cursor: pointer;
        }
        .fixed-action-btn ul {
            left: 0;
            right: 0;
            text-align: center;
            position: absolute;
            bottom: 64px;
            margin: 0
        }
        .fixed-action-btn ul li {
            margin-bottom: 15px
        }
        .fixed-action-btn ul a.btn2-floating {
            opacity: 0
        }
        label.error {
            color: red;
        }
        .color_td_1,
        .color_td_6{
            background: #e74c3c !important;
        }

        .color_td_2,
        .color_td_3,
        .color_td_4,
        .color_td_5,
        .color_td_7,
        .color_td_8{
            background: #7db831 !important;
        }
        .color_td_9{
            background: #d8d3d3  !important;
        }
        .etapa_verde{
            background: green !important;
        }
        .etapa_amarillo{
            background: yellow !important;
        }
        .etapa_rojo{
            background: red !important;
        }
        tr.anulado_tr * {
            text-decoration: line-through;
        }
        tr.anulado_tr {
            background: whitesmoke;
        }
        .block.ele_shadow {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }
        .notificaciones_dashbord {
            color: #fff !important;
        }
        .icon_noti{
            margin-bottom: 14px !important;
        }
        .dt-buttons {
            float: left;
            background: #fff !important;
            border: none !important;
        }
        div#t_final_filter{
            float: right;
            background: #fff;
            border: none;
        }
        div#t_final_wrapper {
            display: flow-root;
        }
        div#t_final_info {
            float: left;
            width: 50%;
            display: block;
            height: 46px;
        }
        div#t_final_paginate {
            float: right;
            width: 50%;
            display: block;
            height: 46px;
        }
        .btn-group.dropup.text-left.open .dropdown-menu {
            left: initial !important;
            right: 0 !important;
        }
        .btn-group.dropup.text-left.open .dropdown-menu * {
            color: #fff !important;
        }
        .btn-group.dropup.text-left.open .dropdown-menu i{display: contents;}
   </style>

    </head>
    <body onload="sinVueltaAtras();" onpageshow="if (event.persisted) sinVueltaAtras();" onunload="">