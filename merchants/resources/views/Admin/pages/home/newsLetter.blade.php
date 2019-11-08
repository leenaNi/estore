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

                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="row">
                    <form action="{{ route('admin.home.saveNewsLetter') }}" method="post" enctype="multipart/form-data" >
                        <div class="box-header no-margin">
                            
                            <div class="col-sm-2">
                                <label>Image</label>
                            </div>
                            <div class="col-sm-2">
                                <img id="newsLetterimg" src="{{ isset($result) ? $result['img_path'] : '' }}" width="50" height="50" >
                            </div>
                            <div class="col-sm-4">
                                <input type="file" id="file_logo" name="newsLetterimg" onchange="readURL(this);" class="form-control" >
                            </div>
                        </div>
                        <div class="box-header no-margin">
                            <div class="col-sm-2">
                                <label>Enable On Home Page</label>
                            </div>
                            <div>
                                <?php
                                $checkval = 0;
                                $checked = '';
                                if(isset($result) && $result['status'] == 1){
                                    $checkval = 1;
                                    $checked = 'checked';
                                }
                                ?>
                            <input type="checkbox" name="enablesub" class="enablesub" value="{{ $checkval }}" {{ $checked }}> 
                            </div>
                        </div>
                        <div class="box-header no-margin">
                            <div class="col-sm-2">
                                <label>Display Header</label>
                            </div>
                            <div class="form-group col-md-4 noBottomMargin">
                                <input type="text" name="displayHeader" value="{{ $result['displayHeader'] or ''}}" class="form-control medium">
                            </div>
                        </div>
                        <div class="box-header no-margin">
                            <div class="col-sm-2">
                                <label>Display Content</label>
                            </div>
                            <div class="form-group col-md-4 noBottomMargin">
                                <input type="text" name="displayContent" value="{{ $result['displayContent'] or '' }}" class="form-control medium">
                            </div>
                        </div>
                        <div class="box-header col-md-3">
                            <input type="submit" class="btn-default pull-left col-md-12">
                        </div>
                    </form> 
                </div>
                <div class="clearfix"></div>
                <div class="dividerhr"></div>
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
                                <th>Subscription Date</th>

                                <th>Subscribed</th>
                        
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($newsLetters) >0)
                            @foreach ($newsLetters as $newsLetter)
                            <tr>
                                <td>{{$newsLetter->email}}</td>
                              
                                <td>{{  date('d M Y ',strtotime($newsLetter->created_at))}}</td>
                             
                                <td>
                                    <?php
                                    if(isset($newsLetter->status) && $newsLetter->status == 1){
                                        $status = 'Yes';
                                    }else{
                                        $status = 'No';
                                    }
                                    ?>
                                    {{ $status }}
                                </td>
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
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#newsLetterimg')
                    .attr('src', e.target.result)
                    .width(150)
                    .height(200);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    
</script>
@stop