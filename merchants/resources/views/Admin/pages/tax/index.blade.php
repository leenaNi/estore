@extends('Admin.layouts.default')
@section('content')

<section class="content-header">
    <h1>
        Taxes ({{$taxCount }})
        <!--        <small>Add/Edit/Delete</small>-->
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Tax</li>
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
                <div class="box-header box-tools filter-box col-md-9 noBorder col-sm-12 col-xs-12">

                    <form action="{{ route('admin.tax.view') }}" method="get" >
                       <div class="form-group col-md-8 col-sm-6 col-xs-12">
                        <input type="text" value="{{ !empty(Input::get('search')) ? Input::get('search') : '' }}" name="search" aria-controls="editable-sample" class="form-control medium" placeholder="Search Tax"/>
                    </div> 
                    <div class="form-group col-md-2 col-sm-3 col-xs-12">
                       <button type="submit" class="btn btn-primary form-control" style="margin-left: 0px;"> Search</button>
                   </div>
                   <div class="from-group col-md-2 col-sm-3 col-xs-12">
                      <a href="{{ route('admin.tax.view')}}" class="form-control medium btn reset-btn noMob-leftmargin"> Reset </a>
                  </div>
              </form> 

          </div>
          <div class="box-header col-md-3 col-sm-12 col-xs-12">
            <a href="{!! route('admin.tax.add') !!}" class="btn btn-default pull-right form-control mobAddnewflagBTN" type="button">Add New Tax</a> 
        </div>
        <div class="clearfix"></div>
        <div class="dividerhr"></div>
       
        <div class="clearfix"></div>
        <div class="box-body table-responsive no-padding">
            <table class="table table-striped table-hover tableVaglignMiddle">
                <thead>
                    <tr>

                        <th>Tax Name</th>
<!--                        <th>Display Name</th>-->
                        <th>Tax Rate (%)</th>
                        <th>Tax Number</th>
                        <th>Created At</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                  @if(count($taxInfo) >0 )
                  @foreach ($taxInfo as $tax)
                  <tr>

                    <td>{{$tax->name}}</td>
<!--                    <td>{{ $tax->label }}</td>-->
                    <td>{{$tax->rate}} </td>
                    <td>{{$tax->tax_number}}</td>
                    <td>{{date('d-M-Y',strtotime($tax->created_at))}}</td>
                    <td>@if($tax->status==1)
                        <a href="{!! route('admin.tax.changeStatus',['id'=>$tax->id]) !!}"  ui-toggle-class="" onclick="return confirm('Are you sure you want to disable this tax?')" data-toggle="tooltip" title="Enabled"><i class="fa fa-check btn-plen btn btnNo-margn-padd"></i></a>
                        @elseif($tax->status==0)
                        <a href="{!! route('admin.tax.changeStatus',['id'=>$tax->id]) !!}" ui-toggle-class="" onclick="return confirm('Are you sure you want to enable this tax?')" data-toggle="tooltip" title="Disabled"><i class="fa fa-times btn-plen btn  btnNo-margn-padd"></i></a>
                        @endif</td>

                        <td>
                            <a href="{{route('admin.tax.edit',['id'=>$tax->id])}}" data-toggle="tooltip" title='Edit' ui-toggle-class=""><i class="fa fa-pencil-square-o btnNo-margn-padd"></i></a> 


                            <a href="{{route('admin.tax.delete',['id'=>$tax->id])}}"  ui-toggle-class="" onclick="return confirm('Are you sure you want to delete this tax?')" data-toggle="tooltip" title='Delete'><i class="fa fa-trash btn-plen btn btnNo-margn-padd"></i></a>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr><td colspan=7> No Record Found</td></tr>
                    @endif
                </tbody>
            </table>
        </div><!-- /.box-body -->
        <div class="box-footer clearfix">
            <?php if (empty(Input::get('search'))) {
             echo $taxInfo->render();
         } ?> 

     </div>
 </div>
</div>
</div>
</section>

@stop 
@section('myscripts')
<script>
    $(function () {
        $("#fromdatepicker").datepicker({dateFormat: 'yy-mm-dd'});
        $("#todatepicker").datepicker({dateFormat: 'yy-mm-dd'});
    });
</script>
@stop