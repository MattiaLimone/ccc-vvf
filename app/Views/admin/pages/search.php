<?= $this->extend("admin/layouts/default") ?>

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
        <!-- INIZIO FORM RICERCA PERSONALE -->
        <div class="row justify-content-center">
            <?php if (isset($validation)) : ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong><i class="bi bi-exclamation-triangle"></i></strong>
                    <?= $validation->listErrors() ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Chiudi"></button>
                </div>
            <?php endif; ?>
            <?php if (isset($success)) : ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong><i class="bi bi-check-lg"></i></strong>
                    <?= $success ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Chiudi"></button>
                </div>
            <?php endif; ?>
            <div class="col-lg-12">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header"><h3 class="text-center font-weight-light my-4">RICERCA PERSONALE</h3></div>

                    <div class="card-header">
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="filters accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Filtri
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <form action="<?= base_url('admin/dashboard/search/filter') ?>" method="post">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3">
                                                        <div class="col-md-4">
                                                            <label class="control-label" for="grado">Qualifica:</label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <select id="grado" name="grado" class="form-select" aria-label=".form-select-lg" style="padding-top: 0.625rem;" enabled>
                                                                <option value="0" selected>------</option>
                                                                <?php foreach ($gradiList as $grado) {
                                                                    echo '<option value="'.$grado['id'].'">'.$grado['title'].' ('.$grado['code'].')</option>';
                                                                }?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3">
                                                        <div class="col-md-4">
                                                            <label for="sede">Sede:</label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <select id="sede" name="sede" class="form-select" aria-label=".form-select-lg" style="padding-top: 0.625rem;" enabled>
                                                                <option value="0" selected>------</option>
                                                                <?php foreach ($sediList as $sede) {
                                                                    echo '<option value="'.$sede['sede_destinazione'].'">'.$sede['sede_destinazione'].'</option>';
                                                                }?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="float-end">
                                                    <input type="submit" class="btn btn-primary center" value="Ricerca">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card card-body border-0 shadow table-wrapper table-responsive">
                        <table id="example" class="table table-striped" style="width:100%">
                            <thead>
                            <tr>
                                <th></th>
                                <?php foreach($fieldList as $field)
                                    echo "<th>".strtoupper(str_replace('_',' ',$field))."</th>";
                                ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($usersList as $user){
                                echo "<tr>";
                                echo "<td></td>";
                                foreach ($user as $value){
                                    echo "<td>".$value."</td>";
                                }
                                echo "</tr>";
                            } ?>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
            <!-- FINE FORM RICERCA PERSONALE -->
            <?php echo @view('admin/_partials/footer', array()); ?>
    </main>
<?= $this->endSection() ?>
<?= $this->section("footer") ?>
    <script>
        $(document).ready(function() {
            var table = $('#example').DataTable({
                dom: 'Bfrtip',
                select: {
                    style: 'multi',
                    selector: 'td:first-child'
                },
                columnDefs: [ {
                    orderable: false,
                    className: 'select-checkbox',
                    targets:   0
                }
                ],
                order: [[ 1, 'asc' ]],
                language: {
                    "infoFiltered": "(filtrati da _MAX_ elementi totali)",
                    "infoThousands": ".",
                    "loadingRecords": "Caricamento...",
                    "processing": "Elaborazione...",
                    "search": "Cerca:",
                    "paginate": {
                        "first": "Inizio",
                        "previous": "Precedente",
                        "next": "Successivo",
                        "last": "Fine"
                    },
                    "aria": {
                        "sortAscending": ": attiva per ordinare la colonna in ordine crescente",
                        "sortDescending": ": attiva per ordinare la colonna in ordine decrescente"
                    },
                    "autoFill": {
                        "cancel": "Annulla",
                        "fill": "Riempi tutte le celle con <i>%d<\/i>",
                        "fillHorizontal": "Riempi celle orizzontalmente",
                        "fillVertical": "Riempi celle verticalmente"
                    },
                    "buttons": {
                        "collection": "Collezione <span class=\"ui-button-icon-primary ui-icon ui-icon-triangle-1-s\"><\/span>",
                        "colvis": "Visibilità Colonna",
                        "colvisRestore": "Ripristina visibilità",
                        "copy": "Copia",
                        "copyKeys": "Premi ctrl o u2318 + C per copiare i dati della tabella nella tua clipboard di sistema.<br \/><br \/>Per annullare, clicca questo messaggio o premi ESC.",
                        "copySuccess": {
                            "1": "Copiata 1 riga nella clipboard",
                            "_": "Copiate %d righe nella clipboard"
                        },
                        "copyTitle": "Copia nella Clipboard",
                        "csv": "CSV",
                        "excel": "Excel",
                        "pageLength": {
                            "-1": "Mostra tutte le righe",
                            "_": "Mostra %d righe"
                        },
                        "pdf": "PDF",
                        "print": "Stampa"
                    },
                    "decimal": ",",
                    "emptyTable": "Nessun dato disponibile nella tabella",
                    "info": "Risultati da _START_ a _END_ di _TOTAL_ elementi",
                    "infoEmpty": "Risultati da 0 a 0 di 0 elementi",
                    "lengthMenu": "Mostra _MENU_ elementi",
                    "searchBuilder": {
                        "add": "Aggiungi Condizione",
                        "button": {
                            "0": "Generatore di Ricerca",
                            "_": "Generatori di Ricerca (%d)"
                        },
                        "clearAll": "Pulisci Tutto",
                        "condition": "Condizione",
                        "conditions": {
                            "date": {
                                "after": "Dopo",
                                "before": "Prima",
                                "between": "Tra",
                                "empty": "Vuoto",
                                "equals": "Uguale A",
                                "not": "Non",
                                "notBetween": "Non Tra",
                                "notEmpty": "Non Vuoto"
                            },
                            "number": {
                                "between": "Tra",
                                "empty": "Vuoto",
                                "equals": "Uguale A",
                                "gt": "Maggiore Di",
                                "gte": "Maggiore O Uguale A",
                                "lt": "Minore Di",
                                "lte": "Minore O Uguale A",
                                "not": "Non",
                                "notBetween": "Non Tra",
                                "notEmpty": "Non Vuoto"
                            },
                            "string": {
                                "contains": "Contiene",
                                "empty": "Vuoto",
                                "endsWith": "Finisce Con",
                                "equals": "Uguale A",
                                "not": "Non",
                                "notEmpty": "Non Vuoto",
                                "startsWith": "Inizia Con"
                            },
                            "array": {
                                "equals": "Uguale A",
                                "empty": "Vuoto",
                                "contains": "Contiene",
                                "not": "Non",
                                "notEmpty": "Non Vuoto",
                                "without": "Senza"
                            }
                        },
                        "data": "Dati",
                        "deleteTitle": "Elimina regola filtro",
                        "leftTitle": "Criterio di Riduzione Rientro",
                        "logicAnd": "E",
                        "logicOr": "O",
                        "rightTitle": "Criterio di Aumento Rientro",
                        "title": {
                            "0": "Generatore di Ricerca",
                            "_": "Generatori di Ricerca (%d)"
                        },
                        "value": "Valore"
                    },
                    "searchPanes": {
                        "clearMessage": "Pulisci Tutto",
                        "collapse": {
                            "0": "Pannello di Ricerca",
                            "_": "Pannelli di Ricerca (%d)"
                        },
                        "count": "{total}",
                        "countFiltered": "{shown} ({total})",
                        "emptyPanes": "Nessun Pannello di Ricerca",
                        "loadMessage": "Caricamento Pannello di Ricerca",
                        "title": "Filtri Attivi - %d"
                    },
                    "select": {
                        "rows": {
                            "1": "1 riga selezionata",
                            "_": "%d righe selezionate"
                        }
                    },
                    "zeroRecords": "Nessun elemento corrispondente trovato",
                    "datetime": {
                        "amPm": [
                            "am",
                            "pm"
                        ],
                        "hours": "ore",
                        "minutes": "minuti",
                        "next": "successivo",
                        "previous": "precedente",
                        "seconds": "secondi",
                        "unknown": "sconosciuto",
                        "weekdays": [
                            "Dom",
                            "Lun",
                            "Mar",
                            "Mer",
                            "Gio",
                            "Ven",
                            "Sab"
                        ],
                        "months": [
                            "Gennaio",
                            "Febbraio",
                            "Marzo",
                            "Aprile",
                            "Maggio",
                            "Giugno",
                            "Luglio",
                            "Agosto",
                            "Settembre",
                            "Ottobre",
                            "Novembre",
                            "Dicembre"
                        ]
                    },
                    "editor": {
                        "close": "Chiudi",
                        "create": {
                            "button": "Nuovo",
                            "submit": "Aggiungi",
                            "title": "Aggiungi nuovo elemento"
                        },
                        "edit": {
                            "button": "Modifica",
                            "submit": "Modifica",
                            "title": "Modifica elemento"
                        },
                        "error": {
                            "system": "Errore del sistema."
                        },
                        "multi": {
                            "info": "Gli elementi selezionati contengono valori diversi. Per modificare e impostare tutti gli elementi per questa selezione allo stesso valore, premi o clicca qui, altrimenti ogni cella manterrà il suo valore attuale.",
                            "noMulti": "Questa selezione può essere modificata individualmente, ma non se fa parte di un gruppo.",
                            "restore": "Annulla le modifiche",
                            "title": "Valori multipli"
                        },
                        "remove": {
                            "button": "Rimuovi",
                            "confirm": {
                                "_": "Sei sicuro di voler cancellare %d righe?",
                                "1": "Sei sicuro di voler cancellare 1 riga?"
                            },
                            "submit": "Rimuovi",
                            "title": "Rimuovi"
                        }
                    },
                    "thousands": "."
                },
                buttons: [
                    {
                        extend: 'copy',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'csv',
                        title : function() {
                            return "Personale Operativo";
                        },
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'excel',
                        title : function() {
                            return "Personale Operativo";
                        },
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdf',
                        title : function() {
                            return "Personale Operativo";
                        },
                        orientation : 'landscape',
                        pageSize : 'A1',
                        text : '<i class="fa fa-file-pdf-o"> PDF</i>',
                        titleAttr : 'PDF',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'colvis',
                        columns: ':not(.select-checkbox)',
                    }
                ],

                "scrollX": true
            });
        } );
        $(document).ready(function() {
            $('.dt-buttons').addClass('row gx-5 gy-2').css({'margin-bottom':'15px'});
            $('.dt-button').addClass('col btn btn-primary center margin-datatable').removeClass('dt-button');
            $('.buttons-colvis').on( "click", function() {
                $("[role=menu]").addClass('row gx-5 gy-2').css({'background':'white'});
                $('.dt-button').addClass('col-sm-2 btn btn-secondary center').removeClass('dt-button').css({'margin-bottom' : '5px'});
            });
        } );

    </script>
<?= $this->endSection() ?>