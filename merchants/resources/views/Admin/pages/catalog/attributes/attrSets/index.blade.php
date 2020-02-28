@extends('Admin.layouts.default')
@section('content')


<section class="content-header">
    <h1>
        Variant Sets 
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Catalog </a></li>
        <li class="active">  Variant Sets</li>
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
            <h1><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'settings-2.svg'}}"> Filters</h1>
        </div>
        <div class="filter-section">
            <div class="col-md-12 noAll-padding">
                <div class="filter-left-section">                    
                    <form method="get" action=" " id="searchForm">
                        <input type="hidden" name="attrSetCatalog">
                        <div class="form-group noBottomMargin col-md-8 col-sm-6 col-xs-12">
                            <div class="input-group">
                            <span class="input-group-addon  lh-bordr-radius"><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'search.svg'}}"></span> 
                            <input type="text" value="{{ !empty(Input::get('attr_set_name'))?Input::get('attr_set_name'):'' }}" name="attr_set_name" aria-controls="editable-sample" class="form-control form-control-right-border-radius medium" placeholder="Variant Set Name">
                            </div>
                        </div>
                       <div class="form-group col-md-4 noBottomMargin">
                            <a href="{{ route('admin.attribute.set.view')}}" class="btn reset-btn noMob-leftmargin pull-right">Reset </a> 
                            <button type="submit" name="submit" vlaue="Filter" class='btn btn-primary noAll-margin pull-right marginRight-lg'>Filter</button> 
                        </div>
                    </form>
                </div>
            </div> 
        </div>
    </div>
    <div class="grid-content">
        <div class="section-main-heading">
            <h1><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'receipt-2.svg'}}">  Variant Sets <span class="listing-counter">{{$attrCount }}</span></h1>

            <a href="{!! route('admin.attribute.set.add') !!}" class="btn btn-listing-heading pull-right noAll-margin"><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'plus.svg'}}"> Create</a>
        </div>
        <div class="listing-section">
            <table class="table table-striped table-hover tableVaglignMiddle">
                <thead>
                    <tr>
                        <!--                <th>id</th>-->
                        <th class="text-left">Variant Set Name</th>
                        <th class="text-right">Date</th>
                        <th class="text-center"> Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                                        @if(count($attrSets) > 0)
                                        @foreach($attrSets as $attrSet)
                                        
                    <tr>
                        <!--                <td>{{$attrSet->id }}</td>-->
                        <td class="text-left">{{$attrSet->attr_set }}</td>
                        <td class="text-right">{{ date("d M ,y",strtotime($attrSet->created_at)) }}</td>
                        <td class="text-center">
                            <?php if ($attrSet->status == 1) { ?>
                            <a href="{!! route('admin.attribute.set.changeStatus',['id'=>$attrSet->id]) !!}" class="" ui-toggle-class="" onclick="return confirm('Are you sure you want to disable this variant set?')" data-toggle="tooltip" title='Enabled'>
                                <i class="fa fa-check"></i>
                            </a>
                            <br>
                                <?php } elseif ($attrSet->status == 0) { ?>
                                <a href="{!! route('admin.attribute.set.changeStatus',['id'=>$attrSet->id]) !!}" class="" ui-toggle-class="" onclick="return confirm('Are you sure you want to enable this variant set?')" data-toggle="tooltip" title='Disabled'>
                                    <i class="fa fa-times"></i>
                                </a>
                                <br>
                                    <?php } ?>
                                </td>
                                <td  class="text-center">

                                <div class="actionCenter">
                                    <span><a class="btn-action-default" href="{!! route('admin.attribute.set.edit',['id'=>$attrSet->id]) !!}"><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'pencil.svg'}}"></a></span> 
                                    <span class="dropdown">
                                        <button class="btn-actions dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <img src="{{ Config('constants.adminImgangePath') }}/icons/{{'more.svg'}}">
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton"> 
                                            <li><a href="{!! route('admin.attribute.set.delete',['id'=>$attrSet->id]) !!}"><i class="fa fa-trash "></i> Delete</a></li>
                                        </ul>
                                    </span>  
                                </div> 
                                </td>
                            </tr>
                                        @endforeach
                                        @else
                                        
                            <tr>
                                <td colspan=6 class="text-center">No Record Found</td>
                            </tr>
                                        @endif
                                    
                        </tbody>
                    </table>

                    <div class="clearfix">
                    <?php                   
                    if(empty(Input::get('attr_set_name'))){
                      echo  $attrSets->links();                      
                     //  dd("fdgdg");
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
            var r = confirm("Are You Sure You want to Delete this Attribute Set?");
            if (r == true) {
                $(this).parent().submit();
            } else {

            }
        });
    });
</script>

@stop