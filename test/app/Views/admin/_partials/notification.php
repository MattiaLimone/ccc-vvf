<li class="nav-item dropdown">
    <a class="nav-link text-dark notification-bell unread dropdown-toggle" data-unread-notifications="true" href="#" role="button" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
        <svg class="icon icon-sm text-gray-900" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path></svg>
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-center mt-2 py-0">
        <div class="list-group list-group-flush">
            <a href="#" class="text-center text-primary fw-bold border-bottom border-light py-3">Notifications</a>
            <a href="#" class="list-group-item list-group-item-action border-bottom">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <!-- Avatar -->
                        <img alt="Image placeholder" src="../../assets/img/team/profile-picture-1.jpg" class="avatar-md rounded">
                    </div>
                    <div class="col ps-0 ms-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="h6 mb-0 text-small">Jose Leos</h4>
                            </div>
                            <div class="text-end">
                                <small class="text-danger">a few moments ago</small>
                            </div>
                        </div>
                        <p class="font-small mt-1 mb-0">Added you to an event "Project stand-up" tomorrow at 12:30 AM.</p>
                    </div>
                </div>
            </a>
            <a href="#" class="list-group-item list-group-item-action border-bottom">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <!-- Avatar -->
                        <img alt="Image placeholder" src="../../assets/img/team/profile-picture-2.jpg" class="avatar-md rounded">
                    </div>
                    <div class="col ps-0 ms-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="h6 mb-0 text-small">Neil Sims</h4>
                            </div>
                            <div class="text-end">
                                <small class="text-danger">2 hrs ago</small>
                            </div>
                        </div>
                        <p class="font-small mt-1 mb-0">You've been assigned a task for "Awesome new project".</p>
                    </div>
                </div>
            </a>
            <a href="#" class="list-group-item list-group-item-action border-bottom">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <!-- Avatar -->
                        <img alt="Image placeholder" src="<?php echo base_url('assets/img/team/profile-picture-3.jpg'); ?>" class="avatar-md rounded">
                    </div>
                    <div class="col ps-0 m-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="h6 mb-0 text-small">Roberta Casas</h4>
                            </div>
                            <div class="text-end">
                                <small>5 hrs ago</small>
                            </div>
                        </div>
                        <p class="font-small mt-1 mb-0">Tagged you in a document called "Financial plans",</p>
                    </div>
                </div>
            </a>
            <a href="#" class="list-group-item list-group-item-action border-bottom">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <!-- Avatar -->
                        <img alt="Image placeholder" src="<?php echo base_url('assets/img/team/profile-picture-4.jpg'); ?>" class="avatar-md rounded">
                    </div>
                    <div class="col ps-0 ms-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="h6 mb-0 text-small">Joseph Garth</h4>
                            </div>
                            <div class="text-end">
                                <small>1 d ago</small>
                            </div>
                        </div>
                        <p class="font-small mt-1 mb-0">New message: "Hey, what's up? All set for the presentation?"</p>
                    </div>
                </div>
            </a>
            <a href="#" class="list-group-item list-group-item-action border-bottom">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <!-- Avatar -->
                        <img alt="Image placeholder" src="assets/img/team/profile-picture-5.jpg" class="avatar-md rounded">
                    </div>
                    <div class="col ps-0 ms-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="h6 mb-0 text-small"><?= session()->get('name') ?> <?= session()->get('surname') ?></h4>
                            </div>
                            <div class="text-end">
                                <small>2 hrs ago</small>
                            </div>
                        </div>
                        <p class="font-small mt-1 mb-0">New message: "We need to improve the UI/UX for the landing page."</p>
                    </div>
                </div>
            </a>
            <a href="#" class="dropdown-item text-center fw-bold rounded-bottom py-3">
                <svg class="icon icon-xxs text-gray-400 me-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path></svg>
                View all
            </a>
        </div>
    </div>
</li>