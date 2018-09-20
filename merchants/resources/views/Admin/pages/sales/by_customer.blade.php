
@extends('Admin.layouts.default')
@section('content')
<section class="content-header">
    <h1>
        By Customers ({{$userCount}})
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">By Customers</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header box-tools filter-box col-md-9 noBorder col-sm-12 col-xs-12">
                    <form method="post" action="{{ route('admin.sales.bycustomer') }}">
                           <input type="hidden" value="dateSearch" name="dateSearch">
                        <div class="form-group col-md-4 col-sm-6 col-xs-12">
                            <input type="text" value="{{ !empty(Input::get('search_name')) ? Input::get('search_name') : '' }}" name="search_name" aria-controls="editable-sample" class="form-control medium" placeholder="Name"/>
                        </div>
                         <div class="form-group col-md-4 col-sm-6 col-xs-12">
                            <input type="text" value="{{ !empty(Input::get('search_email')) ? Input::get('search_email') : '' }}" name="search_email" aria-controls="editable-sample" class="form-control medium" placeholder="Email Id"/>
                        </div>
                         <div class="form-group col-md-4 col-sm-6 col-xs-12">
                            <input type="text" value="{{ !empty(Input::get('search_number')) ? Input::get('search_number') : '' }}" name="search_number" aria-controls="editable-sample" class="form-control medium" placeholder="Mobile"/>
                        </div>
                        <div class="form-group col-md-2 col-sm-6 col-xs-12">
                            <input type="submit" name="submit" class="btn btn-primary form-control noMob-leftmargin" value="Search">
                        </div>
                            <div class="form-group col-md-2 col-sm-6 col-xs-12 noMobBottomMargin">
                         <a  href="{{route('admin.sales.bycustomer')}}" class="medium btn btn-block noLeftMargin reset-btn">Reset</a>
                        </div>
                    </form> 
                </div>
                <div class="box-header col-md-3 col-sm-12 col-xs-12">
                    <form method="post" id="CusExport" action="{{URL::route('admin.sales.orderByCustomerExport') }}">
                        <input type="hidden" value="dateSearch" name="dateSearch">
                        <input type="hidden" name="from_date" value="{{ !empty(Input::get('from_date'))?Input::get('from_date'):'' }}"  class="form-control fromDate " placeholder="From Date" autocomplete="off" id="">
                        <input type="hidden" name="to_date" value="{{ !empty(Input::get('to_date'))?Input::get('to_date'):'' }}"  class="form-control toDate col-md-3" placeholder="To Date" autocomplete="off" id="">
                        <input type="hidden" value="{{ !empty(Input::get('search')) ? Input::get('search') : '' }}" name="search" aria-controls="editable-sample" class="form-control medium" placeholder="Search Category"/>
                        <input type="button" class="cusExport btn btn-default pull-right col-md-12 mobAddnewflagBTN" value="Export">
                    </form>
                </div> 
                <div class="clearfix"></div>
                <div class="dividerhr"></div>
           
                <div class="box-body table-responsive no-padding">
                    <table class="table  catSalesTable table-hover general-table tableVaglignMiddle">
                        <thead>
                            <tr>
<!--                                <th>Sr No</th>-->
                                <th>Name</th>
                                <th>Email Id</th>
                                <th>Mobile</th>
                                <th>Total Purchase</th>
                                <th>Cashback</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php //$i=1; ?>
                             @if(count($users) >0)
                            @foreach($users as $user)
<?php // dd($user);?>
                            <tr>
<!--                                <td></td>-->
                                <td>{{ $user->firstname }} {{ $user->lastname }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->telephone }}</td>
                                <td><?php echo  !empty(Session::get('currency_symbol')) ? Session::get('currency_symbol') : ''; ?> <span class="priceConvert">{{ number_format($user->userCashback->total_purchase_till_now,2) }}</span></td>
                                <td><?php echo !empty(Session::get('currency_symbol')) ? Session::get('currency_symbol') : ''; ?> <span class="priceConvert">{{ number_format($user->userCashback->cashback,2)}}</span></td>
                                <td><a href="{{ URL::route('admin.sales.orderByCustomer',['id' => $user->id]) }}"  data-toggle="tooltip" title="View"><i class="fa fa-eye btn btn-penel btnNo-margn-padd"></i></a></td>
                            </tr>
                            <?php //$i++ ?>
                            @endforeach
                              @else
                           <tr><td colspan=6> No Record Found.</td></tr>
                            @endif
                            
                        </tbody>
                    </table>
                    <?php if (empty(Input::get('dateSearch'))) { ?>
                        <div class="box-footer clearfix">
                            {{ $users->links()}}
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>


@stop

@section('myscripts')
<script>
    $(document).ready(function () {


        $('#checkAll').click(function (event) {

            var checkbox = $(this),
                    isChecked = checkbox.is(':checked');
            if (isChecked) {
                $('.checkcatId').attr('Checked', 'Checked');
            } else {
                $('.checkcatId').removeAttr('Checked');
            }
        });


          $(".fromDate").datepicker({
            dateFormat: "yy-mm-dd",
            onSelect: function (selected) {
                $(".toDate").datepicker("option", "minDate", selected);
            }
        });

        $(".toDate").datepicker({
            dateFormat: "yy-mm-dd",
            onSelect: function (selected) {
                $(".fromDate").datepicker("option", "maxDate", selected);
            }
        });
    });
     $(".cusExport").click(function () {
            //alert("sgfsg");
//            var ids = $(".attrSalesTable input.checkattrId:checkbox:checked").map(function () {
//                return $(this).val();
//            }).toArray();
            //$("input[name='artistIds']").val(ids); 
            // alert(ids);
//            $("#AttrExport").append("<input type='hidden' name='attrIds' value=' " + ids + " '/><br/>");
            $("#CusExport").submit();



        });
</script>

@stop