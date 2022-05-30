<?= $this->extend("admin/layouts/default") ?>
<?= $this->section("head_extra") ?>
<?= $this->endSection() ?>
<?= $this->section("body") ?>
<?php echo @view('admin/_partials/sidebar', array()); ?>
<main class="content">

    <nav class="navbar navbar-top navbar-expand navbar-dashboard navbar-dark ps-0 pe-2 pb-0">
        <div class="container-fluid px-0">
            <div class="d-flex justify-content-between w-100" id="navbarSupportedContent">
                <div class="d-flex align-items-center">
                    <!-- Search form -->
                    <div class="navbar-search form-inline" id="navbar-search-main">
                        <div class="input-group input-group-merge search-bar">
                                  <span class="input-group-text" id="topbar-addon">
                                    <svg class="icon icon-xs" x-description="Heroicon name: solid/search" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                      <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                                    </svg>
                                  </span>
                            <input type="text" class="form-control" id="topbarInputIconLeft" placeholder="Search" aria-label="Search" aria-describedby="topbar-addon">
                        </div>
                    </div>
                    <!-- / Search form -->
                </div>
                <!-- Navbar links -->
                <ul class="navbar-nav align-items-center">
                    <?php echo @view('admin/_partials/notification', array()); ?>
                    <li class="nav-item dropdown ms-lg-3">
                        <a class="nav-link dropdown-toggle pt-1 px-0" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="media d-flex align-items-center">
                                <img class="avatar rounded-circle" alt="Image placeholder" src="<?php echo base_url('assets/img/team/profile-picture-3.jpg'); ?>">
                                <div class="media-body ms-2 text-dark align-items-center d-none d-lg-block">
                                    <span class="mb-0 font-small fw-bold text-gray-900"><?= session()->get('name') ?> <?= session()->get('surname') ?></span>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu dashboard-dropdown dropdown-menu-end mt-2 py-1">
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <svg class="dropdown-icon text-gray-400 me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"></path></svg>
                                My Profile
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <svg class="dropdown-icon text-gray-400 me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path></svg>
                                Settings
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <svg class="dropdown-icon text-gray-400 me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5 3a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V5a2 2 0 00-2-2H5zm0 2h10v7h-2l-1 2H8l-1-2H5V5z" clip-rule="evenodd"></path></svg>
                                Messages
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <svg class="dropdown-icon text-gray-400 me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-2 0c0 .993-.241 1.929-.668 2.754l-1.524-1.525a3.997 3.997 0 00.078-2.183l1.562-1.562C15.802 8.249 16 9.1 16 10zm-5.165 3.913l1.58 1.58A5.98 5.98 0 0110 16a5.976 5.976 0 01-2.516-.552l1.562-1.562a4.006 4.006 0 001.789.027zm-4.677-2.796a4.002 4.002 0 01-.041-2.08l-.08.08-1.53-1.533A5.98 5.98 0 004 10c0 .954.223 1.856.619 2.657l1.54-1.54zm1.088-6.45A5.974 5.974 0 0110 4c.954 0 1.856.223 2.657.619l-1.54 1.54a4.002 4.002 0 00-2.346.033L7.246 4.668zM12 10a2 2 0 11-4 0 2 2 0 014 0z" clip-rule="evenodd"></path></svg>
                                Support
                            </a>
                            <div role="separator" class="dropdown-divider my-1"></div>
                            <a class="dropdown-item d-flex align-items-center" href="<?= base_url('admin/logout') ?>">
                                <svg class="dropdown-icon text-danger me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="py-4">
        <div class="dropdown">
            <?php echo @view('admin/_partials/breadcrumb', array()); ?>
        </div>
    </div>
    <!-- INIZIO FORM MODIFICA PERMESSI -->
    <div class="row justify-content-center">
        <section class="ftco-section">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-6">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <h6 class="text-left font-weight-light my-4">Filtra per sede:</h6>
                                </div>
                                <div class="col-md-9 pt-3">

                                    <select id="sede" name="sede" class="form-select" aria-label=".form-select-lg" style="padding-top: 0.625rem;" enabled>
                                        <option value="0" selected>------</option>
                                        <?php foreach ($sediList as $sede) {
                                            echo '<option value="'.$sede['sede_destinazione'].'">'.$sede['sede_destinazione'].'</option>';
                                        }?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">

                <div class="col-lg-8">
                    <div id="calendar"></div>
                </div>

                <div class="col-lg-6">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header"><h3 class="text-center font-weight-light my-4">Turnazione</h3></div>
                        <div class="card-body">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-centered table-nowrap mb-0 rounded" id="turnazione">
                                        <thead class="thead-light">
                                        <th class="border-0 rounded-start">Turnazione
                                        </th>
                                        <th class="border-0 rounded-end">Orario
                                        </th>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header"><h3 class="text-center font-weight-light my-4">Personale Disponibile</h3></div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-centered table-nowrap mb-0 rounded" id="personale">
                                            <thead class="thead-light">
                                            <th class="border-0 rounded-start">Nome
                                            </th>
                                            <th class="border-0">Cognome
                                            </th>
                                            <th class="border-0">Sede
                                            </th>
                                            <th class="border-0 rounded-end">Turno
                                            </th>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header"><h3 class="text-center font-weight-light my-4">Personale in Ferie</h3></div>
                        <div class="card-body">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-centered table-nowrap mb-0 rounded" id="ferie">
                                        <thead class="thead-light">
                                        <th class="border-0 rounded-start">Nome
                                        </th>
                                        <th class="border-0">Cognome
                                        </th>
                                        <th class="border-0">Sede
                                        </th>
                                        <th class="border-0">Dal
                                        </th>
                                        <th class="border-0 rounded-end">Al
                                        </th>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header"><h3 class="text-center font-weight-light my-4">Personale in Malattia</h3></div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-centered table-nowrap mb-0 rounded" id="malattia">
                                    <thead class="thead-light">
                                    <th class="border-0 rounded-start">Nome
                                    </th>
                                    <th class="border-0">Cognome
                                    </th>
                                    <th class="border-0">Sede
                                    </th>
                                    <th class="border-0">Motivazione
                                    </th>
                                    <th class="border-0">Indirizzo
                                    </th>
                                    <th class="border-0">Email
                                    </th>
                                    <th class="border-0">Dal
                                    </th>
                                    <th class="border-0 rounded-end">Al
                                    </th>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </div>
    </div>
    </section>
    </div>
    <!-- FINE FORM MODIFICA PERMESSI -->

    <?php echo @view('admin/_partials/footer', array()); ?>
</main>
<?= $this->endSection() ?>
<?= $this->section("footer") ?>
<script>
    let testElement;
    function getFormattedDate(date) {
        var year = date.getFullYear();

        var month = (1 + date.getMonth()).toString();
        month = month.length > 1 ? month : '0' + month;

        var day = date.getDate().toString();
        day = day.length > 1 ? day : '0' + day;

        return month + '/' + day + '/' + year;
    }
    $('document').ready(function(){
        const monthNames = ["GEN", "FEB", "MAR", "APR", "MAG", "GIU",
            "LUG", "AGO", "SET", "OTT", "NOV", "DEC"
        ];
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            height: 900,
            contentHeight: 780,
            aspectRatio: 3,
            locale: 'it',
            headerToolbar: {
                left: "prev,next today",
                center: "title",
                right: "dayGridMonth,listMonth"
            },

            displayEventTime: false,
            displayEventEnd :false,
            nowIndicator: true,
            events: '<?php echo base_url('admin/dashboard/calendar/getCalendarEvents'); ?>',
            eventContent: function(arg) {
                return {
                    html:
                        '<div class="row">'
                        + '<div class="col-12" style="display:flex;">'
                        + '<div class="fc-daygrid-event-dot" style="margin: 5px 5px;"></div>'
                        + '<div class="fc-event-title">'
                        +  '<b>'+ arg.event.title +'</b>'
                        + '</div>'
                        + '</div>'
                        + '<div class="col-12 text-center">'
                        + '<div class="bg-secondary rounded-2">' + arg.event.extendedProps.description +'</div>'
                        + '</div>'
                        + '</div>'

                }
            },
            eventClick: function(info) {
                console.log(info.event.startStr);


                $.ajax({
                    url: "<?php echo(base_url('admin/dashboard/calendar/getData')) ?>",
                    dataType: "json",
                    type: "Post",
                    async: true,
                    data: {
                        'day': info.event.startStr,
                        'turno': info.event.title,
                        'sede': $('#sede').val()
                    },
                    success: function (data) {
                        console.log(data);
                        $('#ferie tbody').empty();
                        $('#personale tbody').empty();
                        $('#malattia tbody').empty();
                        $('#turnazione tbody').empty();
                        $('#turnazione tbody').append(
                            '<tr><td>' + data.turno.codice + '</td><td> '+data.turno.orario +' </td></tr>'
                        );
                        $.each(data.ferie, function( index, value ) {
                            var from_ferie = new Date(data.ferie[index].from );
                            var to_ferie = new Date(data.ferie[index].to);
                            $('#ferie tbody').append(
                                '<tr><td class="border-0">' + data.ferie[index].nome + '</td>' +
                                '<td class="border-0">' + data.ferie[index].cognome + '</td>'+
                                '<td class="border-0">' + data.ferie[index].sede_destinazione + '</td>'+
                                '<td class="border-0">' + from_ferie.getDate()+ ' ' + monthNames[from_ferie.getMonth()] + ' '+from_ferie.getFullYear()+ '</td>'+
                                '<td class="border-0">' + to_ferie.getDate()+ ' ' + monthNames[to_ferie.getMonth()] + ' '+to_ferie.getFullYear()+ '</td>'+
                                '</tr>'
                            );
                        });

                        $.each(data.malattia, function( index, value ) {
                            var from_malattia = new Date(data.malattia[index].from);
                            var to_malattia = new Date(data.malattia[index].to);

                            $('#malattia tbody').append(
                                '<tr><td class="border-0">' + data.malattia[index].nome + '</td>' +
                                '<td class="border-0">' + data.malattia[index].cognome + '</td>'+
                                '<td class="border-0">' + data.malattia[index].sede_destinazione + '</td>'+
                                '<td class="border-0">' + data.malattia[index].reason + '</td>'+
                                '<td class="border-0">' + data.malattia[index].address + '</td>'+
                                '<td class="border-0">' + data.malattia[index].email + '</td>'+
                                '<td class="border-0">' + from_malattia.getDate()+' '+ monthNames[from_malattia.getMonth()] + ' '+from_malattia.getFullYear()+ '</td>'+
                                '<td class="border-0">' + to_malattia.getDate()+' '+ monthNames[to_malattia.getMonth()] + ' '+to_malattia.getFullYear()+ '</td>'+
                                '</tr>'
                            );
                        });

                        $.each(data.operativo, function( index, value ) {
                            $('#personale tbody').append(
                                '<tr><td class="border-0">' + data.operativo[index].nome + '</td>' +
                                '<td class="border-0">' + data.operativo[index].cognome + '</td>'+
                                '<td class="border-0">' + data.operativo[index].sede_destinazione + '</td>'+
                                '<td class="border-0">' + data.operativo[index].codice_turnazione + '</td>'+
                                '</tr>'
                            );
                        });
                        $("#turnazione")[0].scrollIntoView();
                    },
                    error: function (xhr, exception, thrownError) {
                        var msg = "";
                        if (xhr.status === 0) {
                            msg = "Not connect.\n Verify Network.";
                        } else if (xhr.status == 404) {
                            msg = "Requested page not found. [404]";
                        } else if (xhr.status == 500) {
                            msg = "Internal Server Error [500].";
                        } else if (exception === "parsererror") {
                            msg = "Requested JSON parse failed.";
                        } else if (exception === "timeout") {
                            msg = "Time out error.";
                        } else if (exception === "abort") {
                            msg = "Ajax request aborted.";
                        } else {
                            msg = "Error:" + xhr.status + " " + xhr.responseText;
                        }
                        if (callbackError) {
                            callbackError(msg);
                        }

                    }
                });

                // change the border color just for fun
                info.el.style.borderColor = 'red';
            },
        });
        calendar.render();

    });
</script>
<?= $this->endSection() ?>

