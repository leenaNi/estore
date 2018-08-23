@extends('Admin.layouts.default')
@section('content')


<section class="content-header">
    <h1>
        Stock Settings

    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active"> Settings </li>
        <li class="active">Stock Settings</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">


                @if(!empty(Session::get('message')))
                <div class="alert" role="alert">
                    {{ Session::get('message') }}
                </div>
                @endif
                <div class="box-body table-responsive no-padding">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Stock running count</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr> 
                                <td></td>
                                <?php
                                $getStockLimitval = json_decode($getStockLimit->details, true);
                                ?>
                                <form method="post" action="{{ route('admin.stockSetting.save')}}" class='form-horizontal' >
                                    <td><input type="number" class="form-control medium" name="stock" value="{{$getStockLimitval['stock_limit']}}" min="1" style="width: 400px;"></td>
                                    <td>
                                        <!-- <input type="submit" name="submit" value="Save" class="btn btn-primary"> -->
                                        <button data-toggle="tooltip" title="Save" type="submit" name="submit" class="btn btn-plen noBackground"><i class="fa fa-floppy-o btnNo-margn-padd" aria-hidden="true"></i></button>
                                    </td>
                                </form>
                            </tr>
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
                <div class="box-footer clearfix"></div>
            </div><!-- /.box -->
        </div><!-- /.col -->

    </div> 
</section>

@stop

