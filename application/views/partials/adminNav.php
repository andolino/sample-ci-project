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
			<?php if($userPriv->level == 0): ?>
      <li>
        <a href="<?php echo base_url(); ?>member-list"><i class="fas fa-tasks"></i> MEMBER LIST</a>
      </li>
			<?php endif; ?> 
      <?php if($userPriv->level == 0 || $userPriv->level == 1): ?>
				<li class="active">
						<a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-hand-holding-usd"></i> LOANS</a>
						<ul class="collapse list-unstyled" id="homeSubmenu">
								<li>
										<a href="<?php echo base_url(); ?>loan-by-member">LOAN BY MEMBER</a>
								</li>
								<li>
										<a href="<?php echo base_url(); ?>loan-request">LOAN REQUEST</a>
								</li>
								<li>
										<a href="<?php echo base_url(); ?>loan-list">LOANS LIST</a>
								</li>
								<li>
										<a href="<?php echo base_url(); ?>loans-application">LOAN APPLICATION</a>
								</li>
								<!-- <li>
										<a href="#">COLLECTION</a>
								</li> -->
								<!-- <li>
										<a href="<?php //echo base_url(); ?>claim-benefit">BENEFIT CLAIMS</a>
								</li>
								<li>
										<a href="<?php //echo base_url(); ?>official-receipt">COLLECTION</a>
								</li>
								<li>
										<a href="<?php //echo base_url(); ?>cash-gift">CASH GIFT</a>
								</li> -->
						</ul>
				</li>
			<?php endif; ?> 
			<?php if($userPriv->level == 0 || $userPriv->level == 2): ?>
			<li>
        <a href="<?php echo base_url(); ?>official-receipt"><i class="fas fa-user-cog"></i> COLLECTION</a>
      </li>
			<?php endif; ?> 
			<?php if($userPriv->level == 0 || $userPriv->level == 3): ?>
      <li class="active">
						<a href="#benefitCSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-hand-holding-usd"></i> BENEFIT CLAIMS</a>
						<ul class="collapse list-unstyled" id="benefitCSubmenu">
								<li>
										<a href="<?php echo base_url(); ?>claim-benefit">MEMBERS</a>
								</li>
								<li>
										<a href="<?php echo base_url(); ?>benefit-request">MEMBER'S REQUEST</a>
								</li>
								<!-- <li>
										<a href="#">COLLECTION</a>
								</li> -->
								<!-- <li>
										<a href="<?php //echo base_url(); ?>claim-benefit">BENEFIT CLAIMS</a>
								</li>
								<li>
										<a href="<?php //echo base_url(); ?>official-receipt">COLLECTION</a>
								</li>
								<li>
										<a href="<?php //echo base_url(); ?>cash-gift">CASH GIFT</a>
								</li> -->
						</ul>
				</li>
			<?php endif; ?> 
			<?php if($userPriv->level == 0 || $userPriv->level == 1): ?>
			<li>
        <a href="<?php echo base_url(); ?>cash-gift"><i class="fas fa-user-cog"></i> CASH GIFT</a>
      </li>
			<?php endif; ?> 
			<?php if($userPriv->level == 0 || $userPriv->level == 4): ?>
      <li>
        <a href="#acctgSubMenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-book-open"></i> ACCOUNTING</a>
        <ul class="collapse list-unstyled" id="acctgSubMenu">
            <li>
                <a href="<?php echo base_url(); ?>general-journal">GJ</a>
            </li>
            <li>
                <a href="<?php echo base_url(); ?>crj-transaction">CRJ</a>
            </li>
            <li>
                <a href="<?php echo base_url(); ?>cdj-transaction">CDJ</a>
            </li>
            <li>
                <a href="<?php echo base_url(); ?>pacs-transaction">PACS</a>
            </li>
            <li>
                <a href="#">ANNUAL CLOSING</a>
            </li>
        </ul>
      </li>
      <li>
        <a href="#acctgRepSubMenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-paste"></i> ACCTG REPORTS</a>
        <ul class="collapse list-unstyled" id="acctgRepSubMenu">
            <li>
                <a href="<?php echo base_url(); ?>gj-posted">GJ</a>
            </li>
            <li>
                <a href="<?php echo base_url(); ?>crj-posted">CRJ</a>
            </li>
            <li>
                <a href="<?php echo base_url(); ?>cdj-posted">CDJ</a>
            </li>
            <li>
                <a href="<?php echo base_url(); ?>pacs-posted">PACS</a>
            </li>
            <li>
                <a href="<?php echo base_url(); ?>general-ledger">GENERAL LEDGER</a>
            </li>
            <li>
                <a href="<?php echo base_url(); ?>trial-balance">TRIAL BALANCE</a>
            </li>
            <li>
                <a href="<?php echo base_url(); ?>balance-sheet">BALANCE SHEET</a>
            </li>
            <li>
                <a href="<?php echo base_url(); ?>income-statement">INCOME STATEMENT</a>
            </li>
        </ul>
      </li>
			<?php endif; ?> 
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
                  <!-- <a class="nav-link" href="<?php //echo base_url('settings'); ?>"><i class="fas fa-cog"></i> Settings</a> -->
                </li>
                <li class="nav-item active">
                  <a class="nav-link" href="<?php echo base_url() . $go_logout; ?>"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
