@extends('Admin.layouts.default')
@section('content')


<section class="content-header">
    <h1>
        Countries
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active"> Countries</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                @if(!empty(Session::get('message')))
                <div class="alert alert-success" role="alert">
                    {{ Session::get('message') }}
                </div>
                @endif
                @if(!empty(Session::get('msg')))
                <div class="alert alert-danger" role="alert">
                    {{ Session::get('msg') }}
                </div>
                @endif
                <div class="clearfix"></div>
                <div class="box-header box-tools filter-box col-md-12 noBorder">
                    <form method="get" action=" " id="searchForm">
                        <div class="form-group col-md-5 col-sm-4 col-xs-12">
                            <select name="country" id="country" class="form-control medium">
                                <option value="">Select Country</option>
                                @foreach($countryall as $countryallVal)
                                <option value="{{$countryallVal->name}}">{{$countryallVal->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-5 col-sm-4 col-xs-12">
                            <select name="status" id="status" class="form-control medium">
                                <option value="">Status</option>

                                <option value="1">Enabled</option>
                                <option value="0">Disabled</option>

                            </select>
                        </div>
                        <div class="form-group col-md-2 col-sm-4 col-xs-12">
                            <input type="submit" name="search" class="btn btn-primary form-control noMob-leftmargin mn-w100" value="Search">
                            </form>
                        </div>

                </div>



                <div class="clearfix"></div>

                
                <div class="dividerhr"></div>

                <div class="box-body table-responsive no-padding">
                    <table class="table table-striped table-hover tableVaglignMiddle">
                        <thead>
                            <tr>
                                <!--                                <th>id</th>-->
                                <th>Name</th>
                                <th>Country Status</th>
                                <th class="text-center mn-w100">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($country) >0)
                            @foreach($country as $countryVal)
                            <tr> 

                                <td>{{$countryVal->name }}</td>

                                <td>@if($countryVal->status=='1') 
                                    <a href="{!! route('admin.country.countryStatus',['id'=>$countryVal->id])!!}" class="" ui-toggle-class="" onclick="return confirm('Are you sure you want to disable this country?')" data-toggle="tooltip" title="Enabled"><i class="fa fa-check btn-plen btn"></i></a>
                                    @elseif($countryVal->status=='0')
                                    <a href="{!! route('admin.country.countryStatus',['id'=>$countryVal->id])!!}" class="" ui-toggle-class="" onclick="return confirm('Are you sure you want to enable this country?')" data-toggle="tooltip" title="Disabled"><i class="fa fa-times btn-plen btn"></i></a>
                                    @endif</td>
                                </td>


                                <td class="text-center mn-w100">
                                    <a href="{!! route('admin.country.edit',['id'=>$countryVal->id]) !!}" class="" ui-toggle-class="" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil-square-o btn btn-plen btnNo-margn-padd"></i></a>
                                    <a href="{!! route('admin.country.delete',['id'=>$countryVal->id]) !!}" class="" ui-toggle-class="" onclick="return confirm('Are you sure you want to delete this country?')" data-toggle="tooltip" title="Delete"><fa class="fa fa-trash"></i>
                                    </a></td>



                            </tr>
                            @endforeach
                            @else
                            <tr><td colspan=5> No Record Found</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">

                    <?php
                    echo $country->render();
                    ?>

                </div>
            </div><!-- /.box -->
        </div><!-- /.col -->

    </div> 
</section>

@stop

