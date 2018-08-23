@extends('Admin.layouts.default')
@section('content')
<section class="content-header">
    <h1>
        Sales By Customer
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Sales By Customer</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header box-tools filter-box col-md-9">
                    <form method="post" action="{{ route('admin.sales.bycustomer') }}">
                        <div class="form-group col-md-4">
                            <input type="text" value="{{ !empty(Input::get('search_name')) ? Input::get('search_name') : '' }}" name="search_name" aria-controls="editable-sample" class="form-control medium" placeholder="Search Username"/>
                        </div>
                         <div class="form-group col-md-4">
                            <input type="text" value="{{ !empty(Input::get('search_email')) ? Input::get('search_email') : '' }}" name="search_email" aria-controls="editable-sample" class="form-control medium" placeholder="Search Email"/>
                        </div>
                         <div class="form-group col-md-4">
                            <input type="text" value="{{ !empty(Input::get('search_number')) ? Input::get('search_number') : '' }}" name="search_number" aria-controls="editable-sample" class="form-control medium" placeholder="Search Number"/>
                        </div>
                        <div class="form-group col-md-3">
                            <input type="submit" name="submit" class="btn" value="Submit">
                        </div>
                    </form>  
                </div>
                <div class="box-header col-md-3">
                    <form method="post" id="CatExport" action="{{ URL::route('admin.sales.export.category') }}">
                        <input type="hidden" value="dateSearch" name="dateSearch">
                        <input type="hidden" name="from_date" value="{{ !empty(Input::get('from_date'))?Input::get('from_date'):'' }}"  class="form-control fromDate " placeholder="From Date" autocomplete="off" id="">
                        <input type="hidden" name="to_date" value="{{ !empty(Input::get('to_date'))?Input::get('to_date'):'' }}"  class="form-control toDate col-md-3" placeholder="To Date" autocomplete="off" id="">
                        <input type="hidden" value="{{ !empty(Input::get('search')) ? Input::get('search') : '' }}" name="search" aria-controls="editable-sample" class="form-control medium" placeholder="Search Category"/>
                        <input type="button" class="catExport btn pull-right col-md-12" value="Export">
                    </form>
                </div> 
                <div style="clear: both"></div>
                <div class="box-body table-responsive no-padding">
                    <table class="table  catSalesTable table-hover general-table">
                        <thead>
                            <tr>
                                <th>Sr No</th>
                                <th>Customer</th>
                                <th>Email_id</th>
                                <th>Telephone</th>
                                <th>Total purchase till now</th>
                                <th>Cashback</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1; ?>
                            @foreach($users as $user)
<?php // dd($user);?>
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{ $user->firstname }} {{ $user->lastname }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->telephone }}</td>
                                <td><i class='fa fa-rupee'></i>{{ number_format($user->total_purchase_till_now) }}</td>
                                <td><i class='fa fa-rupee'></i> {{ number_format($user->cashback)}}</td>
                                <td><a href="{{ URL::route('admin.sales.orderByCustomer',['id' => $user->id]) }}"><i class='fa fa-eye'></i></a></td>
                            </tr>
                            <?php $i++ ?>
                            @endforeach
                        </tbody>
                    </table>
                    <?php if (empty(Input::get('dateSearch'))) { ?>
                        <div class="pull-right">
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
</script>

@stop