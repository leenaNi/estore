
@extends('Admin.layouts.default')
@section('content') 
<section class="content-header">   
    <h1>
        Languages Translations
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Languages Translations</li>
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
                <div class="box-header noBorder box-tools filter-box col-md-9 col-sm-12 col-xs-12">
                  
                        <form action="{{ route('admin.translation.view') }}" method="get" >
                            <input type="hidden" name="dataSearch" value="dataSearch"/>
                              <div class="form-group col-md-8 col-sm-12 col-xs-12">
                                  <input type="text" name="translation"  class="form-control" placeholder="English" value="{{ (!empty(Input::get('translation'))) ? Input::get('translation') :''}}" >
                            </div>
                              
                               <div class="form-group col-md-2 col-sm-6 col-xs-12">
                                <button type="submit" class="btn btn-primary form-control" style="margin-left: 0px;"> Search</button>
                            </div>
                            <div class="from-group col-md-2 col-sm-6 col-xs-12">
                                <a href="{{ route('admin.translation.view')}}" class="btn btn-block reset-btn noMob-leftmargin">Reset </a>
                            </div>
                        </form>
                    </div>   

              
                <div class="box-header col-md-3 col-sm-12 col-xs-12">
                     <a href="{!! route('admin.translation.addEdit') !!}" class="btn btn-default pull-right col-md-12 mobAddnewflagBTN" type="button">Add New Translation</a>
                </div> 

                <div class="clearfix"></div>
                <div class="dividerhr"></div>
                                
                <div class="box-body table-responsive no-padding">
                    <table class="table  table-hover general-table tableVaglignMiddle">
                        <thead>
                            <tr>
                                <th>English</th>
                                <th>Hindi </th>
                                <th>Bengoli</th>
                                <th>Pages</th>
                                <th>Action</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($translations) >0)
                            @foreach($translations as $translation)

                            <tr>
                                  <td>{{ $translation->english }}</td>
                                <td>{{ $translation->hindi }}</td>
                              
                                 <td>{{ $translation->bengali }}</td>
                                 <td>{{ $translation->page }}</td>
                                <td>
                                   
                                    <a href="{{route('admin.translation.addEdit',['id'=>$translation->id])}}" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil-square-o btn btn-plen btnNo-margn-padd btnNo-margn-padd"></i></a>
                                      <a href="{{route('admin.translation.delete',['id'=>$translation->id])}}" onclick="return confirm('Are you sure you want to delete this translation?')" data-toggle="tooltip" title="Delete"><i class="fa fa-trash btnNo-margn-padd"></i></a>
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
                   {{$translations->links() }}
                    @endif

                </div>
            </div>
        </div>
    </div>
</section>

@stop

@section('myscripts')

@stop
