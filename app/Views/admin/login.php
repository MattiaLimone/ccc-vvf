<?= $this->extend("admin/layouts/default") ?>



<?= $this->section("body") ?>
<main>

    <!-- Section -->
    <section class="vh-lg-100 mt-5 mt-lg-0 bg-soft d-flex align-items-center">
        <div class="container">
            <p class="text-center">
                <a href="<?= base_url() ?>" class="d-flex align-items-center justify-content-center">
                    <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd"></path></svg>
                    Torna indietro
                </a>
            </p>
            <div class="row justify-content-center form-bg-image" data-background-lg="<?= base_url('assets/img/illustrations/signin.svg') ?>">

                <div class="col-12 d-flex align-items-center justify-content-center">
                    <div class="bg-white shadow border-0 rounded border-light p-4 p-lg-5 w-100 fmxw-500">
                        <div class="text-center text-md-center mb-4 mt-md-0">
                            <h1 class="mb-0 h3">Dashboard VVF</h1>
                        </div>
                        <?php if (isset($validation)) : ?>
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <?= $validation->listErrors() ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Chiudi"></button>
                            </div>
                        <?php endif; ?>
                        <form action="<?= base_url('admin/login/login') ?>" method="post" class="mt-4">
                            <!-- Form -->
                            <div class="form-group mb-4">
                                <label for="email">Codice Fiscale</label>
                                <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">
                                            <svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path></svg>
                                        </span>
                                    <input type="text" class="form-control" placeholder="Codice Fiscale" name="codice_fiscale" id="codice_fiscale" autofocus required>
                                </div>
                            </div>
                            <!-- End of Form -->
                            <div class="form-group">
                                <!-- Form -->
                                <div class="form-group mb-4">
                                    <label for="password">Password</label>
                                    <div class="input-group">
                                            <span class="input-group-text" id="basic-addon2">
                                                <svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                                            </span>
                                        <input type="password" placeholder="Password" class="form-control" id="password" name="password"required>
                                    </div>
                                </div>
                                <!-- End of Form -->
                                <div class="d-flex justify-content-between align-items-top mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="remember">
                                        <label class="form-check-label mb-0" for="remember">
                                            Salva accesso
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-gray-800">Accedi</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?= $this->endSection() ?>