<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
//get site_align setting
$settings = $this->db->select("site_align")
    ->get('setting')
    ->row();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title><?= display('dashboard') ?> - <?php echo (!empty($title)?$title:null) ?></title>

        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="<?= base_url($this->session->userdata('favicon')) ?>">

        <!-- jquery ui css -->
        <link href="<?php echo base_url('assets/css/jquery-ui.min.css') ?>" rel="stylesheet" type="text/css"/>

        <!-- Bootstrap --> 
        <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <?php if (!empty($settings->site_align) && $settings->site_align == "RTL") {  ?>
            <!-- THEME RTL -->
            <link href="<?php echo base_url(); ?>assets/css/bootstrap-rtl.min.css" rel="stylesheet" type="text/css"/>
            <link href="<?php echo base_url('assets/css/custom-rtl.css') ?>" rel="stylesheet" type="text/css"/>
        <?php } ?>



        <!-- Font Awesome 4.7.0 -->
        <link href="<?php echo base_url('assets/css/font-awesome.min.css') ?>" rel="stylesheet" type="text/css"/>

        <!-- semantic css -->
        <link href="<?php echo base_url(); ?>assets/css/semantic.min.css" rel="stylesheet" type="text/css"/> 
        <!-- sliderAccess css -->
        <link href="<?php echo base_url(); ?>assets/css/jquery-ui-timepicker-addon.min.css" rel="stylesheet" type="text/css"/> 
        <!-- slider  -->
        <link href="<?php echo base_url(); ?>assets/css/select2.min.css" rel="stylesheet" type="text/css"/> 
        <!-- DataTables CSS -->
        <link href="<?= base_url('assets/datatables/css/dataTables.min.css') ?>" rel="stylesheet" type="text/css"/> 
  

        <!-- pe-icon-7-stroke -->
        <link href="<?php echo base_url('assets/css/pe-icon-7-stroke.css') ?>" rel="stylesheet" type="text/css"/> 
        <!-- themify icon css -->
        <link href="<?php echo base_url('assets/css/themify-icons.css') ?>" rel="stylesheet" type="text/css"/> 
        <!-- Pace css -->
        <link href="<?php echo base_url('assets/css/flash.css') ?>" rel="stylesheet" type="text/css"/>

        <!-- Theme style -->
        <link href="<?php echo base_url('assets/css/custom.css') ?>" rel="stylesheet" type="text/css"/>
        <?php if (!empty($settings->site_align) && $settings->site_align == "RTL") {  ?>
            <!-- THEME RTL -->
            <link href="<?php echo base_url('assets/css/custom-rtl.css') ?>" rel="stylesheet" type="text/css"/>
        <?php } ?>


        <!-- jQuery  -->
        <script src="<?php echo base_url('assets/js/jquery.min.js') ?>" type="text/javascript"></script>

    </head>

    <body class="hold-transition sidebar-mini">
        <div class="se-pre-con"></div>

        <!-- Site wrapper -->
        <div class="wrapper">
            <header class="main-header"> 
                <?php $logo = $this->session->userdata('logo'); ?>
                <a href="<?php echo base_url('dashboard_pharmacist/home') ?>" class="logo"> <!-- Logo -->
                    <span class="logo-mini">
                        <img src="<?php echo (!empty($logo)?base_url($logo):base_url("assets/images/logo.png")) ?>" alt="">
                    </span>
                    <span class="logo-lg">
                        <img src="<?php echo (!empty($logo)?base_url($logo):base_url("assets/images/logo.png")) ?>" alt="">
                    </span>
                </a>

                <!-- Header Navbar -->
                <nav class="navbar navbar-static-top">
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button"> <!-- Sidebar toggle button-->
                        <span class="sr-only">Toggle navigation</span>
                        <span class="pe-7s-keypad"></span>
                    </a>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!-- settings -->
                            <li class="dropdown dropdown-user">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="pe-7s-settings"></i></a>
                                <ul class="dropdown-menu">
                                    <li><a href="<?php echo base_url('dashboard_pharmacist/home/profile'); ?>"><i class="pe-7s-users"></i> <?php echo display('profile') ?></a></li>
                                    <li><a href="<?php echo base_url('dashboard_pharmacist/home/form'); ?>"><i class="pe-7s-settings"></i> <?php echo display('edit_profile') ?></a></li>
                                    <li><a href="<?php echo base_url('dashboard_pharmacist/home/logout') ?>"><i class="pe-7s-key"></i> <?php echo display('logout') ?></a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>

            <!-- =============================================== -->
            <!-- Left side column. contains the sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar -->
                <div class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel text-center">
                        <?php $picture = $this->session->userdata('picture'); ?>
                        <div class="image">
                            <img src="<?php echo (!empty($picture)?base_url($picture):base_url("assets/images/no-img.png")) ?>" class="img-circle" alt="User Image">
                        </div>
                        <div class="info">
                            <p><?php echo $this->session->userdata('fullname') ?></p>
                            <a href="#"><i class="fa fa-circle text-success"></i>
                            <?php   
                                $userRoles = array( 
                                    '1' => display('admin'),
                                    '2' => display('doctor'),
                                    '3' => display('accountant'),
                                    '4' => display('laboratorist'),
                                    '5' => display('nurse'),
                                    '6' => display('pharmacist'),
                                    '7' => display('receptionist'),
                                    '8' => display('representative') 
                                ); 
                                echo $userRoles[$this->session->userdata('user_role')];
                            ?></a>
                        </div>
                    </div> 

                    <!-- sidebar menu -->
                    <ul class="sidebar-menu"> 
                        <li class="<?php echo (($this->uri->segment(2) == 'home') ? "active" : null) ?>">
                            <a href="<?php echo base_url('dashboard_pharmacist/home') ?>"><i class="fa ti-home"></i> <?php echo display('dashboard') ?></a>
                        </li> 









                        <!-- Invoice menu start -->
            <li class="treeview <?php if ($this->uri->segment('3') == ("Cinvoice")) { echo "active";}else{ echo " ";}?>">
                <a href="#">
                    <i class="ti-layout-accordion-list"></i><span><?php echo display('invoice') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url('dashboard_pharmacist/invoice/Cinvoice')?>"><?php echo display('new_invoice') ?></a></li>
                    <li><a href="<?php echo base_url('dashboard_pharmacist/invoice/Cinvoice/manage_invoice')?>"><?php echo display('manage_invoice') ?></a></li>
                    <!-- <li><a href="<?php echo base_url('dashboard_pharmacist/invoice/Cinvoice/pos_invoice')?>"><?php echo display('pos_invoice') ?></a></li> -->
                </ul>
            </li>
            <!-- Invoice menu end -->

            <!-- Product menu start -->
            <li class="treeview <?php if ($this->uri->segment('3') == ("Cproduct")) { echo "active";}else{ echo " ";}?>">
                <a href="#">
                    <i class="ti-bag"></i><span><?php echo display('product') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url('dashboard_pharmacist/hospital_activities/Cproduct')?>"><?php echo display('add_medicine') ?></a></li>
                    <li><a href="<?php echo base_url('dashboard_pharmacist/hospital_activities/Cproduct/add_product_csv')?>"><?php echo display('import_product_csv') ?></a></li>
                    <li><a href="<?php echo base_url('dashboard_pharmacist/hospital_activities/Cproduct/manage_product')?>"><?php echo display('manage_product') ?></a></li>
                </ul>
            </li>
            <!-- Product menu end -->
            <!-- Customer menu start -->
            <li class="treeview <?php if ($this->uri->segment('3') == ("Cpatient")) { echo "active";}else{ echo " ";}?>">
                <a href="#">
                    <i class="fa fa-handshake-o"></i><span><?php echo display('customer') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <!-- <li><a href="<?php echo base_url('dashboard_pharmacist/patient/Cpatient/Cpatient')?>"><?php echo display('add_customer') ?></a></li>
                    <li><a href="<?php echo base_url('dashboard_pharmacist/patient/Cpatient/manage_customer')?>"><?php echo display('manage_customer') ?></a></li> -->
                    <li><a href="<?php echo base_url('dashboard_pharmacist/patient/Cpatient/credit_customer')?>"><?php echo display('credit_customer') ?></a></li>
                    <li><a href="<?php echo base_url('dashboard_pharmacist/patient/Cpatient/paid_customer')?>"><?php echo display('paid_customer') ?></a></li>
                </ul>
            </li>
            <!-- Customer menu end -->
            <!-- Category menu start -->
            <li class="treeview <?php if ($this->uri->segment('3') == ("Ccategory")) { echo "active";}else{ echo " ";}?>">
                <a href="#">
                    <i class="ti-tag"></i><span><?php echo display('category') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url('dashboard_pharmacist/category/Ccategory')?>"><?php echo display('add_medicine_category') ?></a></li>
                    <li><a href="<?php echo base_url('dashboard_pharmacist/category/Ccategory/manage_category')?>"><?php echo display('medicine_category_list') ?></a></li>
                </ul>
            </li>
            <!-- Category menu end -->
            <!-- Supplier menu start -->
            <li class="treeview <?php if ($this->uri->segment('3') == ("Csupplier")) { echo "active";}else{ echo " ";}?>">
                <a href="#">
                    <i class="ti-user"></i><span><?php echo display('supplier') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url('dashboard_pharmacist/supplier/Csupplier')?>"><?php echo display('add_supplier') ?></a></li>
                    <li><a href="<?php echo base_url('dashboard_pharmacist/supplier/Csupplier/manage_supplier')?>"><?php echo display('manage_supplier') ?></a></li>
                    
                    <li><a href="<?php echo base_url('dashboard_pharmacist/supplier/Csupplier/supplier_ledger_report')?>"><?php echo display('supplier_ledger') ?></a></li>
                     <li><a href="<?php echo base_url('dashboard_pharmacist/supplier/Csupplier/supplier_sales_details_all')?>"><?php echo display('supplier_sales_details') ?></a></li> 
                </ul>
            </li>
            <!-- Supplier menu end -->
            <!-- Purchase menu start -->
            <li class="treeview <?php if ($this->uri->segment('2') == ("Cpurchase")) { echo "active";}else{ echo " ";}?>">
                <a href="#">
                    <i class="ti-shopping-cart"></i><span><?php echo display('purchase') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url('dashboard_pharmacist/purchase/Cpurchase')?>"><?php echo display('add_purchase') ?></a></li>
                    <li><a href="<?php echo base_url('dashboard_pharmacist/purchase/Cpurchase/manage_purchase')?>"><?php echo display('manage_purchase') ?></a></li>
                </ul>
            </li>
            <!-- Purchase menu end -->   
                <!-- start return -->
            <li class="treeview <?php if ($this->uri->segment('3') == ("Cretrun_m")) { echo "active";}else{ echo " ";}?>">
                <a href="#">
                   <i class="fa fa-retweet" aria-hidden="true"></i><span><?php echo display('return');?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url('dashboard_pharmacist/return/Cretrun_m')?>"><?php echo display('return');?></a></li>
                     <li><a href="<?php echo base_url('dashboard_pharmacist/return/Cretrun_m/return_list')?>"><?php echo display('stock_return_list') ?></a></li>
                        <li><a href="<?php echo base_url('dashboard_pharmacist/return/Cretrun_m/supplier_return_list')?>"><?php echo display('supplier_return_list') ?></a></li>
                      <li><a href="<?php echo base_url('dashboard_pharmacist/return/Cretrun_m/wastage_return_list')?>"><?php echo display('wastage_return_list') ?></a></li>
                   
                </ul>
            </li>
            <li class="<?php echo (($this->uri->segment(1) == "prescription") ? "active" : null) ?>"><a href="<?php echo base_url("dashboard_pharmacist/prescription/prescription") ?>"><i class="fa ti-book"></i><?php echo display('prescription_list') ?></a></li>
            
            <!-- Search menu start -->
            <li class="treeview <?php if ($this->uri->segment('2') == ("Csearch")) { echo "active";}else{ echo " ";}?>">
                <a href="#">
                    <i class="ti-search"></i><span><?php echo display('search') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url('dashboard_pharmacist/search/Csearch/medicine')?>"><?php echo display('product') ?></a></li>
                    <li><a href="<?php echo base_url('dashboard_pharmacist/search/Csearch/customer')?>"><?php echo display('customer') ?> </a></li>
                    <li><a href="<?php echo base_url('dashboard_pharmacist/search/Csearch/invoice')?>"><?php echo display('invoice') ?> </a></li>
                    <li><a href="<?php echo base_url('dashboard_pharmacist/search/Csearch/purchase')?>"><?php echo display('purchase') ?> </a></li>
                </ul>
            </li>
            <!-- Search menu end -->
            <!-- Transection menu start -->
            <li class="treeview <?php if ($this->uri->segment('3') == ("Caccounts") || $this->uri->segment('1') == ("Account_Controller") || $this->uri->segment('3') == ("Cpayment")) { echo "active";}else{ echo " ";}?>">
                <a href="#">
                    <i class="fa fa-money"></i><span><?php echo display('accounts') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <!-- <li><a href="<?php echo base_url('dashboard_pharmacist/Account_Controller')?>"><?php echo display('add_account')?></a></li>
                    <li><a href="<?php echo base_url('dashboard_pharmacist/Account_Controller/manage_account')?>"><?php echo display('manage_account')?></a></li> -->
                    <li><a href="<?php echo base_url('dashboard_pharmacist/payment/Cpayment')?>"><?php echo display('payment')?></a></li>
                    <li><a href="<?php echo base_url('dashboard_pharmacist/payment/Cpayment/receipt_transaction')?>"><?php echo display('receipt')?></a></li>
                    <li><a href="<?php echo base_url('dashboard_pharmacist/payment/Cpayment/manage_payment')?>"><?php echo display('manage_transaction')?></a></li>
                    <li><a href="<?php echo base_url('dashboard_pharmacist/payment/Cpayment/closing')?>"><?php echo display('closing') ?></a></li>
                    <li class="treeview <?php if ($this->uri->segment('3') == ("summaryy") || $this->uri->segment('3') == ("date_summary") || $this->uri->segment('3') == ("custom_report") || $this->uri->segment('3') == ("closing_report")) { echo "active";}else{ echo " ";}?>"><a href=""><?php echo display('report')?></a>
                    <ul class="treeview-menu">
                        <li><a href="<?php echo base_url('dashboard_pharmacist/payment/Cpayment/summaryy')?>"><?php echo display('daily_summary')?></a></li>
                        <li><a href="<?php echo base_url('dashboard_pharmacist/payment/Cpayment/date_summary')?>"><?php echo display('daily_cash_flow')?></a></li>
                        <li><a href="<?php echo base_url('dashboard_pharmacist/payment/Cpayment/custom_report')?>"><?php echo display('custom_report')?></a></li>
                        <li><a href="<?php echo base_url('dashboard_pharmacist/payment/Cpayment/closing_report')?>"><?php echo display('closing_report') ?></a></li>
                    </ul>

                    <li><a href="<?php echo base_url('dashboard_pharmacist/accounts/Caccounts/add_tax')?>"><?php echo display('add_tax') ?></a></li>
                    <li><a href="<?php echo base_url('dashboard_pharmacist/accounts/Caccounts/manage_tax')?>"><?php echo display('manage_tax') ?></a></li>
                   
                  </li>
                </ul>
            </li>
            <!-- Transection menu End -->
            <!-- Stock menu start -->
            <li class="treeview <?php if ($this->uri->segment('3') == ("Creport")) { echo "active";}else{ echo " ";}?>">
                <a href="#">
                    <i class="ti-bar-chart"></i><span><?php echo display('stock') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url('dashboard_pharmacist/reports/Creport')?>"><?php echo display('stock_report') ?></a></li>
                    <li><a href="<?php echo base_url('dashboard_pharmacist/reports/Creport/stock_report_supplier_wise')?>"><?php echo display('stock_report_supplier_wise') ?></a></li>
                    <li><a href="<?php echo base_url('dashboard_pharmacist/reports/Creport/stock_report_product_wise')?>"><?php echo display('stock_report_product_wise') ?></a></li>
                     <li><a href="<?php echo base_url('dashboard_pharmacist/reports/Creport/stock_report_batch_wise')?>"><?php echo display('stock_report_batch_wise') ?></a></li>
                </ul>
            </li>
            <!-- Stock menu end -->
            <!-- Report menu start -->
            <li class="treeview <?php if ($this->uri->segment('2') == ("Admin_dashboard") || $this->uri->segment('3') == ("all_report") || $this->uri->segment('3') == ("todays_sales_report") || $this->uri->segment('3') == ("todays_purchase_report") || $this->uri->segment('3') == ("product_sales_reports_date_wise") || $this->uri->segment('3') == ("total_profit_report") ) { echo "active";}else{ echo " ";}?>">
                <a href="#">
                    <i class="ti-book"></i><span><?php echo display('report') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url('dashboard_pharmacist/Admin_dashboard/all_report')?>"><?php echo display('todays_report') ?></a></li>
                    <li><a href="<?php echo base_url('dashboard_pharmacist/Admin_dashboard/todays_sales_report')?>"><?php echo display('sales_report') ?></a></li>
                    <li><a href="<?php echo base_url('dashboard_pharmacist/Admin_dashboard/todays_purchase_report')?>"><?php echo display('purchase_report') ?></a></li>
                    <li><a href="<?php echo base_url('dashboard_pharmacist/Admin_dashboard/product_sales_reports_date_wise')?>"><?php echo display('sales_report_product_wise') ?></a></li>
                  
                </ul>
            </li>
            <!-- Report menu end -->

            <!-- Bank menu start -->
            <li class="treeview <?php if ($this->uri->segment('2') == ("index") || $this->uri->segment('2') == ("bank_list") || $this->uri->segment('2') == ("bank_ledger") || $this->uri->segment('2') == ("bank_transaction")) { echo "active";}else{ echo " ";}?>">
                <a href="#">
                    <i class="ti-briefcase"></i><span><?php echo display('bank') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url('dashboard_pharmacist/Csettings/index')?>"><?php echo display('add_new_bank') ?></a></li>
                    <li><a href="<?php echo base_url('dashboard_pharmacist/Csettings/bank_transaction')?>"><?php echo display('bank_transaction') ?></a></li>
                    <li><a href="<?php echo base_url('dashboard_pharmacist/Csettings/bank_list')?>"><?php echo display('manage_bank') ?></a></li>
                </ul>
            </li>
            <!-- Bank menu end -->













































                        <!-- <li class="treeview <?php echo (($this->uri->segment(2) == "hospital_activities") ? "active" : null) ?>">
                            <a href="#">
                                <i class="fa fa-hospital-o"></i><span><?php echo display('hospital_activities') ?> </span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?php echo base_url('dashboard_pharmacist/hospital_activities/category/form') ?>"> <?php echo display('add_medicine_category') ?></a></li>
                                <li><a href="<?php echo base_url('dashboard_pharmacist/hospital_activities/category/index') ?>"><?php echo display('medicine_category_list') ?></a></li>
                                <li><a href="<?php echo base_url('dashboard_pharmacist/hospital_activities/medicine/form') ?>"> <?php echo display('add_medicine') ?></a></li>
                                <li><a href="<?php echo base_url('dashboard_pharmacist/hospital_activities/medicine/index') ?>"><?php echo display('medicine_list') ?></a></li>
                            </ul>
                        </li>  -->

                        <li class="<?php echo (($this->uri->segment(2) == 'noticeboard') ? "active" : null) ?>">
                            <a href="<?php echo base_url('dashboard_pharmacist/noticeboard/notice') ?>"><i class="fa fa-bell"></i> <?php echo display('noticeboard') ?></a>
                        </li>  
     
                        <li class="treeview <?php echo (($this->uri->segment(2) == "messages") ? "active" : null) ?>">
                            <a href="#">
                                <i class="fa fa-comments-o"></i><span><?php echo display('messages') ?></span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a> 
                            <ul class="treeview-menu">
                                <li><a href="<?php echo base_url("dashboard_pharmacist/messages/message/new_message") ?>"> <?php echo display('new_message') ?> </a></li> 
                                <li><a href="<?php echo base_url("dashboard_pharmacist/messages/message") ?>"> <?php echo display('inbox') ?> </a></li> 
                                <li><a href="<?php echo base_url("dashboard_pharmacist/messages/message/sent") ?>"><?php echo display('sent') ?> </a></li>
                            </ul>
                        </li>


                        <li class="<?php echo (($this->uri->segment(2) == 'mail') ? "active" : null) ?>">
                            <a href="<?php echo base_url('dashboard_pharmacist/mail/email') ?>"><i class="fa ti-email"></i> <?php echo display('send_mail') ?></a>
                        </li>  

                       <li class="treeview <?php echo (($this->uri->segment(2) == "sms") ? "active" : null) ?>">
                            <a href="#">
                                <i class="fa ti-comment-alt"></i><span><?php echo display('send_sms') ?></span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a> 
                            <ul class="treeview-menu">
                                <li><a href="<?php echo base_url("dashboard_pharmacist/sms/sms/new_sms") ?>"> <?php echo display('new_sms') ?> </a></li> 
                                <li><a href="<?php echo base_url("dashboard_pharmacist/sms/sms/sms_list") ?>"> <?php echo display('sms_list') ?> </a></li> 
                            </ul>
                        </li> 



     
                    </ul>
                </div> <!-- /.sidebar -->
            </aside>

            <!-- =============================================== -->
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="p-l-30 p-r-30">
                        <div class="header-icon"><i class="pe-7s-world"></i></div>
                        <div class="header-title">
                            <h1><?php echo ucwords(str_replace('_', ' ', $this->uri->segment(1))) ?></h1>
                            <small><?php echo (!empty($title)?$title:null) ?></small> 
                        </div>
                    </div>
                </section>
                <!-- Main content -->
                <div class="content"> 

                    <!-- alert message -->
                    <?php if ($this->session->flashdata('message') != null) {  ?>
                    <div class="alert alert-info alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <?php echo $this->session->flashdata('message'); ?>
                    </div> 
                    <?php } ?>
                    
                    <?php if ($this->session->flashdata('exception') != null) {  ?>
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <?php echo $this->session->flashdata('exception'); ?>
                    </div>
                    <?php } ?>
                    
                    <?php if (validation_errors()) {  ?>
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <?php echo validation_errors(); ?>
                    </div>
                    <?php } ?>
                   


                    <!-- content -->
                    <?php echo (!empty($content)?$content:null) ?>

                </div> <!-- /.content -->
            </div> <!-- /.content-wrapper -->

            <footer class="main-footer">
                <?= ($this->session->userdata('footer_text')!=null?$this->session->userdata('footer_text'):null) ?>
            </footer>
        </div> <!-- ./wrapper -->


        <!-- jquery-ui js -->
        <script src="<?php echo base_url('assets/js/jquery-ui.min.js') ?>" type="text/javascript"></script> 
        <!-- bootstrap js -->
        <script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>" type="text/javascript"></script>  
        <!-- pace js -->
        <script src="<?php echo base_url('assets/js/pace.min.js') ?>" type="text/javascript"></script>  
        <!-- SlimScroll -->
        <script src="<?php echo base_url('assets/js/jquery.slimscroll.min.js') ?>" type="text/javascript"></script>  

        <!-- bootstrap timepicker -->
        <script src="<?php echo base_url() ?>assets/js/jquery-ui-sliderAccess.js" type="text/javascript"></script> 
        <script src="<?php echo base_url() ?>assets/js/jquery-ui-timepicker-addon.min.js" type="text/javascript"></script> 
        <!-- select2 js -->
        <script src="<?php echo base_url() ?>assets/js/select2.min.js" type="text/javascript"></script>

        <script src="<?php echo base_url('assets/js/sparkline.min.js') ?>" type="text/javascript"></script> 
        <!-- Counter js -->
        <script src="<?php echo base_url('assets/js/waypoints.js') ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/js/jquery.counterup.min.js') ?>" type="text/javascript"></script> 
        <!-- semantic js -->
        <script src="<?php echo base_url() ?>assets/js/semantic.min.js" type="text/javascript"></script>
        <!-- DataTables JavaScript -->
        <script src="<?php echo base_url("assets/datatables/js/dataTables.min.js") ?>"></script>
        <!-- tinymce texteditor -->
        <script src="<?php echo base_url() ?>assets/tinymce/tinymce.min.js" type="text/javascript"></script> 

        <!-- Admin Script -->
        <script src="<?php echo base_url('assets/js/frame.js') ?>" type="text/javascript"></script> 

        <!-- Custom Theme JavaScript -->
        <script src="<?php echo base_url() ?>assets/js/custom.js" type="text/javascript"></script>
    </body>
</html>