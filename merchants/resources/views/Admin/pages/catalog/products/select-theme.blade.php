@extends('Admin.layouts.default')
@section('mystyles')

@stop
@section('content')

<section class="content-header">
    <h1>
    Select Industry
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Select Industry</li>
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
                <div class="box-header box-tools filter-box col-md-9 col-sm-12 col-xs-12 noBorder">
                    {!! Form::open(['method' => 'post', 'route' => 'applyTheme' , 'id' => 'searchForm' ]) !!}
                    <div class="form-group  col-md-12">
                    {!! Form::label('Industry', 'Industry',['class'=>'control-label']) !!}
                    {!! Form::select('cat_id[]',$cat,null,["class"=>'form-control validate[required]']) !!}
                    </div>

                    <!-- Portfolio Items
            ============================================= -->
            <div class="form-group  col-md-12">
            {!! Form::label('Select Theme', 'theme',['class'=>'control-label']) !!}
            <select class="form-control" name="theme_id">
                @foreach($themeIds as $themeK => $theme)
                <option value="{{$theme->id}}">{{$theme->theme_category}}</option>
                @endforeach
            </select>   
            </div><!-- #portfolio end -->
                            
                    <div class="form-group col-md-4 noBottomMargin">
                        <div class=" button-filter-search col-md-6 no-padding">
                            <button type="submit" name="save" class="btn sbtn btn-primary form-control" style="margin-left: 0px;" value="Search"> Submit</button>
                        </div>
                        
                    </div>
                    {!! Form::close() !!}
                </div>
             
                </div>
            </div><!-- /.box -->
        </div><!-- /.col -->

    </div>
 
   
   
    <!-- Product Add Modal -->
    <!-- Product Close Modal Open -->
</section>

@stop
@section('myscripts')


@stop