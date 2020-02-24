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


<section class="main-content">
    <div class="notification-column">
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
    </div>
  <div class="grid-content">
        <div class="section-main-heading">
            <h1> Attributes</h1>
        </div>
        <div class="filter-section displayFlex">
            <div class="col-md-9 noAll-padding displayFlex">
                <div class="filter-left-section">
                    
                    <form method="get" action=" " id="searchForm">
                      
                        <div class="form-group col-md-8 col-sm-6 col-xs-12">
                            <input type="text" value="{{ !empty(Input::get('attr_name'))?Input::get('attr_name'):'' }}" name="attr_name" aria-controls="editable-sample" class="form-control medium" placeholder="Attribute Name">
                        </div>
                        <div class="form-group col-md-2  col-sm-3 col-xs-12">
                            <input type="submit" name="submit" vlaue='Submit' class='btn btn-primary  noMob-leftmargin'>
                        </div>
                        <div class="from-group col-md-2  col-sm-3 col-xs-12">
                            <a href="{{ route('admin.attributes.view')}}" class="btn reset-btn noMob-leftmargin">Reset </a>
                        </div>

                    </form>

                </div>
            </div>
            <div class="col-md-3 noAll-padding displayFlex">
                <div class="filter-right-section">
                    <a href="{!! route('admin.attributes.add') !!}" class="btn btn-default pull-right col-md-12 mobAddnewflagBTN" type="button">Add New Attribute</a>
                </div>
            </div>
        </div>
    </div>
    <div class="grid-content">
        <div class="section-main-heading">
            <h1>Attributes <span class="listing-counter">{{$attrsCount }}</span></h1>
        </div>
        <div class="listing-section">
        <table class="table table-striped table-hover tableVaglignMiddle">
                        <thead>
                            <tr>
                <!--                <th>id</th>-->

                                <th class="text-left">Attribute Name</th>
                                <th class="text-left">Attribute Set</th>
                                <th class="text-center">Sort Order</th>
                                <th class="text-center">Is Filterable</th>
                                <th class="text-center">Is Required</th>
                                <th class="text-right">Date</th>
                                <th class="text-center"> Status </th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                             @if(count($attrs) > 0)
                            @foreach($attrs as $attr)
                            <tr> 
                <!--                <td>{{$attr->id }}</td>-->
                                <td class="text-left">{{$attr->attr }}</td>
                                <td class="text-left">
                                    @foreach($attr->attributesets as $set)
                                    <div>{{$set->attr_set }}</div>
                                    @endforeach
                                </td>
                                <td class="text-center">{{$attr->att_sort_order }}</td>
                                <td class="text-center">{{$attr->is_filterable? 'Yes' : 'No' }}</td>
                                <td class="text-center">{{$attr->is_required? 'Yes' : 'No' }}</td>

                                <td class="text-right">{{ date("d-M-Y",strtotime($attr->created_at)) }}</td>
                                <td class="text-center">
                                    <?php if ($attr->status == 1) { ?>
                                    <a href="{!! route('admin.attributes.changeStatus',['id'=>$attr->id]) !!}" class="" ui-toggle-class="" onclick="return confirm('Are you sure you want to disable this attribute ?')" data-toggle="tooltip" title="Enabled"><i class="fa fa-check" ></i></a><br>
                                    <?php } elseif ($attr->status == 0) { ?>
                                    <a href="{!! route('admin.attributes.changeStatus',['id'=>$attr->id]) !!}" class="" ui-toggle-class="" onclick="return confirm('Are you sure you want to enable this attribute ?')" data-toggle="tooltip" title="Disabled"> <i class="fa fa-times"></i></a><br>
                                    <?php } ?>
                                </td>
                                <td class="text-center">
                                    <div class="actionLeft">
                                        <span><a class="btn-action-default" href="{!! route('admin.attributes.edit',['id'=>$attr->id]) !!}">Edit</a></span> 
                                        <span class="dropdown">
                                            <button class="btn-actions dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton"> 
                                                <li><a href="{!! route('admin.attributes.delete',['id'=>$attr->id]) !!}"><i class="fa fa-trash "></i> Delete</a></li>
                                            </ul>
                                        </span>  
                                    </div>
                                    <!-- <a href="{!! route('admin.attributes.edit',['id'=>$attr->id]) !!}" class="" ui-toggle-class="" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil-square-o"></i></a>
                               
                                    <a href="{!! route('admin.attributes.delete',['id'=>$attr->id]) !!}"  class="" ui-toggle-class=""  onclick="return confirm('Are you sure you want to delete attribute?')" data-toggle="tooltip" title="Delete"><i class="fa fa-trash fa-fw"></i></a> -->
                                </td>
                            </tr>
                            @endforeach 
                             @else
                            <tr><td colspan=9 class="text-center">No Record Found</td></tr>
                            @endif
                        </tbody>
                    </table>

            <div class="box-footer clearfix">
                 <?php
                    $args = [];
                    !empty(Input::get("attr_name")) ? $args["attr_name"] = Input::get("attr_name") : '';
                    if(empty(Input::get('attr_name'))){
                    
                        echo  $attrs->render();  
                    }
                    
                ?>
            </div>
        </div>
    </div>
</section>
<div class="clearfix"></div>
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