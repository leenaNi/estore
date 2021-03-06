@extends('Admin.layouts.default')
@section('content')

<section class="content-header">
    <h1>
        NewsLetter
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">NewsLetter</li>
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
<!--                <div class="box-header box-tools filter-box col-md-9 noBorder">

                    <form action="{{ route('admin.contact.view') }}" method="get" >
                        <input type="hidden" value="searchData" name="searchData" >
                        <div class="form-group col-md-4 noBottomMargin">
                            <input type="text" value="{{ !empty(Input::get('phone_no')) ? Input::get('phone_no') : '' }}" name="phone_no" aria-controls="editable-sample" class="form-control medium" placeholder="Contact No"/>    
                        </div>
                        <div class="form-group col-md-4 noBottomMargin">
                            <input type="text" value="{{ !empty(Input::get('email')) ? Input::get('email') : '' }}" name="email" aria-controls="editable-sample" class="form-control medium" placeholder=" Email ID"/>
                        </div>

                        <div class="form-group col-md-2 noBottomMargin">

                            <input type="submit" name="submit" class="btn btn-primary form-control"  value="Search">
                        </div>
                        <div class="form-group col-md-2 noBottomMargin">
                            <a href="{{route('admin.contact.view')}}" class="btn reset-btn btn-block" value="reset">Reset</a>
                        </div>

                    </form> 

                </div>
-->                <div class="box-header col-md-3">
    <a href="{{route('admin.home.exportNewsLetter')}}" class="btn btn-default pull-right col-md-12" value="">Export Newsletter</a>
                  
                </div>
                <div class="clearfix"></div>
                <div class="dividerhr"></div>
                <div class="form-group col-md-4 ">
                    <div class="button-filter-search pl0">
                        
                    </div>
                </div> 
                <div class="clearfix"></div>

                <div class="box-body table-responsive no-padding">
                    <table class="table table-striped table-hover tableVaglignMiddle">
                        <thead>
                            <tr>
                                <!--                                <th>Sr No</th>-->
                                <th>Email</th>
                             
                                <!-- <th>Status</th> -->
                                <th>Created At</th>
                        
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($newsLetters) >0)
                            @foreach ($newsLetters as $newsLetter)
                            <tr>
                                <td>{{$newsLetter->email}}</td>
                              
                                <td>{{  date('d M Y ',strtotime($newsLetter->created_at))}}</td>
                             
                       
                            </tr>
                            @endforeach
                            @else
                            <tr><td colspan=6>No Record Found.</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div><!-- /.box-body -->

                <div class="box-footer clearfix">
                  @if(empty(Input::get("searchData")))
                  {!! $newsLetters->links() !!}
                  @endif
              </div>
          </div>
      </div>
  </div>
</section>

@stop 
@section('myscripts')
<script>
    /*$(function () {
        $("#fromdatepicker").datepicker({dateFormat: 'yy-mm-dd'});
        $("#todatepicker").datepicker({dateFormat: 'yy-mm-dd'});
    });*/
</script>
@stop