<!-- Sidebar  -->
<nav id="sidebar">
  <div class="sidebar-header">
    <div class="row">
      <div class="col-3"><img src="<?= base_url('assets/image/misc/logo.png') ?>" width="50"></div>
      <div class="col-9"><h4 style="line-height: 2.1">CPFI SYSTEM </h4></div>
    </div>
    
  </div>

  <ul class="list-unstyled components">
      <p class="text-center"> WELCOME <?php echo strtoupper($this->session->username); ?></p>
      <li>
        <a href="<?php echo base_url(); ?>" class="font-12"><i class="fas fa-users"></i> ABOUT US</a>
      </li>
      <li>
        <a href="<?php echo base_url(); ?>member-list"><i class="fas fa-tasks"></i> MEMBER LIST</a>
      </li>
      <li class="none">
        <a href="<?php echo base_url(); ?>loans-control"><i class="fas fa-user-cog"></i> LOANS</a>
      </li>
      <li class="none">
        <a href="<?php echo base_url(); ?>control-token"><i class="fas fa-user-cog"></i> ACCESSS CONTROL</a>
      </li>
      <li class="active">
          <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-hand-holding-usd"></i> LOANS</a>
          <ul class="collapse list-unstyled" id="homeSubmenu">
              <li>
                  <a href="#">LOAN BY MEMBER</a>
              </li>
              <li>
                  <a href="#">LOANS LIST</a>
              </li>
              <li>
                  <a href="<?php echo base_url(); ?>loans-application">LOAN APPLICATION</a>
              </li>
          </ul>
      </li>
  </ul>

</nav>

        <!-- Page Content  -->
<div id="content">
<nav class="navbar navbar-expand-lg navbar-light bg-light mb-3">
    <div class="container-fluid">
        <button type="button" id="sidebarCollapse" class="btn btn-default mr-3">
            <i class="fas fa-align-left"></i>
            <!-- <span>Toggle Sidebar</span> -->
        </button>
        <button class="btn btn-dark d-inline-block d-lg-none ml-auto " type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-align-justify"></i>
        </button>
        <h4 class="mb-0" id="badge-heading"><?php echo $heading; ?></h4>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="nav navbar-nav ml-auto">
                <li class="nav-item active">
                  <a class="nav-link" href="<?php echo base_url('settings'); ?>"><i class="fas fa-cog"></i> Settings</a>
                </li>
                <li class="nav-item active">
                  <a class="nav-link" href="<?php echo base_url() . $go_logout; ?>"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>