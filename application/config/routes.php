<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] 			 		= 'admin/show_settings';
$route['member-list'] 						 		= 'Admin/member_list';
$route['settings'] 								 		= 'Admin/show_settings';
$route['view-setting-page'] 			 		= 'Admin/view_settings_page';
$route['view-coa'] 								 		= 'Admin/view_chart_of_accounts';
$route['loan-by-member'] 					 		= 'Admin/loanByMember';
$route['loan-request']                = 'Admin/loan_request_by_member';
$route['benefit-request']                = 'Admin/benefit_request_by_member';
$route['loan-list'] 							 		= 'Admin/loanList';
$route['claim-benefit'] 					 		= 'Admin/viewClaimBenefit';
$route['show-claim-benefit'] 			 		= 'Admin/showBenefitClaim';
$route['add-contribution'] 				 		= 'Admin/frmAddContribution';
$route['add-contribution-by-type'] 		= 'Admin/frmAddContributionByType';
$route['add-loan-payments-by-type'] 		= 'Admin/frmAddLoanPaymentsByType';
$route['save-contribution'] 			 		= 'Admin/saveContribution';
$route['save-contribution-by-type'] 			 		= 'Admin/saveContributionByType';
$route['save-payments-by-type'] 			 		= 'Admin/saveLoanPaymentsByType';
$route['save-benefit-claim'] 			 		= 'Admin/saveBenefitClaim';
$route['cdj-transaction'] 				 		= 'Admin/viewCheckDisbursement';
$route['crj-transaction'] 				 		= 'Admin/viewCashReceiptJournal';
$route['general-journal'] 				 		= 'Admin/viewGeneralJournal';
$route['general-ledger'] 					 		= 'Admin/viewGeneralLedger';
$route['trial-balance'] 					 		= 'Admin/viewTrialBalance';
$route['balance-sheet'] 					 		= 'Admin/viewBalanceSheet';
$route['income-statement'] 				 		= 'Admin/viewIncomeStatement';
$route['pacs-transaction'] 				 		= 'Admin/viewPacsTransaction';
$route['cdj-posted'] 							 		= 'Admin/viewPostedCheckDisbursement';
$route['crj-posted'] 							 		= 'Admin/viewPostedCashReceiptJournal';
$route['gj-posted'] 							 		= 'Admin/viewPostedGeneralJournal';
$route['pacs-posted'] 					   		= 'Admin/viewPostedPacs';
$route['get-coa'] 								 		= 'Admin/getChartOfAccounts';
$route['get-subsidiary'] 					 		= 'Admin/getSubsidiaryAccounts';
$route['print-members-docx'] 			 		= 'Admin/printMembersDocx';
$route['print-cash-gift-docx'] 			 		= 'Admin/printCashGiftDocx';
$route['get-members-print-to-excel'] 	= 'Admin/getMembersPrintToExcel';
$route['get-members-print-to-pdf/(:any)'] 	= 'Portal/getMembersPrintToPDF';
$route['get-members-print-to-pdf/(:any)/(:any)/(:any)/(:any)/(:any)'] 	= 'Admin/getMembersPrintToPDF';
$route['get-cash-gift-to-excel'] 	= 'Admin/getCashiGiftPrintToExcel';
$route['search-trial-balance'] 				= 'Admin/searchTrialBalance';
$route['get-last-date-applied-cont'] 	= 'Admin/getLastdateApCont';
$route['get-last-date-applied-cg'] 	= 'Admin/getLastdateApCashGift';
$route['cash-gift'] 									= 'Admin/getCashGift';
$route['official-receipt'] 	= 'Admin/officialReceipt';
$route['get-total-contribution-per-region'] 	= 'Admin/getTotalContributionPerRegion';
$route['get-msg-frm'] 	= 'Admin/get_message_form';
$route['get-msg-simultaneous'] 	= 'Admin/get_message_simultaneous';
$route['save-msg-feedback-admin'] 	= 'Admin/save_msg_feedback_admin';

//member's portal
$route['portal'] 	= 'Portal';
$route['view-portal-profile'] 	= 'Portal/show_profile';
$route['view-loan-request-frm'] 	= 'Portal/show_loan_request';
$route['view-contribution-frm'] 	= 'Portal/show_contribution';
$route['view-benefit-claim-frm'] 	= 'Portal/show_benefit_claims';
$route['portal-login'] 	        = 'Portal/members_login';
$route['submit-member-login'] 			    = 'Portal/proceed_login';
$route['logout-portal'] 											= 'Portal/destroy_sess';
$route['save-member-info'] 						= 'Portal/save_members_info';
$route['update-mem-password'] 						= 'Portal/update_member_password';
$route['upload-files'] 						= 'Portal/upload_files';
$route['upload-files-benefit'] 						= 'Portal/upload_files_benefit';
$route['view-ln-req-msg'] 						= 'Portal/view_loan_comments';
$route['get-loan-settings'] 						= 'Portal/get_loan_settings';



//accounting
$route['save-acctg-entry'] 		= 'Accounting/saveAcctgEntry';
$route['delete-journal'] 		= 'Accounting/deleteJournal';

//CRUD
$route['delete-data'] 	= 'Settings/deleteData';
$route['add-data'] 	= 'Settings/addData';


$route['view-users'] 						 	= 'Settings/view_users';
$route['server-users'] 	= 'Settings/server_users';
$route['server-signatory'] 	= 'Settings/server_signatory';
$route['server-subsidiary'] 	= 'Settings/server_subsidiary';
$route['server-office'] 	= 'Settings/server_office';
$route['server-loan-type'] 	= 'Settings/server_loan_type';
$route['server-benefit-type'] 	= 'Settings/server_benefit_type';

$route['server-member-type'] 	= 'Settings/server_member_type';
$route['server-civil-status'] 	= 'Settings/server_civil_status';
$route['server-relationship-type'] 	= 'Settings/server_relationship_type';
$route['server-beneficiaries'] 	= 'Settings/server_beneficiaries';
$route['server-members-beneficiaries'] 	= 'Settings/server_members_beneficiaries';
$route['server-members-immediate-family'] 	= 'Settings/server_members_immediate_family';
$route['server-immediate-family'] 	= 'Settings/server_immediate_family';
$route['server-departments'] 	= 'Settings/server_departments';
$route['server-contribution-rate'] 	= 'Settings/server_contribution_rate';

$route['get-beneficiaries-members'] 	= 'Settings/getBeneficiariesMembers';
$route['get-immediate-family'] 	= 'Settings/getImmediateFamilyMembers';


$route['save-users-data'] 	= 'Settings/saveUsersData';
$route['save-contribution-rate'] 			= 'Settings/saveContributionRate';
$route['get-users-frm'] 	= 'Settings/getUsersFrm';
$route['get-users-frm-fp'] 	= 'Settings/getUsersFrmFp';
$route['get-signatory-frm'] 	= 'Settings/getSignatoryFrm';
$route['get-subsidiary-frm'] 	= 'Settings/getSubsidiaryFrm';
$route['get-office-frm'] 	= 'Settings/getOfficeFrm';
$route['get-loan-types-frm'] 	= 'Settings/getLoanTypesFrm';
$route['get-benefit-type-frm'] 	= 'Settings/getBenefiTypesFrm';

$route['get-member-type-frm'] 	= 'Settings/getMemberTypeFrm';
$route['get-civil-status-frm'] 	= 'Settings/getCivilStatusFrm';
$route['get-departments-frm'] 	= 'Settings/getDepartmentsFrm';
$route['get-relationship-type-frm'] 	= 'Settings/getRelationshipTypeFrm';
$route['get-beneficiaries-frm'] 	= 'Settings/getBeneficiariesFrm';
$route['get-immediate-family-frm'] 	= 'Settings/getImmediateFamilyFrm';
$route['get-frm-contribution-rate'] 	= 'Settings/getContributionRate';

$route['view-signatory'] 					= 'Settings/view_signatory';	
$route['view-subidiary'] 					= 'Settings/view_subidiary';	
$route['view-office'] 						= 'Settings/view_office';
$route['view-member-type'] 				= 'Settings/view_member_type';
$route['view-civil-status'] 			= 'Settings/view_civil_status';
$route['view-relationship-type'] 	= 'Settings/view_relationship_type';
$route['view-beneficiaries'] 			= 'Settings/view_beneficiaries';
$route['view-immediate-family'] 	= 'Settings/view_immediate_family';
$route['view-contribution-rate'] 	= 'Settings/view_contribution_rate';
$route['view-loan-ltype'] 				= 'Settings/view_loan_type';
$route['view-benefit-type'] 			= 'Settings/view_benefit_type';
$route['view-departments'] 				= 'Settings/view_departments';
$route['view-approval-settings'] 	= 'Settings/view_approval_settings';
$route['save-loan-approval-settings'] 	= 'Settings/save_loan_approval_settings';
$route['save-benefit-approval-settings'] 	= 'Settings/save_benefit_approval_settings';

$route['view-loan-type'] 					= 'Admin/view_loan_code';
$route['view-loan-settings'] 			= 'Admin/view_loan_settings';
$route['add-loans'] 							= 'Admin/add_loans';
$route['show-sub-frm'] 						= 'Admin/show_sub_frm';
$route['show-loans-settings-frm'] = 'Admin/show_add_loans';
$route['show-cash-gift-frm'] 			= 'Admin/show_add_cash_gift';
$route['show-cash-gift-frm-per-region'] 			= 'Admin/show_add_cash_gift_per_region';
$route['show-or-frm-per-region'] 			= 'Admin/show_official_receipt';
$route['show-frm-add-payments'] 	= 'Admin/show_add_payments';
$route['show-loan-req-attachments'] 	= 'Admin/show_loan_request_attachments';
$route['show-benefit-req-attachments'] 	= 'Admin/show_benefit_request_attachments';
$route['show-schedule-list'] 			= 'Admin/show_schedule_list';
$route['show-edit-payment-list'] 			= 'Admin/show_edit_payment_list';
$route['save-update-payments'] 			= 'Admin/save_update_payments';
$route['save-post-payment'] 			= 'Admin/savePostPayment';
$route['get-loan-settings-code'] 	= 'Admin/getSettingsCode';
$route['get-other-benefit-form'] 	= 'Admin/getOtherBenefitForm';

$route['show-main-frm'] 					= 'Admin/show_main_frm';
$route['save-sub-account'] 				= 'Admin/save_sub_account';
$route['save-loans-settings'] 		= 'Admin/save_loans_settings';
$route['save-cash-gift'] 					= 'Admin/save_cash_gift';
$route['get-cg-rate-per-member'] 	= 'Admin/getCgAmntPerMember';
$route['get-cg-rate-per-region'] 	= 'Admin/getCgAmntPerRegion';
$route['upload-dp'] 							= 'Admin/upload_const_dp';
$route['tbl-members'] 						= 'Admin/tbl_members';
$route['save-member'] 						= 'Admin/save_constituent';
$route['view-member'] 						= 'Admin/view_member';
$route['process-claim-benefit'] 				  = 'Admin/process_benefit_claim';
$route['server-tbl-claim-benefit-members'] 	= 'Admin/server_tbl_claim_benefit_members';
$route['edit-member'] 						= 'Admin/edit_member';
$route['view-contribution'] 			= 'Admin/view_contribution';
$route['delete-member'] 					= 'Admin/deleteMember';
$route['delete-loan-settings'] 		= 'Admin/deleteLoanSettings';
$route['loans-application'] 			= 'Admin/loanApplication';
$route['view-loan-app-page'] 			= 'Admin/view_loan_app_page';
$route['process-a-loan'] 					= 'Admin/process_a_loan';
$route['edit-process-a-loan'] 		= 'Admin/edit_process_a_loan';
$route['server-tbl-members'] 			= 'Admin/server_tbl_members';
$route['server-contribution'] 		= 'Admin/server_tbl_contribution';
$route['server-cdj-entry'] 		= 'Admin/server_cdj_entry';
$route['server-crj-entry'] 		= 'Admin/server_crj_entry';
$route['server-gj-entry'] 		= 'Admin/server_gj_entry';
$route['server-pacs-entry'] 		= 'Admin/server_pacs_entry';
$route['server-co-maker'] 				= 'Admin/server_co_maker';
$route['server-tbl-settings'] 		= 'Admin/server_tbl_settings';
$route['server-tbl-loans-list'] 		= 'Admin/server_tbl_loans_list';
$route['server-general-ledger'] 	= 'Admin/serverGeneralLedger';
$route['server-cash-gift'] 	= 'Admin/serverCashGift';
$route['server-official-receipt'] 	= 'Admin/serverOfficialReceipt';
$route['server-get-repayment-list'] = 'Admin/server_tbl_repayments';
$route['save-approval-loan-request'] = 'Admin/save_approval_loan_request';
$route['save-approval-benefit-request'] = 'Admin/save_approval_benefit_request';






$route['add-member'] 							= 'Admin/add_member';
$route['add-cdj-entry'] 							= 'Admin/addCdjEntry';
$route['add-crj-entry'] 							= 'Admin/addCrjEntry';
$route['add-gj-entry'] 							= 'Admin/addGjEntry';
$route['add-pacs-entry'] 							= 'Admin/addPacsEntry';
$route['tbl-cdj-page'] 								= 'Admin/tblCdjPage';
$route['tbl-crj-page'] 								= 'Admin/tblCrjPage';
$route['tbl-gj-page'] 								= 'Admin/tblGjPage';
$route['tbl-pacs-page'] 								= 'Admin/tblPacsPage';
$route['save-loan-comp'] 					= 'Admin/saveLoanComp';
$route['compute-loans'] 					= 'Admin/computeLoans';	
$route['show-loans-list'] 				= 'Admin/showLoansList';
$route['show-loans-by-member'] 		= 'Admin/showLoansByMember';
$route['server-loans-by-member'] 	= 'Admin/server_loans_by_member';
$route['server-loans-by-request'] 	= 'Admin/server_loans_by_request';
$route['server-benefit-by-request'] 	= 'Admin/server_benefit_by_request';
$route['server-portal-loans-request'] 	= 'Admin/server_portal_loans_request';
$route['server-portal-benefit-request'] 	= 'Admin/server_portal_benefit_request';
$route['server-portal-loan-request-attmnt'] 	= 'Admin/server_portal_loan_req_attmnt';
$route['server-benefit-list-claimed-by-member'] 	= 'Admin/server_benefit_claim_by_member';
$route['post-loan-comp'] 					= 'Admin/postLoanComp';
$route['get-previous-loan'] 			= 'Admin/getPreviousLoan';
$route['get-print-loan-comp'] 	 	= 'Admin/getPrintLoanComp';
$route['show-co-maker'] 	 				= 'Admin/showComaker';
$route['show-co-maker-members-list'] = 'Admin/server_co_maker_members_list';
$route['insert-co-maker'] = 'Admin/insert_co_maker';
$route['remove-co-maker'] = 'Admin/remove_co_maker';
$route['save-co-maker'] = 'Admin/save_co_maker';
$route['update-data'] = 'Admin/updateData';
$route['get-frm-benefit-claim'] = 'Admin/getFrmBenefitClaim';
$route['compute-oth-benefit'] = 'Admin/computeOthBenefit';
$route['remove-benefit-claim'] = 'Admin/removeBenefitClaim';
$route['get-payee-type'] = 'Admin/getPayeeType';
$route['show-choose-date-post'] = 'Admin/showChooseDatePost';
$route['show-choose-region-type'] = 'Admin/showChooseRegionType';
$route['post-acct-entry'] = 'Admin/postAcctEntry';
$route['save-official-receipt'] = 'Admin/saveOfficialReceipt';

$route['pdf-vloan-comp/(:any)'] 	= 'Admin/pdfVloanComp';

$route['login'] 											= 'Admin/usr_login';
$route['forgot-password'] 					  = 'Admin/forgot_password';
$route['submit-login'] 								= 'Admin/proceed_login';
$route['submit-forgot-pw'] 						= 'Admin/proceed_fg_pw';
$route['entry-new-password/(:any)']          = 'Admin/entry_new_password';
$route['submit-new-password']          = 'Admin/submit_new_password';
$route['logout'] 											= 'Admin/destroy_sess';
$route['lgu-id/(:any)'] 							= 'Admin/showID';
$route['lgu-c-details'] 							= 'Admin/fetch_indvl_details';
$route['show-multiple-ids'] 					= 'Admin/show_multiple_ids';
$route['show-mltple-const/(:any)'] 		= 'Admin/show_multiple_constituent';
$route['control-token'] 							= 'Admin/control_token';
$route['show-gen-token'] 							= 'Admin/show_gen_token';
$route['generate-token'] 							= 'Admin/generateToken';
$route['save-token'] 									= 'Admin/saveToken';

//reports
$route['crj-summary-report/(:any)/(:any)'] = 'Reports/crjSummaryReport';
$route['crj-contribution-and-payment/(:any)/(:any)/(:any)'] = 'Reports/contributionAndPayments';
$route['print-official-receipt/(:any)'] = 'Reports/printOR';
$route['print-pacs-report/(:any)/(:any)'] = 'Reports/pacsSummaryReport';
$route['print-cdj-report/(:any)/(:any)'] = 'Reports/cdjSummaryReport';
$route['print-gj-report/(:any)/(:any)'] = 'Reports/gjSummaryReport';




$route['404_override'] 					= '';
$route['translate_uri_dashes'] 	= FALSE;
