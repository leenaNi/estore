<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>{{App\Library\Helper::getSettings()['storeName']}} | Online Store Admin</title>
<!-- Tell the browser to be responsive to screen width -->
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<!-- Bootstrap 3.3.5 -->
<link rel="stylesheet" href="{{ Config('constants.adminBootstrapCssPath').'/bootstrap.min.css' }}">
<!-- Font Awesome -->
<link rel="stylesheet" href="{{ Config('constants.adminDistCssPath').'/font-awesome.min.css' }}">
<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- jvectormap -->
<link rel="stylesheet" href="{{ Config('constants.adminPlugins').'/jvectormap/jquery-jvectormap-1.2.2.css'}}">
<!-- ckEditor -->
<!--<link rel="stylesheet" href="{{ asset('public/Admin/plugins/ckeditor/bootstrap3-wysihtml5.min.css') }}">-->

<!-- Theme style -->
<link rel="stylesheet" href="{{ Config('constants.adminDistCssPath').'/AdminLTE.min.css' }}">
<link rel="stylesheet" href="{{ Config('constants.adminDistCssPath').'/jqueryui.css' }}">
<link rel="stylesheet" href="{{ Config('constants.adminDistCssPath').'/jqueryui-timepicker-adon.css' }}">
<link rel="stylesheet" href="{{ Config('constants.adminDistCssPath').'/mdp.css' }}">
<link rel="stylesheet" href="{{Config('constants.adminDistCssPath').'/chosen.css' }}">
<!-- AdminLTE Skins. Choose a skin from the css/skins
     folder instead of downloading all of them to reduce the load. -->
<link rel="stylesheet" href="{{ Config('constants.adminDistCssPath').'/skins/_all-skins.min.css' }}">
<link rel="stylesheet" href="{{ Config('constants.adminDistCssPath').'/style.css' }}">
<link rel="stylesheet" href="{{ Config('constants.adminDistCssPath').'/bootstrap-select.css' }}">
<link rel="stylesheet" href="{{ Config('constants.adminDistCssPath').'/validationEngine.jquery.css' }}">
<link rel="icon" type="image/png" href="{{ Config('constants.frontendThemeImagePath').'/favicon.png' }}">
<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/cropper/2.3.4/cropper.min.css'>
<link rel="stylesheet" href="{{ Config('constants.adminDistCssTempPath').'/custom-admin.css' }}">
<link rel="stylesheet" href="{{ Config('constants.adminDistCssTempPath').'/custom-admin.css' }}">
<link rel="stylesheet" href="{{ Config('constants.adminDistCssTempPath').'/custom-admin-vikram.css' }}">
<?php
$jsonString = App\Library\Helper::getSettings();

$data = (object) $jsonString;
Session::put('storeName', $data->storeName);
Session::put('storelogo', $data->logo);
?>
<div class="modal fade" id="logoModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">    
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Choose Logo (170px W X 100px H)</h4>
            </div>
            <div class="modal-body">        
                <form role="form" id="store_save"  enctype="multipart/form-data" class="cls_logo">   
                    <div class="col-md-12 col-sm-12 col-xs-12 mobilepopup-chooselogo"><div class="form-group">
                            <div class="choosebtnbox text-center">
                                <input type="file" class="custom-file-input chooselogottext" id="logoF" name="logo_img" >
                            </div>
                            <span id="error-logo" class="text-danger"></span>
                        </div></div>      
                    <div class="col-md-10 col-sm-12 col-xs-12 mobilepopup-chooselogo">
                        <div class="box-2 padd-0" >
                            <div class="result padd-0" style="width: 300px; min-height:10px; max-height: 180px;"></div>
                        </div>
                        <div class="options hide">                      
                        </div>
                    </div>    
                    <div class="text-center col-md-12 topmargin-sm mobilepopup-chooselogo">
                        <button type="submit" id="saveLogo" class="btn btn-default btn-success"> Upload</button>
                    </div>

                    <div class="col-md-12 topmargin-sm orDivider-box marginBottom20">
                        <div class="orDivider">or</div>
                    </div>
                    <div class="text-center col-md-12 topmargin-sm custom-chooselogo">
                        <a href="https://www.logocrisp.com/logomaker/" target="_blank" class="btn btn-default btn-success">Auto Logo Generator</a>
                        <p class="nobottommargin topMargin5">Note: This is a third party feature and it is paid.</p>
                    </div>
                    <div class="clearfix"></div>
                </form>
                <div class='clearfix'></div>
            </div>
        </div>
    </div> 
</div>  
<div id="renewModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Renew Your Store</h4>
            </div>
            <form method="post" >
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table  table-hover general-table tableVaglignMiddle">
                                <thead>
                                    <tr>
                                        <th>Store Version</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr id="chargesDetails">

                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary storerenewSubmit">Submit</button>
                            <!--<a class="btn btn-primary " id="storerenewSubmit" target="_blank">Submit</a>-->

                        </div >
                    </div >
                    <div>

                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<script src='https://cdnjs.cloudflare.com/ajax/libs/cropperjs/0.8.1/cropper.min.js'></script>
<style>
    .skin-blue .wrapper, .skin-blue .main-sidebar, .skin-blue .left-side,.skin-blue .main-header .logo,.skin-blue .main-header li.user-header{
        background-color: <?php echo "#" . $data->secondary_color . " !important"; ?>;
    }
    .skin-blue .sidebar-menu > li:hover > a, .skin-blue .sidebar-menu > li.active > a{
        color: <?php echo "#" . $data->primary_color . " !important"; ?>;
    }

    .treeview-menu li.active a{
        color: <?php echo "#" . $data->primary_color . " !important"; ?>;}
    .skin-blue .treeview-menu>li>a:hover{ color: <?php echo "#" . $data->primary_color . " !important"; ?>;}
    .sidebar-menu .treeview-menu, .sidebar-mini.sidebar-collapse .sidebar-menu>li>a>span{
        background-color: <?php echo "#" . $data->secondary_color . " !important"; ?>;
    }
    /*.main-header, .navbar .navbar-static-top{
        background-color: <?php echo "#" . $data->primary_color . " !important"; ?>;} 

    .btn-primary, .btn-default{
        background-color: <?php echo "#" . @$data->btn_color . " !important"; ?>;}

    .reset-btn, .btn-black{
        background-color: <?php echo "#" . @$data->sbtn_color . " !important"; ?>; color: #fff!important;}
    .form-control:focus{border-color: <?php echo "#" . $data->primary_color . " !important"; ?>;;}*/

    .pagination>.active>span { background-color: <?php echo "#" . $data->btn_color . " !important"; ?>;
                               border-color: <?php echo "#" . $data->btn_color . " !important"; ?>;}
    .nav-tabs-custom>.nav-tabs>li.active{border-top-color: <?php echo "#" . $data->primary_color . " !important"; ?>;}

    .btn{margin-left:10px;}
</style> 