@extends('Admin.layouts.default')
@section('content')


<section class="content-header">
    <h1>
        Features list       
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Feature Activation</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header box-tools filter-box noBorder">
                    <form action="{{ route('admin.generalSetting.view') }}" method="get" >
                        <input type="hidden" name="dataSearch" value="dataSearch"/>
                        <div class="form-group col-md-4  col-sm-6 col-xs-12">
                            <input type="text" name="name"  class="form-control" placeholder="Search Feature" value="{{ (!empty(Input::get('name'))) ? Input::get('name') :''}}" >
                        </div>
                        <div class="form-group col-md-3 col-sm-6 col-xs-12">
                            {{ Form::select('status',['' => 'Select Status','1' => 'Yes', '0'=> 'No'],Input::get('status'),['class' => 'form-control']) }}

                        </div>
                       <div class="form-group col-md-3 col-sm-12 col-xs-12">
                            <div class="search-resetsubmit"> 
                               <button type="submit" class="btn btn-primary form-control no-leftmargin mn-w100"> Search</button>
                                <a href="{{ route('admin.generalSetting.view')}}" class="reset-btn btn btn-block noMob-leftmargin mn-w100">Reset </a>
                            </div>
                        </div>
                    </form>

                </div>
                <div class="clearfix"></div>
                @if(!empty(Session::get('message')))
                <div class="alert" role="alert">
                    {{ Session::get('message') }}
                </div>
                @endif
                <div class="box-body table-responsive no-padding">
                    <table class="table table-striped table-hover tableVaglignMiddle">
                        <thead>
                            <tr>
<!--                                <th>URL key</th>-->
                                <th>Feature</th>
                                <th style="text-align:center">Status</th>
                                <!-- <th>Action</th> -->

                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0; ?>
                            @if(count($settingData) >0)
                            @foreach($settingData as $key=>$seting)
                            <tr > <td colspan="2" class="headingHiglighted">{{$key}}</td></tr>
                    
                            @foreach($seting as $set)
                            
                            <tr> 
                                
                               
                                <td><a href="javascript:;" data-placement="right" title="{{$set->info}}" data-toggle="tooltip" class="tooltip-style">
                                        <img src="{{  Config('constants.adminImgPath').'/info-icon.png' }}" width="16"> </a>{{$set->name }}</td>
                                <?php
                                if ($set->id == 26) {
                                    $det = json_decode($set->details);
                                    $det->stocklimit;
                                }
                                elseif ($set->id == 1) {
                                    $loyaltyDay = $set->details;
                                }
                                ?>


                                <td class="text-right"><input type="checkbox" data-loyalty="{{@$loyaltyDay}}" data-stocklimit="{{ isset($det)?$det->stocklimit:''}}" data-json="{{ $set->details }}" class="{{ "chk_".$set->id }}" onchange="datacheck({{$set->id}})"<?php echo $set->status == 1 ? 'checked' : ''; ?> data-toggle="toggle" name="onOff" data-size="normal" id="toggle-two" data-on="Yes" data-off="No" >

                                </td>

                             </tr>
                            @endforeach
                           
                            @endforeach
                             @else
                           <tr><td colspan=6> No Record Found.</td></tr>
                            @endif
                            
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">

                </div>
            </div><!-- /.box -->
        </div><!-- /.col -->

    </div> 

    <!-- Modal -->
    <div id="stockLimit" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Stock Limit</h4>
                </div>
                <div class="modal-body">
                    <label>Please Enter Stock limit </label>
                    <input type="number" class="form-control stocklimitInpt" value="1" min="1" required="true">
                    <p class="stockErr" style="color: red;"></p>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default submitStockLimit" value="Submit">

                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for COD charge -->
    <div id="codCharge" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">COD Charges</h4>
                </div>
                <div class="modal-body">
                    <label>Please Enter COD Charges </label>
                    <input type="number" class="form-control codInpt" value="1" min="1" required="true">
                    <p class="codErr" style="color: red;"></p>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default submitCod" value="Submit">

                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- model for loyalty -->
    <div id="layaltyDay" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Loyalty activation days</h4>
                </div>
                <div class="modal-body">
                    <label>Please Enter number of day </label>
                    <input type="number" class="form-control loyaltyInpt" value="1" min="1" required="true">
                    <p class="loyaltyErr" style="color: red;"></p>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default  submitLoyalty" value="Submit">

                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</section>

@stop

@section('myscripts')

<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script>
//    $(".switch").change(function(){
//        console.log($(this).val());
//        if($(this).val() == 26){
//            alert("stock related");
//        }else{}
//        
//    })

                                    $(".stocklimitInpt").keyup(function(){
                                    if ($(this).val().length > 0){
                                    $(".stockErr").text("");
                                    }
                                    });
                                    $("#stockLimit").on("hidden.bs.modal", function () {
                                    // alert("cod close pop up");
                                    window.location.href = "{{ route('admin.generalSetting.view') }}";
                                    return false;
                                    });
                                    $("#codCharge").on("hidden.bs.modal", function () {
                                    //  alert("cod close pop up");
                                    window.location.href = "{{ route('admin.generalSetting.view') }}";
                                    return false;
                                    });
                                    $(".codInpt").keyup(function(){
                                    if ($(this).val().length > 0){
                                    $(".codErr").text("");
                                    }
                                    });
// $(function () {
//     $('[data-toggle="tooltip"]').tooltip()
// })

                                    $(".submitStockLimit").on("click", function(){
                                    $(".stockErr").text("");
                                    if ($(".stocklimitInpt").val() != ""){
                                    $.ajax({
                                    method:"POST",
                                            data:{'id':26, stocklimit:$(".stocklimitInpt").val() },
                                            url:"<?php echo route('admin.generalSetting.changeStatus'); ?>",
                                            success: function(data){
                                            // console.log(data);
                                            location.reload();
                                            }
                                    })
                                    } else{
                                    $(".stockErr").text("Please enter stock limit.");
                                    }

                                    });
                                    $(".submitCod").on("click", function(){
                                    $(".codErr").text("");
                                    if ($(".codInpt").val() != ""){
                                    $.ajax({
                                    method:"POST",
                                            data:{'id':9, codCharge:$(".codInpt").val() },
                                            url:"<?php echo route('admin.generalSetting.changeStatus'); ?>",
                                            success: function(data){
                                            // console.log(data);
                                            location.reload();
                                            }
                                    })
                                    } else{
                                    $(".codErr").text("Please enter COD charges.");
                                    }

                                    });
                                    $(".submitLoyalty").on("click", function(){
                                    $(".loyaltyErr").text("");
                                    if ($(".loyaltyInpt").val() != ""){
                                    $.ajax({
                                    method:"POST",
                                            data:{'id':1, loyaltyDay:$(".loyaltyInpt").val() },
                                            url:"<?php echo route('admin.generalSetting.changeStatus'); ?>",
                                            success: function(data){
                                            // console.log(data);
                                            location.reload();
                                            }
                                    })
                                    } else{
                                    $(".loyaltyErr").text("Please enter loyalty activation day.");
                                    }

                                    });
                                    function datacheck(id){
                                    if (id == 26){
                                    if ($(".chk_26").is(":checked")){
                                    $(".stocklimitInpt").val($(".chk_26").attr('data-stocklimit'));
                                    $("#stockLimit").modal("show");
                                    return false;
                                    }
                                    }
                                    else if (id == 1){
                                    if ($(".chk_1").is(":checked")){
                                    $(".loyaltyInpt").val($(".chk_1").attr('data-loyalty'));
                                    $("#layaltyDay").modal("show");
                                    return false;
                                    }
                                    } else if (id == 9) {
                                    if ($(".chk_9").is(":checked")) {
                                    var details = $(".chk_9").attr('data-json');
                                    var detarr = JSON.parse(details);
                                    $(".codInpt").val(detarr['charges']);
                                    $("#codCharge").modal("show");
                                    return false;
                                    }
                                    }
                                    
//        else if(id == 28){
//                                        if ($(".chk_28").is(":checked") === true) {
//                                     chekconf = confirm("If you disabled this feature, then tax of current products will gets removed.") ; 
//                                     if(chekconf)
//                                         return true;
//                                     else
//                                         return false;
//                                 }   else{
//                                   return true;
//                                 }
//                                        
//                                    }


                                    var userId = id;
                                    $.ajax({
                                    method:"POST",
                                            data:{'id':userId },
                                            url:"<?php echo route('admin.generalSetting.changeStatus'); ?>",
                                            success: function(data){
                                            location.reload();
                                            }
                                    })
                                    }

</script>
<!-- <script type="text/javascript">
    $('tbody').sortable();
</script> -->
@stop