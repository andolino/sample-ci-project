
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
                    <a class="nav-link" href="<?php echo base_url() . $go_logout; ?>"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- <div class="navbar mb-3">
 <div class="row">
    <div class="col pr-0 border-right">
      <button type="button" class="btn btn-default btn-md rounded-0" id="loadPage" data-link="show-gen-token" data-ind="" data-cls="cont-add-token"><i class="fas fa-user-plus"></i> Show Token</button>
    </div>
    <div class="col pl-0">
      <button type="button" class="btn btn-default btn-md rounded-0" id="view_id_selected"><i class="fas fa-print"></i> View ID Selected</button>
    </div>
  </div> 
</div>-->
<div class="navbar bg-light custom-container none">
  <form id="frm-add-token-key">
    <div class="row">
      <div class="col-3">
        <label for="token" class="font-12">TOKEN</label>
        <input type="text" class="form-control form-control-sm" id="token" name="token" value="<?php echo !empty($data) ? $data->token : '--'; ?>" placeholder="...">
      </div>
      <div class="col-5 pl-0">
        <label for="secret-key" class="font-12">SECRET KEY</label>
        <input type="text" class="form-control form-control-sm" id="secret-key" name="secret-key" value="<?php echo !empty($data) ? $data->secret_key : '--'; ?>" placeholder="...">
      </div>
      <div class="col-4 pl-0 mt-4 pt-1">
        <button type="button" id="generate-token" class="btn btn-default btn-sm rounded-0 border"><i class="fas fa-redo-alt"></i> GENERATE TOKEN</button>
        <button type="submit" class="btn btn-info btn-sm rounded-0 border"><i class="fas fa-save"></i> SAVE TOKEN</button>
      </div>  
    </div>  
  </form>
<div class="line"></div>
    
</div>