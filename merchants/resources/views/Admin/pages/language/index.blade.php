@extends('Admin.layouts.default')
@section('content') 
<section class="content-header">   
    <h1>
        Languages
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Languages</li>
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
<!--                <div class="box-header noBorder box-tools filter-box col-md-9 noBottompadding">
                  
                        <form action="{{ route('admin.language.view') }}" method="get" >
                            <input type="hidden" name="dataSearch" value="dataSearch"/>
                              <div class="form-group col-md-6">
                                  <input type="text" name="language"  class="form-control" placeholder="Search Language" value="{{ (!empty(Input::get('language'))) ? Input::get('language') :''}}" >
                            </div>
                              
                               <div class="form-group col-sm-2">
                                <button type="submit" class="btn btn-primary form-control" style="margin-left: 0px;"> Search</button>
                            </div>
                            <div class="from-group col-sm-2">
                                <a href="{{ route('admin.language.view')}}" class="btn btn-block reset-btn">Reset </a>
                            </div>
                        </form>
                    </div>   -->

              
                <div class="box-header col-md-3 pull-right">
                     <a href="{!! route('admin.language.addEdit') !!}" class="btn btn-default pull-right col-md-12" type="button">Add New Language</a>
                </div> 

                <div class="clearfix"></div>
                <div class="dividerhr"></div>
                                
                <div class="box-body table-responsive no-padding">
                    <table class="table  table-hover general-table tableVaglignMiddle">
                        <thead>
                            <tr>
                              
                                <th>Language</th>
                                <th> Status</th>
                                  <th>Action</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($languages) >0)
                            @foreach($languages as $language)

                            <tr>
                              
                                <td>{{ $language->name }}</td>
                                 <td>@if($language->status ==1)  
                                   <a href="{{route('admin.language.changeStatus',['id'=>$language->id])}}" data-toggle="tooltip" title="Enabled" onclick="return confirm('Are you sure you want to disable this language?')"><i class="fa fa-check btn btn-plen"></i></a>
                                 @endif
                                 @if($language->status ==0)  
                                  <a href="{{route('admin.language.changeStatus',['id'=>$language->id])}}" data-toggle="tooltip" title="Disabled" onclick="return confirm('Are you sure you want to enable this language?')"><i class="fa fa-times btn btn-plen"></i></a>
                                 @endif
                                 </td>
                                <td>
                                   
                                    <a href="{{route('admin.language.addEdit',['id'=>$language->id])}}" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil-square-o btn btn-plen btnNo-margn-padd"></i></a>
                                      <a href="{{route('admin.language.delete',['id'=>$language->id])}}" onclick="return confirm('Are you sure you want to delete this language?')" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr> <td colspan="4">No Record Found.</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
                
                 <div class="box-footer clearfix">
                    @if(empty(Input::get('dataSearch')))
                   {{$languages->links() }}
                    @endif

                </div>
            </div>
        </div>
    </div>
</section>

@stop

@section('myscripts')

@stop

