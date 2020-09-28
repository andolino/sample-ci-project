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
var tbl_loans_by_request_pending = [];
var tbl_loans_by_request_approved = [];
var tbl_loans_by_request_disapproved = [];
var tbl_co_maker = [];
var tbl_users = [];
var tbl_signatory = [];
var tbl_subsidiary = [];
var tbl_office = [];
var tbl_member_type = [];
var tbl_civil_status = [];
var tbl_relationship_type = [];
var tbl_beneficiaries = [];
var tbl_immediate_family = [];
var tbl_loan_type = [];
var tbl_benefit_type = [];
var tbl_departments = [];
var tbl_contribution = [];
var tbl_benefit_claimed_list = [];
var tbl_cdj_entry = [];
var tbl_pacs_entry = [];
var tbl_gj_entry = [];
var tbl_crj_entry = [];
var tbl_contribution_rate = [];
var tbl_cash_gift = [];
var tbl_official_receipt = [];
var tbl_benefit_by_request_pending = [];
var tbl_benefit_by_request_approved = [];
var tbl_benefit_by_request_disapproved = [];
$(document).ready(function() {
  //init plugin
  $("body").tooltip({ selector: '[data-toggle=tooltip]' });
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


  /**
    * ACCOUNTING FILTER
    */
  var dd = new Date();
  var sd = new Date(dd.getFullYear(), dd.getMonth(), 1);
  var ed = new Date(dd.getFullYear(), dd.getMonth() + 1, 0);
  getGeneralLedger(formatDate(sd), formatDate(ed));
  getCashGift(formatDate(sd), formatDate(ed));
  getOfficialReceipt(formatDate(sd), formatDate(ed));



  $('#general-ledger-search-date').daterangepicker({
      "showDropdowns": true
    }, function(start, end, label) {
      $('#general-ledger-search-date').html('<i class="fas fa-calendar-alt"></i> ' + start.format('MMM DD, YYYY') + ' - ' + end.format('MMM DD, YYYY'));
      getGeneralLedger(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
  });
  $('#trial-balance-search-date').daterangepicker({
      "showDropdowns": true
    }, function(start, end, label) {
      $('#trial-balance-search-date').html('<i class="fas fa-calendar-alt"></i> ' + start.format('MMM DD, YYYY') + ' - ' + end.format('MMM DD, YYYY'));
      $.ajax({
        url: 'search-trial-balance',
        type: 'POST',
        data: {
          'sd': start.format('YYYY-MM-DD'),
          'ed': end.format('YYYY-MM-DD'),
        },
        success: function(res){
          $('#cont-search-t-bal').html(res);
        }
      });    
  });
  $('#posted-crj-search-date').daterangepicker({
      "showDropdowns": true,
      "singleDatePicker": true
    }, function(start, end, label) {
      var dd = new Date();
      var sd = new Date(dd.getFullYear(), 0, 1);
      $('#posted-crj-search-date').attr({
        'data-sd' : formatDate(sd),
        'data-ed' : end.format('YYYY-MM-DD')
      }).html('<i class="fas fa-calendar-alt"></i> ' + start.format('MMM DD, YYYY'));
      initCrjEntry();
      // $.ajax({
      //   url: 'search-posted-crj',
      //   type: 'POST',
      //   data: {
      //     'sd': start.format('YYYY-MM-DD'),
      //     'ed': end.format('YYYY-MM-DD'),
      //   },
      //   success: function(res){
      //     $('#cont-search-t-bal').html(res);
      //   }
      // });    
  });
  
  $('#posted-pacs-search-date').daterangepicker({
      "showDropdowns": true,
      "singleDatePicker": true
    }, function(start, end, label) {
      var dd = new Date();
      var sd = new Date(dd.getFullYear(), 0, 1);
      $('#posted-pacs-search-date').attr({
        'data-sd' : formatDate(sd),
        'data-ed' : end.format('YYYY-MM-DD')
      }).html('<i class="fas fa-calendar-alt"></i> ' + start.format('MMM DD, YYYY'));
      initPacsEntry();
      // $.ajax({
      //   url: 'search-posted-crj',
      //   type: 'POST',
      //   data: {
      //     'sd': start.format('YYYY-MM-DD'),
      //     'ed': end.format('YYYY-MM-DD'),
      //   },
      //   success: function(res){
      //     $('#cont-search-t-bal').html(res);
      //   }
      // });    
  });
  
  $('#posted-cdj-search-date').daterangepicker({
      "showDropdowns": true,
      "singleDatePicker": true
    }, function(start, end, label) {
      var dd = new Date();
      var sd = new Date(dd.getFullYear(), 0, 1);
      $('#posted-cdj-search-date').attr({
        'data-sd' : formatDate(sd),
        'data-ed' : end.format('YYYY-MM-DD')
      }).html('<i class="fas fa-calendar-alt"></i> ' + start.format('MMM DD, YYYY'));
      initCdjEntry();
      // $.ajax({
      //   url: 'search-posted-crj',
      //   type: 'POST',
      //   data: {
      //     'sd': start.format('YYYY-MM-DD'),
      //     'ed': end.format('YYYY-MM-DD'),
      //   },
      //   success: function(res){
      //     $('#cont-search-t-bal').html(res);
      //   }
      // });    
  });

  $('#posted-gj-search-date').daterangepicker({
    "showDropdowns": true,
    "singleDatePicker": true
  }, function(start, end, label) {
    var dd = new Date();
    var sd = new Date(dd.getFullYear(), 0, 1);
    $('#posted-gj-search-date').attr({
      'data-sd' : formatDate(sd),
      'data-ed' : end.format('YYYY-MM-DD')
    }).html('<i class="fas fa-calendar-alt"></i> ' + start.format('MMM DD, YYYY'));
    initGjEntry();
    // $.ajax({
    //   url: 'search-posted-crj',
    //   type: 'POST',
    //   data: {
    //     'sd': start.format('YYYY-MM-DD'),
    //     'ed': end.format('YYYY-MM-DD'),
    //   },
    //   success: function(res){
    //     $('#cont-search-t-bal').html(res);
    //   }
    // });    
});
  /*END*/

  //load data-page
  $(document).on('click', '#loadPage', function(event) {
    var link          = $(this).attr('data-link');
    var d             = $(this).attr('data-ind');
    var dataBadgeHead = $(this).attr('data-badge-head');
    var acls          = $(this).attr('data-cls');
    var request_id    = $(this).attr('data-reqid');
    // $(this).tooltip('hide');
    $('.custom-container').html('');
    $.get(baseURL + link, { 'data' : d, 'request_id' : request_id }, function(data, textStatus, xhr) {
      $('.custom-container').html(data);
      $(".pickerDate").datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true
      });

      

      $('.main_code').select2({
        placeholder        : 'Select main code...',
        width              : '100%',
        minimumInputLength : 1,
        ajax               : {  
          url              : 'get-coa',
          dataType         : 'json',
          data             : function(params) {
            return {
              q            : params.term,
            };
          },
          processResults   : function(data, params) {
            return {
              results     : $.map(data.account_title, function(obj) {
                return {
                  text  : obj.code + ' :: ' + obj.main_desc,
                  id    : obj.code
                }
              }),
            };
          },
        }
      });
      
      var i = 1;
      $('select.main_code').each(function(index, el) {
          $('#select-main'+i).select2({
            placeholder        : 'Select main code...',
            width              : '100%',
            minimumInputLength : 1,
            ajax               : {  
              url              : 'get-coa',
              dataType         : 'json',
              data             : function(params) {
                return {
                  q            : params.term,
                };
              },
              processResults   : function(data, params) {
                return {
                  results     : $.map(data.account_title, function(obj) {
                    return {
                      text  : obj.code + ' :: ' + obj.main_desc,
                      id    : obj.code
                    }
                  }),
                };
              },
            }
          });
          $('#select-main'+i).trigger('change');
        i++;
      });
      computeDebitCredit();

      // $('.sub_code').select2({
      //   placeholder        : 'Select sub code...',
      //   width              : '100%',
      //   minimumInputLength : 1,
      //   ajax               : {  
      //     url              : 'get-coa',
      //     dataType         : 'json',
      //     data             : function(params) {
      //       return {
      //         q            : params.term,
      //       };
      //     },
      //     processResults   : function(data, params) {
      //       return {
      //         results     : $.map(data.account_title, function(obj) {
      //           // return {}
      //           // if (obj.sub_code == null && obj.main_sub_code == null) {
      //             return {
      //                 text  : obj.code + ' :: ' + obj.main_desc,
      //                 id    : obj.code
      //             }
      //         }),
      //       };
      //     },
      //   }
      // });

      $('select[name="select-sub-acct[]"]').select2({
        placeholder: '--',
        allowClear: true,
        width: '100%'
      });

      $( "div.picture-cont" )
      .mouseenter(function() {
        $('.upload-ctrl').removeClass('none');
      })
      .mouseleave(function() {
        $('.upload-ctrl').addClass('none');
      });
      $('#badge-heading').html(dataBadgeHead);
      $('#payee_select').trigger('change');

      animateSingleIn('.'+acls, 'fadeInUp');
      
      animateSingleIn('.cont-tbl-constituent', 'fadeIn');
      
      //datatables for single page
      initUsersDataTables();
      initSignatoryDataTables();
      initOfficeDataTables();
      initMemberTypeDataTables();
      initCivilStatusDataTables();
      initRelationshipTypeDataTables();
      initBeneficiariesDataTables();
      initMembersImmediateFamilyDataTables();
      initImmediateFamilyDataTables();
      initLoanTypeDataTables();
      initBenefitTypeDataTables();
      initMembersBeneficiariesDataTables();
      initSubsidiaryDataTables();
      initDepartmentsDataTables();
      initBenefitClaimedListByMembers();
      initContributionRateDataTables();


      //datatables for page reload
      initMembersDataTables();
      $('#select-loan-request-comp').select2({
        width: '100%',
      });
      initLoanSettingsDataTables();
      initLoanListDataTables();
      initLoanListByMemberDataTables();
      initLoanListByRequestDataTables();
      initBenefitClaimMembersDataTables();
      initBenefitClaimsByRequestDataTables();
      initContributions();

      initCdjEntry();
      initPacsEntry();
      initGjEntry();
      initCrjEntry();

      

      initDateDefault();

      $('.ref_no_evt').trigger('change');

    });    
  });

  //init datatable list
  initMembersDataTables();
  initLoanSettingsDataTables();
  initLoanListDataTables();
  initLoanListByMemberDataTables();
  initLoanListByRequestDataTables();
  initBenefitClaimMembersDataTables();
  initBenefitClaimsByRequestDataTables();
  initCdjEntry();
  initPacsEntry();
  initGjEntry();
  initCrjEntry();

  //form submit
  $(document).on('submit', '#frm-accounting-entry', function(e) {
    e.preventDefault();
    var frm = $(this).serialize();
    customSwal(
      'btn btn-success', 
      'btn btn-danger mr-2', 
      'Yes', 
      'Wait', 
      ['', 'Are you sure you want to save this entry?', 'info'], 
      function(){
        $.ajax({
          url: 'save-acctg-entry',
          type: 'POST',
          dataType: 'JSON',
          data: frm,
          context: this,
          success: function(res){
            Swal.fire(
              res.param1,
              res.param2,
              res.param3
            );
            $('a[data-link="tbl-gj-page"]').trigger('click');
            $('a[data-link="tbl-cdj-page"]').trigger('click');
            $('a[data-link="tbl-pacs-page"]').trigger('click');
            $('a[data-link="tbl-crj-page"]').trigger('click');
          }
        });
      }, function(){
        console.log('Fail');
    });
  });

  $(document).on('submit', '#frm-add-comaker', function(e) {
    e.preventDefault();
    var frm = $(this).serialize();
    $.post('save-co-maker', frm, function(data, textStatus, xhr) {
      tbl_co_maker.ajax.reload();
      tbl_member.ajax.reload();
    });
  });
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
    // console.log(loanSchedID);
    $('input[name="period_start"], input[name="prev_loan_per_pay_start"]').val(dateSchedToPay[0]);
    var lastSched = dateSchedToPay.pop();
    $('input[name="period_end"], input[name="prev_loan_per_pay_end"]').val(lastSched);
    $('input[name="tot_amnt"], input[name="prev_loan_tot_pymnts"]').val(number_format(totalAmnt));
    $('input[name="loanSchedID"]').val(loanSchedID.join('|'));
    //input loan comp
    $('input[name="prev_loan_tot_amnt"]').val($('#tbl-sched-pymnt-select tfoot tr').find('th:eq(2)').html());
    //reselect month
    var val_mo = $('select[name="no_mos_applied"]').val();
    if (val_mo!=='') {
      $('select[name="no_mos_applied"]').val(val_mo).trigger('change');
    }
  });
  $(document).on('submit', '#frm-add-payments', function(e) {
    e.preventDefault();
    var frm = $(this).serialize();

    customSwal(
        'btn btn-success', 
        'btn btn-danger mr-2', 
        'Yes', 
        'Wait', 
        ['', 'Are you sure you want to post this payment?', 'info'], 
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
                tbl_loans_by_member.ajax.reload();
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

  $(document).on('submit', '#frm-cash-gift', function(e) {
    e.preventDefault();
    var frmData = $(this).serialize();
    $.post('save-cash-gift', frmData, function(data, textStatus, xhr) {
      var res = $.parseJSON(data);
      Swal.fire(
        res.param1,
        res.param2,
        res.param3
      );
      animateSingleOut('.loans-card-add', 'fadeOutRight');
      setTimeout(function(){
       tbl_cash_gift.ajax.reload();
      }, 1000);
      console.log(res);
    });
  });

  $(document).on('change', '#select_members_cash_gift', function(e) {
    e.preventDefault();
    var m_id = $(this).val();
    $.post('get-cg-rate-per-member', { 'm_id':m_id }, function(data, textStatus, xhr) {
      var res = $.parseJSON(data);
      $('#amount').val(number_format(res.amnt));
      // Swal.fire(
      //   res.param1,
      //   res.param2,
      //   res.param3
      // );
      // animateSingleOut('.loans-card-add', 'fadeOutRight');
      // setTimeout(function(){
      //  tbl_settings.ajax.reload();
      // }, 1000);
    });
  });
  
  $(document).on('change', '#select-loan-request-comp', function(e) {
    e.preventDefault();
    var members_id = $(this).val(); 
    initMembersWhereIdDataTables(members_id);
    setTimeout(function(){
      $('.procLoanComp[data-ind="'+members_id+'"]').trigger('click');
    }, 500);
  });

  $(document).on('change', '#select-benefit-request-comp', function(e) {
    e.preventDefault();
    var req_id = $(this).find('option:selected').attr('data-reqid');
    var members_id = $(this).val(); 
    initBenefitClaimMembersDataTablesByMember(members_id);
    setTimeout(function(){
      $('.process-benefit-claim[data-ind="'+members_id+'"]').attr('data-reqid', req_id).trigger('click');
    }, 500);
  });

  $(document).on('change', '#select_region_cash_gift', function(e) {
    e.preventDefault();
    var departments_id = $(this).val();
    var remarks = $('input[name="remarks"]').val();
    var date_applied = $('input[name="date_applied"]').val();
    if (date_applied=='') {
      Swal.fire(
        'Opps!',
        'Please Choose a date!',
        'info'
      );
      $(this).parents('form').trigger('reset');
    } else if(remarks==''){
      Swal.fire(
        'Opps!',
        'Input Remarks!',
        'info'
      );
      $(this).parents('form').trigger('reset');
    } else {
      var self = $(this);
      customSwal(
        'btn btn-success', 
        'btn btn-danger mr-2', 
        'Yes', 
        'Wait', 
        ['', 'Details Correct?', 'info'], 
        function(){
            $.post('get-cg-rate-per-region', { 'departments_id' : departments_id, 'remarks' : remarks, 'date_applied' : date_applied }, function(data, textStatus, xhr) {
              var res = $.parseJSON(data);
              Swal.fire(
                res.param1,
                res.param2,
                res.param3
              );
            });
            self.parents('form').trigger('reset');
            tbl_cash_gift.ajax.reload();
          }, function(){
           self.parents('form').trigger('reset');
           console.log(self);
      });
      
    }
    
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
  $(document).on('click', '#printPostedCRJ', function(e) {
    e.preventDefault();
    var dd = new Date();
    var sd = new Date(dd.getFullYear(), 0, 1);
    var ed = new Date(dd.getFullYear(), dd.getMonth() + 1, 0);

    var startData = (typeof $('#posted-crj-search-date').attr('data-sd') === 'undefined' ? formatDate(sd) : $('#posted-crj-search-date').attr('data-sd'));
    var endData = (typeof $('#posted-crj-search-date').attr('data-ed') === 'undefined' ? formatDate(ed) : $('#posted-crj-search-date').attr('data-ed'));
    window.open(baseURL+'crj-summary-report/'+startData+'/'+endData);
  });
  
  $(document).on('click', '#printPostedPACS', function(e) {
    e.preventDefault();
    var dd = new Date();
    var sd = new Date(dd.getFullYear(), 0, 1);
    var ed = new Date(dd.getFullYear(), dd.getMonth() + 1, 0);

    var startData = (typeof $('#posted-pacs-search-date').attr('data-sd') === 'undefined' ? formatDate(sd) : $('#posted-pacs-search-date').attr('data-sd'));
    var endData = (typeof $('#posted-pacs-search-date').attr('data-ed') === 'undefined' ? formatDate(ed) : $('#posted-pacs-search-date').attr('data-ed'));
    window.open(baseURL+'print-pacs-report/'+startData+'/'+endData);
  });
  
  $(document).on('click', '#printPostedGJ', function(e) {
    e.preventDefault();
    var dd = new Date();
    var sd = new Date(dd.getFullYear(), 0, 1);
    var ed = new Date(dd.getFullYear(), dd.getMonth() + 1, 0);

    var startData = (typeof $('#posted-gj-search-date').attr('data-sd') === 'undefined' ? formatDate(sd) : $('#posted-gj-search-date').attr('data-sd'));
    var endData = (typeof $('#posted-gj-search-date').attr('data-ed') === 'undefined' ? formatDate(ed) : $('#posted-gj-search-date').attr('data-ed'));
    window.open(baseURL+'print-gj-report/'+startData+'/'+endData);
  });  
  
  $(document).on('click', '#printPostedCDJ', function(e) {
    e.preventDefault();
    var dd = new Date();
    var sd = new Date(dd.getFullYear(), 0, 1);
    var ed = new Date(dd.getFullYear(), dd.getMonth() + 1, 0);

    var startData = (typeof $('#posted-cdj-search-date').attr('data-sd') === 'undefined' ? formatDate(sd) : $('#posted-cdj-search-date').attr('data-sd'));
    var endData = (typeof $('#posted-cdj-search-date').attr('data-ed') === 'undefined' ? formatDate(ed) : $('#posted-cdj-search-date').attr('data-ed'));
    window.open(baseURL+'print-cdj-report/'+startData+'/'+endData);
  });

  $(document).on('click', '#showBtnPrintByRegion', function(e) {
    $.post("show-choose-region-type", {}, function (data) {
      $('#custom-modal .modal-content').html(data);
      $('#custom-modal .modal-dialog').removeClass('modal-lg modal-md').addClass('modal-sm');
      $('#custom-modal .modal-title').html('<i class="fas fa-list-alt"></i> REGION TYPE');
      $('#custom-modal').modal('show', { backdrop: 'static' });
      $('#posted-crj-search-date').daterangepicker({
        "showDropdowns": true,
        "singleDatePicker": true
      }, function(start, end, label) {
        var dd = new Date();
        var sd = new Date(dd.getFullYear(), 0, 1);
        $('#posted-crj-search-date').attr({
          'data-sd' : formatDate(sd),
          'data-ed' : end.format('YYYY-MM-DD')
        }).html('<i class="fas fa-calendar-alt"></i> ' + start.format('MMM DD, YYYY'));
      });
    });
  });

  $(document).on('click', '#printCntrbtnPymnts', function(e) {
    e.preventDefault();
    var type = $(this).attr('data-type');
    var dd = new Date();
    var sd = new Date(dd.getFullYear(), 0, 1);
    var ed = new Date(dd.getFullYear(), dd.getMonth() + 1, 0);

    var startData = (typeof $('#posted-crj-search-date').attr('data-sd') === 'undefined' ? formatDate(sd) : $('#posted-crj-search-date').attr('data-sd'));
    var endData = (typeof $('#posted-crj-search-date').attr('data-ed') === 'undefined' ? formatDate(ed) : $('#posted-crj-search-date').attr('data-ed'));
    window.open(baseURL+'crj-contribution-and-payment/'+startData+'/'+endData+'/'+type);
  });

  $(document).on('click', '.chk-input-to-post', function(e) {
    if ($(this).is(':checked')) {
      $.each($('.chk-row-input-to-post'), function(index, el) {
        $(this).prop('checked', true);
      });
    } else {
      $.each($('.chk-row-input-to-post'), function(index, el) {
        $(this).prop('checked', false);
      });
    }
  });
  $(document).on('click', '#postMultiple', function(e) {
    e.preventDefault();
    var checked_jm_id=[];
    $.each($('.chk-row-input-to-post'), function(index, el) {
      if ($(this).is(':checked')) {
        checked_jm_id.push($(el).val());
      }
    });
    $.post('show-choose-date-post', { 'id': checked_jm_id }, function(data) {
      $('#custom-modal .modal-content').html(data);
      $('#custom-modal .modal-dialog').removeClass('modal-lg modal-md').addClass('modal-sm');
      $('#custom-modal .modal-title').html('<i class="fas fa-list-alt"></i> ENTER POST DATE');
      $('#custom-modal').modal('show', { backdrop: 'static' });
      $(".pickerDate").datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true
      });
    });
    // $.ajax({
    //   url: '/multiple-post-journal',
    //   type: 'POST',
    //   dataType: 'JSON',
    //   data: {'ids': checked_jm_id},
    //   success: function(res){

    //   }
    // });
  });
  $(document).on('click', '#postAcctgEntry', function(e) {
    e.preventDefault();
    var id=$(this).attr('data-id');
    $.post('show-choose-date-post', { 'id': id }, function(data) {
      $('#custom-modal .modal-content').html(data);
      $('#custom-modal .modal-dialog').removeClass('modal-lg modal-md').addClass('modal-sm');
      $('#custom-modal .modal-title').html('<i class="fas fa-list-alt"></i> ENTER POST DATE');
      $('#custom-modal').modal('show', { backdrop: 'static' });
      $(".pickerDate").datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true
      });
    });
  });
  $(document).on('click', '#btnPickDatePosted', function(e) {
    e.preventDefault();
    var id=$(this).attr('data-id');
    if (id=='') {
      Swal.fire(
        'Opps!',
        'Please select the entry',
        'danger'
      );
      $('#custom-modal').modal('hide');
      return false;
    }

    if ($('input[name="date_posted"]').val()!='') {
      customSwal(
        'btn btn-success', 
        'btn btn-danger mr-2', 
        'Yes', 
        'Wait', 
        ['', 'Are you sure you want to post entry?', 'info'], 
        function(){
            $.ajax({
              url: 'post-acct-entry',
              type: 'POST',
              dataType: 'JSON',
              data: { 'date': $('input[name="date_posted"]').val(), 'id': id, }, 
              context: this,
              success: function (res){
                Swal.fire(
                  res.param1,
                  res.param2,
                  res.param3
                );
                if (res.param3 == 'success') {
                  tbl_cdj_entry.ajax.reload();
                  tbl_pacs_entry.ajax.reload();
                  tbl_gj_entry.ajax.reload();
                  tbl_crj_entry.ajax.reload();
                  $('#custom-modal').modal('hide');
                }
              }
            });
          }, function(){
            console.log('Fail');
      });
    }
    else {
      Swal.fire(
        'Sorry',
        'Please choose a date!',
        'danger'
      );
    }
  });

  $(document).on('change', '#payee_select', function(e) {
    e.preventDefault();
    var val = $(this).val();
    var has_update = $(this).attr('data-has-update');
    $.ajax({
      url: 'get-payee-type',
      type: 'POST',
      data: {'val':val,'has_update':has_update},
      success: function(res){
        $('.payee-cont').html(res).removeClass('d-none');
        $('#select-payee').select2({
          placeholder: 'Select Members',
          allowClear: true,
          width: '100%'
        });
      }
    })
  });

  $(document).on('change', '#or_departments', function(e) {
    e.preventDefault();
    var val = $(this).val();
    var date = $('input[name="date_applied"]').val();
    $.ajax({
      url       : 'get-total-contribution-per-region',
      type      : 'POST',
      dataType  : 'json',
      data      : { 'departments_id' : val, 'date' : date },
      success   : function(res) {
        $('#contribution').val(number_format(res.total)).trigger('change');
      }
    })
  });

  $(document).on('click', '#printMemberDocs', function(e) {
    e.preventDefault();
    $.post('print-members-docx', {/*'id': m_id, 'c_id' : id*/}, function(data) {
      $('#custom-modal .modal-content').html(data);
      $('#custom-modal .modal-dialog').removeClass('modal-sm modal-lg').addClass('modal-md');
      $('#custom-modal .modal-title').html('<i class="fas fa-list-alt"></i> VIEW DOCX');
      $('#custom-modal').modal('show', { backdrop: 'static' });
      $('#select-members-to-print').select2({
        placeholder: 'Select Members',
        allowClear: true,
        width: '100%',
        dropdownParent: "#custom-modal"
      });
      $('#select-office-to-print').select2({
        placeholder: 'Select Office',
        allowClear: true,
        width: '100%',
        dropdownParent: "#custom-modal"
      });
      $('input[name="date_range"]').daterangepicker({
        locale: {
          cancelLabel: 'Clear'
        },
        "drops": "up"
      }, function(start, end, label) {
        $('input[name="date_range"]').attr('data-pick', start.format('YYYY-MM-DD') + ' ' + end.format('YYYY-MM-DD'));
        // console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' 
        //   + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
      });
    });
  });

  $(document).on('click', '#printCashGiftDocs', function(e) {
    e.preventDefault();
    $.post('print-cash-gift-docx', {/*'id': m_id, 'c_id' : id*/}, function(data) {
      $('#custom-modal .modal-content').html(data);
      $('#custom-modal .modal-dialog').removeClass('modal-sm modal-lg').addClass('modal-md');
      $('#custom-modal .modal-title').html('<i class="fas fa-list-alt"></i> VIEW DOCX');
      $('#custom-modal').modal('show', { backdrop: 'static' });
      $('#select-members-to-print').select2({
        placeholder: 'Select Members',
        allowClear: true,
        width: '100%',
        dropdownParent: "#custom-modal"
      });
      $('#select-office-to-print').select2({
        placeholder: 'Select Office',
        allowClear: true,
        width: '100%',
        dropdownParent: "#custom-modal"
      });
      $('input[name="date_range_cg"]').daterangepicker({
        locale: {
          cancelLabel: 'Clear'
        },
        "drops": "up"
      }, function(start, end, label) {
        $('input[name="date_range_cg"]').attr('data-pick', start.format('YYYY-MM-DD') + ' ' + end.format('YYYY-MM-DD'));
        // console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' 
        //   + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
      });
    });
  });

  $(document).on('change', 'input[name="date_range"]', function(e) {
    e.preventDefault();
    console.log($(this).attr('data-pick'));
    var m_id          = $('#select-members-to-print').val();
    var type_to_print = $('#select-type-to-print').val();
    var office_to_print = $('#select-office-to-print').val();
    var date = $(this).attr('data-pick');
    $.ajax({
      url: 'get-members-print-to-excel',
      type: 'POST',
      data: {
        'm_id': m_id,
        'type_to_print': type_to_print,
        'office_to_print': office_to_print,
        'date': date,
      },
      success: function(res){
        $('#print-container-docx-or-excel').html(res);
      }
    });
    
  });
  
  $(document).on('click', '#membersOfcContribution', function(e) {
    e.preventDefault();
    var m_id          = $('#select-members-to-print').val();
    var type_to_print = $('#select-type-to-print').val();
    var office_to_print = $('#select-office-to-print').val();
    var date = $('#date_range').attr('data-pick').split(' ');
    window.open('get-members-print-to-pdf/'+m_id+'/'+type_to_print+'/'+office_to_print+'/'+date[0]+'/'+date[1]);
  });

  $(document).on('change', 'input[name="date_range_cg"]', function(e) {
    e.preventDefault();
    // console.log($(this).attr('data-pick'));
    var m_id          = $('#select-members-to-print').val();
    var type_to_print = $('#select-type-to-print').val();
    var office_to_print = $('#select-office-to-print').val();
    var type = $('#select-dept-to-print').val();
    var date = $(this).attr('data-pick');
    $.ajax({
      url: 'get-cash-gift-to-excel',
      type: 'POST',
      data: {
        'm_id': m_id,
        'type_to_print': type_to_print,
        'office_to_print': office_to_print,
        'date': date,
        'type' : type,
        'remarks' : $('input[name="remarks"]').val()
      },
      success: function(res){
        $('#print-container-docx-or-excel').html(res);
      }
    });
  });

  $(document).on('click', '#add-row-acct-entry', function(e) {
    // e.preventDefault();
    if ($('#select-main').data('select2')) {
      $('#select-main').select2('destroy');
    }
    var ht = '<tr>'
          ht+='<td><select class="form-control custom-select custom-select-sm rounded-0 main_code" name="main_code[]"></select></td>';
          ht+='<td><select class="form-control-sm custom-select custom-select-sm rounded-0 sub_code" id="" name="sub_code[]"><option value=""></option></select></td>';
          ht+='<td><input type="text" class="form-control form-control-sm font-12 rounded-0 text-right isNum debit" id="debit" name="debit[]" placeholder="0.00"></td>';
          ht+='<td><input type="text" class="form-control form-control-sm font-12 rounded-0 text-right isNum credit" id="credit" name="credit[]" placeholder="0.00"></td>';
          ht+='<td class="text-center">';
            ht+='<button type="button" class="btn btn-sm btn-success font-12" id="add-row-acct-entry"><i class="fas fa-plus-square"></i></button> | ';
            ht+='<button type="button" class="btn btn-sm btn-danger font-12" id="remove-row-acct-entry"><i class="fas fa-minus-square"></i></button></td>';
          ht+'</tr>';
    $(this).parents('table').find('tbody tr:last').after(ht);

    $('.main_code').select2({
      placeholder        : 'Select main code...',
      width              : '100%',
      minimumInputLength : 1,
      ajax               : {  
        url              : 'get-coa',
        dataType         : 'json',
        data             : function(params) {
          return {
            q            : params.term,
          };
        },
        processResults   : function(data, params) {
          return {
            results     : $.map(data.account_title, function(obj) {
              // return {}
              // if (obj.sub_code == null && obj.main_sub_code == null) {
                return {
                    text  : obj.code + ' :: ' + obj.main_desc,
                    id    : obj.code
                }
            }),
          };
        },
      }
    });
  });

  $(document).on('change', '.debit, .credit', function(e) {
    e.preventDefault();
    computeDebitCredit();
  });

  $(document).on('change', 'select[name="main_code[]"]', function(e) {
    e.preventDefault();
    var code = $(this).val();
    $(this).parent('td').next().find('.sub_code').select2({
      placeholder        : 'Select sub code...',
      width              : '100%',
      minimumInputLength : 1,
      ajax               : {  
        url              : 'get-subsidiary',
        dataType         : 'json',
        data             : function(params) {
          return {
            q            : params.term,
            'code'       : code
          };
        },
        processResults   : function(data, params) {
          return {
            results     : $.map(data.account_title, function(obj) {
              // return {}
              // if (obj.sub_code == null && obj.main_sub_code == null) {
                return {
                    text  : obj.sub_code + ' :: ' + obj.name,
                    id    : obj.sub_code
                }
            }),
          };
        },
      }
    });
  });

  $(document).on('click', '#remove-row-acct-entry', function(e) {
    e.preventDefault();
    $(this).parents('tr').remove();
    computeDebitCredit();
  });

  $(document).on('click', '#removeClaim', function(e) {
    e.preventDefault();
    var id = $(this).attr('data-id');
    var claim_all = $(this).attr('data-claim-all');
    var members_id = $(this).attr('data-member-id');
    customSwal(
        'btn btn-success', 
        'btn btn-danger mr-2', 
        'Yes', 
        'Wait', 
        ['', 'Are you sure you want to remove this benefit?', 'info'], 
        function(){
            $.ajax({
              url: 'remove-benefit-claim',
              type: 'POST',
              dataType: 'JSON',
              data: { 'id': id, 'claim_all': claim_all, 'members_id': members_id }, 
              context: this,
              success: function (res){
                Swal.fire(
                  res.param1,
                  res.param2,
                  res.param3
                );
                if (res.param3 == 'success') {
                  $('a[data-link="show-claim-benefit"]').trigger('click');
                }
              }
            });
          }, function(){
            console.log('Fail');
      });
  });

  $(document).on('click', '#removeCoMaker', function(e) {
    e.preventDefault();
    var id = $(this).attr('data-id');
    $.post('remove-co-maker', {'id': id}, function(data, textStatus, xhr) {
      tbl_co_maker.ajax.reload();
      tbl_member.ajax.reload();
    });
  });

  $(document).on('click', '#editClaim', function(e) {
    e.preventDefault();
    var claim_benefit_id = $(this).attr('data-id');
    var benefit_id = $(this).attr('data-benefit-id');
    $('#benefit_type').attr('data-claimed-benefit-id', claim_benefit_id);
    $('#benefit_type').removeClass('d-none').val(benefit_id).trigger('change');
  });

  $(document).on('click', '#addMembersToCoMaker', function(e) {
    e.preventDefault();
    var id = $(this).attr('data-id');
    var member_id = $(this).attr('data-mem-id');
    $.post('insert-co-maker', {'id': id, 'member_id': member_id}, function(data, textStatus, xhr) {
      tbl_co_maker.ajax.reload();
      tbl_member.ajax.reload();
    });
  });

  $(document).on('click', '#add-comaker', function(e) {
    e.preventDefault();
    var m_id = $(this).attr('data-m-id');
    $.get('show-co-maker', {'id': m_id}, function(data) {
      $('#custom-modal .modal-content').html(data);
      $('#custom-modal .modal-dialog').removeClass('modal-sm modal-md').addClass('modal-lg');
      $('#custom-modal .modal-title').html('<i class="fas fa-list-alt"></i> CREATE CO-MAKER');
      $('#custom-modal').modal('show', { backdrop: 'static' });
      $('input[name="co_members_id_hddn"]').val(m_id);
      initCoMaker(m_id);
      initMembersCoMaker(m_id);

    });
  });

  $(document).on('click', '#add-contribution', function(e) {
    e.preventDefault();
    var m_id = $(this).attr('data-m-id');
    var id = $(this).attr('data-cont-id');
    $.post('add-contribution', {'id': m_id, 'c_id' : id}, function(data) {
      $('#custom-modal .modal-content').html(data);
      $('#custom-modal .modal-dialog').removeClass('modal-sm modal-lg').addClass('modal-md');
      $('#custom-modal .modal-title').html('<i class="fas fa-list-alt"></i> ADD CONTRIBUTION');
      $('#custom-modal').modal('show', { backdrop: 'static' });
    });
  });

  $(document).on('click', '#add-contribution-by-type', function(e) {
    e.preventDefault();
    $.post('add-contribution-by-type', {}, function(data) {
      $('#custom-modal .modal-content').html(data);
      $('#custom-modal .modal-dialog').removeClass('modal-sm modal-lg').addClass('modal-md');
      $('#custom-modal .modal-title').html('<i class="fas fa-list-alt"></i> ADD CONTRIBUTION');
      $('#custom-modal').modal('show', { backdrop: 'static' });

      $('#members_by_type').select2({
        placeholder: '--',
        allowClear: true,
        width: '100%',
        dropdownParent: "#custom-modal"
      });
      $.post('get-last-date-applied-cont', function(data, textStatus, xhr) {
        var r = $.parseJSON(data);
        // console.log(r.data);
        var today = new Date(r.data);
        var nextMo = today.getMonth() == 11 ? new Date(today.getFullYear()+1, 0 , 1) : new Date(today.getFullYear(), today.getMonth() + 1, 1);
        // console.log(formatDate(nextMo));
        $('#date_applied').daterangepicker({
          "singleDatePicker": true,
          // "minDate": formatDateOthFormat(nextMo)
        }, function(start, end, label) {
          $('#date_applied').html('<i class="fas fa-calendar-alt"></i> ' + start.format('MMM DD, YYYY') + ' - ' + end.format('MMM DD, YYYY'));
          // getGeneralLedger(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
        });
      });
      

    });
  });
  
  $(document).on('click', '#add-payments-by-type', function(e) {
    e.preventDefault();
    $.post('add-loan-payments-by-type', {}, function(data) {
      $('#custom-modal .modal-content').html(data);
      $('#custom-modal .modal-dialog').removeClass('modal-md modal-sm').addClass('modal-lg');
      $('#custom-modal .modal-title').html('<i class="fas fa-list-alt"></i> ADD LOAN PAYMENTS');
      $('#custom-modal').modal('show', { backdrop: 'static' });

      $('#members_by_type').select2({
        placeholder: '--',
        allowClear: true,
        width: '100%',
        dropdownParent: "#custom-modal"
      });
      $.post('get-last-date-applied-cont', function(data, textStatus, xhr) {
        var r = $.parseJSON(data);
        var today = new Date(r.data);
        var nextMo = today.getMonth() == 11 ? new Date(today.getFullYear()+1, 0 , 1) : new Date(today.getFullYear(), today.getMonth() + 1, 1);
        $('#date_applied').daterangepicker({
          "singleDatePicker": true,
          // "minDate": formatDateOthFormat(nextMo)
        }, function(start, end, label) {
          $('#date_applied').html('<i class="fas fa-calendar-alt"></i> ' + start.format('MMM DD, YYYY') + ' - ' + end.format('MMM DD, YYYY'));
          $('#tbl-members-due-to-pay').DataTable().clear().destroy();
          var myObjKeyLguConst = {};
          $("#tbl-members-due-to-pay").DataTable({
            "searching": false,
            "paging":   false,
            "ordering": false,
            "info":     false,
            searchHighlight : true,
            lengthMenu      : [[-1], ['All']],
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
                className            : 'text-right', 
                targets              : [1,2] 
              }
            ],
            scrollY         : '300px',
            scrollX         : true,
            scrollCollapse  : true,
            "serverSide"               : true,
            "processing"               : true,
            "ajax"                     : {
                "url"                  : 'server-get-repayment-list',
                "type"                 : 'POST',
                "data"                 : {
                                        'office_management_id': $('select[name="office_management_id"]').val(), 
                                        'date_applied': start.format('YYYY-MM-DD')
                                      }
            },
            'createdRow'            : function(row, data, dataIndex) {
              var dataRowAttrIndex = ['data-lgu-const-id'];
              var dataRowAttrValue = [0];
                for (var i = 0; i < dataRowAttrIndex.length; i++) {
                  myObjKeyLguConst[dataRowAttrIndex[i]] = data[dataRowAttrValue[i]];
                }
                $(row).attr(myObjKeyLguConst);
            },
            "footerCallback": function ( row, data, start, end, display ) {
              var api = this.api(), data;
              // Remove the formatting to get integer data for summation
              var intVal = function ( i ) {
                  return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                          i : 0;
              };
              // Total over all pages
              var darr = [1,2];
              for (var i = 0; i < darr.length; i++) {
                total = api
                  .column( darr[i] )
                  .data()
                  .reduce( function (a, b) {
                      return intVal(a) + intVal(b);
                  }, 0 );
                // Total over this page
                pageTotal = api
                  .column( darr[i], { page: 'current'} )
                  .data()
                  .reduce( function (a, b) {
                      return intVal(a) + intVal(b);
                  }, 0 );
        
                // Update footer
                $( api.column( darr[i] ).footer() ).html(number_format(total));
              }
              
            }
          });
        });
      });

    });
  });

  $(document).on('click', '#btnAddContribution', function(e) {
    $('#frm-add-contribution').trigger('submit');    
  });

  $(document).on('submit', '#frm-add-contribution', function(e) {
    e.preventDefault();
    if ($(this).valid()) {
      var frm = $(this).serialize();
      customSwal(
        'btn btn-success', 
        'btn btn-danger mr-2', 
        'Yes', 
        'Wait', 
        ['', 'Are you sure?', 'info'], 
        function(){
            $.ajax({
              url: 'save-contribution',
              type: 'POST',
              dataType: 'JSON',
              data: frm, 
              context: this,
              success: function (res){
                Swal.fire(
                  res.param1,
                  res.param2,
                  res.param3
                );
                if (res.param3 == 'success') {
                  tbl_contribution.ajax.reload();
                  $('#custom-modal').modal('hide');
                }
              }
            });
          }, function(){
            console.log('Fail');
      });

    }
  });

  $(document).on('click', '#btnAddContributionByType', function(e) {
    $('#frm-add-contribution-by-type').trigger('submit');    
  });

  $(document).on('submit', '#frm-add-contribution-by-type', function(e) {
    e.preventDefault();
    if ($(this).valid()) {
      var frm = $(this).serialize();
      customSwal(
        'btn btn-success', 
        'btn btn-danger mr-2', 
        'Yes', 
        'Wait', 
        ['', 'Are you sure?', 'info'], 
        function(){
            $.ajax({
              url: 'save-contribution-by-type',
              type: 'POST',
              dataType: 'JSON',
              data: frm, 
              context: this,
              success: function (res){
                Swal.fire(
                  res.param1,
                  res.param2,
                  res.param3
                );
                if (res.param3 == 'success') {
                  $('#custom-modal').modal('hide');
                }
              }
            });
          }, function(){
            console.log('Fail');
      });

    }
  });
  
  $(document).on('click', '#btnAddLoanPaymentByType', function(e) {
    $('#frm-add-loan-payments-by-type').trigger('submit');    
  });
  
  $(document).on('submit', '#frm-add-loan-payments-by-type', function(e) {
    e.preventDefault();
    if ($(this).valid()) {
      var frm = $(this).serialize();
      customSwal(
        'btn btn-success', 
        'btn btn-danger mr-2', 
        'Yes', 
        'Wait', 
        ['', 'Are you sure?', 'info'], 
        function(){
            $.ajax({
              url: 'save-payments-by-type',
              type: 'POST',
              dataType: 'JSON',
              data: frm, 
              context: this,
              success: function (res){
                Swal.fire(
                  res.param1,
                  res.param2,
                  res.param3
                );
                if (res.param3 == 'success') {
                  $('#custom-modal').modal('hide');
                }
              }
            });
          }, function(){
            console.log('Fail');
      });

    }
  });

  $(document).on('click', '#print-loan-comp', function(e) {
    e.preventDefault();
    var frm=$('#frm-save-loancomp').serializeArray(); 
    frm.push({ name: 'repayment_period', value: $('select[name="repayment_period"]:disabled').val() })
    $.post('get-print-loan-comp', frm, function(res) {
      var r = $.parseJSON(res);
      window.open(baseURL+'pdf-vloan-comp/'+r.data);
    });
  });

  $(document).on('change', '.ref_no_evt', function(e) {
    e.preventDefault();
    var ref_no = $(this).val();
    var memberId = $(this).attr('data-mem');
    $.ajax({
      url: 'get-previous-loan',
      type: 'POST',
      dataType: 'JSON',
      data: { 'ref_no' : ref_no, 'memberId': memberId },
      context: this,
      success: function(res){
        if (ref_no !== '') {
          if (res === null) {
            Swal.fire(
              'Opps!',
              'The reference number might be incorrect!',
              'warning'
            );
            $(this).val('');
            $('input[name="total_loan_amnt"]').val('');
            $('input[name="repymnt_start"]').val('');
            $('input[name="repymnt_end"]').val('');
            $('input[name="mo_amortization"]').val('');
          } else {
            if (res.is_posted==0) {
              Swal.fire(
                'Opps!',
                'This loan is not posted',
                'warning'
              );
              $(this).val('');
              $('input[name="total_loan_amnt"]').val('');
              $('input[name="repymnt_start"]').val('');
              $('input[name="repymnt_end"]').val('');
              $('input[name="mo_amortization"]').val('');
            } else {
              $('input[name="total_loan_amnt"]').val(number_format(res.total_amnt_to_be_amort));
              $('input[name="repymnt_start"]').val(res.f_date);
              $('input[name="repymnt_end"]').val(res.l_date);
              $('input[name="mo_amortization"]').val(number_format(res.breakdown_ma_total));
              $('#btnPickDateAndComp').attr('data-comp-id', res.loan_computation_id);
              var val_mo = $('select[name="no_mos_applied"]').val();
              if (val_mo!=='') {
                $('select[name="no_mos_applied"]').val(val_mo).trigger('change');
              } 
            }
          }
        }
      }
    });
  });

  $(document).on('click', '#btnPickDateAndComp', function(e) {
    e.preventDefault();
    if ($('.ref_no_evt').val() === '') {
      Swal.fire(
        'Opps!',
        'The reference number must not be empty!',
        'warning'
      );
    } else if($('#prev_loan_orno').val() === '') {
      Swal.fire(
        'Opps!',
        'Please input OR No. first!',
        'warning'
      );
    } else {
      var comp_id = $(this).attr('data-comp-id');
      $.get('show-schedule-list', {'id': comp_id}, function(data) {
        $('#custom-modal .modal-content').html(data);
        $('#custom-modal .modal-dialog').removeClass('modal-sm modal-md').addClass('modal-lg');
        $('#custom-modal .modal-title').html('<i class="fas fa-list-alt"></i> SELECT SCHEDULE LIST');
        $('#custom-modal').modal('show', { backdrop: 'static' });
      });
    }
  });

  $(document).on('change', 'input[name="blb_principal"]', function(e) {
    e.preventDefault();
    var pp = strToFloat($(this).val());
    var int = strToFloat($('input[name="blb_interest"]').val()==''?'0':$('input[name="blb_interest"]').val());
    $('input[name="blb_total"]').val(number_format(pp - int));
  });
  $(document).on('change', 'input[name="blb_interest"]', function(e) {
    e.preventDefault();
    var int = strToFloat($(this).val());
    var pp = strToFloat($('input[name="blb_principal"]').val()==''?'0':$('input[name="blb_principal"]').val());
    $('input[name="blb_total"]').val(number_format(pp - int));
  });

  $(document).on('click', '#view-monthly-schedule', function(e) {
    e.preventDefault();
    var comp_id = $(this).attr('data-comp-id');
    $.get('show-schedule-list', {'id': comp_id}, function(data) {
      $('#custom-modal .modal-content').html(data);
      $('#custom-modal .modal-dialog').removeClass('modal-sm modal-md').addClass('modal-lg');
      $('#custom-modal .modal-title').html('<i class="fas fa-list-alt"></i> SELECT SCHEDULE LIST');
      $('#custom-modal').modal('show', { backdrop: 'static' });
    });
  });

  $(document).on('click', '#btn-edit-payments', function(e) {
    e.preventDefault();
    var comp_id = $(this).attr('data-comp-id');
    $.get('show-edit-payment-list', {'id': comp_id}, function(data) {
      $('#custom-modal .modal-content').html(data);
      $('#custom-modal .modal-dialog').removeClass('modal-sm modal-md').addClass('modal-lg');
      $('#custom-modal .modal-title').html('<i class="fas fa-list-alt"></i> SELECT SCHEDULE LIST');
      $('#custom-modal').modal('show', { backdrop: 'static' });
    });
  });

  $(document).on('change', '#edit-amnt-paid', function () {
    var val = strToFloat($(this).val());
    var int = strToFloat($(this).parents('tr').find('td:eq(3)').html());
    var principal = strToFloat($(this).parents('tr').find('td:eq(2)').html());
    var percent = int / principal;
    if (val > principal) {
      Swal.fire(
        'Sorry!',
        'Sorry Your Amount is greater than amortization amount!',
        'warning'
      );
      $(this).val(number_format(principal));
    } else {
      $(this).parents('tr').find('td:eq(5)').find('input').val(number_format(val * percent));
    }
    
  });

  $(document).on('click', '#postThisLoan', function(e) {
    e.preventDefault();
    var id = $(this).attr('data-id');
    customSwal(
        'btn btn-success', 
        'btn btn-danger mr-2', 
        'Yes', 
        'Wait', 
        ['', 'Are you sure you want to post this loan?', 'info'], 
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

  $(document).on('click', '#btn-cash-gift', function(e) {
    e.preventDefault();
    var id   = $(this).attr('data-id');
    var type = $(this).attr('data-field');
    $.get('show-cash-gift-frm', { 'id':id }, function(data, textStatus) {
      $('.loans-cont-add').html(data);
      $('.title-loans-form').html(type+' CASH GIFT');
      animateSingleIn('.loans-card-add', 'fadeInRight');
      // $.post('get-last-date-applied-cg', function(data, textStatus, xhr) {
      //   var r = $.parseJSON(data);
      //   // console.log(r.data);
      //   var today = new Date(r.data);
      //   var nextMo = today.getMonth() == 11 ? new Date(today.getFullYear()+1, 0 , 1) : new Date(today.getFullYear(), today.getMonth() + 1, 1);
      //   // console.log(formatDate(nextMo));
      //   $('#date_applied').daterangepicker({
      //     "singleDatePicker": true,
      //     "minDate": formatDateOthFormat(nextMo)
      //   }, function(start, end, label) {
      //     $('#date_applied').html('<i class="fas fa-calendar-alt"></i> ' + start.format('MMM DD, YYYY') + ' - ' + end.format('MMM DD, YYYY'));
      //     // getGeneralLedger(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
      //   });
      // });
        $('#date_applied').daterangepicker({
          "showDropdowns": true,
          "singleDatePicker": true
          }, function(start, end, label) {
        });
    });
  });

  $(document).on('click', '#btn-cash-gift-per-region', function(e) {
    e.preventDefault();
    var id   = $(this).attr('data-id');
    var type = $(this).attr('data-field');
    $.get('show-cash-gift-frm-per-region', { 'id':id }, function(data, textStatus) {
      $('.loans-cont-add').html(data);
      $('.title-loans-form').html(type+' CASH GIFT');
      animateSingleIn('.loans-card-add', 'fadeInRight');
      // $.post('get-last-date-applied-cg', function(data, textStatus, xhr) {
      //   var r = $.parseJSON(data);
      //   // console.log(r.data);
      //   var today = new Date(r.data);
      //   var nextMo = today.getMonth() == 11 ? new Date(today.getFullYear()+1, 0 , 1) : new Date(today.getFullYear(), today.getMonth() + 1, 1);
      //   // console.log(formatDate(nextMo));
      //   $('#date_applied').daterangepicker({
      //     "singleDatePicker": true,
      //     "minDate": formatDateOthFormat(nextMo)
      //   }, function(start, end, label) {
      //     $('#date_applied').html('<i class="fas fa-calendar-alt"></i> ' + start.format('MMM DD, YYYY') + ' - ' + end.format('MMM DD, YYYY'));
      //     // getGeneralLedger(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
      //   });
      // });
        $('#date_applied').daterangepicker({
          "showDropdowns": true,
          "singleDatePicker": true
          }, function(start, end, label) {
        });
    });
  });

  $(document).on('click', '#btn-or-per-region', function(e) {
    e.preventDefault();
    var id   = $(this).attr('data-id');
    var type = $(this).attr('data-field');
    $.get('show-or-frm-per-region', { 'id':id }, function(data, textStatus) {
      $('.loans-cont-add').html(data);
      $('.title-loans-form').html(type+' OFFICIAL RECEIPT');
      animateSingleIn('.loans-card-add', 'fadeInRight');
      // $.post('get-last-date-applied-cg', function(data, textStatus, xhr) {
      //   var r = $.parseJSON(data);
      //   // console.log(r.data);
      //   var today = new Date(r.data);
      //   var nextMo = today.getMonth() == 11 ? new Date(today.getFullYear()+1, 0 , 1) : new Date(today.getFullYear(), today.getMonth() + 1, 1);
      //   // console.log(formatDate(nextMo));
      //   $('#date_applied').daterangepicker({
      //     "singleDatePicker": true,
      //     "minDate": formatDateOthFormat(nextMo)
      //   }, function(start, end, label) {
      //     $('#date_applied').html('<i class="fas fa-calendar-alt"></i> ' + start.format('MMM DD, YYYY') + ' - ' + end.format('MMM DD, YYYY'));
      //     // getGeneralLedger(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
      //   });
      // });
        $('#date_applied').daterangepicker({
          "showDropdowns": true,
          "singleDatePicker": true
          }, function(start, end, label) {
        });
    });
  });

  $(document).on('change', '#type_of_loan', function(e) {
    e.preventDefault();
    var loan_code = $(this).val();
    $.ajax({
      url: 'get-loan-settings-code',
      type: 'POST',
      dataType: 'JSON',
      data: {'loan_code': loan_code},
      success: function (res){
        $('#no_mos_applied').val("").trigger('change');
        var ht = '<option selected value="" hidden>-NONE-</option>';
        $.each(res, function(index, el) {
          ht += '<option value="'+el.loan_settings_id+'">'+el.number_of_month+'</option>';
        });
        $('#no_mos_applied').html(ht);
        // ht += '<option selected value="" hidden>-NONE-</option>';
        //   <option value="<?php echo $row->loan_code_id; ?>"><?php echo $row->loan_type_name; ?></option>
        // <?php endforeach; ?>

      }
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
  
  $(document).on('click', '#btn-show-ln-req-attmnt', function(e) {
    e.preventDefault();
    var id   = $(this).attr('data-id');
    $.get('show-loan-req-attachments', { 'id':id }, function(data, textStatus) {
      $('.loans-cont-add').html(data);
      $('.title-loans-form').html('ATTACHMENTS');
      animateSingleIn('.loans-card-add', 'fadeInRight');
    });

  }); 

  $(document).on('click', '#btn-show-ben-req-attmnt', function(e) {
    e.preventDefault();
    var id   = $(this).attr('data-id');
    $.get('show-benefit-req-attachments', { 'id':id }, function(data, textStatus) {
      $('.loans-cont-add').html(data);
      $('.title-loans-form').html('ATTACHMENTS');
      animateSingleIn('.loans-card-add', 'fadeInRight');
    });

  }); 
  
  $(document).on('click', '#btn-comment-ln-request', function(e) {
    e.preventDefault();
    var id   = $(this).attr('data-id');
    var flag   = $(this).attr('data-field');
    $.get('get-msg-frm', { 'id':id, 'flag':flag}, function(data, textStatus) {
      $('.loans-cont-add').html(data);
      $('.title-loans-form').html('FEEDBACK MESSAGE');
      animateSingleIn('.loans-card-add', 'fadeInRight');
    });

  }); 

  $(document).on('click', '#btn-disapproved-ln-request', function(e) {
    e.preventDefault();
    var id   = $(this).attr('data-id');
    var flag   = $(this).attr('data-field');
    $.get('get-disapproved-frm', { 'id':id, 'flag':flag}, function(data, textStatus) {
      $('.loans-cont-add').html(data);
      $('.title-loans-form').html('DISAPPROVED REQUEST');
      animateSingleIn('.loans-card-add', 'fadeInRight');
    });

  }); 


  
  $(document).on('click', '#btn-comment-ben-request', function(e) {
    e.preventDefault();
    var id   = $(this).attr('data-id');
    var field   = $(this).attr('data-field');
    $.get('get-msg-frm', { 'id':id, 'flag' : field}, function(data, textStatus) {
      $('.loans-cont-add').html(data);
      $('.title-loans-form').html('FEEDBACK MESSAGE');
      animateSingleIn('.loans-card-add', 'fadeInRight');
    });

  });  

  $(document).on('submit', '#frm-send-feedback-msg', function(e) {
    e.preventDefault();
    $.ajax({
      type: "POST",
      url: "save-msg-feedback-admin",
      data: $(this).serialize(),
      success: function (res) {
        $('.list-msg-fdbk').html(res);
      }
    });
  });

  $(document).on('submit', '#frm-send-disapproved-msg', function(e) {
    e.preventDefault();
    var frm = $(this).serialize();
    customSwal(
      'btn btn-success', 
      'btn btn-danger mr-2', 
      'Yes', 
      'Wait', 
      ['', 'Are you sure you want to Disapproved this request?', 'warning'], 
      function(){
          $.ajax({
            url      : 'save-approval-loan-request',
            type     : 'POST',
            dataType : 'JSON',
            context  : this,
            data     : frm,
            success: function (res){
              Swal.fire(
                res.param1,
                res.param2,
                res.param3
              );
              tbl_loans_by_request_pending.ajax.reload();
              tbl_loans_by_request_approved.ajax.reload();
              tbl_loans_by_request_disapproved.ajax.reload();
            }
          });
        }, function(){
          console.log('Fail');
    });
  });
  
  $(document).on('submit', '#frm-save-loan-approval-settings', function(e) {
    e.preventDefault();
    var frm = $(this).serialize();
    customSwal(
      'btn btn-success', 
      'btn btn-danger mr-2', 
      'Yes', 
      'Wait', 
      ['', 'Are you sure you want to save this settings?', 'warning'], 
      function(){
          $.ajax({
            url      : 'save-loan-approval-settings',
            type     : 'POST',
            dataType : 'JSON',
            context  : this,
            data     : frm,
            success: function (res){
              Swal.fire(
                res.param1,
                res.param2,
                res.param3
              );
              setTimeout(function(){
                window.location.reload();
              }, 1000)
            }
          });
        }, function(){
          console.log('Fail');
    });
  });  
  
  $(document).on('submit', '#frm-save-benefit-approval-settings', function(e) {
    e.preventDefault();
    var frm = $(this).serialize();
    customSwal(
      'btn btn-success', 
      'btn btn-danger mr-2', 
      'Yes', 
      'Wait', 
      ['', 'Are you sure you want to save this settings?', 'warning'], 
      function(){
          $.ajax({
            url      : 'save-benefit-approval-settings',
            type     : 'POST',
            dataType : 'JSON',
            context  : this,
            data     : frm,
            success: function (res){
              Swal.fire(
                res.param1,
                res.param2,
                res.param3
              );
              setTimeout(function(){
                window.location.reload();
              }, 1000)
            }
          });
        }, function(){
          console.log('Fail');
    });
  });  

  $(document).on("click", 'input[name="loan_req_second_approver"]', function () {
    if ($(this).is(':checked')) {
      $('input[name="loan_override_first_approver"]').prop({
        'disabled': false,
        'checked': false
      });
    } else {
      $('input[name="loan_override_first_approver"]').prop({
        'disabled': true,
        'checked': false
      });
    }
  });
  
  $(document).on('click', '#btn-approved-ln-req-attmnt', function(e) {
    e.preventDefault();
    var id = $(this).attr('data-id');
    var field = $(this).attr('data-field');
    customSwal(
      'btn btn-success', 
      'btn btn-danger mr-2', 
      'Yes', 
      'Wait', 
      ['', 'Are you sure you want to ' + field + ' this request?', 'warning'], 
      function(){
          $.ajax({
            url      : 'save-approval-loan-request',
            type     : 'POST',
            dataType : 'JSON',
            context  : this,
            data     : { "id" : id, "field" : field },
            success: function (res){
              Swal.fire(
                res.param1,
                res.param2,
                res.param3
              );
              tbl_loans_by_request_pending.ajax.reload();
              tbl_loans_by_request_approved.ajax.reload();
              tbl_loans_by_request_disapproved.ajax.reload();
            }
          });
        }, function(){
          console.log('Fail');
    });

  });  
  
  $(document).on('click', '#btn-approved-ben-req-attmnt', function(e) {
    e.preventDefault();
    var id = $(this).attr('data-id');
    var field = $(this).attr('data-field');
    customSwal(
      'btn btn-success', 
      'btn btn-danger mr-2', 
      'Yes', 
      'Wait', 
      ['', 'Are you sure you want to ' + field + ' this request?', 'warning'], 
      function(){
          $.ajax({
            url      : 'save-approval-benefit-request',
            type     : 'POST',
            dataType : 'JSON',
            context  : this,
            data     : { "id" : id, "field" : field },
            success: function (res){
              Swal.fire(
                res.param1,
                res.param2,
                res.param3
              );
              tbl_benefit_by_request_pending.ajax.reload();
              tbl_benefit_by_request_approved.ajax.reload();
              tbl_benefit_by_request_disapproved.ajax.reload();
            }
          });
        }, function(){
          console.log('Fail');
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
  
  $(document).on('submit', '#frm-update-payments', function(e) {
    e.preventDefault();
    var lr_id = [];
    var frm = $(this).serializeArray();
    frm.push({ name: 'lr_id', value: lr_id });
    $('input[name="orno[]"]').each(function(){
      lr_id.push($(this).attr('data-id'));
    });
    customSwal(
      'btn btn-success', 
      'btn btn-danger mr-2', 
      'Yes', 
      'Wait', 
      ['', 'Are you sure you want to save this OR?', 'warning'], 
      function(){
          $.ajax({
            url      : 'save-update-payments',
            type     : 'POST',
            dataType : 'JSON',
            context  : this,
            data     : frm,
            success: function (res){
              Swal.fire(
                res.param1,
                res.param2,
                res.param3
              );
              $('#custom-modal').modal('hide');
            }
          });
        }, function(){
          console.log('Fail');
    });

  });

  $(document).on('submit', '#frm-official-receipt', function(e) {
    e.preventDefault();
    var frm = $(this).serialize();
    customSwal(
      'btn btn-success', 
      'btn btn-danger mr-2', 
      'Yes', 
      'Wait', 
      ['', 'Are you sure you want to save this OR?', 'warning'], 
      function(){
          $.ajax({
            url      : 'save-official-receipt',
            type     : 'POST',
            dataType : 'JSON',
            context  : this,
            data     : frm,
            success: function (res){
              Swal.fire(
                res.param1,
                res.param2,
                res.param3
              );
              if (res.param4 != '') {
                $('input[name="has_update"]').val(res.param4);
              }
              tbl_official_receipt.ajax.reload();
            }
          });
        }, function(){
          console.log('Fail');
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
  
  $(document).on('change', '#sc_pw_discount, #withholding_tax, #payment_due', function(event) {
    event.preventDefault();
    $('.orcompamnt').trigger('change');
  });

  $(document).on('change', '.orcompamnt', function(event) {
    var total_sales = 0;
    var total_due = 0;
    var grand_total = 0;

    $('.orcompamnt').each(function(i, v){
      total_sales += strToFloat($(v).val()==''?'0':$(v).val());            
    });
    total_due = total_sales - strToFloat($('input[name="sc_pw_discount"]').val()==''?'0':$('input[name="sc_pw_discount"]').val());
    grand_total = total_due - strToFloat($('input[name="withholding_tax"]').val()==''?'0':$('input[name="withholding_tax"]').val()) + 
                                strToFloat($('input[name="payment_due"]').val()==''?'0':$('input[name="payment_due"]').val());

    $('input[name="amount"]').val(number_format(total_sales));
    $('input[name="total_due"]').val(number_format(total_due));
    $('input[name="total"]').val(number_format(grand_total));
    /* Act on the event */
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
    $('#frm-upload-dp').trigger('submit');
  });

  $(document).on('change', 'input[name="date_processed"]', function(e) {
    e.preventDefault();
    var val_mo = $('select[name="no_mos_applied"]').val();
    $('select[name="no_mos_applied"]').val(val_mo).trigger('change');
  });

  $(document).on('change', '#monthly_salary', function(e) {
    e.preventDefault();
    var val_mo = $('select[name="no_mos_applied"]').val();
    if (val_mo!=='') {
      $('select[name="no_mos_applied"]').val(val_mo).trigger('change');
    }
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
      var frm = $('#frm-save-loancomp').serializeArray();
      frm.push({ name: 'prev_loan_tot_amnt', value: strToFloat($('input[name="prev_loan_tot_amnt"]').val()) > 0 ? strToFloat($('input[name="prev_loan_tot_amnt"]').val()) : strToFloat($('input[name="total_loan_amnt"]').val()), });
      frm.push({ name: 'prev_loan_tot_pymnts', value: $('input[name="prev_loan_tot_pymnts"]').val(), });
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
        ['', 'Are you sure you want to save this loan?', 'warning'], 
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
                // window.open(baseURL+'pdf-vloan-comp/'+res.id);
                // var frm=$('#frm-save-loancomp').serializeArray(); 
                frm.push({ name: 'repayment_period', value: $('select[name="repayment_period"]:disabled').val() });
                $.post('get-print-loan-comp', frm, function(res) {
                  var r = $.parseJSON(res);
                  window.open(baseURL+'pdf-vloan-comp/'+r.data);
                  setTimeout(function(){
                    $('a[data-link="view-loan-app-page"]').trigger('click');
                  }, 1000)
                });
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
      async:true,
      dataType: 'json',
      beforeSend: function(){
        $('.spinner-cont').removeClass('none');
      },
      success: function(data){
        // animateSingleOut('.spinner-cont', 'fadeOut');
        $('.spinner-cont').addClass('none');
        if (data.success) {
          Swal.fire(
            'Success!',
            'Picture Successfully Updated!',
            'success'
          );
          $('#lgu-captured-image').attr('src', baseURL + 'assets/image/uploads/' + data.file_name);
        } else {
          Swal.fire(
            'Oopps!',
            'Looks like ' + data.error.error + ' Please upload atleast 1MB',
            'warning'
          );
        }
        // alert("Upload Image Successful.");
        // animateSingleOut('.spinner-cont', 'fadeOut');
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
      ['', 'Are you sure you want to delete this member?', 'warning'], 
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
      ['', 'Are you sure you want to delete this loans?', 'warning'], 
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

  $(document).on('change', '#other_benefit', function(e) {
    e.preventDefault();
    var val=$(this).val();
    $.ajax({
      url: 'compute-oth-benefit',
      type: 'POST',
      dataType: 'JSON',
      context: this,
      data: {'percent':val},
      success: function(res){
        $('input[name="sickness"]').val(res.sickness);
        $('input[name="doif"]').val(res.doif);
        $('input[name="accident"]').val(res.accident);
        $('input[name="calamity"]').val(res.calamity);
        var sickness=strToFloat($('input[name="sickness"]').val())||0;
        var doif=strToFloat($('input[name="doif"]').val())||0;
        var accident=strToFloat($('input[name="accident"]').val())||0;
        var calamity=strToFloat($('input[name="calamity"]').val())||0;

        var accum_mem_cont=strToFloat($('#accum_mem_cont').val())||0;
        var total_contrib=strToFloat($('#total_contrib').val())||0;
        var totalPrevLoan=0;
        if (!$('#lbToLRI').is(':checked')) {
          $.each($('.tr-heading'), function(index, el) {
            totalPrevLoan+=strToFloat($(el).find('td:eq(4)').html())||0;
          });
        }

        var totalLessBenefit=0;
        $.each($('.less-prev-benefit'), function(index, el) {
          totalLessBenefit+=strToFloat($(el).html())||0;
        });
        var other_benefit = (sickness + doif + accident + calamity - totalLessBenefit);

        $('.total-other-benefit').html(number_format(other_benefit));
        $('.total-loan').html(number_format((accum_mem_cont + total_contrib + other_benefit) - totalPrevLoan));

        //not multi claim
        var amnt_claim = strToFloat($('#org_amnt_claim').val())||0;
        $('#amnt_claim').val(number_format(amnt_claim*(val/100)));
      }
    });
  });

  //Benefit claim computation
  $(document).on('change', 'input[name="claim_date"]', function(e) {
    e.preventDefault();
    var date_reg=$('.p-member-eff').html();
    var date_claim=$('#claim_date').val();
    var years = moment(date_claim).diff(date_reg, 'years');
    var percent_share = (years < 5 ? 0 : 100);
    var accum_mem_cont = strToFloat($('input[name="accum_mem_cont"]').val())||0;

    $('#lbToLRI, #hideOthBen').prop('disabled', false);

    $('input[name="share"]').val(percent_share);
    if (years < 1) {
      $('input[name="other_benefit"]').val(0).trigger('change');  
    } 
    if(years >= 1 && years < 2) {
      $('input[name="other_benefit"]').val(20).trigger('change');  
    } 
    if(years >= 2 && years < 3) {
      $('input[name="other_benefit"]').val(40).trigger('change');  
    } 
    if(years >= 3 && years < 4) {
      $('input[name="other_benefit"]').val(60).trigger('change');  
    } 
    if(years >= 4 && years < 5) {
      $('input[name="other_benefit"]').val(80).trigger('change');  
    } 
    if(years >= 5) {
      $('input[name="other_benefit"]').val(100).trigger('change');  
    }

    $('input[name="total_contrib"]').val(number_format(accum_mem_cont*(percent_share/100)));
    
    var accum_mem_cont=strToFloat($('#accum_mem_cont').val())||0;
    var total_contrib=strToFloat($('#total_contrib').val())||0;
    var totalPrevLoan=0; 
    if (!$('#lbToLRI').is(':checked')) {
      $.each($('.tr-heading'), function(index, el) {
        totalPrevLoan+=strToFloat($(el).find('td:eq(4)').html())||0;
      });
    }

    $('.total-loan').html(number_format(accum_mem_cont + total_contrib - totalPrevLoan));
  });

  $(document).on('change', 'input[name="accum_mem_cont"]', function(e) {
    e.preventDefault();
    var val = strToFloat($(this).val())||0;
    var percent_share = strToFloat($('input[name="share"]').val())||0;
    $('input[name="total_contrib"]').val(number_format(val*(percent_share/100)));
  });

  $(document).on('change', '#benefit_type', function(e) {
    e.preventDefault();
    var val=$(this).val();
    var m_id=$(this).find('option:selected').attr('data-m-id');
    var claimed_id=$(this).attr('data-claimed-benefit-id');
    $.ajax({
      url: 'get-frm-benefit-claim',
      type: 'POST',
      data: {'multi_claim':val,'m_id':m_id,'claimed_id':claimed_id},
      success: function(res){
        $('.bfit-frm').html(res);
        if ($('input[name="claim_date"]').val()=='') {} else {
          $('input[name="claim_date"]').trigger('change');
          setTimeout(function(){
            // $('#lbToLRI, #hideOthBen').trigger('change');
            if ($('input[name="lri_from_loan_balance"]').val()=='') {} else {
              $('#lbToLRI').trigger('click');
              $('#lbToLRI').prop('checked', true);
            }
            if ($('input[name="oth_benefit"]').val()>0) {} else {
              $('#hideOthBen').trigger('click');
              $('#hideOthBen').prop('checked', true);
            }
          },2000);
        }

        var totalPrevLoan = 0;
        if (!$('#lbToLRI').is(':checked')) {
          $.each($('.tr-heading'), function(index, el) {
            totalPrevLoan+=strToFloat($(el).find('td:eq(4)').html())||0;
          });
        }
        var sickness=strToFloat($('input[name="sickness"]').val())||0;
        var doif=strToFloat($('input[name="doif"]').val())||0;
        var accident=strToFloat($('input[name="accident"]').val())||0;
        var calamity=strToFloat($('input[name="calamity"]').val())||0;
        
        //less other benefit
        var totalLessBenefit=0;
        $.each($('.less-prev-benefit'), function(index, el) {
          totalLessBenefit+=strToFloat($(el).html())||0;
        });
        var other_benefit = (sickness + doif + accident + calamity - totalLessBenefit);
        $('.total-other-benefit').html(number_format(other_benefit));

        var accum_mem_cont=strToFloat($('#accum_mem_cont').val())||0;
        var total_contrib=strToFloat($('#total_contrib').val())||0;

        $('.total-loan').html(number_format((accum_mem_cont + total_contrib + other_benefit) - totalPrevLoan));
      }
    });
  });

  $(document).on('submit', '#frm-claim-beneft', function(e) {
    e.preventDefault();
    var frm = $(this).serializeArray();
    frm.push({name: 'total_claim', value: $('.total-loan').html() });
    frm.push({name: 'members_id', value: $('select[name="benefit_type"]').find('option:selected').attr('data-m-id') });
    customSwal(
        'btn btn-success', 
        'btn btn-danger mr-2', 
        'Yes', 
        'Wait', 
        ['', 'Are you sure for this claiming entry?', 'question'], 
        function(){
            $.ajax({
              url      : 'save-benefit-claim',
              type     : 'POST',
              dataType : 'JSON',
              data     : frm,
              context  : this,
              success  : function(res){
                console.log(res);
                Swal.fire(
                  res.param1,
                  res.param2,
                  res.param3
                );
                if (res.param3=='success') {
                  $('a[data-link="show-claim-benefit"]').trigger('click');
                }
              }
            });
          }, function(){
            console.log('Fail');
      });

    
  });

  $(document).on('click', '#hideOthBen', function(e) {
    if ($(this).is(':checked')) {
      $('#other-benefit-tbl-frm').html('');
      setTimeout(function(){
        if ($('#claim_date').val()!='') {
          $('#claim_date').trigger('change');
        }
      }, 1000);
    } else {
      var mid = $(this).val();
      $.ajax({
        url: 'get-other-benefit-form',
        type: 'POST',
        data: {'m_id' : mid},
        success: function(res){
          $('#other-benefit-tbl-frm').html(res);
          setTimeout(function(){
            if ($('#claim_date').val()!='') {
              $('#claim_date').trigger('change');
            }
          }, 1000);
        }
      });
    }
  });

  $(document).on('click', '#lbToLRI', function(e) {
    if ($(this).is(':checked')) {
      var totalPrevLoan = 0;
      $.each($('.tr-heading'), function(index, el) {
        totalPrevLoan+=strToFloat($(el).find('td:eq(4)').html())||0;
      });
      $('input[name="lri_from_loan_balance"]').val(totalPrevLoan);
    } else {
      $('input[name="lri_from_loan_balance"]').val('');
    }
    setTimeout(function(){
      if ($('#claim_date').val()!='') {
        $('#claim_date').trigger('change');
      }
    }, 1000);
  });

});//ready


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
  $('#select-loan-request-comp').select2({
    width: '100%',
  });
  var myObjKeyLguConst = {};
  $('#tbl-member-list').DataTable().clear().destroy();
  tbl_member  = $("#tbl-member-list").DataTable({
    searchHighlight : true,
    lengthMenu      : [[50, -1], [50, 'All']],
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
                                "page" : $("#tbl-member-list").attr('data-page'),
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
function initMembersWhereIdDataTables(members_id){
  $('#select-loan-request-comp').select2({
    width: '100%',
  });
  var myObjKeyLguConst = {};
  $('#tbl-member-list').DataTable().clear().destroy();
  tbl_member  = $("#tbl-member-list").DataTable({
    searchHighlight : true,
    lengthMenu      : [[50, -1], [50, 'All']],
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
                                "page" : $("#tbl-member-list").attr('data-page'),
                                "members_id" : members_id
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

function initBenefitClaimMembersDataTables(){
  $('#select-benefit-request-comp').select2({
    width: '100%',
  });
  var myObjKeyLguConst = {};
  $('#tbl-benefit-claim-members').DataTable().clear().destroy();
  tbl_member  = $("#tbl-benefit-claim-members").DataTable({
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
      }
    ],
    "serverSide"               : true,
    "processing"               : true,
    "ajax"                     : {
        "url"                  : 'server-tbl-claim-benefit-members',
        "type"                 : 'POST',
        // "data"                 : { 
        //                         "page" : $("#tbl-member-list").attr('data-page')
        //                       }
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

function initBenefitClaimMembersDataTablesByMember(members_id){
  $('#select-benefit-request-comp').select2({
    width: '100%',
  });
  var myObjKeyLguConst = {};
  $('#tbl-benefit-claim-members').DataTable().clear().destroy();
  tbl_member  = $("#tbl-benefit-claim-members").DataTable({
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
      }
    ],
    "serverSide"               : true,
    "processing"               : true,
    "ajax"                     : {
        "url"                  : 'server-tbl-claim-benefit-members',
        "type"                 : 'POST',
        "data"                 : { 
                                "members_id" : members_id
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

function initBenefitClaimedListByMembers(){
  var myObjKeyLguConst = {};
  $('#tbl-benefit-list-by-member').DataTable().clear().destroy();
  tbl_benefit_claimed_list  = $("#tbl-benefit-list-by-member").DataTable({
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
      }
    ],
    "serverSide"               : true,
    "processing"               : true,
    "ajax"                     : {
        "url"                  : 'server-benefit-list-claimed-by-member',
        "type"                 : 'POST',
        "data"                 : { 
                                "members_id" : $("#tbl-benefit-list-by-member").attr('data-member-id')
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
        targets              : [0,1,2,3,4,5,6,7] 
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

function initLoanListByRequestDataTables(){
  var myObjKeyLguConst = {};
  tbl_loans_by_request_pending  = $("#tbl-loans-by-request-pending").DataTable({
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
        targets              : [0,1,2,3,4,5,6,7,8,9] 
      },
      { 
        className            : 'text-right', 
        targets              : [5,6] 
      },
      { 
        visible            : false, 
        targets              : [5,6] 
      }
    ],
    "serverSide"               : true,
    "processing"               : true,
    "ajax"                     : {
        "url"                  : 'server-loans-by-request',
        "type"                 : 'POST',
        "data"                 : { 
                                "flag" : $("#tbl-loans-by-request-pending").attr('data-flag')
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

  tbl_loans_by_request_approved  = $("#tbl-loans-by-request-approved").DataTable({
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
        targets              : [0,1,2,3,4,5,6,7,8,9] 
      },
      { 
        className            : 'text-right', 
        targets              : [5,6] 
      }
    ],
    "serverSide"               : true,
    "processing"               : true,
    "ajax"                     : {
        "url"                  : 'server-loans-by-request',
        "type"                 : 'POST',
        "data"                 : { 
                                "flag" : $("#tbl-loans-by-request-approved").attr('data-flag')
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

  tbl_loans_by_request_disapproved  = $("#tbl-loans-by-request-disapproved").DataTable({
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
        targets              : [0,1,2,3,4,5,6,7,8,9] 
      },
      { 
        className            : 'text-right', 
        targets              : [5,6] 
      }
    ],
    "serverSide"               : true,
    "processing"               : true,
    "ajax"                     : {
        "url"                  : 'server-loans-by-request',
        "type"                 : 'POST',
        "data"                 : { 
                                "flag" : $("#tbl-loans-by-request-disapproved").attr('data-flag')
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

function initBenefitClaimsByRequestDataTables(){
  var myObjKeyLguConst = {};
  tbl_benefit_by_request_pending  = $("#tbl-benefit-by-request-pending").DataTable({
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
      },
      { 
        className            : 'text-right', 
        targets              : [5,6] 
      }
    ],
    "serverSide"               : true,
    "processing"               : true,
    "ajax"                     : {
        "url"                  : 'server-benefit-by-request',
        "type"                 : 'POST',
        "data"                 : { 
                                "flag" : $("#tbl-benefit-by-request-pending").attr('data-flag')
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

  tbl_benefit_by_request_approved  = $("#tbl-benefit-by-request-approved").DataTable({
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
      },
      { 
        className            : 'text-right', 
        targets              : [5,6] 
      }
    ],
    "serverSide"               : true,
    "processing"               : true,
    "ajax"                     : {
        "url"                  : 'server-benefit-by-request',
        "type"                 : 'POST',
        "data"                 : { 
                                "flag" : $("#tbl-benefit-by-request-approved").attr('data-flag')
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

  tbl_benefit_by_request_disapproved  = $("#tbl-benefit-by-request-disapproved").DataTable({
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
      },
      { 
        className            : 'text-right', 
        targets              : [5,6] 
      }
    ],
    "serverSide"               : true,
    "processing"               : true,
    "ajax"                     : {
        "url"                  : 'server-benefit-by-request',
        "type"                 : 'POST',
        "data"                 : { 
                                "flag" : $("#tbl-benefit-by-request-disapproved").attr('data-flag')
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

function initCoMaker(id){
  var myObjKeyLguConst = {};
  tbl_co_maker  = $("#tbl-comaker").DataTable({
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
        className            : 'text-right', 
        targets              : [0,1,2,3] 
      },
      // { 
      //   className            : 'text-center', 
      //   targets              : [6] 
      // }
    ],
    order                    : false,
    "serverSide"               : true,
    "processing"               : true,
    "ajax"                     : {
        "url"                  : 'server-co-maker',
        "type"                 : 'POST',
        "data"                 : { 
                                "id" : id
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
function initMembersCoMaker(id){
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
        className            : 'text-right', 
        targets              : [0,1,2,3] 
      }
    ],
    order                    : false,
    "serverSide"               : true,
    "processing"               : true,
    "ajax"                     : {
        "url"                  : 'show-co-maker-members-list',
        "type"                 : 'POST',
        "data"                 : { 
                                "co_makers_mem_id" : id
                              }
    },
    'createdRow'            : function(row, data, dataIndex) {
      var dataRowAttrIndex = ['data-members-id'];
      var dataRowAttrValue = [0];
        for (var i = 0; i < dataRowAttrIndex.length; i++) {
          myObjKeyLguConst[dataRowAttrIndex[i]] = data[dataRowAttrValue[i]];
        }
        $(row).attr(myObjKeyLguConst);
    }
  });
}

function initContributions(id){
  var myObjKeyLguConst = {};
  $('#tbl-contribution').DataTable().clear().destroy();
  tbl_contribution  = $("#tbl-contribution").DataTable({
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
        targets              : [1,2,3] 
      }
    ],
    order                    : false,
    "serverSide"               : true,
    "processing"               : true,
    "ajax"                     : {
        "url"                  : 'server-contribution',
        "type"                 : 'POST',
        "data"                 : { 
                                "tlb_cont_members_id" : $("#tbl-contribution").attr('data-m-id')
                              }
    },
    'createdRow'            : function(row, data, dataIndex) {
      var dataRowAttrIndex = ['data-members-id'];
      var dataRowAttrValue = [0];
        for (var i = 0; i < dataRowAttrIndex.length; i++) {
          myObjKeyLguConst[dataRowAttrIndex[i]] = data[dataRowAttrValue[i]];
        }
        $(row).attr(myObjKeyLguConst);
    }
  });
}

function initGjEntry(id){
  var myObjKeyLguConst = {};
  $('#tbl-gj-transaction').DataTable().clear().destroy();
  tbl_gj_entry  = $("#tbl-gj-transaction").DataTable({
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
      }
      // { 
      //   className            : 'text-right', 
      //   targets              : [1,2,3] 
      // }
    ],
    order                    : false,
    "serverSide"               : true,
    "processing"               : true,
    "ajax"                     : {
        "url"                  : 'server-gj-entry',
        "type"                 : 'POST',
        "data"                 : { 
                                "tbl_acctg_page" : $("#tbl-gj-transaction").attr('data-page'),
                                "sd": $('#posted-gj-search-date').attr('data-sd'),
                                "ed": $('#posted-gj-search-date').attr('data-ed')
                              }
    },
    'createdRow'            : function(row, data, dataIndex) {
      var dataRowAttrIndex = ['data-members-id'];
      var dataRowAttrValue = [0];
        for (var i = 0; i < dataRowAttrIndex.length; i++) {
          myObjKeyLguConst[dataRowAttrIndex[i]] = data[dataRowAttrValue[i]];
        }
        $(row).attr(myObjKeyLguConst);
    }
  });
}

function initCrjEntry(){
  var myObjKeyLguConst = {};
  $('#tbl-crj-transaction').DataTable().clear().destroy();
  tbl_crj_entry  = $("#tbl-crj-transaction").DataTable({
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
      }
      // { 
      //   className            : 'text-right', 
      //   targets              : [1,2,3] 
      // }
    ],
    order                    : false,
    "serverSide"               : true,
    "processing"               : true,
    "ajax"                     : {
        "url"                  : 'server-crj-entry',
        "type"                 : 'POST',
        "data"                 : { 
                                "tbl_acctg_page" : $("#tbl-crj-transaction").attr('data-page'),
                                "sd": $('#posted-crj-search-date').attr('data-sd'),
                                "ed": $('#posted-crj-search-date').attr('data-ed')
                              }
    },
    'createdRow'            : function(row, data, dataIndex) {
      var dataRowAttrIndex = ['data-members-id'];
      var dataRowAttrValue = [0];
        for (var i = 0; i < dataRowAttrIndex.length; i++) {
          myObjKeyLguConst[dataRowAttrIndex[i]] = data[dataRowAttrValue[i]];
        }
        $(row).attr(myObjKeyLguConst);
    }
  });
}

function initCdjEntry(){
  var myObjKeyLguConst = {};
  $('#tbl-cdj-transaction').DataTable().clear().destroy();
  tbl_cdj_entry  = $("#tbl-cdj-transaction").DataTable({
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
      }
      // { 
      //   className            : 'text-right', 
      //   targets              : [1,2,3] 
      // }
    ],
    order                    : false,
    "serverSide"               : true,
    "processing"               : true,
    "ajax"                     : {
        "url"                  : 'server-cdj-entry',
        "type"                 : 'POST',
        "data"                 : { 
                                "tbl_acctg_page" : $("#tbl-cdj-transaction").attr('data-page'),
                                "sd": $('#posted-cdj-search-date').attr('data-sd'),
                                "ed": $('#posted-cdj-search-date').attr('data-ed')
                                
                              }
    },
    'createdRow'            : function(row, data, dataIndex) {
      var dataRowAttrIndex = ['data-members-id'];
      var dataRowAttrValue = [0];
        for (var i = 0; i < dataRowAttrIndex.length; i++) {
          myObjKeyLguConst[dataRowAttrIndex[i]] = data[dataRowAttrValue[i]];
        }
        $(row).attr(myObjKeyLguConst);
    }
  });
}

function initPacsEntry(id){
  var myObjKeyLguConst = {};
  $('#tbl-pacs-transaction').DataTable().clear().destroy();
  tbl_pacs_entry  = $("#tbl-pacs-transaction").DataTable({
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
      }
      // { 
      //   className            : 'text-right', 
      //   targets              : [1,2,3] 
      // }
    ],
    order                    : false,
    "serverSide"               : true,
    "processing"               : true,
    "ajax"                     : {
        "url"                  : 'server-pacs-entry',
        "type"                 : 'POST',
        "data"                 : { 
                                "tbl_acctg_page" : $("#tbl-pacs-transaction").attr('data-page'),
                                "sd": $('#posted-pacs-search-date').attr('data-sd'),
                                "ed": $('#posted-pacs-search-date').attr('data-ed')
                              }
    },
    'createdRow'            : function(row, data, dataIndex) {
      var dataRowAttrIndex = ['data-members-id'];
      var dataRowAttrValue = [0];
        for (var i = 0; i < dataRowAttrIndex.length; i++) {
          myObjKeyLguConst[dataRowAttrIndex[i]] = data[dataRowAttrValue[i]];
        }
        $(row).attr(myObjKeyLguConst);
    }
  });
}

function getGeneralLedger(sd, ed){
  var myObjKeyLguConst = {};
  $('#tbl-general-ledger').DataTable().clear().destroy();
  tbl_pacs_entry  = $("#tbl-general-ledger").DataTable({
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
        targets              : [2,3,4] 
      }
    ],
    order                    : false,
    "serverSide"               : true,
    "processing"               : true,
    "ajax"                     : {
        "url"                  : 'server-general-ledger',
        "type"                 : 'POST',
        "data"                 : { 
                                "sd" : sd,
                                "ed" : ed,
                                "tbl_acctg_page" : $("#tbl-general-ledger").attr('data-page')
                              }
    },
    'createdRow'            : function(row, data, dataIndex) {
      var dataRowAttrIndex = ['data-members-id'];
      var dataRowAttrValue = [0];
        for (var i = 0; i < dataRowAttrIndex.length; i++) {
          myObjKeyLguConst[dataRowAttrIndex[i]] = data[dataRowAttrValue[i]];
        }
        $(row).attr(myObjKeyLguConst);
    },
    "footerCallback": function ( row, data, start, end, display ) {
      var api = this.api(), data;
      // Remove the formatting to get integer data for summation
      var intVal = function ( i ) {
          return typeof i === 'string' ?
              i.replace(/[\$,]/g, '')*1 :
              typeof i === 'number' ?
                  i : 0;
      };
      // Total over all pages
      var darr = [2,3,4];
      for (var i = 0; i < darr.length; i++) {
        total = api
          .column( darr[i] )
          .data()
          .reduce( function (a, b) {
              return intVal(a) + intVal(b);
          }, 0 );
        // Total over this page
        pageTotal = api
          .column( darr[i], { page: 'current'} )
          .data()
          .reduce( function (a, b) {
              return intVal(a) + intVal(b);
          }, 0 );

        // Update footer
        $( api.column( darr[i] ).footer() ).html(number_format(total));
      }
      
    }
  });
}

function getCashGift(sd, ed){
  var myObjKeyLguConst = {};
  $('#tbl-cash-gift').DataTable().clear().destroy();
  tbl_cash_gift  = $("#tbl-cash-gift").DataTable({
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
        targets              : [1] 
      }
    ],
    order                    : false,
    "serverSide"               : true,
    "processing"               : true,
    "ajax"                     : {
        "url"                  : 'server-cash-gift',
        "type"                 : 'POST',
        "data"                 : { 
                                "sd" : sd,
                                "ed" : ed,
                                "tbl_acctg_page" : $("#tbl-cash-gift").attr('data-page')
                              }
    },
    'createdRow'            : function(row, data, dataIndex) {
      var dataRowAttrIndex = ['data-members-id'];
      var dataRowAttrValue = [0];
        for (var i = 0; i < dataRowAttrIndex.length; i++) {
          myObjKeyLguConst[dataRowAttrIndex[i]] = data[dataRowAttrValue[i]];
        }
        $(row).attr(myObjKeyLguConst);
    },
    "footerCallback": function ( row, data, start, end, display ) {
      var api = this.api(), data;
      // Remove the formatting to get integer data for summation
      var intVal = function ( i ) {
          return typeof i === 'string' ?
              i.replace(/[\$,]/g, '')*1 :
              typeof i === 'number' ?
                  i : 0;
      };
      // Total over all pages
      var darr = [2,3,4];
      for (var i = 0; i < darr.length; i++) {
        total = api
          .column( darr[i] )
          .data()
          .reduce( function (a, b) {
              return intVal(a) + intVal(b);
          }, 0 );
        // Total over this page
        pageTotal = api
          .column( darr[i], { page: 'current'} )
          .data()
          .reduce( function (a, b) {
              return intVal(a) + intVal(b);
          }, 0 );

        // Update footer
        $( api.column( darr[i] ).footer() ).html(number_format(total));
      }
      
    }
  });
}

function getOfficialReceipt(sd, ed){
  var myObjKeyLguConst = {};
  $('#tbl-official-receipt').DataTable().clear().destroy();
  tbl_official_receipt  = $("#tbl-official-receipt").DataTable({
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
        className            : 'text-center', 
        targets              : [2] 
      }
    ],
    order                    : false,
    "serverSide"               : true,
    "processing"               : true,
    "ajax"                     : {
        "url"                  : 'server-official-receipt',
        "type"                 : 'POST',
        "data"                 : { 
                                "sd" : sd,
                                "ed" : ed,
                                "tbl_acctg_page" : $("#tbl-official-receipt").attr('data-page')
                              }
    },
    'createdRow'            : function(row, data, dataIndex) {
      var dataRowAttrIndex = ['data-members-id'];
      var dataRowAttrValue = [0];
        for (var i = 0; i < dataRowAttrIndex.length; i++) {
          myObjKeyLguConst[dataRowAttrIndex[i]] = data[dataRowAttrValue[i]];
        }
        $(row).attr(myObjKeyLguConst);
    },
    "footerCallback": function ( row, data, start, end, display ) {
      var api = this.api(), data;
      // Remove the formatting to get integer data for summation
      var intVal = function ( i ) {
          return typeof i === 'string' ?
              i.replace(/[\$,]/g, '')*1 :
              typeof i === 'number' ?
                  i : 0;
      };
      // Total over all pages
      var darr = [2,3,4];
      for (var i = 0; i < darr.length; i++) {
        total = api
          .column( darr[i] )
          .data()
          .reduce( function (a, b) {
              return intVal(a) + intVal(b);
          }, 0 );
        // Total over this page
        pageTotal = api
          .column( darr[i], { page: 'current'} )
          .data()
          .reduce( function (a, b) {
              return intVal(a) + intVal(b);
          }, 0 );

        // Update footer
        $( api.column( darr[i] ).footer() ).html(number_format(total));
      }
      
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
  if (typeof stringValue !== 'undefined') {
    stringValue = stringValue.trim();
    var result = stringValue.replace(/[^0-9]/g, '');
    if (/[,\.]\d{2}$/.test(stringValue)) {
        result = result.replace(/(\d{2})$/, '.$1');
    }
    return parseFloat(result);  
  }
}

function editGroupCodeCoa(d){
  var groupCode = d.getAttribute('data-gcode');
  var currVal = $(d).parents('tr').find('td:eq(1)').html();
  $(d).parents('tr').find('td:eq(1)').html('<input type="text" class="form-control form-control-sm font-12" value="'+currVal+'">');
  $(d).parent('td').html('<a href="javascript:void(0);" onclick="updateGroupCodeCoa(this)" data-gcode="'
                          +groupCode+
                          '"><i class="fas fa-check" data-toogle="tooltip" data-placement="right" title="Save"></i></a> | <a href="javascript:void(0);" onclick="deleteData(this)" data-fld="group_code" data-tbl="account_groups" data-code="'
                          +groupCode+
                          '"><i class="fas fa-trash" data-toogle="tooltip" data-placement="right" title="Delete"></i></a>');
}
function updateGroupCodeCoa(d){
  var groupCode = d.getAttribute('data-gcode');
  var currVal = $(d).parents('tr').find('td:eq(1) input').val();
  $.ajax({
    url      : 'update-data',
    type     : 'POST',
    dataType : 'JSON',
    data     : {'tbl': 'account_groups', 
                'update_data': {
                  'group_desc' : currVal
                },
                'field_where': 'group_code', 
                'where_val': groupCode 
                },
    success:function(res){
      if (res.param3=='success') {
        Swal.fire(
          res.param1,
          res.param2,
          res.param3
        );
        $(d).parents('tr').find('td:eq(1)').html(currVal);
        $(d).parent('td').html('<a href="javascript:void(0);" onclick="editGroupCodeCoa(this)" data-gcode="'
                          +groupCode+
                          '"><i class="fas fa-edit" data-toogle="tooltip" data-placement="right" title="Edit"></i></a> | <a href="javascript:void(0);" onclick="deleteData(this)" data-fld="group_code" data-tbl="account_groups" data-code="'
                          +groupCode+
                          '"><i class="fas fa-trash" data-toogle="tooltip" data-placement="right" title="Delete"></i></a>');  
      } else {
        Swal.fire(
          res.param1,
          res.param2,
          res.param3
        );
      }
      
    }
  });
}

function editMainCodeCoa(d){
  var mainCode = d.getAttribute('data-mcode');
  var code = $(d).parents('tr').find('td:eq(2)').html();
  var mainDesc = $(d).parents('tr').find('td:eq(3)').html();
  $(d).parents('tr').find('td:eq(2)').html('<input type="text" class="form-control form-control-sm font-12" value="'+code+'">');
  $(d).parents('tr').find('td:eq(3)').html('<input type="text" class="form-control form-control-sm font-12" value="'+mainDesc+'">');
  $(d).parent('td').html('<a href="javascript:void(0);" onclick="updateMainCodeCoa(this)" data-mcode="'
                          +mainCode+
                          '"><i class="fas fa-check" data-toogle="tooltip" data-placement="right" title="Save"></i></a> | <a href="javascript:void(0);" onclick="deleteData(this)" data-fld="main_code" data-tbl="account_main" data-code="'
                          +mainCode+
                          '"><i class="fas fa-trash" data-toogle="tooltip" data-placement="right" title="Delete"></i></a>');
}

function updateMainCodeCoa(d){
  var mainCode = d.getAttribute('data-mcode');
  var code = $(d).parents('tr').find('td:eq(2) input').val();
  var mainDesc = $(d).parents('tr').find('td:eq(3) input').val();
  $.ajax({
    url      : 'update-data',
    type     : 'POST',
    dataType : 'JSON',
    data     : {'tbl': 'account_main',  
                'update_data': {
                  'main_desc' : mainDesc,
                  'code' : code
                },
                'field_where': 'main_code', 
                'where_val': mainCode 
                },
    success:function(res){
      if (res.param3=='success') {
        Swal.fire(
          res.param1,
          res.param2,
          res.param3
        );
        $(d).parents('tr').find('td:eq(2)').html(code);
        $(d).parents('tr').find('td:eq(3)').html(mainDesc);
        $(d).parent('td').html('<a href="javascript:void(0);" onclick="editMainCodeCoa(this)" data-mcode="'
                          +mainCode+
                          '"><i class="fas fa-edit" data-toogle="tooltip" data-placement="right" title="Edit"></i></a> | <a href="javascript:void(0);" onclick="deleteData(this)" data-fld="main_code" data-tbl="account_main" data-code="'
                          +mainCode+
                          '"><i class="fas fa-trash" data-toogle="tooltip" data-placement="right" title="Delete"></i></a>');  
      } else {
        Swal.fire(
          res.param1,
          res.param2,
          res.param3
        );
      }
      
    }
  });
}

function deleteData(d){
  var acctCode = d.getAttribute('data-code');
  var tbl      = d.getAttribute('data-tbl');
  var field    = d.getAttribute('data-fld');
  customSwal(
        'btn btn-success', 
        'btn btn-danger mr-2', 
        'Yes', 
        'Wait', 
        ['', 'Are you sure you want to delete this account ? ' + (field == 'group_code' ? 'Note: if you click YES the sub accident  ount for this account will automatically deleted!' : ''), 'question'], 
        function(){
            $.ajax({
                url      : 'update-data',
                type     : 'POST',
                dataType : 'JSON',
                context  : this,
                data     : {'tbl': tbl,  
                            'update_data': {
                              'is_deleted' : 1,
                            },
                            'field_where': field, 
                            'where_val': acctCode 
                            },
                success:function(res){
                  Swal.fire(
                    res.param1,
                    res.param2,
                    res.param3
                  );
                  if (res.param3=='success') {
                    if (field == 'group_code') {
                      $('a[data-link=view-setting-page]').trigger('click');
                    } else {
                      $(d).parents('tr').remove();
                    }

                  }
                }
              });
          }, function(){
            console.log('Fail');
      });
}

// function exportCrj(elem) {
//   var table = document.getElementById('tbl-crj-report-excel');
//   var html = table.outerHTML;
//   var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
//   elem.setAttribute("href", url);
//   elem.setAttribute("download", "crj-report-excel.xls"); // Choose the file name
//   return false;
// }

function exportF(elem) {
  var table = document.getElementById('table-to-excel');
  var html = table.outerHTML;
  var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
  elem.setAttribute("href", url);
  elem.setAttribute("download", "benefit-claimed.xls"); // Choose the file name
  return false;
}

function exportMemberContribution(elem) {
  var table = document.getElementById('members-contribution-excel');
  var html = table.outerHTML;
  var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
  elem.setAttribute("href", url);
  elem.setAttribute("download", "contribution-members.xls"); // Choose the file name
  return false;
}

function exportCashGift(elem) {
  var table = document.getElementById('members-contribution-excel');
  var html = table.outerHTML;
  var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
  elem.setAttribute("href", url);
  elem.setAttribute("download", "cash-gift.xls"); // Choose the file name
  return false;
}

function computeDebitCredit(){
  var debit=0;
  var credit=0;
  $.each($('.debit'), function(index, el) {
    debit+=strToFloat($(el).val()==''?'0':$(el).val())
  }); 
  $.each($('.credit'), function(index, el) {
    credit+=strToFloat($(el).val()==''?'0':$(el).val())
  });
  $('.total_debit').html(number_format(debit));
  $('.total_credit').html(number_format(credit));
}

function removeJournal(d){
  var id  = d.getAttribute('data-id');
  customSwal(
    'btn btn-success', 
    'btn btn-danger mr-2', 
    'Yes', 
    'Wait',   
    ['', 'Are you sure you want to delete ?', 'question'], 
    function(){
        $.post('delete-journal', { 'id': id }, function(data, textStatus, xhr) {
          var r = $.parseJSON(data);
          Swal.fire(
            r.param1,
            r.param2,
            r.param3
          );
          tbl_cdj_entry.ajax.reload();
          tbl_pacs_entry.ajax.reload();
          tbl_gj_entry.ajax.reload();
          tbl_crj_entry.ajax.reload();
        });
      }, function(){
        console.log('Fail');
  });
}

function formatDate(date) {
  var d = new Date(date),
      month = '' + (d.getMonth() + 1),
      day = '' + d.getDate(),
      year = d.getFullYear();

  if (month.length < 2) 
      month = '0' + month;
  if (day.length < 2) 
      day = '0' + day;

  return [year, month, day].join('-');
}

function formatDateOthFormat(date) {
  var d = new Date(date),
      month = '' + (d.getMonth() + 1),
      day = '' + d.getDate(),
      year = d.getFullYear();

  if (month.length < 2) 
      month = '0' + month;
  if (day.length < 2) 
      day = '0' + day;

  return [month, day, year].join('/');
}