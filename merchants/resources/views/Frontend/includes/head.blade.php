<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="author" content="Veestores" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="description" content="@yield('meta-description')">
<meta name="og:image" content="@yield('og:image')">

<!--<meta property="og:image" content="http://cartini.cruxservers.in/public/Admin/uploads/layout/20180131131939.jpg"/>-->
<link rel="stylesheet" href="{{ Config('constants.frontendThemeCssCommonPath').'/style.css' }}" type="text/css" />	
<link rel="stylesheet" href="{{ Config('constants.frontendThemeCssCommonPath').'/responsive.css' }}" type="text/css" />
@if(config('app.active_theme'))
<link rel="stylesheet" href="{{ Config('constants.frontendThemeCssPath').'/'.config('app.active_theme').'style.css' }}" type="text/css" />
@if(strtolower(config('app.active_theme')) =='rs1_' || strtolower(config('app.active_theme')) =='fs3_')
@if(Route::currentRouteName()!='home')
<link rel="stylesheet" href="{{ Config('constants.frontendThemeCssPath').'/'.config('app.active_theme').'style_inner.css' }}" type="text/css" />
@endif
@endif

@endif

<title>{{App\Library\Helper::getSettings()['storeName']}}  @yield('title')</title>
<link rel="icon" type="image/png" href="{{ Config('constants.frontendThemeImagePath').'/favicon.png' }}">
<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/cropper/2.3.4/cropper.min.css'>
<link rel="stylesheet" href="{{Config('constants.adminDistCssPath').'/bootstrap-select.css' }}">

<div class="modal fade" id="logoModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">    
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Choose Logo (170px W X 100px H)</h4>
            </div>
            <div class="modal-body">        
                <form role="form" id="store_save" action="{{route('updateHomeSettings')}}"  enctype="multipart/form-data" class="cls_logo">   
                    <div class="col-md-12 col-sm-12 col-xs-12 mobilepopup-chooselogo"><div class="form-group"> 
                            <div class="choosebtnbox text-center">   
                                <input type="file" class="custom-file-input chooselogottext1" id="logoF" name="logo_img" onClick='setCroppedImage("#saveLogo", ".resultLogo", "#logoF", 171, 100)' >
                            </div><!-- 
                  <input type="file" class="form-control" id="logoF" name="logo_img" class="form-control" /> -->
                            <span id="error-logo" class="text-danger"></span>
                        </div></div>      
                    <div class="col-md-10 col-sm-12 col-xs-12 mobilepopup-chooselogo">
                        <div class="box-2 padd-0">
                            <div class="resultLogo padd-0" style="width: 300px; min-height:10px; max-height: 180px;"></div>
                        </div>
                        <div class="options hide" >                      
                        </div>
                    </div>    
                    <div class="text-center col-md-12 topmargin-sm mobilepopup-chooselogo">
                        <button type="submit" id="saveLogo" onClick="saveCroppedImage('#saveLogo', '#logoF', '#store_save', 171, '#error-logo')"  class="btn btn-default btn-success"><span class="glyphicon glyphicon-off"></span> Upload</button>
                    </div>
                    <div class="col-md-12  col-xs-12 topmargin-sm orDivider-box marginBottom20">
                        <div class="orDivider">or</div>
                    </div>
                    <div class="text-center col-md-12 col-xs-12 topmargin-sm custom-chooselogo">
                        <a href="https://www.logocrisp.com/logomaker/" target="_blank" class="btn btn-default btn-success">Auto Logo Generator</a>
                        <p class="nobottommargin topMargin5">Note: This is a third party feature and it is paid.</p>
                    </div>
                    <div class="clearfix"></div>

                </form>

            </div>

        </div>
    </div> 
</div> 
<script src='https://cdnjs.cloudflare.com/ajax/libs/cropperjs/0.8.1/cropper.min.js'></script>
<?php
$selcats = [];
foreach ($menu as $ca) {
    array_push($selcats, $ca->id);
}
?>
<div id="manageCateModal" class="modal fade in" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Manage Categories</h4>
                <p>Select categories that you offer.</p>
            </div>
            <form method="post" action="{{ route('saveManageCategories')}}">
                <div class="modal-body">
                    <div class="managecatbox">
                        @foreach($getAllCategories as $mn)
                        <div><label class="custom-check">{{$mn->category}}<input class="catCheck" type="checkbox"  <?= in_array($mn->id, $selcats) ? 'checked' : '' ?> name="manage_categories[{{$mn->id}}]" value="{{$mn->status}}"><span class="checkmark-custom"></span>
                            </label></div>
                        @endforeach
                    </div> 
                </div>
                <div class="modal-footer force-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <!--                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
                </div>
            </form>
        </div>
    </div>
</div>
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Track Your Order</h4>
            </div>
            <form method="post" >
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <input type="taxt" class="form-control" name="trackingId" id="trackingId" placeholder="Tracking Id">
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary eurireTraking">Submit</button>
                            <!--                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
                        </div >
                    </div >
                    <div>
                        <table class="table  table-hover general-table tableVaglignMiddle hide">
                            <thead>
                                <tr>

                                    <th>Tracking Status</th>
                                    <th>Date</th>


                                </tr>
                            </thead>
                            <tbody>


                                <tr id="trackingDetails">


                                </tr>

                            </tbody>
                        </table>    
                    </div>
                </div>

            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<div id="homepage3Boxespopup" class="modal fade in" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Home Page 3 Boxes</h4>
            </div>
            <form method='post' action='{{ route('updateHomePage3Boxes') }}' enctype="multipart/form-data" id="frm3boxes">
                <div class="modal-body">
                    <input type="hidden" name="id" value="" class="homePageId">
                    <input type="hidden" name="box3_image" class="sm-form-control" id="box3_image" >
                    <div class="form-group mb-15 clearfix" style="padding: 0 15px;">
                        <div id="addImg" class="add-img homePage3BoxImage">
                            <input type="file" id="chooseImg" name="image">
                            <i class="fa fa-plus"></i><br>
                            <span class="add-img-txt">Add Image</span>
                        </div>
                        <span id="error-product" class="text-danger"></span>
                        <div class="img-box">  
                            <div class="form-group">
                                <div class="box-2">
                                    <div class="result3Boxes"></div>
                                </div>
                            </div>
                        </div>  
                    </div>                   

                    <div class="clearfix"></div>

                    <img id="previewImage" class="existingImg3Box" height="20%" width="20%"  src="#" alt="your image" />

                    <div class="row topmargin-sm">
                        <div class="col-md-6 col-sm-12 col-xs-12  homepage3boxespopalign">
                            <input type="text" name="sort_order" value="" class="sm-form-control homePageSortOrder" placeholder="Sort Order"></div>
                        <div class="col-md-6 col-sm-12 col-xs-12  homepage3boxespopalign">
                            <input type="text" name="link" class="sm-form-control homePageLink" placeholder="Link"></div>

                        <div class="col-md-12 topmargin-sm text-center homepage3boxespopalign">     
                            <div class="">
                                <label class="switch text-center">
                                    <input class="switch-input homePageStatus" name="is_active" value="1"  type="checkbox" checked>
                                    <span class="switch-label" data-on="Enabled" data-off="Disabled"></span> 
                                    <span class="switch-handle"></span> 
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="force-center">
                        <button type="submit" id="save3Boxes" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
