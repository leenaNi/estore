@extends('Admin.layouts.default')
@section('content') 

<section class="content-header">   
    <h1>
        Returned Customers Data
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Returned Customers Data</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                     
                <div class="clearfix"></div>
                <div class="box-body table-responsive">
                    <table class="table table-striped table-hover tableVaglignMiddle">
                        <thead>
                            <tr>

                                <th>Customer Name</th>
                                <th>Email</th>
                                <th>Total Purchase</th>
                              
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($returningcustomer) > 0) { ?>
                                @foreach ($returningcustomer as $key => $customer)
                                <tr>
                                    <td>{{$customer->firstname}} {{$customer->lastname}}</td>
                                    <td>{{$customer->email}}</td>
                                    <td>{{$customer->pay_amt}}</td>
                                </tr>
                                @endforeach
                            <?php } else { ?>
                                <tr>
                                    <td colspan="5">No Record Found.</td>
                                </tr>
                            <?php } ?>      
                        </tbody>
                    </table>
                </div><!-- /.box-body -->

            </div>
        </div>
    </div>
</section>

@stop