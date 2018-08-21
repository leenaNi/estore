@extends('Admin.layouts.default')
@section('content')
<style>
.circleBase {
    border-radius: 50%;
    behavior: url(PIE.htc); /* remove if you don't care about IE8 */
}
.type2 {
    width: 50px;
    height: 50px;
}
</style>
<section class="content-header">
    <h1>
        Flags
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Flags</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div >
                @if(!empty(Session::get('message')))
                <div class="alert alert-danger" role="alert">
                    {{ Session::get('message') }}
                </div>
                @endif
                @if(!empty(Session::get('msg')))
                <div class="alert alert-success" role="alert">
                    {{ Session::get('msg') }}
                </div>
                @endif
        </div>
        <div class="col-sm-12">
            <div class="panel">
                <div class="panel-body ">
                    <div class="adv-table editable-table ">
                        <div class="clearfix">
                            <div class="btn-group col-md-6 col-sm-12 col-xs-12">
                                <form action="{{ route("admin.miscellaneous.flags") }}" method="get" >
                                     <div class="form-group col-md-6 col-sm-12 col-xs-12 mob-marBottom15">
                                    <input type="text" value="{{ !empty(Input::get('search')) ? Input::get('search') : '' }}" name="search" aria-controls="editable-sample" class="form-control medium" placeholder="Flag Name"/>
                                </div>
                                     <div class="form-group col-md-4 col-sm-12 col-xs-12 mob-marBottom15">
                               <button type="submit" class="btn btn-primary form-control" style="margin-left: 0px;"> Search</button>
                            </div>
                                </form> 
                            </div>
                            <div class="btn-group col-md-6 col-sm-12 col-xs-12">
                                <button id="editable-sample_new" class="btn btn-primary pull-right mobAddnewflagBTN" onclick="window.location.href ='{{ route('admin.miscellaneous.addNewFlag')}}'">
                                    Add New Flag 
                                </button>
                            </div>
                        </div>
                        <div class="space15"></div>
                        <br />
                        <div class="clearfix"></div>
                        <div class="dividerhr"></div>
                        <table class="table rttable table-hover general-table tableVaglignMiddle">
                            <thead>
                                <tr>
<!--                                    <th>Sr No</th>-->
                                    <th>Flag Name</th>
                                    <th>Flag Color</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($flags) >0)
                                @foreach($flags as $flag)

                                <tr>
<!--                                    <td>{{ @$flag->id }}</td>-->
                                    <td>{{ @$flag->flag }}</td>
                                    <td><div class="circleBase" style="width:30px; height: 30px; background: {{ @$flag->value }};"></div></td>
                                    <td>{{ @$flag->desc }}</td>
                                    <td>
                                        <a href="{!! route('admin.miscellaneous.editFlag', ['id' => $flag->id]) !!}" class="edit"  data-toggle="tooltip" title="Edit"><i class="fa fa-pencil-square-o btn btn-plen btnNo-margn-padd"></i></a>
                                        <a href="{!! route('admin.miscellaneous.deleteFlag',['id' => $flag->id]) !!}"  onclick="return confirm('Are you sure you want to delete this flag?')" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                            <tr><td colspan=14> No Record Found.</td></tr>
                         @endif
                            </tbody>
                        </table>
                        <div class="pull-right">
                            <?php
                            $args = [];
                            !empty(Input::get("search")) ? $args["search"] = Input::get("search") : '';
                            !empty(Input::get("sort")) ? $args["sort"] = Input::get("sort") : '';
                            !empty(Input::get("order")) ? $args["order"] = Input::get("order") : '';
                            ?>
                            <?= $flags->appends($args)->render() ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@stop

@section('myscripts')
<script>
    $(document).ready(function () {
        $(".delete").click(function () {
            var r = confirm("Are You Sure You want to Delete this record?");
            if (r == true) {
                $(this).parent().submit();
            } else {

            }
        });
    });
</script>

@stop