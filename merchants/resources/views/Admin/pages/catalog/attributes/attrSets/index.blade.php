@extends('Admin.layouts.default')
@section('content')


<section class="content-header">
    <h1>
        Variant Sets ({{$attrCount }})
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">  Variant Sets</li>
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
                        <input type="hidden" name="attrSetCatalog">
                        <div class="form-group col-md-8 col-sm-6 col-xs-12">
                            <input type="text" value="{{ !empty(Input::get('attr_set_name'))?Input::get('attr_set_name'):'' }}" name="attr_set_name" aria-controls="editable-sample" class="form-control medium" placeholder="Variant Set Name">
                        </div>
                        <div class="form-group col-md-2 col-sm-3 col-xs-12">
                            <input type="submit" name="submit" vlaue='Submit' class='form-control btn btn-primary noMob-leftmargin'>
                        </div>
                        <div class="from-group col-md-2 col-sm-3 col-xs-12">
                            <a href="{{ route('admin.attribute.set.view')}}" class="form-control btn reset-btn noMob-leftmargin">Reset </a>
                        </div>
                    </form>
                </div>
                <div class="box-header col-md-3 col-sm-12 col-xs-12">
                    <a href="{!! route('admin.attribute.set.add') !!}" class="btn btn-default pull-right col-md-12 mobAddnewflagBTN" type="button">Add New Variant Set</a>
                </div> 
                <div class="clearfix"></div>
                <div class="dividerhr"></div>
           

                <div class="box-body table-responsive no-padding">
                    <table class="table table-striped table-hover tableVaglignMiddle">
                        <thead>
                            <tr>
                <!--                <th>id</th>-->

                                <th>Variant Set Name</th>
                                <th>Date</th>
                                <th> Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                             @if(count($attrSets) > 0)
                            @foreach($attrSets as $attrSet)
                            <tr> 
                <!--                <td>{{$attrSet->id }}</td>-->
                                <td>{{$attrSet->attr_set }}</td>

                                <td>{{ date("d M ,y",strtotime($attrSet->created_at)) }}</td>
                                 <td>
                                    <?php if ($attrSet->status == 1) { ?>
                                     <a href="{!! route('admin.attribute.set.changeStatus',['id'=>$attrSet->id]) !!}" class="" ui-toggle-class="" onclick="return confirm('Are you sure you want to disable this variant set?')" data-toggle="tooltip" title='Enabled'><i class="fa fa-check"></i></a><br>
                                    <?php } elseif ($attrSet->status == 0) { ?>
                                     <a href="{!! route('admin.attribute.set.changeStatus',['id'=>$attrSet->id]) !!}" class="" ui-toggle-class="" onclick="return confirm('Are you sure you want to enable this variant set?')" data-toggle="tooltip" title='Disabled'><i class="fa fa-times"></i></a><br>
                                    <?php } ?>
                                </td>
                                <td>
                                    <a href="{!! route('admin.attribute.set.edit',['id'=>$attrSet->id]) !!}" class="" ui-toggle-class="" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil-square-o btn-plen btn"></i></a>
                              
                                    <a href="{!! route('admin.attribute.set.delete',['id'=>$attrSet->id]) !!}"  class="" ui-toggle-class=""  onclick="return confirm('Are you sure you want to delete variant set?')" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a>
                                </td>

                            </tr>
                            @endforeach
                            @else
                            <tr><td colspan=6>No Record Found</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">

                    <?php
                   
                    if(empty(Input::get('attr_set_name'))){
                      echo  $attrSets->links();
                      
                     //  dd("fdgdg");
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
            var r = confirm("Are You Sure You want to Delete this Attribute Set?");
            if (r == true) {
                $(this).parent().submit();
            } else {

            }
        });
    });
</script>

@stop