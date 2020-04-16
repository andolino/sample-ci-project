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
$route['default_controller'] 			= 'admin';
$route['member-list'] 						= 'Admin/member_list';
$route['settings'] 								= 'Admin/show_settings';
$route['view-setting-page'] 			= 'Admin/view_settings_page';
$route['view-coa'] 								= 'Admin/view_chart_of_accounts';
$route['view-loan-type'] 					= 'Admin/view_loan_code';
$route['view-loan-settings'] 			= 'Admin/view_loan_settings';
$route['add-loans'] 							= 'Admin/add_loans';
$route['show-sub-frm'] 						= 'Admin/show_sub_frm';
$route['show-loans-settings-frm'] = 'Admin/show_add_loans';
$route['show-frm-add-payments'] 	= 'Admin/show_add_payments';
$route['show-schedule-list'] 			= 'Admin/show_schedule_list';
$route['save-post-payment'] 			= 'Admin/savePostPayment';

$route['show-main-frm'] 					= 'Admin/show_main_frm';
$route['save-sub-account'] 				= 'Admin/save_sub_account';
$route['save-loans-settings'] 		= 'Admin/save_loans_settings';
$route['upload-dp'] 							= 'Admin/upload_const_dp';
$route['tbl-members'] 						= 'Admin/tbl_members';
$route['save-member'] 						= 'Admin/save_constituent';
$route['view-member'] 						= 'Admin/view_member';
$route['edit-member'] 						= 'Admin/edit_member';
$route['delete-member'] 					= 'Admin/deleteMember';
$route['delete-loan-settings'] 		= 'Admin/deleteLoanSettings';
$route['loans-application'] 			= 'Admin/loanApplication';
$route['view-loan-app-page'] 			= 'Admin/view_loan_app_page';
$route['process-a-loan'] 					= 'Admin/process_a_loan';
$route['edit-process-a-loan'] 		= 'Admin/edit_process_a_loan';
$route['server-tbl-members'] 			= 'Admin/server_tbl_members';
$route['server-tbl-settings'] 		= 'Admin/server_tbl_settings';
$route['server-tbl-loans-list'] 		= 'Admin/server_tbl_loans_list';
$route['add-member'] 							= 'Admin/add_member';
$route['save-loan-comp'] 					= 'Admin/saveLoanComp';
$route['compute-loans'] 					= 'Admin/computeLoans';	
$route['show-loans-list'] 				= 'Admin/showLoansList';
$route['show-loans-by-member'] 		= 'Admin/showLoansByMember';
$route['server-loans-by-member'] 		= 'Admin/server_loans_by_member';
$route['post-loan-comp'] 					= 'Admin/postLoanComp';

$route['pdf-vloan-comp'] 					= 'Admin/pdfVloanComp';





$route['login'] 											= 'Admin/usr_login';
$route['submit-login'] 								= 'Admin/proceed_login';
$route['logout'] 											= 'Admin/destroy_sess';
$route['lgu-id/(:any)'] 							= 'Admin/showID';
$route['lgu-c-details'] 							= 'Admin/fetch_indvl_details';
$route['show-multiple-ids'] 					= 'Admin/show_multiple_ids';
$route['show-mltple-const/(:any)'] 		= 'Admin/show_multiple_constituent';
$route['control-token'] 							= 'Admin/control_token';
$route['show-gen-token'] 							= 'Admin/show_gen_token';
$route['generate-token'] 							= 'Admin/generateToken';
$route['save-token'] 									= 'Admin/saveToken';



$route['404_override'] 					= '';
$route['translate_uri_dashes'] 	= FALSE;
