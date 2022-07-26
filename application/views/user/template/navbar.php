<?php
    if(!$this->session->userdata('isLoggedIn')) {
        redirect('');
    }
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <div class="d-flex align-items-center col-lg-3">
      <a class="navbar-brand" href="<?= base_url(); ?>">Petsbook</a>
      <div class="d-none d-lg-block">
        <input type="search" id="searchBox" class="form-control" placeholder="Search PetsBook" />
      </div>
    </div>
    <button
      class="navbar-toggler"
      type="button"
      data-mdb-toggle="collapse"
      data-mdb-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <i class="fas fa-bars"></i>
    </button>
    <div class="collapse navbar-collapse col-lg-9" id="navbarSupportedContent">
      <ul class="navbar-nav col-lg-8 justify-content-center mb-2 mb-lg-0">
        <li class="nav-item d-lg-none">
          <input type="search" id="searchBoxCollapse" class="form-control" placeholder="Search PetsBook" />
        </li>
        <li class="nav-item mx-lg-2">
          <a class="nav-link" href="<?= base_url(); ?>">Home</a>
        </li>
        <li class="nav-item mx-lg-2">
          <a class="nav-link" href="<?= base_url(); ?>marketplace">Marketplace</a>
        </li>
        <li class="nav-item mx-lg-2">
          <a class="nav-link" href="<?= base_url(); ?>friends">Friends</a>
        </li>
      </ul>
      <ul class="navbar-nav d-flex flex-row col-lg-4 justify-content-lg-end">
        <!-- Notification dropdown -->
        <li class="nav-item dropdown me-3 mx-lg-3">
          <a
            class="nav-link dropdown-toggle hidden-arrow"
            href="#"
            id="navbarDropdownMenuLink"
            role="button"
            data-mdb-toggle="dropdown"
            data-mdb-auto-close="outside"
            aria-expanded="false"
          >
            <i class="fas fa-bell"></i>
            <span class="badge rounded-pill badge-notification bg-danger" id="notifCount"></span>
          </a>
          <ul
            class="dropdown-menu dropdown-menu-lg-end dropdown-menu-start infinite-scrol"
            aria-labelledby="navbarDropdownMenuLink"
            id="notification"
            style="min-width: 250px; min-height: 150px;"
          >
            <div class="container">
              <div class="row align-items-center pt-2">
                <div class="col-6 d-flex justify-content-start"><span class="fs-6 fw-bold dropdown-header p-0">Notification</span></div>
                <div class="col-6 d-flex justify-content-end dropdown">
                  <a class="text-dark dropdown-toggle hidden-arrow" href="#" role="button" id="dropdownMenuLink" data-mdb-toggle="dropdown"                         data-mdb-auto-close="outside" aria-expanded="false"><span class="p-1 rounded-circle d-flex justify-content-center align-items-center" style="cursor: pointer; height: 30px; width: 30px; background-color: rgba(33,37,37,0.15);"><i class="fas fa-ellipsis-h"></span></i></a>
                  <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink">
                    <li><a href="" class="dropdown-item" id="notifMarkRead" onclick="markAllRead()">Mark all as read</a></li>
                    <li><a class="dropdown-item" href="<?= base_url(); ?>notifications">See all</a></li>
                  </ul>
                </div>
              </div>
            </div>
            <div id="notificationBody">
            </div>
          </ul>
        </li>
        <!-- Notification dropdown -->
        <!-- Chat -->
        <li class="nav-item mx-3 mx-lg-2">
          <a
            class="nav-link"
            href="<?= base_url(); ?>chat"
          >
            <i class="fas fa-comment"></i>
            <span class="badge rounded-pill badge-notification bg-danger" id="messageCount"></span>
          </a>
        </li>
        <!-- Chat -->
        <!-- Avatar -->
        <li class="nav-item dropdown mx-3 ms-lg-2 hiddenNavigation">
          <a
            class="nav-link dropdown-toggle d-flex align-items-center hidden-arrow"
            href="#"
            id="navbarDropdownMenuLink"
            role="button"
            data-mdb-toggle="dropdown"
            aria-expanded="false"
          >
            <span class="me-2 overflow-hidden" style="max-width:95px;"></span>
            <img
              src="<?= $this->session->userdata('profilePicture'); ?>"
              class="rounded-circle"
              height="22"
              width="22"
              alt=""
              loading="lazy"
              style="object-fit: cover;"
            />
          </a>
          <ul class="dropdown-menu dropdown-menu-lg-end dropdown-menu-start" aria-labelledby="navbarDropdownMenuLink">
            <li>
              <a class="dropdown-item" href="<?= base_url(); ?>profile/<?= $this->session->userdata('userId'); ?>"><i class="fas fa-user-alt me-2"></i>My profile</a>
            </li>
            <li>
              <a class="dropdown-item" href="<?= base_url(); ?>api/logout"><i class="fas fa-sign-out-alt me-2"></i>Logout</a>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>