<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- Primary Meta Tags -->
    <title><?= $page_title ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="title" content="<?= $page_title ?>">
    <meta name="author" content="Mattia Limone">
    <!--
    <meta name="description" content="Volt Pro is a Premium Bootstrap 5 Admin Dashboard featuring over 800 components, 10+ plugins and 20 example pages using Vanilla JS.">
    <meta name="keywords" content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, themesberg, themesberg dashboard, themesberg admin dashboard" />
    <link rel="canonical" href="https://themesberg.com/product/admin-dashboard/volt-premium-bootstrap-5-dashboard">
    -->

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo base_url('assets/img/favicon/apple-touch-icon.png'); ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url('assets/img/favicon/favicon-32x32.png'); ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url('assets/img/favicon/favicon-16x16.png'); ?>">
    <link rel="manifest" href="<?php echo base_url('assets/img/favicon/site.webmanifest'); ?>">
    <link rel="mask-icon" href="<?php echo base_url('assets/img/favicon/safari-pinned-tab.svg'); ?>" color="#ffffff">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">

    <!-- Sweet Alert -->
    <link type="text/css" href="<?php echo base_url('vendor/sweetalert2/dist/sweetalert2.min.css'); ?>" rel="stylesheet">

    <!-- Notyf -->
    <link type="text/css" href="<?php echo base_url('vendor/notyf/notyf.min.css'); ?>" rel="stylesheet">

    <!-- Volt CSS -->
    <link type="text/css" href="<?php echo base_url('css/volt.css'); ?>" rel="stylesheet">
    <link type="text/css" href="<?php echo base_url('css/custom.css'); ?>" rel="stylesheet">
    <!-- Datatables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/1.3.3/css/select.dataTables.min.css"/>
    <!-- Calendar CSS -->
    <link href="<?php echo base_url('vendor/fullcalendar/main.css'); ?>" rel="stylesheet" />


    <?= $this->renderSection("head_extra") ?>
</head>

<body>

<?= $this->renderSection("body") ?>

<!-- Core -->
<script src="<?php echo base_url('vendor/@popperjs/core/dist/umd/popper.min.js'); ?>"></script>
<script src="<?php echo base_url('vendor/bootstrap/dist/js/bootstrap.min.js'); ?>"></script>
<!-- Jquery JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- Vendor JS -->
<script src="<?php echo base_url('vendor/onscreen/dist/on-screen.umd.min.js'); ?>"></script>
<!-- Slider -->
<script src="<?php echo base_url('vendor/nouislider/dist/nouislider.min.js'); ?>"></script>
<!-- Smooth scroll -->
<script src="<?php echo base_url('vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js'); ?>"></script>
<!-- Charts -->
<script src="<?php echo base_url('vendor/chartist/dist/chartist.min.js'); ?>"></script>
<script src="<?php echo base_url('vendor/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js'); ?>"></script>
<!-- Datepicker -->
<script src="<?php echo base_url('vendor/vanillajs-datepicker/dist/js/datepicker.min.js'); ?>"></script>
<!-- Sweet Alerts 2 -->
<script src="<?php echo base_url('vendor/sweetalert2/dist/sweetalert2.all.min.js'); ?>"></script>
<!-- Moment JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"></script>
<!-- Vanilla JS Datepicker -->
<script src="<?php echo base_url('vendor/vanillajs-datepicker/dist/js/datepicker.min.js'); ?>"></script>
<!-- Notyf -->
<script src="<?php echo base_url('vendor/notyf/notyf.min.js'); ?>"></script>
<!-- Simplebar -->
<script src="<?php echo base_url('vendor/simplebar/dist/simplebar.min.js'); ?>"></script>
<!-- Github buttons -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
<!-- Volt JS -->
<script src="<?php echo base_url('assets/js/volt.js'); ?>"></script>
<!-- AutoComplete JS -->
<script src="<?php echo base_url('assets/js/autocomplete.js'); ?>"></script>
<!-- DatePicker JS -->
<script src="<?php echo base_url('vendor/vanillajs-datepicker/dist/js/datepicker.min.js'); ?>"></script>
<!-- DatePicker IT translation JS -->
<script src="<?php echo base_url('vendor/vanillajs-datepicker/dist/js/locales/it.js'); ?>"></script>

<!-- Datatables JS -->
<script src="https://cdn.datatables.net/v/dt/dt-1.10.25/datatables.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.3/js/dataTables.select.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables-buttons/1.5.4/js/buttons.colVis.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js "></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js "></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
<!-- Calendar JS -->
<script src="<?php echo base_url('vendor/fullcalendar/main.js'); ?>"></script>
<script src="<?php echo base_url('vendor/fullcalendar/locales/it.js'); ?>"></script>
<!-- CKEditor 5 JS -->
<script src="https://cdn.ckeditor.com/ckeditor5/30.0.0/decoupled-document/ckeditor.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/30.0.0/decoupled-document/translations/it.js"></script>
<?= $this->renderSection("footer") ?>
<script>
    const searchField = document.getElementById('topbarInputIconLeft');
    const searchAutoComplete = new Autocomplete(searchField, {
        data: [{label: "Default", value: 1}],
        maximumItems: 5,
        treshold: 3,
        onSelectItem: ({label, value}) => {
            window.location.replace(value);
        }
    });
    searchAutoComplete.setData(<?= $searchList?>);
</script>
</body>
</html>
