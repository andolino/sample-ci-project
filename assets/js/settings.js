$(document).ready(function() {
  
  //load data-page
  $(document).on('click', '#loadSidePage', function(event) {
    var link  = $(this).attr('data-link');
    var title = $(this).attr('data-title');
    var id    = $(this).attr('data-id');
    var fn    = $(this).attr('data-fn');
    // $(this).tooltip('hide');
    $.post(link, { 'id' : id, 'fn': fn  }, function(data, textStatus, xhr) {
      $('.cont-add-body').html(data);
      $('.title-cont-form').html(title);
      animateSingleIn('.cont-card-add', 'fadeInRight');

      $('select[name="departments_id"]').select2({
        placeholder: 'Select Department',
        allowClear: true
      });

      $('select[name="employee_id"]').select2({
        placeholder: "Selec Member's ID",
        allowClear: true
      });

    });    
  });

  $(document).on('change', '.is-invalid', function(e) {
    e.preventDefault();
    $(this).removeClass('is-invalid');
  });

  $(document).on('click', '#updateContributionRate', function(e) {
    e.preventDefault();
    $.ajax({
      url: 'get-frm-contribution-rate',
      type: 'POST',
      success: function(res){
        $('.cont-add-body').html(res);
        $('.title-cont-form').html('UPDATE CONTRIBUTION RATE');
        animateSingleIn('.cont-card-add', 'fadeInRight');

      }
    });
    
  });

 $(document).on('submit', '#frm-users-settings', function(e) {
    e.preventDefault();
    var frm = $(this).serialize();
    customSwal(
        'btn btn-success', 
        'btn btn-danger mr-2', 
        'Yes', 
        'Wait', 
        ['', 'Are you sure you want to save ?', 'question'], 
        function(){
            $.ajax({
              url       : 'save-users-data',
              type      : 'POST',
              dataType  : 'JSON',
              data      : frm,
              context   : this,
              success   : function(res){
                if (res.msg == 'fail') {
                  $('input').removeClass('is-valid is-invalid');
                  $('select').removeClass('is-valid is-invalid');
                  $('.err-msg').html('');
                  $.each(res, function(index, el) {
                    console.log(index, el);
                    $('input[name="'+index+'"]').addClass('is-invalid');
                    $('select[name="'+index+'"]').addClass('is-invalid');
                    $('.'+index).addClass('invalid-feedback').html(el);
                  });
                } else {
                  Swal.fire(
                    'Success!',
                    'Users Successfully Registered!',
                    'success'
                  );
                  animateSingleOut('.cont-card-add', 'fadeOutRight')
                  tbl_users.ajax.reload();
                }
              }
            });
          }, function(){
            console.log('Fail');
      });
  
  });

 $(document).on('submit', '#frm-contribution-rate', function(e) {
    e.preventDefault();
    var frm = $(this).serialize();
    customSwal(
        'btn btn-success', 
        'btn btn-danger mr-2', 
        'Yes', 
        'Wait', 
        ['', 'Are you sure you want to update ?', 'question'], 
        function(){
            $.ajax({
              url       : 'save-contribution-rate',
              type      : 'POST',
              dataType  : 'JSON',
              data      : frm,
              context   : this,
              success   : function(res){
                Swal.fire(
                  'Success!',
                  'Users Successfully Updated!',
                  'success'
                );
                animateSingleOut('.cont-card-add', 'fadeOutRight')
                tbl_contribution_rate.ajax.reload();
              }
            });
          }, function(){
            console.log('Fail');
      });
  
  });

  $(document).on('submit', '#frm-signatory-settings', function(e) {
    e.preventDefault();
    var frm = $(this).serializeArray();
    frm.push({name: 'tbl', value: 'signatory'});
    frm.push({name: 'pk_key', value: 'signatory_id'});
    frm.push({name: 'unique', value: 'signatory_name'});
    customSwal(
        'btn btn-success', 
        'btn btn-danger mr-2', 
        'Yes', 
        'Wait', 
        ['', 'Are you sure you want to save ?', 'question'], 
        function(){
          $.ajax({
            url: 'add-data',
            type: 'POST',
            dataType: 'JSON',
            data: frm,
            success: function(res){
              if (res.param3 == 'success') {
                tbl_signatory.ajax.reload();
              }
              Swal.fire(
                res.param1,
                res.param2,
                res.param3
              );
              animateSingleOut('.cont-card-add', 'fadeOutRight');
            }
          });
          
          }, function(){
            console.log('Fail');
      });
  });


  $(document).on('submit', '#frm-subsidiary-settings', function(e) {
    e.preventDefault();
    var frm = $(this).serializeArray();
    frm.push({name: 'tbl', value: 'account_subsidiary'});
    frm.push({name: 'pk_key', value: 'account_subsidiary_id'});
    frm.push({name: 'unique', value: 'sub_code'});
    customSwal(
        'btn btn-success', 
        'btn btn-danger mr-2', 
        'Yes', 
        'Wait', 
        ['', 'Are you sure you want to save ?', 'question'], 
        function(){
          $.ajax({
            url: 'add-data',
            type: 'POST',
            dataType: 'JSON',
            data: frm,
            success: function(res){
              if (res.param3 == 'success') {
                tbl_subsidiary.ajax.reload();
              }
              Swal.fire(
                res.param1,
                res.param2,
                res.param3
              );
              animateSingleOut('.cont-card-add', 'fadeOutRight');
            }
          });
          
          }, function(){
            console.log('Fail');
      });
  });

  $(document).on('submit', '#frm-office-settings', function(e) {
    e.preventDefault();
    var frm = $(this).serializeArray();
    frm.push({name: 'tbl', value: 'office_management'});
    frm.push({name: 'pk_key', value: 'office_management_id'});
    frm.push({name: 'unique', value: 'office_code'});
    customSwal(
        'btn btn-success', 
        'btn btn-danger mr-2', 
        'Yes', 
        'Wait', 
        ['', 'Are you sure you want to save ?', 'question'], 
        function(){
          $.ajax({
            url: 'add-data',
            type: 'POST',
            dataType: 'JSON',
            data: frm,
            success: function(res){
              if (res.param3 == 'success') {
                tbl_office.ajax.reload();
              }
              Swal.fire(
                res.param1,
                res.param2,
                res.param3
              );
              animateSingleOut('.cont-card-add', 'fadeOutRight');
            }
          });
          }, function(){
            console.log('Fail');
      });
  });

  $(document).on('submit', '#frm-member-type-settings', function(e) {
    e.preventDefault();
    var frm = $(this).serializeArray();
    frm.push({name: 'tbl', value: 'member_type'});
    frm.push({name: 'pk_key', value: 'member_type_id'});
    frm.push({name: 'unique', value: 'type'});
    customSwal(
        'btn btn-success', 
        'btn btn-danger mr-2', 
        'Yes', 
        'Wait', 
        ['', 'Are you sure you want to save ?', 'question'], 
        function(){
          $.ajax({
            url: 'add-data',
            type: 'POST',
            dataType: 'JSON',
            data: frm,
            success: function(res){
              if (res.param3 == 'success') {
                tbl_member_type.ajax.reload();
              }
              Swal.fire(
                res.param1,
                res.param2,
                res.param3
              );
              animateSingleOut('.cont-card-add', 'fadeOutRight');
            }
          });
          
          }, function(){
            console.log('Fail');
      });
  });

  $(document).on('submit', '#frm-civil-status-settings', function(e) {
    e.preventDefault();
    var frm = $(this).serializeArray();
    frm.push({name: 'tbl', value: 'civil_status'});
    frm.push({name: 'pk_key', value: 'civil_status_id'});
    frm.push({name: 'unique', value: 'status'});
    customSwal(
        'btn btn-success', 
        'btn btn-danger mr-2', 
        'Yes', 
        'Wait', 
        ['', 'Are you sure you want to save ?', 'question'], 
        function(){
          $.ajax({
            url: 'add-data',
            type: 'POST',
            dataType: 'JSON',
            data: frm,
            success: function(res){
              if (res.param3 == 'success') {
                tbl_civil_status.ajax.reload();
              }
              Swal.fire(
                res.param1,
                res.param2,
                res.param3
              );
              animateSingleOut('.cont-card-add', 'fadeOutRight');
            }
          });
          
          }, function(){
            console.log('Fail');
      });
  });

  $(document).on('submit', '#frm-departments-settings', function(e) {
    e.preventDefault();
    var frm = $(this).serializeArray();
    frm.push({name: 'tbl', value: 'departments'});
    frm.push({name: 'pk_key', value: 'departments_id'});
    frm.push({name: 'unique', value: 'region'});
    customSwal(
        'btn btn-success', 
        'btn btn-danger mr-2', 
        'Yes', 
        'Wait', 
        ['', 'Are you sure you want to save ?', 'question'], 
        function(){
          $.ajax({
            url: 'add-data',
            type: 'POST',
            dataType: 'JSON',
            data: frm,
            success: function(res){
              if (res.param3 == 'success') {
                tbl_departments.ajax.reload();
              }
              Swal.fire(
                res.param1,
                res.param2,
                res.param3
              );
              animateSingleOut('.cont-card-add', 'fadeOutRight');
            }
          });
          
          }, function(){
            console.log('Fail');
      });
  });

  $(document).on('submit', '#frm-relationship-type-settings', function(e) {
    e.preventDefault();
    var frm = $(this).serializeArray();
    frm.push({name: 'tbl', value: 'relationship_type'});
    frm.push({name: 'pk_key', value: 'relationship_type_id'});
    frm.push({name: 'unique', value: 'rel_type'});
    customSwal(
        'btn btn-success', 
        'btn btn-danger mr-2', 
        'Yes', 
        'Wait', 
        ['', 'Are you sure you want to save ?', 'question'], 
        function(){
          $.ajax({
            url: 'add-data',
            type: 'POST',
            dataType: 'JSON',
            data: frm,
            success: function(res){
              if (res.param3 == 'success') {
                tbl_relationship_type.ajax.reload();
              }
              Swal.fire(
                res.param1,
                res.param2,
                res.param3
              );
              animateSingleOut('.cont-card-add', 'fadeOutRight');
            }
          });
          
          }, function(){
            console.log('Fail');
      });
  });

  $(document).on('submit', '#frm-beneficiaries-settings', function(e) {
    e.preventDefault();
    var frm = $(this).serializeArray();
    frm.push({name: 'tbl', value: 'beneficiaries'});
    frm.push({name: 'pk_key', value: 'beneficiaries_id'});
    frm.push({name: 'unique', value: 'name'});
    customSwal(
        'btn btn-success', 
        'btn btn-danger mr-2', 
        'Yes', 
        'Wait', 
        ['', 'Are you sure you want to save ?', 'question'], 
        function(){
          $.ajax({
            url: 'add-data',
            type: 'POST',
            dataType: 'JSON',
            data: frm,
            success: function(res){
              if (res.param3 == 'success') {
                tbl_beneficiaries.ajax.reload();
              }
              Swal.fire(
                res.param1,
                res.param2,
                res.param3
              );
              animateSingleOut('.cont-card-add', 'fadeOutRight');
            }
          });
          
          }, function(){
            console.log('Fail');
      });
  });

  $(document).on('submit', '#frm-immediate-family-settings', function(e) {
    e.preventDefault();
    var frm = $(this).serializeArray();
    frm.push({name: 'tbl', value: 'immediate_family'});
    frm.push({name: 'pk_key', value: 'immediate_family_id'});
    frm.push({name: 'unique', value: 'name'});
    customSwal(
        'btn btn-success', 
        'btn btn-danger mr-2', 
        'Yes', 
        'Wait', 
        ['', 'Are you sure you want to save ?', 'question'], 
        function(){
          $.ajax({
            url: 'add-data',
            type: 'POST',
            dataType: 'JSON',
            data: frm,
            success: function(res){
              if (res.param3 == 'success') {
                tbl_immediate_family.ajax.reload();
              }
              Swal.fire(
                res.param1,
                res.param2,
                res.param3
              );
              animateSingleOut('.cont-card-add', 'fadeOutRight');
            }
          });
          
          }, function(){
            console.log('Fail');
      });
  });

  $(document).on('submit', '#frm-loan-types', function(e) {
    e.preventDefault();
    var frm = $(this).serializeArray();
    frm.push({name: 'tbl', value: 'loan_code'});
    frm.push({name: 'pk_key', value: 'loan_code_id'});
    frm.push({name: 'unique', value: 'loan_code'});
    customSwal(
        'btn btn-success', 
        'btn btn-danger mr-2', 
        'Yes', 
        'Wait', 
        ['', 'Are you sure you want to save ?', 'question'], 
        function(){
          $.ajax({
            url: 'add-data',
            type: 'POST',
            dataType: 'JSON',
            data: frm,
            success: function(res){
              if (res.param3 == 'success') {
                tbl_loan_type.ajax.reload();
              }
              Swal.fire(
                res.param1,
                res.param2,
                res.param3
              );
              animateSingleOut('.cont-card-add', 'fadeOutRight');
            }
          });
          
          }, function(){
            console.log('Fail');
      });
  });

  $(document).on('submit', '#frm-benefit-type-settings', function(e) {
    e.preventDefault();
    var frm = $(this).serializeArray();
    frm.push({name: 'tbl', value: 'benefit_type'});
    frm.push({name: 'pk_key', value: 'benefit_type_id'});
    frm.push({name: 'unique', value: 'type_of_benefit'});
    customSwal(
        'btn btn-success', 
        'btn btn-danger mr-2', 
        'Yes', 
        'Wait', 
        ['', 'Are you sure you want to save ?', 'question'], 
        function(){
          $.ajax({
            url: 'add-data',
            type: 'POST',
            dataType: 'JSON',
            data: frm,
            success: function(res){
              if (res.param3 == 'success') {
                tbl_benefit_type.ajax.reload();
              }
              Swal.fire(
                res.param1,
                res.param2,
                res.param3
              );
              animateSingleOut('.cont-card-add', 'fadeOutRight');
            }
          });
          
          }, function(){
            console.log('Fail');
      });
  });


});


function initUsersDataTables(){
  var myObjKeyLguConst = {};
  tbl_users  = $("#tbl-user-settings").DataTable({
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
        targets              : [0,1,2,3,4] 
      },
      { 
        className            : 'text-center', 
        targets              : [4] 
      }
      // { 
      //   className            : 'text-center', 
      //   targets              : [6] 
      // }
    ],
    "serverSide"               : true,
    "processing"               : true,
    "ajax"                     : {
        "url"                  : 'server-users',
        "type"                 : 'POST',
        // "data"                 : { 
        //                         "id" : $("#tbl-loans-by-member").attr('data-id')
        //                       }
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

function initSignatoryDataTables(){
  var myObjKeyLguConst = {};
  tbl_signatory  = $("#tbl-signatory-settings").DataTable({
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
        targets              : [0,1,2] 
      },
      { 
        className            : 'text-center', 
        targets              : [2] 
      }
      // { 
      //   className            : 'text-center', 
      //   targets              : [6] 
      // }
    ],
    "serverSide"               : true,
    "processing"               : true,
    "ajax"                     : {
        "url"                  : 'server-signatory',
        "type"                 : 'POST',
        // "data"                 : { 
        //                         "id" : $("#tbl-loans-by-member").attr('data-id')
        //                       }
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

function initSubsidiaryDataTables(){
  var myObjKeyLguConst = {};
  tbl_subsidiary  = $("#tbl-subsidiary-settings").DataTable({
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
        targets              : [0,1,2,3,4] 
      },
      { 
        className            : 'text-center', 
        targets              : [4] 
      }
      // { 
      //   className            : 'text-center', 
      //   targets              : [6] 
      // }
    ],
    "serverSide"               : true,
    "processing"               : true,
    "ajax"                     : {
        "url"                  : 'server-subsidiary',
        "type"                 : 'POST',
        // "data"                 : { 
        //                         "id" : $("#tbl-loans-by-member").attr('data-id')
        //                       }
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

function initOfficeDataTables(){
  var myObjKeyLguConst = {};
  tbl_office  = $("#tbl-office-settings").DataTable({
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
        targets              : [0,1,2] 
      },
      { 
        className            : 'text-center', 
        targets              : [2] 
      }
      // { 
      //   className            : 'text-center', 
      //   targets              : [6] 
      // }
    ],
    "serverSide"               : true,
    "processing"               : true,
    "ajax"                     : {
        "url"                  : 'server-office',
        "type"                 : 'POST',
        // "data"                 : { 
        //                         "id" : $("#tbl-loans-by-member").attr('data-id')
        //                       }
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

function initMemberTypeDataTables(){
  var myObjKeyLguConst = {};
  tbl_member_type  = $("#tbl-member-type-settings").DataTable({
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
        targets              : [0,1] 
      },
      { 
        className            : 'text-center', 
        targets              : [1] 
      }
      // { 
      //   className            : 'text-center', 
      //   targets              : [6] 
      // }
    ],
    "serverSide"               : true,
    "processing"               : true,
    "ajax"                     : {
        "url"                  : 'server-member-type',
        "type"                 : 'POST',
        // "data"                 : { 
        //                         "id" : $("#tbl-loans-by-member").attr('data-id')
        //                       }
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

function initCivilStatusDataTables(){
  var myObjKeyLguConst = {};
  tbl_civil_status  = $("#tbl-civil-status-settings").DataTable({
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
        targets              : [0,1] 
      },
      { 
        className            : 'text-center', 
        targets              : [1] 
      }
      // { 
      //   className            : 'text-center', 
      //   targets              : [6] 
      // }
    ],
    "serverSide"               : true,
    "processing"               : true,
    "ajax"                     : {
        "url"                  : 'server-civil-status',
        "type"                 : 'POST',
        // "data"                 : { 
        //                         "id" : $("#tbl-loans-by-member").attr('data-id')
        //                       }
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

function initRelationshipTypeDataTables(){
  var myObjKeyLguConst = {};
  tbl_relationship_type  = $("#tbl-relationship-type-settings").DataTable({
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
        targets              : [0,1] 
      },
      { 
        className            : 'text-center', 
        targets              : [1] 
      }
      // { 
      //   className            : 'text-center', 
      //   targets              : [6] 
      // }
    ],
    "serverSide"               : true,
    "processing"               : true,
    "ajax"                     : {
        "url"                  : 'server-relationship-type',
        "type"                 : 'POST',
        // "data"                 : { 
        //                         "id" : $("#tbl-loans-by-member").attr('data-id')
        //                       }
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

function initBeneficiariesDataTables(){
  var myObjKeyLguConst = {};
  tbl_beneficiaries  = $("#tbl-beneficiaries-settings").DataTable({
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
        targets              : [0,1] 
      },
      { 
        className            : 'text-center', 
        targets              : [1] 
      }
      // { 
      //   className            : 'text-center', 
      //   targets              : [6] 
      // }
    ],
    "serverSide"               : true,
    "processing"               : true,
    "ajax"                     : {
        "url"                  : 'server-beneficiaries',
        "type"                 : 'POST',
        "data"                 : { 
                                "id" : $("#tbl-beneficiaries-settings").attr('data-id')
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

function initMembersBeneficiariesDataTables(){
  var myObjKeyLguConst = {};
  // tbl_member.destroy();
  tbl_member  = $("#tbl-members-ben").DataTable({
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
        targets              : [0,1,2,3] 
      },
      { 
        className            : 'text-center', 
        targets              : [3] 
      }
      // { 
      //   className            : 'text-center', 
      //   targets              : [6] 
      // }
    ],
    "serverSide"               : true,
    "processing"               : true,
    "ajax"                     : {
        "url"                  : 'server-members-beneficiaries',
        "type"                 : 'POST',
        // "data"                 : { 
        //                         "id" : $("#tbl-loans-by-member").attr('data-id')
        //                       }
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

function initMembersImmediateFamilyDataTables(){
  var myObjKeyLguConst = {};
  $('#tbl-members').DataTable().clear().destroy();
  tbl_member  = $("#tbl-members").DataTable({
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
        targets              : [0,1,2,3] 
      },
      { 
        className            : 'text-center', 
        targets              : [3] 
      }
      // { 
      //   className            : 'text-center', 
      //   targets              : [6] 
      // }
    ],
    "serverSide"               : true,
    "processing"               : true,
    "ajax"                     : {
        "url"                  : 'server-members-immediate-family',
        "type"                 : 'POST',
        // "data"                 : { 
        //                         "id" : $("#tbl-loans-by-member").attr('data-id')
        //                       }
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

function initImmediateFamilyDataTables(){
  var myObjKeyLguConst = {};
  tbl_immediate_family  = $("#tbl-immediate-family-settings").DataTable({
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
        targets              : [0,1] 
      },
      { 
        className            : 'text-center', 
        targets              : [1] 
      }
      // { 
      //   className            : 'text-center', 
      //   targets              : [6] 
      // }
    ],
    "serverSide"               : true,
    "processing"               : true,
    "ajax"                     : {
        "url"                  : 'server-immediate-family',
        "type"                 : 'POST',
        // "data"                 : { 
        //                         "id" : $("#tbl-loans-by-member").attr('data-id')
        //                       }
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

function initLoanTypeDataTables(){
  var myObjKeyLguConst = {};
  tbl_loan_type  = $("#tbl-loan-types-settings").DataTable({
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
        targets              : [0,1,2] 
      },
      { 
        className            : 'text-center', 
        targets              : [2] 
      }
      // { 
      //   className            : 'text-center', 
      //   targets              : [6] 
      // }
    ],
    "serverSide"               : true,
    "processing"               : true,
    "ajax"                     : {
        "url"                  : 'server-loan-type',
        "type"                 : 'POST',
        // "data"                 : { 
        //                         "id" : $("#tbl-loans-by-member").attr('data-id')
        //                       }
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

function initDepartmentsDataTables(){
  var myObjKeyLguConst = {};
  tbl_departments  = $("#tbl-departments-settings").DataTable({
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
        targets              : [0,1,2] 
      },
      { 
        className            : 'text-center', 
        targets              : [2] 
      }
      // { 
      //   className            : 'text-center', 
      //   targets              : [6] 
      // }
    ],
    "serverSide"               : true,
    "processing"               : true,
    "ajax"                     : {
        "url"                  : 'server-departments',
        "type"                 : 'POST',
        // "data"                 : { 
        //                         "id" : $("#tbl-loans-by-member").attr('data-id')
        //                       }
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

function initBenefitTypeDataTables(){
  var myObjKeyLguConst = {};
  tbl_benefit_type  = $("#tbl-benefit-type-settings").DataTable({
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
        targets              : [0,1] 
      },
      { 
        className            : 'text-center', 
        targets              : [1] 
      }
      // { 
      //   className            : 'text-center', 
      //   targets              : [6] 
      // }
    ],
    "serverSide"               : true,
    "processing"               : true,
    "ajax"                     : {
        "url"                  : 'server-benefit-type',
        "type"                 : 'POST',
        // "data"                 : { 
        //                         "id" : $("#tbl-loans-by-member").attr('data-id')
        //                       }
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

function initContributionRateDataTables(){
  var myObjKeyLguConst = {};
  tbl_contribution_rate  = $("#tbl-contribution-rate").DataTable({
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
        targets              : [0,1,2] 
      },
      { 
        className            : 'text-center', 
        targets              : [1,2] 
      }
      // { 
      //   className            : 'text-center', 
      //   targets              : [6] 
      // }
    ],
    "serverSide"               : true,
    "processing"               : true,
    "ajax"                     : {
        "url"                  : 'server-contribution-rate',
        "type"                 : 'POST',
        // "data"                 : { 
        //                         "id" : $("#tbl-loans-by-member").attr('data-id')
        //                       }
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

function initProcessContributionDataTables(){
  var myObjKeyLguConst = {};
  tbl_process_contribution  = $("#tbl-processs-contribution").DataTable({
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
        targets              : [3,4] 
      },
      { 
        className            : 'text-left', 
        targets              : [0] 
      }
      // { 
      //   className            : 'text-center', 
      //   targets              : [6] 
      // }
    ],
    "serverSide"               : true,
    "processing"               : true,
    "ajax"                     : {
        "url"                  : 'server-process-contribution',
        "type"                 : 'POST',
        "data"                 : { 
                                // "id" : $("#tbl-loans-by-member").attr('data-id')
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


function initProcessLoanPaymentsDataTables(){
  var myObjKeyLguConst = {};
  tbl_process_loan_payments  = $("#tbl-processs-loan-payments").DataTable({
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
        targets              : [3,4,5] 
      },
      { 
        className            : 'text-left', 
        targets              : [0] 
      }
      // { 
      //   className            : 'text-center', 
      //   targets              : [6] 
      // }
    ],
    "serverSide"               : true,
    "processing"               : true,
    "ajax"                     : {
        "url"                  : 'server-process-loan-payments',
        "type"                 : 'POST',
        "data"                 : { 
                                // "id" : $("#tbl-loans-by-member").attr('data-id')
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

function removeData(d){
  var id  = d.getAttribute('data-id');
  var tbl = d.getAttribute('data-tbl');
  var fld = d.getAttribute('data-field');
  customSwal(
    'btn btn-success', 
    'btn btn-danger mr-2', 
    'Yes', 
    'Wait',   
    ['', 'Are you sure you want to delete ?', 'question'], 
    function(){
        $.post('delete-data', {'tbl' : tbl, 'w': fld, 'v': id}, function(data, textStatus, xhr) {
          tbl_users.ajax.reload();
          tbl_signatory.ajax.reload();
          tbl_office.ajax.reload();
          tbl_member_type.ajax.reload();
          tbl_civil_status.ajax.reload();
          tbl_relationship_type.ajax.reload();
          tbl_beneficiaries.ajax.reload();
          tbl_immediate_family.ajax.reload();
          tbl_loan_type.ajax.reload();
          tbl_benefit_type.ajax.reload();
          tbl_subsidiary.ajax.reload();
          tbl_departments.ajax.reload();
        });
      }, function(){
        console.log('Fail');
  });
}