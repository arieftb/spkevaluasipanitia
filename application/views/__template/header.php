<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?= $title ?> | <?= WEB_TITLE ?></title>
    <!-- Favicon-->
    <link rel="icon" href="<?php echo base_url() ?>res/favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet"
        type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="<?php echo base_url() ?>res/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="<?php echo base_url() ?>res/plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="<?php echo base_url() ?>res/plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- Bootstrap Material Datetime Picker Css -->
    <link
        href="<?php echo base_url() ?>res/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css"
        rel="stylesheet" />

    <!-- Bootstrap DatePicker Css -->
    <link href="<?php echo base_url() ?>res/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css"
        rel="stylesheet" />

    <!-- Morris Chart Css-->
    <link href="<?php echo base_url() ?>res/plugins/morrisjs/morris.css" rel="stylesheet" />

    <!-- Bootstrap Select Css -->
    <link href="<?php echo base_url() ?>res/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="<?php echo base_url() ?>res/css/style.css" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="<?php echo base_url() ?>res/css/themes/all-themes.css" rel="stylesheet" />
</head>

<body class="theme-blue">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Please wait...</p>
        </div>
    </div>