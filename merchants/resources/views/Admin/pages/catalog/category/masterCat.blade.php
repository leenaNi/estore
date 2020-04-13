@extends('Admin.layouts.default')
@section('content')
<style>
.bxmodal{margin: 10px 0; border: 1px #eee solid; float: left; width: 100%; padding: 15px;}
.tree li{margin: 10px 0px;}
</style>
<section class="content-header">
    <h1>
    Manage Categories
        <!-- <small>Add/Edit</small> -->
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class=""><a href="{{route('admin.category.view')}} " >Manage Categories </a></li>
        <li class="active">Add/Edit</li>
    </ol>
</section>
<section class='content'>
<div class="notification-column">
    @if(!empty(Session::get('message')))
    <div  class="alert alert-danger" role="alert">
        {{ Session::get('message') }}
    </div>
    @endif
    @if(!empty(Session::get('msg')))
    <div  class="alert alert-success" role="alert">
        {{ Session::get('msg') }}
    </div>
    @endif
    </div>
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs" role="tablist">
            <li class="{{ in_array(Route::currentRouteName(),['admin.category.view']) ? 'active' : '' }}"><a href="{!! route('admin.category.view',['parent_id'=>Input::get('parent_id')]) !!}"  aria-expanded="false">Store Category</a></li>
           
            <li class="{{ in_array(Route::currentRouteName(),['admin.category.viewMasterCat']) ? 'active' : '' }}"><a href="{!! route('admin.category.viewMasterCat') !!}"      aria-expanded="false">Master Category</a></li>
            
        </ul>

        <div class="tab-content">
            <div class="tab-pan-active" id="activity">
                <div>
                    <p style="color: red;text-align: center;">{{ Session::get('messege') }} </p>
                </div>
                <div class="panel-body">
                <div class="section-main-heading">
            <h1><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'receipt-2.svg'}}"> All Categories</h1>
        </div>
      <div class="listing-section">
      <div class="box-body no-padding">
                    <table class="table table-striped table-hover">
                        <?php
                        echo "<ul  id='catTree' class='tree icheck catTrEE'>";
                        foreach ($roots as $root)
                            renderNode($root);
                        echo "</ul>";

                        function renderNode($node) {
                            echo "<li class='tree-item fl_left ps_relative_li" . ($node->status == '0' ? 'text-muted' : '') . "'>";
                            if($node->adminChildren()->count() > 0){
                            echo '<b>' . $node->category . '</b><a href="' . route("admin.category.addmastercat", ["cat_id" => $node->id]) . '" style="color:green;" data-toggle="tooltip" title="Add New"><i class="fa fa-plus fa-fw"></i></a>';
                            } else {
                            echo '' . $node->category . '<a href="' . route("admin.category.addmastercat", ["cat_id" => $node->id]) . '" style="color:green;" data-toggle="tooltip" title="Add New"><i class="fa fa-plus fa-fw"></i></a>';
                            }
                           ?>
                           
                            <?php   
                                if ($node->adminChildren()->count() > 0) {
                                        echo "<ul class='treemap fl_left'>";
                                        foreach ($node->adminChildren as $child)
                                            renderNode($child);
                                        // echo $child;
                                        echo "</ul>";
                                    }
                                    echo "</li>";
                                }
                            ?> 

                    </table>
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">

                </div>
            </div><!-- /.box -->
                </div>
            </div>
        </div>
    </div>
</section>
<?php $public_path = Config('constant.sizeChartImgPath');?>
@stop
@section('myscripts')

@stop