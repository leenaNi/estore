@extends('Admin.layouts.default')
@section('content')
<style type="text/css">
    input[type=checkbox]{display:none;}
</style>
<section class="content-header">
    <h1>
        SMS Campaign
        <small>Add/Edit</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active"><a href="{{route('admin.campaign.view')}}" >SMS Campaign </a></li>
        <li class="active">Add/Edit</li>
    </ol>
</section>

<section class="content">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs" role="tablist">
            @if(in_array(Route::currentRouteName(),['admin.coupons.edit','admin.coupons.history']))

            <li class="{{ in_array(Route::currentRouteName(),['admin.coupons.edit']) ? 'active' : '' }}">
                <a href="{!! route('admin.coupons.edit', ['id' => Input::get('id')]) !!}" aria-expanded="false">Coupons</a>
            </li>
            <li class="{{ in_array(Route::currentRouteName(),['admin.coupons.history']) ? 'active' : '' }}">
                <a href="{!! route('admin.coupons.history', ['id' => Input::get('id')]) !!}"  aria-expanded="false">History</a>
            </li>
            @else
            <li class="{{ Route::currentRouteName()=='admin.coupons.add' ? 'active' : '' }}">
                <a href="{!! route('admin.coupons.add') !!}" aria-expanded="false">SMS Details</a>
            </li>
            @endif
        </ul>
        <div  class="tab-content" >
            <div class="active tab-pane" id="activity">
                <div class="row">
                    
                    <div class="col-md-12">
                        <div class="box noShadow noBorder">
                            <div class="box-body">
                               <div class="alert alert-success" style="display: none" role="alert" id="successmsg">
                     
                                 </div> 
                                <!-- <form action="{{$action}}" method="post"> -->
                                    {!! Form::model($smsCampaign, ['method' => 'post', 'files'=> true, 'url' => $action , 'id'=>'save_message' ]) !!}
                                <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('title', 'Message Title ',['id'=>'msg_title','class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                                        {!! Form::hidden('id',null) !!}
                                       
                                        <input type="hidden" name="return_url" value="{{ Route::currentRouteName()=='admin.campaign.add' ? 'active' : '' }}" />                                    
                                        {!! Form::text('title',null, ["class"=>'form-control validate[required] ' ,"placeholder"=>'Message Title']) !!}
                                        <div id="coupon_name_re_validate" style="color:red;"></div>
                                    </div>                                    
                                </div>
                                </div>
                                <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('content', 'Message Content ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                                        {!! Form::textarea('content',null, ["id"=>"msg_content","rows"=>5,"class"=>'form-control validate[required]' ,"placeholder"=>'Message Content']) !!}
                                        <span id="error_msg"></span>
                                        <div id="coupon_code_re_validate" style="color:red;"></div>
                                    </div>
                                </div>
                                </div>
                             
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <input type="submit" value="Save as draft" class="btn btn-primary pull-right mobFloatLeft noMob-leftmargin" >
                                        <button type="button" class="btn btn-primary pull-right mobFloatLeft noMob-leftmargin" data-toggle="modal" data-target="#sendSmsModal">Send Test SMS </button>
                                        <input type="button" value="Send Bulk SMS" class="btn btn-primary pull-right mobFloatLeft noMob-leftmargin" >
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section> 
<div class="modal fade" id="sendSmsModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <form method="post" id="sendSms">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Send Test SMS</h4>
        </div>
        <div class="modal-body">
            <div class="col-md-12">
                <div class="form-group">    
                    <label>Mobile No. </label>
                        <input class="form-control" id="contactno" name="contactno" type="text">
                </div>
            </div>
        </div>    
        
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="publishbtn" onclick="sendSms()">Send SMS</button>  
          
        </div>
     
      </div>
      </form>
    </div>
  </div>
@stop 

@section('myscripts')

<script>
    function sendSms()
    {
        var contactno = $("#contactno").val();
        var title = $("#msg_title").val();
        var content = $("#msg_content").val();
          // alert(contactno);
            $.ajax({
                type: "POST",
                url: "{{ route('admin.campaign.sendsms') }}",
                data: {contactno: contactno,title:title,content:content},
                cache: false,
                success: function (response) {
                    $('#sendSmsModal').modal('toggle');
                    $("#successmsg").show();
                    $("#successmsg").html('SMS Send Successfully');
                   
                }, error: function (e) {
                    console.log(e.responseText);
                }
            });
    }

    $(document).on('keyup', '.searchProducts', function () {
        var getVal = $(this).val().toLowerCase().trim();
        var getMatchedList = $('.searchProductsList');
        $('.searchProductsList').hide();
        $.each(getMatchedList, function (k, v) {
            var getLi = $(this).text().toLowerCase();
            console.log(getLi.search(getVal));
            if (getLi.search(getVal) >= 0) {
                $(this).show();
            }
        })
    })
    $("#showCategories").hide();
    $("#showProducts").hide();

    $("a.deleteImg").click(function () {
        var imgs = $("input[name='c_image']").val();
        var r = confirm("Are You Sure You want to Delete this Image?");
        if (r == true) {
            $("input[name='c_image']").val('');
            $(this).parent().hide();
        } else {

        }
    });

    $(".checkCategoryId").click(function () {
        var ids = $(".allCategories input.checkCategoryId:checkbox:checked").map(function () {
            return $(this).val();
        }).toArray();
        $("input[name='CategoryIds']").val(ids);

    });

    $(".checkProductId").click(function () {
        var ids = $(".allProducts input.checkProductId:checkbox:checked").map(function () {
            return $(this).val();
        }).toArray();
        $("input[name='ProductIds']").val(ids);
    });

    if ($("#coupon_type").val() == 2) {
        $("#showProducts").hide();
        $("#showCategories").show();

        var ids = $(".allCategories input.checkCategoryId:checkbox:checked").map(function () {
            return $(this).val();
        }).toArray();
        $("input[name='CategoryIds']").val(ids);
    }

    if ($("#coupon_type").val() == 3) {
        $("#showCategories").hide();
        $("#showProducts").show();

        var ids = $(".allProducts input.checkProductId:checkbox:checked").map(function () {
            return $(this).val();
        }).toArray();
        $("input[name='ProductIds']").val(ids);
    }

    $("#coupon_type").change(function () {
        if ($("#coupon_type").val() == 2) {
            $("#showProducts").hide();
            $("#showCategories").show();
            $("input[name='ProductIds']").val("");
        }

        if ($("#coupon_type").val() == 3) {
            $("#showCategories").hide();
            $("#showProducts").show();
            $("input[name='CategoryIds']").val("");
        }

        if ($("#coupon_type").val() == 1) {
            $("#showCategories").hide();
            $("#showProducts").hide();
            $("input[name='CategoryIds']").val("");
            $("input[name='ProductIds']").val("");
        }
    });

    if ($("#user_specific").val() == 0) {
        $(".userslist").hide();
    }

    $("#user_specific").change(function () {
        if ($("#user_specific").val() == 1) {
            $(".userslist").show();
        } else {
            $(".userslist").hide();
        }
    });

    $("#fromdatepicker").datepicker({dateFormat: 'yy-mm-dd'});
    $("#todatepicker").datepicker({dateFormat: 'yy-mm-dd'});


</script>
<script>
    var tagFunction = function () {
        function log(message) {
            $("<div>").html(message).prependTo("#log");
            $("#log").scrollTop(0);
        }

        $products = $("#pdcts");

        $products.autocomplete({
            source: "{{route('admin.coupons.searchUser')}}",
            minLength: 2,
            select: function (event, ui) {
                log(ui.item ?
                        ui.item.email + "<input type='hidden' name='uid[]' value='" + ui.item.id + "' ><a href='#' class='pull-right remove-rag'  ><i class='fa fa-trash'></i></a>" : "");
            }
        });

        $products.data("ui-autocomplete")._renderItem = function (ul, item) {
            return $("<li>")
                    .append("<a>" + item.email + "</a>")
                    .appendTo(ul);
        };
        ;
    };

    jQuery('body').on('click', '.remove-rag', function (event) {
        /* Act on the event */
        event.preventDefault();
        jQuery(this).parent().remove();
    });
</script>
<script>
    $(document).ready(function () {
        $("#coupon_code").keyup(function () {
            var code = $(this).val();
            console.log('code' + code);
            $.ajax({
                type: "POST",
                url: "{{ route('admin.coupons.checkcoupon') }}",
                data: {code: code},
                cache: false,
                success: function (response) {
                    // console.log('@@@@'+response['msg'])
                    if (response['status'] == 'success') {
                        $('#coupon_code').val('');
                        $('#error_msg').text(response['msg']).css({'color': 'red'});
                    } else
                        $('#coupon_code').text('');
                }, error: function (e) {
                    console.log(e.responseText);
                }
            });
        });

      
    });
</script>

@stop