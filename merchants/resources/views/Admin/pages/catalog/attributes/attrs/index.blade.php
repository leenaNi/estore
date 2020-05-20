@extends('Admin.layouts.default')
@section('content')


<section class="content-header">
    <h1>
        Attributes ({{$attrsCount }})
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Attributes</li>
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
                <div class="box-header box-tools filter-box col-md-9 col-sm-12 col-xs-12">
                 
                    <form method="get" action=" " id="searchForm">
                      
                        <div class="form-group col-md-8 col-sm-6 col-xs-12">
                            <input type="text" value="{{ !empty(Input::get('attr_name'))?Input::get('attr_name'):'' }}" name="attr_name" aria-controls="editable-sample" class="form-control medium" placeholder="Attribute Name">
                        </div>
                        <div class="form-group col-md-2  col-sm-3 col-xs-12">
                            <input type="submit" name="submit" vlaue='Submit' class='form-control btn btn-primary  noMob-leftmargin'>
                        </div>
                        <div class="from-group col-md-2  col-sm-3 col-xs-12">
                            <a href="{{ route('admin.attributes.view')}}" class="form-control btn reset-btn noMob-leftmargin">Reset </a>
                        </div>

                    </form>
                       
                    </div>
              
                <div class="box-header col-md-3 col-sm-12 col-xs-12">
                    <a href="{!! route('admin.attributes.add') !!}" class="btn btn-default pull-right col-md-12 mobAddnewflagBTN" type="button">Add New Attribute</a>
                </div> 
                    <div class="clearfix"></div>
                <div class="dividerhr"></div>
          
                <div class="box-body table-responsive no-padding">
                    <table class="table table-striped table-hover tableVaglignMiddle">
                        <thead>
                            <tr>
                <!--                <th>id</th>-->

                                <th>Attribute Name</th>
                                <th>Attribute Set</th>
                                <th>Sort Order</th>
                                <th>Is Filterable</th>
                                <th>Is Required</th>
                                <th>Date</th>
                                <th> Status </th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                             @if(count($attrs) > 0)
                            @foreach($attrs as $attr)
                            <tr> 
                <!--                <td>{{$attr->id }}</td>-->
                                <td>{{$attr->attr }}</td>
                                <td>
                                    @foreach($attr->attributesets as $set)
                                    <div>{{$set->attr_set }}</div>
                                    @endforeach
                                </td>
                                <td>{{$attr->att_sort_order }}</td>
                                <td>{{$attr->is_filterable? 'Yes' : 'No' }}</td>
                                <td>{{$attr->is_required? 'Yes' : 'No' }}</td>

                                <td>{{ date("d-M-Y",strtotime($attr->created_at)) }}</td>
                                <td>
                                    <?php if ($attr->status == 1) { ?>
                                    <a href="{!! route('admin.attributes.changeStatus',['id'=>$attr->id]) !!}" class="" ui-toggle-class="" onclick="return confirm('Are you sure you want to disable this attribute ?')" data-toggle="tooltip" title="Enabled"><i class="fa fa-check" ></i></a><br>
                                    <?php } elseif ($attr->status == 0) { ?>
                                    <a href="{!! route('admin.attributes.changeStatus',['id'=>$attr->id]) !!}" class="" ui-toggle-class="" onclick="return confirm('Are you sure you want to enable this attribute ?')" data-toggle="tooltip" title="Disabled"> <i class="fa fa-times"></i></a><br>
                                    <?php } ?>
                                </td>
                                <td>
                                    <a href="{!! route('admin.attributes.edit',['id'=>$attr->id]) !!}" class="" ui-toggle-class="" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil-square-o"></i></a>
                               
                                    <a href="{!! route('admin.attributes.delete',['id'=>$attr->id]) !!}"  class="" ui-toggle-class=""  onclick="return confirm('Are you sure you want to delete attribute?')" data-toggle="tooltip" title="Delete"><i class="fa fa-trash fa-fw"></i></a>
                                </td>
                            </tr>
                            @endforeach 
                             @else
                            <tr><td colspan=9>No Record Found</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">

                    <?php
                    $args = [];
                    !empty(Input::get("attr_name")) ? $args["attr_name"] = Input::get("attr_name") : '';
                    if(empty(Input::get('attr_name'))){
                    
                        echo  $attrs->render();  
                    }
                    
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
        $(".delete").click(function () {
            var r = confirm("Are You Sure You want to Delete this Attribute?");
            if (r == true) {
                $(this).parent().submit();
            } else {

            }
        });
    });
</script>

@stop