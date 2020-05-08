@extends('Admin.layouts.default')
@section('mystyles')
<style>.bxmodal{margin: 10px 0; border: 1px #eee solid; float: left; width: 100%; padding: 15px;}</style> 
<link rel="stylesheet" href="{{Config('constants.fileUploadPluginPath').'css/jquery.fileupload.css'}}">
<link rel="stylesheet" href="{{Config('constants.fileUploadPluginPath').'css/jquery.fileupload-ui.css'}}">
<noscript>
  <link rel="stylesheet" href="{{Config('constants.fileUploadPluginPath').'css/jquery.fileupload-noscript.css'}}">
</noscript>
<noscript>
  <link rel="stylesheet" href="{{Config('constants.fileUploadPluginPath').'css/jquery.fileupload-ui-noscript.css'}}">
</noscript>
@stop
@section('content')
<section class="content-header">
  <h1>
    All Products
  </h1>
  <ol class="breadcrumb">
    <li>
      <a href="#">
        <i class="fa fa-dashboard">
        </i> Catalog
      </a>
    </li>
    <li class="active">All Products 
    </li>
  </ol>
</section>
<section class="main-content">
  <div class="notification-column">
    <div class="alert alert-danger" role="alert" id="errorMsgDiv" style="display: none;"></div>
    <div class="alert alert-success" role="alert" id="successMsgDiv" style="display: none;"></div> 
       @if((Session::get('message')))
        <div class="alert alert-danger" role="alert">
        {{ Session::get('message') }}
        </div>
        @endif
        @if((Session::get('msg')))
        <div class="alert alert-success" role="alert">
        {{Session::get('msg')}}
        </div>
        @endif 
        </div> 
  <div class="col-md-9 noLeft-padding">
    <div class="grid-content" data-match-height="groupName">
        <div class="section-main-heading">
            <h1><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'settings-2.svg'}}"> Filters</h1>
        </div>
        <div class="filter-section equal-height-div-1">
                <div class="filter-left-section">
                {!! Form::open(['method' => 'get', 'route' => 'admin.products.view' , 'id' => 'searchForm' ]) !!}
                {!! Form::hidden('productsCatalog',null) !!}
                {!! Form::hidden('prdSearch',1) !!}
                <div class="form-group col-md-8">
                  <div class="input-group">
                    <span class="input-group-addon  lh-bordr-radius"><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'search.svg'}}"></span>
                    {!! Form::text('product_name',Input::get('product_name'), ["class"=>'form-control  form-control-right-border-radius', "placeholder"=>"Product"]) !!}
                  </div>
                </div>
                <div class="form-group col-md-4">
                    <!--                        {!! Form::select('category',$category,Input::get('category'), ["class"=>'form-control', "placeholder"=>"Category"]) !!}-->
                    <select class='form-control' name='category' class="form-control" placeholder="Product Category">
                    <option value="">Product Category
                    </option>
                    <?php
                        $dash = " -- ";
                        echo "<ul>";
                        foreach ($rootsS as $root) {
                        renderNode1($root, $dash);
                        }
                        echo "</ul>";
                        function renderNode1($node, $dash)
                        {
                        echo "<li>";
                        echo "<option value='{$node->id}'   > {$dash}{$node->categoryName->category}</option>";
                        if ($node->children()->count() > 0) {
                        $dash .= " -- ";
                        echo "<ul>";
                        foreach ($node->children as $child) {
                        renderNode1($child, $dash);
                        }
                        echo "</ul>";
                        }
                        echo "</li>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    {!! Form::select('status',['1'=>'Enabled', '0'=>'Disabled'],Input::get('status'), ["class"=>'form-control ', "placeholder"=>"Status"]) !!}
                </div>
                @if($settingStatus['stock'] == 1)
                <div class="form-group col-md-4">
                    {!! Form::select('availability',['1'=>'In Stock', '0'=>'Out of Stock'],Input::get('availability'), ["class"=>'form-control filter_type', "placeholder"=>"Availability"]) !!}
                </div>
                @endif
                <div class="form-group col-md-4">
                    {!! Form::select('updated_by',$user,Input::get('updated_by'), ["class"=>'form-control ', "placeholder"=>"Updated By"]) !!}
                </div>
                <span id="advanced-filter"> 
                <div class="form-group col-md-3">
                    {!! Form::text('pricemin',Input::get('pricemin'), ["class"=>'form-control form-control-border-radius ', "placeholder"=>"Min Price"]) !!}
                </div>
                <div class="form-group col-md-3">
                    {!! Form::text('pricemax',Input::get('pricemax'), ["class"=>'form-control form-control-border-radius ', "placeholder"=>"Max Price"]) !!}
                </div>
                <div class="form-group col-md-3">
                    {!! Form::text('datefrom',Input::get('datefrom'), ["class"=>'form-control form-control-border-radius fromDate', "placeholder"=>"From Date"]) !!}
                </div>
                <div class="form-group col-md-3">
                    {!! Form::text('dateto',Input::get('dateto'), ["class"=>'form-control form-control-border-radius toDate', "placeholder"=>"To Date"]) !!}
                </div>
                </span>
                <span id="dots"></span><div class="clearfix"></div> 
                <div class="form-group col-md-6 noBottomMargin">
                    <span onclick="myFunction()" id="advanced-filter-Btn"><i class="fa fa-caret-down" aria-hidden="true"></i> Advanced Filters</span>
                </div>
                <div class="form-group col-md-6 noBottomMargin"> 
                    <a href="{{route('admin.products.view')}}">
                        <button type="button" class="btn reset-btn noMob-leftmargin pull-right mn-w100" value="reset">Reset
                        </button>
                    </a>  
                    <button type="submit" name="search" class="btn btn-primary noAll-margin pull-right marginRight-sm mn-w100" value="Search"> Filter
                    </button>  
                </div>
                {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div> 
 
    <div class="col-md-3 noRight-padding">
    <div class="grid-content" data-match-height="groupName">
        <div class="section-main-heading">
            <h1><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'transfer-2.svg'}}"> Import & Export</h1>
        </div>
        <div class="filter-section equal-height-div-2">
          <div class="filter-right-section">  
          <div class="form-group">
            <a class="btn btn-default fullWidth noAll-margin" href="{{ route('admin.products.sampleProductDownload')}}">Sample Products</a>
            </div>           
            <div class="form-group">
            <a class="btn btn-default fullWidth noAll-margin" href="{{ route('admin.products.sampleBulkDownload')}}">Download Products</a>
            </div>  
            @if(Session::get('login_user_type') != 3)           
            <div class="form-group">
              <a href="{{route('admin.product.wishlist')}}">
                  <button type="button" class="btn btn-default fullWidth noAll-margin" >Export Wishlist Products
                  </button>
              </a> 
            </div>
            @endif  
            @if(Session::get('login_user_type') == 5)    
             <div class="form-group">
            <form action="{{ route('admin.products.supplierproductBulkUpload') }}" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <div class="input-group file-upload-column">
                        <span class="input-group-addon lh-bordr-radius"><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'up-arrow.svg'}}"></span>
                        <div class="file-upload-wrapper" data-text="Products Upload"> 
                            <input type="file" name="file" class="fullWidth form-control form-control-right-border-radius file-upload-field fileUploder file-upload-field" onChange="validateFile(this.value)"/>
                        </div>
                    </div>
                </div>
                <div class="form-group noAll-margin">
                    <input type="submit" class="btn sbtn btn-secondary submitBulkUpload fullWidth noAll-margin" value="Upload"/> 
                </div>
            </form>   
          </div> 
          @else
            <div class="form-group">
            <form action="{{ route('admin.products.productBulkUpload') }}" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <div class="input-group file-upload-column">
                        <span class="input-group-addon lh-bordr-radius"><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'up-arrow.svg'}}"></span>
                        <div class="file-upload-wrapper" data-text="Products Upload"> 
                            <input type="file" name="file" class="fullWidth form-control form-control-right-border-radius file-upload-field fileUploder file-upload-field" onChange="validateFile(this.value)"/>
                        </div>
                    </div>
                </div>
                <div class="form-group noAll-margin">
                    <input type="submit" class="btn sbtn btn-secondary submitBulkUpload fullWidth noAll-margin" value="Upload"/> 
                </div>
            </form>   
          </div>
          @endif  
           @if(Session::get('login_user_type') != 5)            
            <div class="form-group noAll-margin">
             <form id="fileupload" action="{{ asset(route('admin.products.prdBulkImgUpload')) }}" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <div class="input-group file-upload-column">
                        <span class="input-group-addon lh-bordr-radius"><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'up-arrow.svg'}}"></span>
                        <div class="file-upload-wrapper" data-text="Images Upload">  
                        <input type="file" class="fullWidth form-control form-control-right-border-radius file-upload-field" name="files[]" multiple>
                        <input type="hidden" name="redirect" value="back">
                        </div>
                    </div>
                </div>
                <div class="form-group noAll-margin">
                    <input type="submit" class="start uploadBulkImages btn sbtn btn-secondary submitBulkUpload fullWidth noAll-margin" value="Start Upload"/> 
                </div>
                <span class="fileupload-process"></span>
            </form>   
            </div> 
            @endif
            <!-- <button class="btn btn-default pull-right col-md-12 bulkuploadprod marginBottom15 mobAddnewflagBTN" type="button">Bulk Upload
            </button> --> 
        </div>
      </div>
    </div>
    </div>   

  <div class="grid-content">
  <div class="section-main-heading">
            <h1><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'receipt-2.svg'}}"> Products  
			<?php
                if($productCount > 0)
                {
                ?>
                    <span class="listing-counter">{{$startIndex}}-{{$endIndex}} of {{$productCount }}</span>
                <?php
                }
                ?>  
			 </h1> 
            <?php $cat = count($rootsS) > 0 ? '' : "Cat";?> 
            <a type="button" class="btn btn-listing-heading pull-right noAll-margin" data-toggle="modal" data-target="#addProduct{{$cat}}"> <img src="{{ Config('constants.adminImgangePath') }}/icons/{{'plus.svg'}}"> Create </a> 

        </div>
      <div class="listing-section">
      <table class="table table-striped table-hover tableVaglignMiddle">
            <thead>
              <tr>
                @if($barcode == 1)   
                  <th width="5%" class="text-center">
                    <label class="custom-checkbox">
                      <input type="checkbox" id="masterCheck" value="00"/>
                      <span class="checkmark"></span>
                    </label>

                    <div> 
                     <span class="dropdown">
                        <button class="checkbox-dropdown dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> 
                          <<img src="{{ Config('constants.adminImgangePath') }}/icons/{{'more.svg'}}">
                        </button>
                        <ul id="bulk_action" class="dropdown-menu bulk-action-dropdown-menu" aria-labelledby="dropdownMenu1">
                          <li role="presentation" class="dropdown-header">Select Bulk Action</li>
                          <li><input type="radio" id="export" name="Bulk Action" value="export">
                              <label for="export">Export</label> 
                          </li>
                          <li><input type="radio" id="remove" name="Bulk Action" value="remove">
                              <label for="remove">Delete</label> 
                          </li> 
                        </ul>
                      </span>
                    </div>
                  </th>  
                @endif
                <th width="35%" class="text-left">@sortablelink ('product', 'Product')</th>
                <th class="text-left">Categories</th>
                <th class="text-right mn-w100">@sortablelink ('price', 'Price') </th>
                <th class="text-left">Product Type</th>
                @if($settingStatus['stock'] == 1)
                  <th class="text-center">Stock</th>
                @endif
                  <th class="text-center">Status</th>
                @if(Session::get('login_user_type') != 3 && Session::get('login_user_type') != 5)
                  <th class="text-center">Sell On Estorifi Mall</th>
                @endif
                 @if(Session::get('login_user_type') == 5)
                  <th class="text-center">Show On Lisitng Page</th>
                @endif
                  <th class="text-center mn-w100">Action</th>
              </tr>
            </thead>
            <tbody>
              @if(count($products) >0 )
              @foreach($products as $product)
              <?php 
                if($product->status==1)
                  {
                      $statusLabel = 'Active';
                      $linkLabel = 'Mark as Inactive';
                  }
                  else
                  {
                      $statusLabel = 'Inactive';
                      $linkLabel = 'Mark as Active';
                  }
              ?>
              <tr> @if($barcode == 1)  
                <td class="text-center">
                    <label class="custom-checkbox">
                    <input type="checkbox" class="singleCheck" name="singleCheck[]" value="{{ $product->id }}-{{ $product->prod_type }}"/>
                    <span class="checkmark"></span>
                    </label>
                </td>
                @endif
                <td class="text-left">
                  <div class="product-name vMiddle">
                    <span>
                      <img src="{{($product->catalogimgs()->first())?  Config('constants.productImgPath').'/'.$product->catalogimgs()->first()->filename:'' }}" class="admin-profile-picture" />
                    </span>
                    <span class="marginleft10">
                      {{$product->product }}
                      <br>
                      <span class="breakLine">
                        @if($product->product_code)
                          ({{ $product->product_code }})
                        @endif
                      </span>
                    </span>
                  </div>
                </td>
                  <td class="text-left">
                    <?php
                      $prodCategories = $product->categories()->get();
                      if ($prodCategories->count() > 0) 
                      {
                          echo $prodCategories[0]->categoryName->category;
                      } 
                      else 
                      {
                          echo '-';
                      }
                    ?>
                  </td>
                  <td class="text-right mn-w100">
                    @if( $product->spl_price <= 0.00 )
                      <?php echo !empty(Session::get('currency_symbol')) ? Session::get('currency_symbol') : ''; ?> 
                      <span class=""> {{ $product->price }} </span>
                    @else
                    <strike>
                        <?php echo !empty(Session::get('currency_symbol')) ? Session::get('currency_symbol') : ''; ?>
                        <span class="priceConvert">{{$product->price }}
                      </span> 
                    </strike>
                    <br>
                    <?php echo !empty(Session::get('currency_symbol')) ? Session::get('currency_symbol') : ''; ?>
                    <span class="priceConvert"> {{ $product->spl_price }} 
                    </span>
                    @endif
                  </td>
                <td class="text-left"> {{ $product->producttype->type }}</td>
                @if($settingStatus['stock'] == 1)
                <td class="text-center">{{ $product->stock }}</td>
                @endif
                <td class="text-center" id="productStatus_{{$product->id}}"><span class="alertSuccess">{{$statusLabel}}</span></td>
                @if(Session::get('login_user_type') != 3 && Session::get('login_user_type') != 5)
                <td class="text-center">
                  @if($product->is_share_on_mall==0)
                  <a prod-id="{{$product->id}}" class="   shareProductToMall" ui-toggle-class="" title="Publish To Mall"> 
                    <i class="fa fa-check btn-plen btn"></i>
                  </a>
                  @else
                  <a prod-id="{{$product->id}}" class="  unpublishToMall" ui-toggle-class=""  title="Unpublish" >
                    <i class="fa fa-times  btn-plen btn"></i>
                  </a>
                  @endif
                </td>
                @endif
                @if(Session::get('login_user_type') == 5)
                 <td class="text-center"> 
                  @if(@$product->supplierProducts->count()==0)
                  <a href="{!! route('admin.products.changesupplierStatus',['id'=>$product->id]) !!}" class="" ui-toggle-class="" onclick="return confirm('Are you sure you want to enable this product?')" data-toggle="tooltip" title="Disabled"><i class="fa fa-times btn-plen btn"></i></a>
                  @else
                   @foreach(@$product->supplierProducts as $prostatus)
                    @if($prostatus->status==1)
                    <a href="{!! route('admin.products.changesupplierStatus',['id'=>$product->id]) !!}" class="" ui-toggle-class="" onclick="return confirm('Are you sure you want to disable this product?')" data-toggle="tooltip" title="Enabled"><i class="fa fa-check btn-plen btn"></i></a>
                    @elseif($prostatus->status==0)
                    <a href="{!! route('admin.products.changesupplierStatus',['id'=>$product->id]) !!}" class="" ui-toggle-class="" onclick="return confirm('Are you sure you want to enable this product?')" data-toggle="tooltip" title="Disabled"><i class="fa fa-times btn-plen btn"></i></a>
                    @endif
                  @endforeach

                  @endif

                  
                </td>
                @endif
                <td class="text-center  mn-w100">
                <div class="actionCenter">
                   @if(Session::get('login_user_type') != 5)
                      <span><a class="btn-action-default" href="{!! route('admin.products.general.info',['id'=>$product->id]) !!}"><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'pencil.svg'}}"></a></span> 
                      <span class="dropdown">
                          <button class="btn-actions dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <img src="{{ Config('constants.adminImgangePath') }}/icons/{{'more.svg'}}">
                          </button>
                          <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton"> 
                              <li><a href="{!! route('admin.products.delete',['id'=>$product->id]) !!}"><i class="fa fa-trash "></i> Delete</a></li>
                              <li><a href="javascript:;" id="changeStatusLink_{{$product->id}}" onclick="changeStatus({{$product->id}},{{$product->status}})" ><i class="fa fa-check "></i> {{$linkLabel}}</a></li>
                          </ul>
                      </span>  
                    @endif
                   
                    @if(Session::get('login_user_type') == 5)
                    <button  title="Edit Price" data-toggle="modal" data-target="#PriceModal" class="btn btn-secondary buyBtn btn-sm supplierprice"  data-id="{{$product->id}}" data-price="{{ $product->price }}" data-supprice={{@$product->supplierProducts[0]->price}} >Edit Price</button>
                    @endif

                  </div>
                 
                  <!--                            @if($barcode == 1)  <a class="" data-id="{{ $product->id }}-{{ $product->prod_type }}" data-toggle="tooltip" title="Print"><i class="fa fa-print fa-fw"></i></a>
                    <span id="barerr{{ $product->id }}"></span> @endif-->
                </td>
              </tr>
              @endforeach
              @else
              <tr>
                <td colspan=10 class="text-center"> No Record Found
                </td>
              </tr>
              @endif
            </tbody>
          </table>
          <div class="clearfix">
          <?php
            $args = [];
            !empty(Input::get("product_name")) ? $args["product_name"] = Input::get("product_name") : '';
            !empty(Input::get("product_code")) ? $args["product_code"] = Input::get("product_code") : '';
            //echo $products->appends(Input::except('page'))->render();
            if (empty(Input::get('prdSearch'))) {
            echo $products->render();
            }
            ?>
        </div>
      </div>
  </div>
  <div class="modal fade" id="bulkProduct" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;
            </span>
          </button>
          <h4 class="modal-title" id="myModalLabel">Bulk Upload/Download
          </h4>
        </div>
        <div class="modal-body">
          <div  class="bxmodal">
            <div class='col-md-6 mob-marBottom15'>
              <label>Products Download
              </label>
            </div>
            <div class='col-md-6'>
              <a href="{{ route('admin.products.sampleBulkDownload')}}" class="btn btn-primary sampleDownload noMob-leftmargin">Download
              </a>
            </div>
          </div>
          <div  class="bxmodal">
            <form action="{{ route('admin.products.productBulkUpload') }}" method="post" enctype="multipart/form-data">
              <div class='col-md-6 mob-marBottom15'>
                <label>Products Upload
                </label>
                <input type="file" name="file" class="fileUploder" onChange="validateFile(this.value)"/>
              </div>
              <div class='col-md-6'>
                <input type="submit" class="btn btn-primary noMob-leftmargin" value="Upload">
              </div>
            </form>
          </div>
          <div  class="bxmodal">
            <form id="fileupload" action="{{ asset(route('admin.products.prdBulkImgUpload')) }}" method="POST" enctype="multipart/form-data">
              <!-- Redirect browsers with JavaScript disabled to the origin page -->
              <!--        <noscript><input type="hidden" name="redirect" value="https://blueimp.github.io/jQuery-File-Upload/"></noscript>-->
              <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
              <div class="row fileupload-buttonbar">
                <div class="col-lg-12">
                  <!-- The fileinput-button span is used to style the file input field as button -->
                  <span class="btn btn-primary fileinput-button col-lg-6">
                    <!-- <i class="glyphicon glyphicon-plus">
                    </i>
                    <span>Add files...
                    </span> -->
                    <input type="file" name="files[]" multiple>
                    <input type="hidden" name="redirect" value="back">
                  </span>
                  <button type="submit" class="btn btn-primary start uploadBulkImages col-lg-4 ">
                    <i class="glyphicon glyphicon-upload">
                    </i>
                    <span>Start upload
                    </span>
                  </button>
                                    <!--                                    <button type="reset" class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel upload</span>
                    </button>-->
                                    <!--                                    <button type="button" class="btn btn-danger delete">
                    <i class="glyphicon glyphicon-trash"></i>
                    <span>Delete</span>
                    </button>-->
                    <!--                                    <input type="checkbox" class="toggle">-->
                    <!-- The global file processing state -->
                  <span class="fileupload-process">
                  </span>
                </div>
                <!-- The global progress state -->
                <div class="col-lg-5 fileupload-progress fade">
                  <!-- The global progress bar -->
                  <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar progress-bar-success" style="width:0%;">
                    </div>
                  </div>
                  <!-- The extended global progress state -->
                  <!-- <div class="progress-extended">&nbsp;</div> -->
                </div>
              </div>
              <!-- The table listing the files available for upload/download -->
              <!-- <table role="presentation" id="show-uploaded-images" class="table table-striped">
                <tbody class="files"></tbody>
                </table> -->
                            <!-- <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
                <div class="slides"></div>
                <h3 class="title"></h3>
                <a class="prev">‹</a>
                <a class="next">›</a>
                <a class="close">×</a>
                <a class="play-pause"></a>
                <ol class="indicator"></ol>
                </div> -->
            </form>
            <br>
          </div>
        </div>
        <div class='clearfix'>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close
          </button>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal -->
  <div class="modal fade" id="myModalbarcode" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content">
        <span id="tempHtml">
        </span>
        <form id="get_quantity"  method="post" action="">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;
            </button>
            <h4 class="modal-title">Product Print Quantity
            </h4>
          </div>
          <div class="modal-body" >
            <input type="hidden" name="csrf-token" value="<?php echo csrf_token() ?>"/>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Product
                  </th>
                  <th>Quantity
                  </th>
                </tr>
              </thead>
              <tbody id="print_loop">
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-default" >Submit
            </button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="modal fade" id="modalBulkUpdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <span id="tempHtml">
        </span>
        <form  method="post" action="{{route('admin.products.bulkUpdate')}}">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;
            </button>
            <h4 class="modal-title">
            </h4>
          </div>
          <div class="modal-body" >
            <input type="hidden" name="csrf-token" value="<?php echo csrf_token() ?>"/>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th class="b-action">
                  </th>
                  <th class="product_loop">
                  </th>
                </tr>
              </thead>
              <!--                            <tbody class="product_loop">
</tbody>-->
            </table>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-default" >Submit
            </button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Product Add Modal -->
  <!-- Product Close Modal Open -->
</section>
<div class="clearfix"></div>
<div id="addProductCat" class="modal fade"tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog addProduct-modal-dialog">
    <div class="modal-content">
      <div class="modal-header addProduct-modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;
        </button>
        <h4 class="modal-title">Plese Create/Select Category First
        </h4>
      </div>
      <div class="box-body">
        <p>Please select/create minimum one Category before adding a product by clicking on Categories under Product in the left menu.
        </p>
      </div>
      <!-- Modal content-->
    </div>
  </div>
</div>
<div id="addProduct" class="modal fade" role="dialog">
  <div class="modal-dialog addProduct-modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      @include('Admin.pages.catalog.products.add')
    </div>
  </div>
</div>
<div id="addProductToMall" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form class="form-horizontal" method="post" id="shareProductToMall">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;
          </button>
          <h4 class="modal-title">Publish Product To Mall
          </h4>
        </div>
        <div class="modal-body" >
          <div class="" id="selCat">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" id="publish">Publish
          </button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close
          </button>
        </div>
      </form>
      <!-- Modal content-->
    </div>
  </div>
</div>
<input type="hidden" id="page_type" value="main"/>


<!-- Supplier Price Modal -->
<div id="PriceModal" class="modal fade" role="dialog" style="height:auto;">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="background: #FCAF17;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Product Price</h4>
      </div>
        <div class="modal-body">


                    <form id="prodpricefrm" method="post" action="{{route('admin.products.supplierprodPrice')}}" class="form-horizontal form-label-left mode2">
                        <input type='hidden' name='_token' value='{{csrf_token()}}' >
                            <span id="product"></span>
                            <span id="productprice"></span>
                            @if(Session::get('loggedinAdminId'))
                            <input type='hidden' id="userId" name='user_id' value="{{@Session::get('loggedinAdminId')}}" >
                            @else
                            <input type='hidden' id="userId" name='user_id' >
                            @endif
                             <div class="form-group has-feedback ">
                                    <label class="col-md-3" for="price">Price: <span style="color:red;">*</span></label>
                                    <div class="col-md-9">
                                     <input class="form-control input-sm bidPrice" type="number"  name="price" id="price"  value="" required />
                                    </div>
                            </div>
                            <center><button type="submit" id="checkout" class="btn btn-block bidSubmitBtn btn-success buyBtn btn-md" style="width:130px;">Submit </button></center>
                        </form>

        </div>


      </div>

    </div>

  </div>
<!-- model end -->












@stop
@section('myscripts')
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="{{Config('constants.fileUploadPluginPath').'js/vendor/jquery.ui.widget.js'}}">
</script>
<!-- The Templates plugin is included to render the upload/download listings -->
<script src="//blueimp.github.io/JavaScript-Templates/js/tmpl.min.js">
</script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="//blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js">
</script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="//blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js">
</script>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
<!-- <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
-->
<!-- blueimp Gallery script -->
<script src="//blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js">
</script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="{{Config('constants.fileUploadPluginPath').'js/jquery.iframe-transport.js'}}">
</script>
<!-- The basic File Upload plugin -->
<script src="{{Config('constants.fileUploadPluginPath').'js/jquery.fileupload.js'}}">
</script>
<!-- The File Upload processing plugin -->
<script src="{{Config('constants.fileUploadPluginPath').'js/jquery.fileupload-process.js'}}">
</script>
<!-- The File Upload image preview & resize plugin -->
<script src="{{Config('constants.fileUploadPluginPath').'js/jquery.fileupload-image.js'}}">
</script>
<!-- The File Upload audio preview plugin -->
<script src="{{Config('constants.fileUploadPluginPath').'js/jquery.fileupload-audio.js'}}">
</script>
<!-- The File Upload video preview plugin -->
<script src="{{Config('constants.fileUploadPluginPath').'js/jquery.fileupload-video.js'}}">
</script>
<!-- The File Upload validation plugin -->
<script src="{{Config('constants.fileUploadPluginPath').'js/jquery.fileupload-validate.js'}}">
</script>
<!-- The File Upload user interface plugin -->
<script src="{{Config('constants.fileUploadPluginPath').'js/jquery.fileupload-ui.js'}}">
</script>
<!-- The main application script -->
<script src="{{Config('constants.fileUploadPluginPath').'js/main.js'}}">
</script>
<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
    {% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
    <td>
    <span class="preview"></span>
  </td>
    <td>
    <p class="name">{%=file.name%}</p>
    <strong class="error text-danger"></strong>
  </td>
    <td>
    <p class="size">Processing...</p>
    <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
  </td>
    <td>
    {% if (!i && !o.options.autoUpload) { %}
    <button class="btn btn-primary start startgrid" disabled style="display:none;">
    <i class="glyphicon glyphicon-upload"></i>
    <span>Start</span>
  </button>
    {% } %}
    {% if (!i) { %}
    <button class="btn btn-warning cancel cancelgrid" style="display:none;">
    <i class="glyphicon glyphicon-ban-circle"></i>
    <span>Cancel</span>
  </button>
    {% } %}
  </td>
  </tr>
    {% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
    {% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
    <td>
    <span class="preview">
    {% if (file.thumbnailUrl) { %}
    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
    {% } %}
  </span>
  </td>
    <td>
    <p class="name">
    {% if (file.url) { %}
    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
    {% } else { %}
    <span>{%=file.name%}</span>
    {% } %}
  </p>
    {% if (file.error) { %}
    <div><span class="label label-danger">Error</span> {%=file.error%}</div>
    {% } %}
  </td>
    <td>
    <span class="size">{%=o.formatFileSize(file.size)%}</span>
  </td>
  </tr>
    {% } %}
</script>


<script>

  $('.supplierprice').click(function(){
    var prdid=$(this).data('id');
    var prdprice=$(this).data('price');
    var supprice=$(this).data('supprice');
    $('#price').val(supprice);
    $("#product").html("<input type='hidden' name='prod_id' value='"+prdid+"' id='prod_id'>");
    $("#productprice").html("<input type='hidden' name='prod_price' value='"+prdprice+"' id='prod_price'>");
  })


  function changeStatus(productId,status)
  {
      if(status == 1)
          var msg = 'Are you sure you want to inactive this product?';
      else
          var msg = 'Are you sure you want to active this product?';

      if (confirm(msg)) {
          $.ajax({
              type: "POST",
              url: "{{ route('admin.products.changeStatus') }}",
              data: {id: productId},
              cache: false,
              success: function(response) {
                  console.log("done");
                  
                  if(response['status'] == 1)
                  {
                      if(status == 1)
                      {
                          $("#changeStatusLink_"+productId).html('Mark as Active');
                          $("#productStatus_"+productId).html("Inactive");
                          $("#errorMsgDiv").html(response['msg']).show().fadeOut(4000);
                          $("#changeStatusLink_"+productId).attr("onclick","changeStatus("+productId+",0)");
                      }
                      else
                      {
                          $("#productStatus_"+productId).html("Active");
                          $("#changeStatusLink_"+productId).html('Mark as Inactive');
                          $("#successMsgDiv").html(response['msg']).show().fadeOut(4000);
                          $("#changeStatusLink_"+productId).attr("onclick","changeStatus("+productId+",1)");
                      }
                  }
                  else
                  {
                      $("#errorMsgDiv").html(response['msg']).show().fadeOut(4000);
                  }
                  //$(window).scrollTop(0);
                  $("html, body").animate({ scrollTop: 0 }, "slow");
              }
          });
      }
  } // End function
  // $('#uploadBulkImages').click(function(){
  //     var form = $("form#fileupload");
  //     $.ajax({
  //         url: form.attr('action'),
  //         type: 'post',
  //         data: form.serialize(),
  //         beforeSend: function () {
  //             // $("#barerr" + id).text('Please wait');
  //         },
  //         success: function (res) {
  //             console.log(res);
  //         }
  //     });
  // });
  $(".shareProductToMall").click(function () {
    $("#selCat").empty();
    //    alert("for ");
    var prodId = ($(this).attr('prod-id'));
    //  var optionVal='<oprion value="">Please Select Category</option>';
    var optionVal = '<input type="hidden" name="prodId" value="' + prodId + '">';
    $.ajax({
      url: "{{ route('admin.product.mall.category') }}",
      type: "post",
      data: {
        prodId: prodId}
      ,
      success: function (data) {
        //console.log(data);
        $.each(data.prod_cat, function (index, value) {
          //                                                    optionVal += '<div><label class="custom-check"><input class="catCheck" type="checkbox" name="categories[]" value="' + value.id + '"><span class="checkmark-custom"></span></label>' + value.category + '</div>';
        }
              );
        $('#addProductToMall').modal({
          backdrop: 'static',
          keyboard: false
        }
                                    );
        $("#addProductToMall").modal("show");
        $("#selCat").append(optionVal).append(data.category);
        //                                                $("#selCat").append(optionVal);
      }
    }
          );
  }
                                );
  $(".unpublishToMall").click(function () {
    //    alert("for ");
    var prodId = ($(this).attr('prod-id'));
    //  var optionVal='<oprion value="">Please Select Category</option>';
    var conf = confirm("Are you sure to unpublish the product form mall ?");
    if (conf) {
      $.ajax({
        url: "{{ route('admin.product.mall.product.update') }}",
        type: "post",
        data: {
          prodId: prodId}
        ,
        success: function (data) {
          if (data.status === "1" || data.status === "0")
            window.location.href = "{{ route('admin.products.view') }}";
          //                                                $("#selCat").append(optionVal);
        }
      }
            );
    }
    else {
      return false;
    }
  }
                             );
  $(function () {
    $("body").on("click", "button#publish", function (e) {
      var prodcat = [];
      var ids = jQuery.map($(':checkbox[name=categories\\[\\]]:checked'), function (n, i) {
        prodcat.push(n.value);
      }
                          );
      console.log("Categories s", prodcat);
      if (prodcat.length > 0) {
        e.preventDefault();
        var form = $("form#shareProductToMall");
        console.log(form.serialize());
        $.ajax({
          url: "{{ route('admin.product.mall.product.Add') }}",
          type: 'post',
          data: form.serialize(),
          beforeSend: function () {
            // $("#barerr" + id).text('Please wait');
          }
          ,
          success: function (res) {
            if (res.status == "1" || res.status == "0") {
              $("#addProductToMall").modal("hide");
              window.location.href = "{{ route('admin.products.view') }}";
            }
          }
        }
              );
      }
      else {
        alert("Please select atleast one category.");
      }
    }
                );
  }
   );
  $('.prod_type').change(function () {
    var prod_type = $('.prod_type').val();
    if (prod_type == 3) {
      $('#attribute').removeClass("hide");
      $('#listingprice').addClass("hide");
      $('#sellprice').addClass("hide");
      $('#prodstock').addClass("hide");
    }
    else if (prod_type == 1 || prod_type == 2 || prod_type == 5) {
      $('#attribute').addClass("hide");
      $('#listingprice').removeClass("hide");
      $('#sellprice').removeClass("hide");
      $('#prodstock').removeClass("hide");
    }
  }
                        );
  $(".bulkuploadprod").click(function () {
    //    alert("for ");
    $(".template-download").hide();
    $("#bulkProduct").modal("show");
  }
                            );
  $(document).ready(function () {
    $(".fromDate").datepicker({
      dateFormat: "yy-mm-dd",
      onSelect: function (selected) {
        $(".toDate").datepicker("option", "minDate", selected);
      }
    }
                             );
    $(".toDate").datepicker({
      dateFormat: "yy-mm-dd",
      onSelect: function (selected) {
        $(".fromDate").datepicker("option", "maxDate", selected);
      }
    }
                           );
  }
                   );
  ////////////////////////////////////////////////////
  $.ajaxSetup({
    headers: {
      'X-CSRF-Token': $('input[name="csrf-token"]').val()
    }
  }
             );
  //new FormData(this)
  $('html body').on('submit', '#get_quantity', function () {
    $.ajax({
      url: "{{ route('admin.products.barcodeForm') }}",
      type: 'post',
      data: new FormData(this),
      processData: false,
      contentType: false,
      //   dataType: 'json',
      beforeSend: function () {
        // $("#barerr" + id).text('Please wait');
      }
      ,
      success: function (res) {
        //     $("#tempHtml").html(res);
        window.location.href = "{{ route('admin.products.downloadbarcode') }}?url=" + res;
      }
    }
          );
    return false;
  }
                   );
  $('#masterCheck').click(function (event) {
    if ($(this).is(':checked')) {
      $('.singleCheck').attr('Checked', 'Checked');
      ;
    }
    else {
      $('.singleCheck').removeAttr('Checked');
      ;
    }
  }
                         );
  $(".singleCheck").change(function () {
    $("#masterCheck").attr("checked", $(".singleCheck:checked").length == $(".singleCheck").length);
  }
                          );
  $("#bulk_action").change(function () {
    var $this = $(this);
    if ($this.val() == 'print_barcode') {
      $("#myModalbarcode").modal("show");
      $("#myModalbarcode").css("display", "block");
      var ids = jQuery.map($(':checkbox[name=singleCheck\\[\\]]:checked'), function (n, i) {
        return n.value;
      }
                          ).join(',');
      get_print_form(ids);
    }
    else if ($this.val() == 'update_stock_status') {
      $("#modalBulkUpdate").modal("show");
      $("#modalBulkUpdate").css("display", "block");
      var prod_list = [];
      var ids = jQuery.map($(':checkbox[name=singleCheck\\[\\]]:checked'), function (n, i) {
        //                                            prod_list.push({id: n.value, product: $(n).closest('tr').find('.product-name').html()});
        prod_list.push(n.value);
      }
                          );
      get_update_form(prod_list, 'modalBulkUpdate', $this.find("option:selected").text(), $this.val());
    }
    else if ($this.val() == 'update_availability') {
      $("#modalBulkUpdate").modal("show");
      $("#modalBulkUpdate").css("display", "block");
      var prod_list = [];
      var ids = jQuery.map($(':checkbox[name=singleCheck\\[\\]]:checked'), function (n, i) {
        //                                            prod_list.push({id: n.value, product: $(n).closest('tr').find('.product-name').html()});
        prod_list.push(n.value);
      }
                          );
      get_update_form(prod_list, 'modalBulkUpdate', $this.find("option:selected").text(), $this.val());
    }
    else if ($this.val() == 'update_price') {
      $("#modalBulkUpdate").modal("show");
      $("#modalBulkUpdate").css("display", "block");
      var prod_list = [];
      var ids = jQuery.map($(':checkbox[name=singleCheck\\[\\]]:checked'), function (n, i) {
        //                                            prod_list.push({id: n.value, product: $(n).closest('tr').find('.product-name').html()});
        prod_list.push(n.value);
      }
                          );
      get_update_form(prod_list, 'modalBulkUpdate', $this.find("option:selected").text(), $this.val());
    }
    else if ($this.val() == 'update_special_price') {
      $("#modalBulkUpdate").modal("show");
      $("#modalBulkUpdate").css("display", "block");
      var prod_list = [];
      var ids = jQuery.map($(':checkbox[name=singleCheck\\[\\]]:checked'), function (n, i) {
        //                                            prod_list.push({id: n.value, product: $(n).closest('tr').find('.product-name').html()});
        prod_list.push(n.value);
      }
                          );
      get_update_form(prod_list, 'modalBulkUpdate', $this.find("option:selected").text(), $this.val());
    }
    else if ($this.val() == 'export') {
      var prod_list = [];
      var ids = jQuery.map($(':checkbox[name=singleCheck\\[\\]]:checked'), function (n, i) {
        console.log(JSON.stringify(n));
        //                                            prod_list.push({id: n.value, product: $(n).closest('tr').find('.product-name').html()});
        prod_list.push(n.value);
      }
                          );
      //                                        if(prod_list==''){
      //                                           alert("Please select product");
      //                                            return false;
      //                                        }
      var str = '<form method="post" action="<?=route('admin.products.export')?>" id="exportForm">';
      str += '<input type="hidden" name="productId" value="' + prod_list + '"/>';
      str += '<input type="hidden" name="type" value="' + $this.val() + '"/>';
      str += '</form>';
      $('body').append(str);
      $('#exportForm').submit();
    }
    else if ($this.val() == 'add_category') {
      $("#modalBulkUpdate").modal("show");
      $("#modalBulkUpdate").css("display", "block");
      var prod_list = [];
      var ids = jQuery.map($(':checkbox[name=singleCheck\\[\\]]:checked'), function (n, i) {
        //                                            prod_list.push({id: n.value, product: $(n).closest('tr').find('.product-name').html()});
        prod_list.push(n.value);
      }
                          );
      get_update_form(prod_list, 'modalBulkUpdate', $this.find("option:selected").text(), $this.val());
    }
    else if ($this.val() == 'remove') {
      var confirm = window.confirm("Are you sure to remove selected products?");
      if (confirm == true) {
        txt = "You pressed OK!";
        var prod_list = [];
        var ids = jQuery.map($(':checkbox[name=singleCheck\\[\\]]:checked'), function (n, i) {
          //                                            prod_list.push({id: n.value, product: $(n).closest('tr').find('.product-name').html()});
          prod_list.push(n.value);
        }
                            );
        var str = '<form method="post" action="<?=route('admin.products.bulkUpdate')?>" id="removeForm">';
        str += '<input type="hidden" name="productId" value="' + prod_list + '"/>';
        str += '<input type="hidden" name="type" value="' + $this.val() + '"/>';
        str += '</form>';
        $('body').append(str);
        $('#removeForm').submit();
      }
    }
  }
                          );
  function get_update_form(prod_list, modal, action, action_val) {
    $(".priceRow").remove();
    $('#' + modal + ' .b-action').show();
    var str = '';
    //                                    $.each(prod_list, function (key, val) {
    //                                        str += '<tr>';
    //                                        str += '<td>' + val.product + '</td>';
    //                                        str += '<td>';
    //                                        str += '<input type="hidden" name="product[' + val.product + '][id]" value="' + val.id + '"/>';
    //                                        if (action_val == 'update_stock_status') {
    //                                            str += '<select name="updated_value"><option value="1">In Stock</option><option value="0">Out of Stock</option></select>';
    //                                        } else {
    //                                            str += '<input type="number"  min="1" name="product[' + val.product + '][action]" /></td>';
    //                                        }
    //                                        str += '</tr>';
    //                                    });
    //
    str += '<input type="hidden" name="productId" value="' + prod_list + '"/>';
    str += '<input type="hidden" name="type" value="' + action_val + '"/>';
    if (action_val == 'update_stock_status') {
      str += '<select name="updated_value"><option value="1">In Stock</option><option value="0">Out of Stock</option></select>';
      $('#' + modal + ' .b-action').html('Stock Status');
    }
    if (action_val == 'update_availability') {
      str += '<select name="updated_value"><option value="1">Yes</option><option value="0">No</option></select>';
      $('#' + modal + ' .b-action').html('Product Availability');
    }
    if (action_val == 'update_price') {
      str += '<input name="updated_value" />';
      $('#' + modal + ' .b-action').html('Price');
    }
    if (action_val == 'update_special_price') {
      str += '<input type="text" name="prod_price" />';
      $('#' + modal + ' .b-action').html('Price');
      $("#modalBulkUpdate").find("thead").append("<tr class='priceRow'> \n\
<th class='' style='display: table-cell;'>Special Price</th>\
<th class=''><input  type='text' name='prod_special_price'></th>\
  </tr>")
    }
    if (action_val == 'add_category') {
      <?php
      $roots = App\Models\Category::roots()->get();
      echo "str += \"<ul id='catTree' class='tree icheck '>\";";
      foreach ($roots as $root) {
        renderNode($root);
      }
      echo "str += \"</ul>\";";
      function renderNode($node)
      {
        echo "str += \"<li class='tree-item fl_left ps_relative_li " . ($node->parent_id == '' ? 'parent' : '') . "'>\";";
        echo 'str += \'<div class="checkbox"><label class="i-checks checks-sm"><input type="checkbox"  name="updated_value[]" value="' . $node->id . '" /> <i></i>' . $node->category . '</label></div>\';';
        if ($node->children()->count() > 0) {
          echo "str += \"<ul class='fl_left treemap'>\";";
          foreach ($node->children as $child) {
            renderNode($child);
          }
          echo "str += \"</ul>\";";
        }
        echo "str += \"</li>\";";
      }
      ?>
        //str += '<input name="updated_value" />';
        $('#' + modal + ' .b-action').hide();
    }
    $('#' + modal + ' .product_loop').html(str);
    $('#' + modal + ' .modal-title').html(action);
    //                                    if (action_val == 'update_stock_status') {
    //
    //                                    }
  }
  $('.singleCheck').change(function () {
    $("#bulk_action").val('');
  }
                          );
  $("#print_all").click(function () {
    $("#myModalbarcode").modal("show");
    $("#myModalbarcode").css("display", "block");
    var ids = jQuery.map($(':checkbox[name=singleCheck\\[\\]]:checked'), function (n, i) {
      return n.value;
    }
                        ).join(',');
    get_print_form(ids);
  }
                       );
  $(".bprint").click(function () {
    $("#myModalbarcode").modal("show");
    $("#myModalbarcode").css("display", "block");
    var id = $(this).attr("data-id");
    get_print_form(id);
  }
                    );
  function get_print_form(id) {
    $.ajax({
      data: "id=" + id + "&pt=" + $("#page_type").val(),
      type: 'post',
      url: "{{ route('admin.products.printBarcode') }}",
      dataType: 'json',
      beforeSend: function () {
        $("#print_loop").text('Please wait');
        $("#barerr" + id).text('Please wait');
      }
      ,
      success: function (res) {
        $("#barerr" + res.id).text('');
        var str = '';
        $.each(res, function (index, val) {
          $("#barerr" + val.id).text('');
          str += '<tr>';
          str += '<td>' + val.product + '</td>';
          str += '<td>';
          //              str += '<input type="hidden" name="proId[]" value="' + val.id + '"/>';
          str += '<input type="hidden" name="product[' + val.product + '][id]" value="' + val.id + '"/>';
          str += '<input type="hidden" name="product[' + val.product + '][barcode]" value="' + val.barcode + '"/>';
          str += '<input type="number"  min="1" name="product[' + val.product + '][quantity]" /></td>';
          str += '</tr>';
        }
              );
        $("#print_loop").html(str);
      }
    }
          );
  }
  //////////////
  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $('#blah').removeClass("hide");
        $('#blah').attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
  $("#chooseImg").change(function () {
    readURL(this);
  }
                        );
  $(".saveButton").click(function () {
    $(".retunUrl").val("{{route('admin.products.view')}}")
  }
                        );
  $("input[type='checkbox']").on('change', function () {
    $(this).val(this.checked ? "1" : "0");
    if ($(this).attr("name") == 'is_stock') {
      this.checked == 1 ? $('.stockcheck').removeClass("hide") : $('.stockcheck').addClass("hide")
    }
  }
                                )
</script>
<script>
  var resultSlider = document.querySelector('.result-product'),
      //save = document.querySelector('#saveSlider'),
      upload = document.querySelector('#chooseImg'),
      cropper = '';
  // on change show image with crop options
  upload.addEventListener('change', function (e) {
    if (e.target.files.length) {
      var reader = new FileReader();
      reader.onload = function (e) {
        if (e.target.result) {
          var img = document.createElement('img');
          img.id = 'image';
          img.src = e.target.result;
          resultSlider.innerHTML = '';
          resultSlider.appendChild(img);
          cropper = new Cropper(img, {
            aspectRatio: 1,
            dragMode: 'move',
            cropBoxMovable: true,
            cropBoxResizable: true,
            zoom: -0.1,
            built: function () {
              $toCrop.cropper("setCropBoxData", {
                width: "1000", height: "1000"}
                             );
            }
          }
                               );
        }
      };
      reader.readAsDataURL(e.target.files[0]);
    }
  }
                         );
  // save on click
  //save.addEventListener('click', function (e) {
  $(".nextButton , .saveButton").on('click', function (e) {
    e.preventDefault();
    console.log("savebtn");
    if ($("#chooseImg").val() == "")
    {
      $("#error-product").html("Please select product image.");
      return false;
    }
    else
    {
      var fileUpload = $("#chooseImg")[0];
      var imageExt = fileUpload.value.split('.');
      var validImageTypes = ["gif", "jpeg", "jpg", "png","bmp","svg"];
      //Check whether the file is valid Image.

      //var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.png|.gif)$");
      //if (regex.test(fileUpload.value.toLowerCase())) {
      if ($.inArray(imageExt[1], validImageTypes) == true || $.inArray(imageExt[1], validImageTypes) != -1) {
        //Check whether HTML5 is supported.
        if (typeof (fileUpload.files) != "undefined") {
          $("#error-product").html("");
          var form = $('#addProductFrm');
          var formdata = false;
          if (window.FormData) {
            formdata = new FormData(form[0]);
          }
          var ImageURL = cropper.getCroppedCanvas({
            width: "1000" // input value
          }
                                                 ).toDataURL();
          $("#prod_img_url").val(ImageURL);
          console.log("formdata");
          $('#addProductFrm').submit();
        }
        else
        {
          $("#error-product").html("This browser does not support HTML5.");
          return false;
        }
      }
      else
      {
        $("#error-product").html("Please select a valid Image file.");
        return false;
      }
    }
  }
 );

$( document ).ready(function() {
    var s1 = $('#div1').height();
    var s2 = $('#div2').height();

    if (s1 > s2)
        $('#div2').css('height', s1 + "px");
    else
        $('#div1').css('height', s2 + "px");
});

</script>
@stop
