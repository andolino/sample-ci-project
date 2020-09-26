var tbl_portal_loans_by_request = [];
var tbl_portal_loan_req_attmnt = [];
var tbl_portal_benefit_req_attmnt = [];
$(document).ready(function () {
  
  $(document).on("click", "#btnViewProfile", function (e) {
    $.ajax({
      type: "POST",
      url: "view-portal-profile",
      data: {  },
      // dataType: "JSON",
      success: function (res) {
        $('.custom-container').html(res);

        $( "div.picture-cont" )
        .mouseenter(function() {
          $('.upload-ctrl').removeClass('none');
        })
        .mouseleave(function() {
          $('.upload-ctrl').addClass('none');
        });

      }
    });
  });
  
  $(document).on("click", "#btnLoanRequest", function (e) {
    $.ajax({
      type: "POST",
      url: "view-loan-request-frm",
      data: {  },
      // dataType: "JSON",
      success: function (res) {
        $('.custom-container').html(res);

        $( "div.picture-cont" )
        .mouseenter(function() {
          $('.upload-ctrl').removeClass('none');
        })
        .mouseleave(function() {
          $('.upload-ctrl').addClass('none');
        });
        initLoanRequestDataTables();
        
        $('.co-maker').select2({
          width: '100%',
          maximumSelectionLength: 2
        });
      }
    });
  });
  
  $(document).on("click", "#btnContribution", function (e) {
    $.ajax({
      type: "POST",
      url: "view-contribution-frm",
      data: {  },
      // dataType: "JSON",
      success: function (res) {
        $('.custom-container').html(res);

        // $( "div.picture-cont" )
        // .mouseenter(function() {
        //   $('.upload-ctrl').removeClass('none');
        // })
        // .mouseleave(function() {
        //   $('.upload-ctrl').addClass('none');
        // });
        // initLoanRequestDataTables();
        
        // $('.co-maker').select2({
        //   width: '100%',
        //   maximumSelectionLength: 2
        // });
      }
    });
  });
  
  $(document).on("click", "#btnBenefitClaimReq", function (e) {
    $.ajax({
      type: "POST",
      url: "view-benefit-claim-frm",
      data: {  },
      // dataType: "JSON",
      success: function (res) {
        $('.custom-container').html(res);

        // $( "div.picture-cont" )
        // .mouseenter(function() {
        //   $('.upload-ctrl').removeClass('none');
        // })
        // .mouseleave(function() {
        //   $('.upload-ctrl').addClass('none');
        // });
        initBenefitRequestDataTables();
        
        // $('.co-maker').select2({
        //   width: '100%',
        //   maximumSelectionLength: 2
        // });
      }
    });
  });

  $(document).on('click', '#membersOfContributionPortalPdf', function(e) {
    e.preventDefault();
    var m_id          = $(this).attr('data-id');
    window.location.href = baseURL + 'get-members-print-to-pdf/'+m_id; 
  });

  $(document).on("click", '#btn-view-attachment', function (e) {
    var id = $(this).attr('data-id');
    var field = $(this).attr('data-field');
    initLoanRequestAttmntDataTables(id, field);
    animateSingleOut('.req-ln-tbl', 'fadeOut');
    setTimeout(function(){
      animateSingleIn('.req-ln-attmnt', 'fadeIn');
    }, 1000);
  });
  
  $(document).on("click", '#btn-view-comment', function (e) {
    var id = $(this).attr('data-id');
    var field = $(this).attr('data-field');
    animateSingleOut('.req-ln-tbl', 'fadeOut');
    $.ajax({
      type: "POST",
      url: "view-ln-req-msg",
      data: { "id" : id, 'field': field },
      success: function (res) {
        $('.req-ln-msg-container').html(res);
        setTimeout(function(){
          animateSingleIn('.req-ln-msg', 'fadeIn');
        }, 1000);
      }
    });
    
  });


  $(document).on('submit', '#frm-update-member', function(e) {
    e.preventDefault();
    e.stopImmediatePropagation();
    var frm = $(this).serialize(); 
    $.ajax({
      url      : 'save-member-info',
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
          }).appendTo('#frm-update-member');
          // $('#frm-update-member').trigger('reset');
        }
      }
    });
  });

  $(document).on("submit", "#frm-update-password", function (e) {
    e.preventDefault();
    $.ajax({
      type: "POST",
      url: "update-mem-password",
      data: $(this).serialize(),
      dataType: "JSON",
      success: function (res) {
        Swal.fire(
          res.param1,
          res.param2,
          res.param3
        );
        $('#newpw').modal('hide');
      }
    });
  });
  
  $(document).on("change", "#loan_code_id", function (e) {
    $.ajax({
      type: "POST",
      url: "get-loan-settings",
      data: { 'loan_code_id': $(this).val() },
      success: function (res) {
        $('.mo-term-n-amnt').html(res);
        animateSingleIn('.mo-term-n-amnt', 'fadeIn');
      }
    });
  });

  $(document).on("submit", "#frm-request-a-loan", function (e) {
    e.preventDefault();
    var frm = new FormData(this);
    var dcom = [];
    $.each($(".co-maker").select2('data'), function (i, v) { 
      dcom.push(v.id);
    });
    frm.append('co-maker-id', dcom);   
    $.ajax({
      url:'upload-files',
      type:"post",
      data: frm,
      processData:false,
      contentType:false,
      cache:false,
      async:false,
      dataType: 'json',
      success: function(res){
        Swal.fire(
          res.param1,
          res.param2,
          res.param3
        );
        animateSingleOut('.req-ln-frm', 'fadeOut');
        setTimeout(function(){ animateSingleIn('.req-ln-tbl', 'fadeIn'); },1000);
        tbl_portal_loans_by_request.ajax.reload();
      }
    });
  });

  $(document).on("submit", "#frm-request-a-benefit", function (e) {
    e.preventDefault();
    var frm = new FormData(this);
    $.ajax({
      url:'upload-files-benefit',
      type:"post",
      data: frm,
      processData:false,
      contentType:false,
      cache:false,
      async:false,
      dataType: 'json',
      success: function(res){
        Swal.fire(
          res.param1,
          res.param2,
          res.param3
        );
        animateSingleOut('.req-ln-frm', 'fadeOut');
        setTimeout(function(){ animateSingleIn('.req-ln-tbl', 'fadeIn'); },1000);
        tbl_portal_benefit_req_attmnt.ajax.reload();
      }
    });
  });

});





function initLoanRequestDataTables(){
  var myObjKeyLguConst = {};
  tbl_portal_loans_by_request  = $("#tbl-portal-loan-request-list").DataTable({
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
        className            : 'text-right', 
        targets              : [3,4] 
      }
    ],
    "serverSide"               : true,
    "processing"               : true,
    "responsive"               : true,
    "ajax"                     : {
        "url"                  : 'server-portal-loans-request',
        "type"                 : 'POST',
        // "data"                 : { 
        //                         "id" : $("#tbl-portal-loan-request-list").attr('data-id')
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
  new $.fn.dataTable.FixedHeader( tbl_portal_loans_by_request );

}


function initBenefitRequestDataTables(){
  var myObjKeyLguConst = {};
  tbl_portal_benefit_req_attmnt  = $("#tbl-portal-benefit-request-list").DataTable({
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
        className            : 'text-right', 
        targets              : [3,4] 
      }
    ],
    "serverSide"               : true,
    "processing"               : true,
    "responsive"               : true,
    "ajax"                     : {
        "url"                  : 'server-portal-benefit-request',
        "type"                 : 'POST',
        // "data"                 : { 
        //                         "id" : $("#tbl-portal-benefit-request-list").attr('data-id')
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
  new $.fn.dataTable.FixedHeader( tbl_portal_benefit_req_attmnt );

}

function initLoanRequestAttmntDataTables(id, field){
  var myObjKeyLguConst = {};
  var data = {};
  if (field=='loan_request') {
    data["loan_req_id"] = id;
  } else {
    data["benefit_req_id"] = id;
  }
  $('#tbl-portal-loan-request-attmnt').DataTable().clear().destroy();
  tbl_portal_loan_req_attmnt  = $("#tbl-portal-loan-request-attmnt").DataTable({
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
      }
    ],
    "serverSide"               : true,
    "processing"               : true,
    "responsive"               : true,
    "ajax"                     : {
        "url"                  : 'server-portal-loan-request-attmnt',
        "type"                 : 'POST',
        "data"                 : data
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