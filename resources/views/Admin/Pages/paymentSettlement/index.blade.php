@extends('Admin.Layouts.default')

@section('contents')

<section class="content-header">
    <h1>
        Payment Settlement

    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Payment Settlement</li>
    </ol>
</section>
<section class="content">

    <div class="row">
        <div class="col-xs-12">
            <div class="box">

              
                <div class="box-body table-responsive">
                    <table class="table table-hover">
                        <tr>
                 
                            <th>Merchant</th>
                
                            <th>Email ID</th>
                            <th>Mobile</th>
                       
                            <th>Created Date</th>
                            <th>Actions</th>
                        </tr>
                        @foreach($merchants as $merchant)
                        <tr>

                            <td>{{ $merchant->firstname." ".$merchant->lastname }}</td>
                         
                            <td>{{ $merchant->email }}</td>
                            <td>{{ $merchant->phone }}</td>
                       
                            <td>{{ date('d-M-Y',strtotime($merchant->created_at)) }}</td>
                            <td>
                            </td>
                        </tr>
                        @endforeach
                    </table>

                    <div class="pull-right">
                        {{ $merchants->appends($arguments)->links() }}
                    </div>


                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
<!-- /.content -->

@stop
@section('myscripts')

@stop