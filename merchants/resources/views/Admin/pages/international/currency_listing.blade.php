@extends('Admin.layouts.default')
@section('content')


<section class="content-header">
    <h1>
        Currency Conversion
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active"> Currency Conversion </li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                  @if(!empty(Session::get('message')))
                <div class="alert alert-danger" role="alert">
                    {{ Session::get('message') }}
                </div>
                @endif
                  @if(!empty(Session::get('msg')))
                <div class="alert alert-success" role="alert">
                    {{Session::get('msg')}}
                </div>
                @endif
                <div class="box-header box-tools filter-box col-md-12 noBorder">
                    <form method="get" action=" " id="searchForm">

                        <div class="form-group col-md-5 noBottomMargin">
                            <select name="currency" id="currency" class="form-control medium">
                                <option value="">Select Country</option>
                                @foreach($currencyall as $currencyValall)
                                <option value="{{$currencyValall->currency_code}}">{{$currencyValall->currency_code}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-5 noBottomMargin">
                            <select name="status" id="status" class="form-control medium">
                                <option value="">Select Status</option>
                                <option value="1">Enabled</option>
                                <option value="0">Disabled</option>

                            </select>
                        </div>
                        <div class="form-group col-md-2 noBottomMargin">
                            <input type="submit" name="search" class="btn btn-primary form-control" value="Search">
                        </div>

                    </form>
                </div>

              

                <div class="clearfix"></div>
                <div class="dividerhr"></div>

                <div class="box-body table-responsive no-padding">
                    <table class="table table-striped table-hover tableVaglignMiddle">
                        <thead>
                            <tr>
                                <!--                                <th>id</th>-->
                                <th>Name</th>
                                <th>Country Value</th>
                                <th>Country Status</th>
                                <th>Action</th>


                            </tr>
                        </thead>
                        <tbody>
                           @if(count($currency) >0)
                           @foreach($currency as $currencyVal)

                           <tr> 
                            <!--                                <td>{{$currencyVal->id }}</td>-->
                            <td>{{$currencyVal->currency_code }}</td>
                            <td>{{$currencyVal->currency_val }}</td>

                            <td> <?php
                                if ($currencyVal->currency_status == '0') {
                                    ?>
                                    <a  class="status" id="<?php echo $currencyVal->id . '-0'; ?>" style="cursor:pointer;" onclick="return confirm('Are you sure you want to enable this currency?')" data-toggle="tooltip" title="Disabled"><i class="fa fa-times btnNo-margn-padd"></i></a>
                                    <?php } else {
                                        ?>
                                        <a  class="status" id="<?php echo $currencyVal->id . '-1'; ?>" style="cursor:pointer;" onclick="return confirm('Are you sure you want to disabled this currency?')" data-toggle="tooltip" title="Enabled"><i class="fa fa-check btnNo-margn-padd"></i></a>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <a href="{!! route('admin.currency.editCurrencyListing',['id'=>$currencyVal->id]) !!}" class="" ui-toggle-class="" data-toggle="tooltip" title='Edit'><i class='fa fa-pencil-square-o btnNo-margn-padd'></i></a>
                                    </td>

                                </tr>
                                @endforeach
                                @else
                                <tr><td colspan=6> No Record Found</td></tr>
                                @endif
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                    <div class="box-footer clearfix">

                        <?php
                        echo $currency->render();
                        ?>

                    </div>
                </div><!-- /.box -->
            </div><!-- /.col -->

        </div> 
    </section>

    @stop
    @section('myscripts')
    <script>
        $(document).ready(function () {
            $('.status').on('click', function () {
                var statusId = $(this).attr('id');

                var currency = statusId.split('-');

                var currencyId = currency[0];

                var currencyStatus = currency[1];

                $.ajax({
                    url: "{{route('admin.currency.currencyStatus')}}",
                    data: {currencyId: currencyId, currencyStatus: currencyStatus},
                    success: function (data) {

                        location.reload();
                    }
                });
            });
        });
    </script>

    @stop
