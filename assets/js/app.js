$(window).on('load', function(){
  //remove loading
  animateSingleIn('.custom-container', 'fadeInUp');
  animateSingleOut('.spinner-cont', 'fadeOut');

    
});

//datatable var array
var tbl_member = [];
var tbl_settings = [];
var tbl_loans_list = [];
var tbl_loans_by_member = [];
$(document).ready(function() {
  //init plugin
  // $("body").tooltip({ selector: '[data-toggle=tooltip]' });
  initDateDefault();

  //for numeric values input
  $(document).on("focusout", '.isNum', function(e){
    $(this).val(isNaN(parseFloat($(this).val().replace(',',''))) ? '0' : number_format($(this).val().replace(',', '')));
  });
  $(document).on("change, keyup", '.isNum', function(e){
    var currentInput = $(this).val();
    var fixedInput = currentInput.replace(/[A-Za-z!@#$%^&*()]/g, '');
    $(this).val(fixedInput);
  });

  //load data-page
  $(document).on('click', '#loadPage', function(event) {
    var link          = $(this).attr('data-link');
    var d             = $(this).attr('data-ind');
    var dataBadgeHead = $(this).attr('data-badge-head');
    var acls          = $(this).attr('data-cls');
    // $(this).tooltip('hide');
    $('.custom-container').html('');
    $.get(baseURL + link, { 'data' : d }, function(data, textStatus, xhr) {
      $('.custom-container').html(data);
      $( "div.picture-cont" )
      .mouseenter(function() {
        $('.upload-ctrl').removeClass('none');
      })
      .mouseleave(function() {
        $('.upload-ctrl').addClass('none');
      });
      $('#badge-heading').html(dataBadgeHead);

      animateSingleIn('.'+acls, 'fadeInUp');
      
      animateSingleIn('.cont-tbl-constituent', 'fadeIn');
      initMembersDataTables();
      initLoanSettingsDataTables();
      initLoanListDataTables();
      initLoanListByMemberDataTables();



    });    
  });

  //init datatable list
  initMembersDataTables();
  initLoanSettingsDataTables();
  initLoanListDataTables();
  initLoanListByMemberDataTables();

  //form submit
  $(document).on('click', '#btnPickDatePay', function(e) {
    $('#frm-pick-date-pay').trigger('submit');
    $(this).prop('disabled', true);
  });
  $(document).on('click', 'input[name="chk-select-payment-sched"]', function(event) {
    $('#btnPickDatePay').prop('disabled', false);
  });
  $(document).on('submit', '#frm-pick-date-pay', function(e) {
    e.preventDefault();
    var totalAmntArr   = [];
    var totalAmnt      = 0;
    var dateSchedToPay = [];
    var loanSchedID = [];
    $(this).find('input[type="checkbox"]:checked').each(function(i, el){
      totalAmntArr.push($(this).parents('tr').find('td').eq(3).html());
      dateSchedToPay.push($(this).parents('tr').find('td').eq(1).html());
      loanSchedID.push($(this).val());
      totalAmnt = totalAmnt + strToFloat($(this).parents('tr').find('td').eq(3).html());
    });
    console.log(loanSchedID);
    $('input[name="period_start"]').val(dateSchedToPay[0]);
    var lastSched = dateSchedToPay.pop();
    $('input[name="period_end"]').val(lastSched);
    $('input[name="tot_amnt"]').val(number_format(totalAmnt));
    $('input[name="loanSchedID"]').val(loanSchedID.join('|'));
  });
  $(document).on('submit', '#frm-add-payments', function(e) {
    e.preventDefault();
    var frm = $(this).serialize();

    customSwal(
        'btn btn-success', 
        'btn btn-danger mr-2', 
        'Yes', 
        'Wait', 
        ['Hey!', 'Are you sure you want to post this payment?', 'info'], 
        function(){
            $.ajax({
              url      : 'save-post-payment',
              type     : 'POST',
              dataType : 'JSON',
              data     : frm,
              context  : this,
              success  : function(res){
                Swal.fire(
                  res.param1,
                  res.param2,
                  res.param3
                );
              }
            });
          }, function(){
            console.log('Fail');
      });


    
    
  });
  $(document).on('submit', '#frm-sub-acct', function(e) {
    e.preventDefault();
    var frmData = $(this).serialize();
    $.post('save-sub-account', frmData, function(data, textStatus, xhr) {
      var res = $.parseJSON(data);
      Swal.fire(
        res.param1,
        res.param2,
        res.param3
      );
      animateSingleOut('.coa-card-add', 'fadeOutRight');
      setTimeout(function(){
        $('a[data-link="view-setting-page"]').trigger('click');
      }, 1000);
    });
  });

  $(document).on('submit', '#frm-add-loans', function(e) {
    e.preventDefault();
    var frmData = $(this).serialize();
    $.post('save-loans-settings', frmData, function(data, textStatus, xhr) {
      var res = $.parseJSON(data);
      Swal.fire(
        res.param1,
        res.param2,
        res.param3
      );
      animateSingleOut('.loans-card-add', 'fadeOutRight');
      setTimeout(function(){
       tbl_settings.ajax.reload();
      }, 1000);
    });
  });


  //============================> LGU
  $(document).on('submit', '#frm-add-member', function(e) {
    e.preventDefault();
    e.stopImmediatePropagation();
    var frm = $(this).serialize(); 
    $.ajax({
      url      : 'save-member',
      type     : 'POST',
      data     : frm,
      dataType : 'JSON',
      success  : function(res) {
        // console.log(typeof res.length);
        console.log(res);
        // typeof res.length === 'undefined'
        if (!res.hasOwnProperty('members_id')) {
          $.each(res, function(index, el) {
            if ($('#'+index).parent('div').find('div.invalid-feedback').length == 0) {
              $('#'+index).parent('div').append('<div class="invalid-feedback">'+el+'</div>').show();
              $('#'+index).parent('div').find('div.invalid-feedback').show();
            } else {
              $('#'+index).parent('div').find('div.invalid-feedback').html(el).show();
            }
            $(document).on('change input', '#'+index, function(){
              $('#'+index).parent('div').find('div.invalid-feedback').hide();
            });
          });
        } else {
          Swal.fire(
            'Success!',
            'You successfully saved!',
            'success'
          );
          $('<input>').attr({
              type: 'hidden',
              id: 'has_update',
              name: 'has_update',
              value: res.members_id
          }).appendTo('#frm-add-member');
          // $('#frm-add-member').trigger('reset');
        }
      }
    });
  });

  //custom
  $(document).on('click', '#view-monthly-schedule', function(e) {
    e.preventDefault();
    var comp_id = $(this).attr('data-comp-id');
    $.get('show-schedule-list', {'id': comp_id}, function(data) {
      $('#custom-modal .modal-content').html(data);
      $('#custom-modal .modal-dialog').addClass('modal-lg');
      $('#custom-modal .modal-title').html('<i class="fas fa-list-alt"></i> SELECT SCHEDULE LIST');
      $('#custom-modal').modal('show', { backdrop: 'static' });
    });
  });

  $(document).on('click', '#postThisLoan', function(e) {
    e.preventDefault();
    var id = $(this).attr('data-id');
    customSwal(
        'btn btn-success', 
        'btn btn-danger mr-2', 
        'Yes', 
        'Wait', 
        ['Hey!', 'Are you sure you want to post this loan?', 'info'], 
        function(){
            $.ajax({
              url      : 'post-loan-comp',
              type     : 'POST',
              dataType : 'JSON',
              context  : this,
              data     : { 'id':id },
              success: function (res){
                Swal.fire(
                  res.param1,
                  res.param2,
                  res.param3
                );
                if (res.param3 == 'success') {
                  $('#is_posted').val('Posted');
                }
              }
            });
          }, function(){
            console.log('Fail');
      });
  });
  $(document).on('change', 'select[name="coa-select"]', function(e) {
    e.preventDefault();
    var val = $(this).val();
    if (val==1) {
      $.get('show-sub-frm', function(data, textStatus) {
        $('.coa-cont-add').html(data);
        $('.title-coa-form').html('ADD SUB ACCOUNT');
        animateSingleIn('.coa-card-add', 'fadeInRight');
      });
    } else if(val==2){
      $.get('show-main-frm', function(data, textStatus) {
        $('.coa-cont-add').html(data);
        $('.title-coa-form').html('ADD MAIN ACCOUNT');
        animateSingleIn('.coa-card-add', 'fadeInRight');
      });
    }
  });

  $(document).on('click', '#btn-add-loans', function(e) {
    e.preventDefault();
    var id   = $(this).attr('data-id');
    var type = $(this).attr('data-field');
    $.get('show-loans-settings-frm', { 'id':id }, function(data, textStatus) {
      $('.loans-cont-add').html(data);
      $('.title-loans-form').html(type+' LOAN SETTINGS');
      animateSingleIn('.loans-card-add', 'fadeInRight');
    });
  });  

  $(document).on('click', '#btn-add-payments', function(e) {
    e.preventDefault();
    var id   = $(this).attr('data-id');
    var type = $(this).attr('data-field');
    $.get('show-frm-add-payments', { 'id':id }, function(data, textStatus) {
      $('.loans-cont-add').html(data);
      $('.title-loans-form').html(type + ' PAYMENTS');
      animateSingleIn('.loans-card-add', 'fadeInRight');
    });

  });  

  //================================================> LGU
  $(document).on('click', '#chk-const-list-tbl-all', function(e) {
    var rows = tbl_member.rows({ 'search': 'applied' }).nodes();
    $('input[type="checkbox"]', rows).prop('checked', this.checked);
    if ($(this).is(':checked')) {
      $('#view_id_selected').removeAttr('disabled');
    } else {
      $('#view_id_selected').prop('disabled', true);
    }
  });

  $(document).on('click', '#chk-const-list-tbl', function(e) {
    var d = []; 
    $.each($('.chk-const-list-tbl'), function(i, el) {
      d[i]=$(el).is(':checked').toString();
    });
    if ($.inArray('true', d) !== -1) {
      $('#view_id_selected').removeAttr('disabled');
    } else {
      $('#view_id_selected').prop('disabled', true);
    }
  });

  $(document).on('click', '#generate-token', function(event) {
    event.preventDefault();
    $.ajax({
      url: 'generate-token',
      type: 'POST',
      dataType: 'JSON',
      success: function(res){
        $('input[name="token"]').val(res.token);
        $('input[name="secret-key"]').val(res.encrypt_key);
      }
    });
  });

  $(document).on('submit', '#frm-add-token-key', function(e) {
    e.preventDefault();
    var frm = $(this).serialize();
    $.ajax({
      url: 'save-token',
      type: 'POST',
      dataType: 'JSON',
      data: frm,
      success: function(res){
        Swal.fire(
          res.param1,
          res.param2,
          res.param3
        );
      }
    });

  });
  
  $(document).on('click', '#view_id_selected', function(e) {
    e.preventDefault();
    var _ids = [];
    $('input[name="chk-const-list-tbl[]"]:checked').each(function(i, el){
      _ids.push($(el).val());
    });
    $.ajax({
      url       : 'show-multiple-ids',
      type      : 'POST',
      dataType  : 'JSON',
      data      : {'ids' : _ids},
      success   : function(res){
        window.open(baseURL + 'show-mltple-const/' + res.ids);
      }
    });
    
  });
  

  $(document).on('change', 'input[name=upload-file-dp]', function(e) {
    e.preventDefault();

  });

  $(document).on('click', '#add-children-field', function(e) {
    e.preventDefault();
    var ht = '';
    ht += '<div class="col-4 mt-2">';
      ht += '<label for="children_name" class="font-12">Children\'s Name</label>';
      ht += '<input type="text" class="form-control form-control-sm" id="children_name" name="children_name[]" placeholder="...">';
    ht += '</div>';
    ht += '<div class="col-7 mt-2 pl-0">';
      ht += '<label for="children_birth_place" class="font-12">Birth Place</label>';
      ht += '<input type="text" class="form-control form-control-sm" id="children_birth_place" name="children_birth_place[]" placeholder="...">';
    ht += '</div>';
    ht += '<div class="col-1 mt-4 pt-3 pl-0" id="children-sect">';
      ht += '<button type="button" class="btn btn-warning btn-sm font-12" id="ded-children-field"><i class="fas fa-minus"></i></button> | ';
      ht += '<button type="button" class="btn btn-success btn-sm font-12" id="add-children-field"><i class="fas fa-plus"></i></button>';
    ht += '</div>';
    $(ht).insertAfter($(this).parent('div'));
  });

  $(document).on('click', '#add-govt-field', function(e) {
    e.preventDefault();
    var ht = '';
    ht += '<div class="col-12"></div>';
      ht += '<div class="col-3 mt-2 govt-name-cont">';
      ht += $('.govt-name-cont').html();
      ht += '</div>';
    ht += '<div class="col-3 mt-2 pl-0">';
      ht += '<label for="govt_id" class="font-12">Gov\'t ID #</label>';
      ht += '<input type="text" class="form-control form-control-sm" id="govt_id" name="govt_id[]" placeholder="...">';
    ht += '</div>';
    ht += '<div class="col-1 mt-4 pt-3 pl-0" id="addgovt-sect">';
      ht += '<button type="button" class="btn btn-warning btn-sm font-12" id="ded-govt-field"><i class="fas fa-minus"></i></button> | ';
      ht += '<button type="button" class="btn btn-success btn-sm font-12" id="add-govt-field"><i class="fas fa-plus"></i></button>';
    ht += '</div>';
    $(ht).insertAfter($(this).parent('div'));
  });

  $(document).on('click', '#ded-children-field', function(e) {
    e.preventDefault();
    $(this).parent('div#children-sect').prev().remove();
    $(this).parent('div#children-sect').prev().remove();
    $(this).parent('div#children-sect').remove();
  });

  $(document).on('click', '#ded-govt-field', function(e) {
    e.preventDefault();
    $(this).parent('div#addgovt-sect').prev().remove();
    $(this).parent('div#addgovt-sect').prev().remove();
    $(this).parent('div#addgovt-sect').prev().remove();
    $(this).parent('div#addgovt-sect').remove();
  });

  $(document).on('click', 'input[name="social_status[]"]', function(e) {
    var val = $(this).val();
    if ($(this).is(':checked')) {
      // if ($(this).val() == 1) {
        $('.social_status'+val).append('<input type="text" class="form-control form-control-sm mt-2" id="pwd_id" name="pwd_id[]" placeholder="ID #">');
      // }
    } else {
      // if ($(this).val() == 1) {
        $('.social_status'+val).find('#pwd_id').remove();
        $('.social_status'+val).find('div.invalid-feedback').remove();
      // }
    }
  });

  $(document).on('change', 'select[name="religion"]', function(e) {
    e.preventDefault();
    if ($(this).val() == 3) {
      $('.rel-cont').append('<input type="text" class="form-control form-control-sm mt-2" id="religion_desc" name="religion_desc" placeholder="Write here..">');
    } else {
      $('#religion_desc').remove();  
    }
  });

  $(document).on('change', '#upload-file-dp', function() {
    $('.spinner-cont').removeClass('none');
    $('#frm-upload-dp').trigger('submit');
  });

  $(document).on('change', 'input[name="date_processed"]', function(e) {
    e.preventDefault();
    var val_mo = $('select[name="no_mos_applied"]').val();
    $('select[name="no_mos_applied"]').val(val_mo).trigger('change');
  });

  $(document).on('change', 'select[name="no_mos_applied"]', function(e) {
    e.preventDefault();
    var loan_settings_id = $(this).val();
    //process computation
    if ($('input[name="monthly_salary"]').val() < 0 || $('input[name="monthly_salary"]').val() == '') {
      Swal.fire(
        'Sorry!',
        'Sorry Please update monthly salary!',
        'warning'
      );
      // setTimeout(function(){
      $("#no_mos_applied").val($("#no_mos_applied option:first").val());
      // }, 1000);
    } else if($('input[name="date_processed"]').val() == ''){
      Swal.fire(
        'Sorry!',
        'Sorry Please input date processed!',
        'warning'
      );
      $("#no_mos_applied").val($("#no_mos_applied option:first").val());
    } else {
      $('select[name="repayment_period"]').val(loan_settings_id).trigger('change');
      var frm = $('#frm-save-loancomp').serialize();
      $.ajax({
        url      : 'compute-loans',
        type     : 'POST',
        dataType : 'JSON',
        data     : frm,
        success  : function(res){
          $.each(res, function(index, el) {
            $('input[name="'+index+'"]').val((typeof el == 'string' ? el : number_format(el)));
          });
        }
      });
    }
  });

  $(document).on('click', '#saveLoansComp', function(e) {
    $('#frm-save-loancomp').trigger('submit');
  });

  $(document).on('submit', '#frm-save-loancomp', function(e) {
    e.preventDefault();
    var frm = $(this).serializeArray();
    if ($(this).valid()) {
      customSwal(
        'btn btn-success', 
        'btn btn-danger mr-2', 
        'Yes', 
        'Wait', 
        ['Hey!', 'Are you sure you want to save this loan?', 'warning'], 
        function(){
            $.ajax({
              url      : 'save-loan-comp',
              type     : 'POST',
              dataType : 'JSON',
              context  : this,
              data     : $('#frm-save-loancomp').serialize(),
              success: function (res){
                Swal.fire(
                  res.param1,
                  res.param2,
                  res.param3
                );
                if (res.id > 0) {
                  $('input[name="has_update"]').val(res.id);
                }
                window.open(baseURL+'pdf-vloan-comp')
              }
            });
          }, function(){
            console.log('Fail');
      });


      
    }
  });

  $(document).on('submit', '#frm-upload-dp', function(e) {
    e.preventDefault();
    var frm = new FormData(this);
    frm.append('lgu-cons-id', $(this).find('input[type="hidden"]').val());
    
    $.ajax({
      url:'upload-dp',
      type:"post",
      data: frm,
      processData:false,
      contentType:false,
      cache:false,
      async:false,
      dataType: 'json',
      success: function(data){
        if (data.success) {
          Swal.fire(
            'Success!',
            'Picture Successfully Updated!',
            'success'
          );
        } else {
          Swal.fire(
            'Oopps!',
            'Looks like there was an error encountered!',
            'warning'
          );
        }
        // alert("Upload Image Successful.");
        $('#lgu-captured-image').attr('src', baseURL + 'assets/image/uploads/' + data.file_name);
        animateSingleOut('.spinner-cont', 'fadeOut');
      }
    });
  });

  $(document).on('click', '#remove-lgu-const-list', function(e) {
    e.preventDefault();
    var id = $(this).attr('data-id');
    customSwal(
      'btn btn-success', 
      'btn btn-danger mr-2', 
      'Yes', 
      'Wait', 
      ['Hey!', 'Are you sure you want to delete this member?', 'warning'], 
      function(){
      $.post('delete-member', {'id': id}, function(data, textStatus, xhr) {
        Swal.fire(
          'Alright!',
          'Successfully Deleted!',
          'success'
        );
        tbl_member.ajax.reload();
      });
      
    }, function(){
      console.log('Fail');
    });
  });

  $(document).on('click', '#removeLoanSettings', function(e) {
    e.preventDefault();
    var id = $(this).attr('data-id');
    customSwal(
      'btn btn-success', 
      'btn btn-danger mr-2', 
      'Yes', 
      'Wait', 
      ['Hey!', 'Are you sure you want to delete this loans?', 'warning'], 
      function(){
      $.post('delete-loan-settings', {'id': id}, function(data, textStatus, xhr) {
        Swal.fire(
          'Alright!',
          'Successfully Deleted!',
          'success'
        );
        tbl_settings.ajax.reload();
      });
      
    }, function(){
      console.log('Fail');
    });
  });


});


/* FUNCTIONS */
// animate single element in
function animateSingleIn(element, animation, focus = null) {
  $(element).addClass('animated ' + animation).removeClass('none');
  setTimeout(function() {
      $(element).removeClass('animated ' + animation);
      focus != null ? $(focus).focus() : null;
  }, 1000);
}

// animate single element out
function animateSingleOut(element, animation) {
  $(element).addClass('animated ' + animation);
  setTimeout(function() {
      $(element).removeClass('animated ' + animation).addClass('none');
  }, 1000);
}

function doUploadDb(){
  $('input[name=upload-file-dp]').trigger('click');
}



function customSwal(confrmBtn, canclBtn, confrmTxt, canclTxt, headingArr=array(), funCalback, failCalback){
  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: confrmBtn,
      cancelButton: canclBtn
    },
    buttonsStyling: false
  });

  swalWithBootstrapButtons.fire({
    title             : headingArr[0],
    text              : headingArr[1],
    icon              : headingArr[2],
    showCancelButton  : true,
    confirmButtonText : confrmTxt,
    cancelButtonText  : canclTxt,
    reverseButtons    : true
  }).then((result) => {
    if (result.value) {
      funCalback();
    } else if (
      /* Read more about handling dismissals below */
      result.dismiss === Swal.DismissReason.cancel
    ) {
      failCalback();
    }
  });
}

// format numbers to currency format
function number_format(amount) {
  var formatted_amount = parseFloat(amount)
          .toFixed(2)
          .toString()
          .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  return formatted_amount;
}

//init datatables =====================================================>
function initMembersDataTables(){
  var myObjKeyLguConst = {};
  tbl_member  = $("#tbl-member-list").DataTable({
    searchHighlight : true,
    lengthMenu      : [[5, 10, 20, 30, 50, -1], [5, 10, 20, 30, 50, 'All']],
    language: {
        search                 : '_INPUT_',
        searchPlaceholder      : 'Search...',
        lengthMenu             : '_MENU_'       
    },
    columnDefs                 : [
      { 
        orderable            : false, 
        targets              : [0,1,2,3,4,5,6,7,8] 
      }
    ],
    "serverSide"               : true,
    "processing"               : true,
    "ajax"                     : {
        "url"                  : 'server-tbl-members',
        "type"                 : 'POST',
        "data"                 : { 
                                "page" : $("#tbl-member-list").attr('data-page')
                              }
    },
    'createdRow'            : function(row, data, dataIndex) {
      var dataRowAttrIndex = ['data-lgu-const-id'];
      var dataRowAttrValue = [0];
        for (var i = 0; i < dataRowAttrIndex.length; i++) {
          myObjKeyLguConst[dataRowAttrIndex[i]] = data[dataRowAttrValue[i]];
        }
        $(row).attr(myObjKeyLguConst);
    }
  });
}
function initLoanSettingsDataTables(){
  var myObjKeyLguConst = {};
  tbl_settings  = $("#tbl-settings").DataTable({
    searchHighlight : true,
    lengthMenu      : [[5, 10, 20, 30, 50, -1], [5, 10, 20, 30, 50, 'All']],
    language: {
        search                 : '_INPUT_',
        searchPlaceholder      : 'Search...',
        lengthMenu             : '_MENU_'       
    },
    columnDefs                 : [
      { 
        orderable            : false, 
        targets              : [0,1,2,3,4,5,6,7] 
      },
      { 
        className            : 'text-right', 
        targets              : [1,2,3,4,5,6] 
      }
    ],
    "serverSide"               : true,
    "processing"               : true,
    "ajax"                     : {
        "url"                  : 'server-tbl-settings',
        "type"                 : 'POST',
        "data"                 : { 
                                "page" : $("#tbl-member-list").attr('data-page')
                              }
    },
    'createdRow'            : function(row, data, dataIndex) {
      var dataRowAttrIndex = ['data-loan-settings'];
      var dataRowAttrValue = [0];
        for (var i = 0; i < dataRowAttrIndex.length; i++) {
          myObjKeyLguConst[dataRowAttrIndex[i]] = data[dataRowAttrValue[i]];
        }
        $(row).attr(myObjKeyLguConst);
    }
  });
}

function initLoanListDataTables(){
  var myObjKeyLguConst = {};
  tbl_loans_list  = $("#tbl-loan-list").DataTable({
    searchHighlight : true,
    lengthMenu      : [[5, 10, 20, 30, 50, -1], [5, 10, 20, 30, 50, 'All']],
    language: {
        search                 : '_INPUT_',
        searchPlaceholder      : 'Search...',
        lengthMenu             : '_MENU_'       
    },
    columnDefs                 : [
      { 
        orderable            : false, 
        targets              : [0,1,2,3,4,5] 
      },
      { 
        className            : 'text-right', 
        targets              : [3,4,5] 
      }
    ],
    "serverSide"               : true,
    "processing"               : true,
    "ajax"                     : {
        "url"                  : 'server-tbl-loans-list',
        "type"                 : 'POST',
        "data"                 : { 
                                "id" : $("#tbl-loan-list").attr('data-id')
                              }
    },
    'createdRow'            : function(row, data, dataIndex) {
      var dataRowAttrIndex = ['data-loan-settings'];
      var dataRowAttrValue = [0];
        for (var i = 0; i < dataRowAttrIndex.length; i++) {
          myObjKeyLguConst[dataRowAttrIndex[i]] = data[dataRowAttrValue[i]];
        }
        $(row).attr(myObjKeyLguConst);
    }
  });
}

function initLoanListByMemberDataTables(){
  var myObjKeyLguConst = {};
  tbl_loans_by_member  = $("#tbl-loans-by-member").DataTable({
    searchHighlight : true,
    lengthMenu      : [[5, 10, 20, 30, 50, -1], [5, 10, 20, 30, 50, 'All']],
    language: {
        search                 : '_INPUT_',
        searchPlaceholder      : 'Search...',
        lengthMenu             : '_MENU_'       
    },
    columnDefs                 : [
      { 
        orderable            : false, 
        targets              : [0,1,2,3,4,5,6] 
      },
      { 
        className            : 'text-right', 
        targets              : [4,5] 
      },
      { 
        className            : 'text-center', 
        targets              : [6] 
      }
    ],
    "serverSide"               : true,
    "processing"               : true,
    "ajax"                     : {
        "url"                  : 'server-loans-by-member',
        "type"                 : 'POST',
        "data"                 : { 
                                "id" : $("#tbl-loans-by-member").attr('data-id')
                              }
    },
    'createdRow'            : function(row, data, dataIndex) {
      var dataRowAttrIndex = ['data-loan-settings'];
      var dataRowAttrValue = [0];
        for (var i = 0; i < dataRowAttrIndex.length; i++) {
          myObjKeyLguConst[dataRowAttrIndex[i]] = data[dataRowAttrValue[i]];
        }
        $(row).attr(myObjKeyLguConst);
    }
  });
}

//init datatables END =====================================================>

//init datepicker 'YYYY-MM'
function initDateDefault(){
  $(".dp-ym").datepicker({
    dateFormat: 'yy-mm',
    changeMonth: true,
    changeYear: true,
    showButtonPanel: true,

    onClose: function(dateText, inst) {
        var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
        var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
        $(this).val($.datepicker.formatDate('yy-mm', new Date(year, month, 1)));
    }
  });
  $(".dp-ym").focus(function () {
  $(".ui-datepicker-calendar").hide();
    $("#ui-datepicker-div").position({
      my: "center top",
      at: "center bottom",
      of: $(this)
    });
  });
}

function strToFloat(stringValue) {
    stringValue = stringValue.trim();
    var result = stringValue.replace(/[^0-9]/g, '');
    if (/[,\.]\d{2}$/.test(stringValue)) {
        result = result.replace(/(\d{2})$/, '.$1');
    }
    return parseFloat(result);
}

//computation =====================================================>
function goCompute(){

}

