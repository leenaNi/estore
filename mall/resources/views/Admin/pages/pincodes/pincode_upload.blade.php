@extends('Admin.layouts.default')
@section('content')

<section class="content-header">   
    <h1>
        Pincodes
        <small>Add/Edit/Delete </small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Pincodes</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">


            <div class="panel-body">
                <p style="color:green;text-align: center">{{ Session::get("msg") }}</p>

                <div class="col-md-12 form-group">

                    <form  class='bucket-form'  action="{{URL::route('admin.pincodes.upload')}}" method="post" enctype="multipart/form-data">

                        <div class="col-md-4 form-group">
                            Select CSV to upload: 
                            <input class="form-group" readonly="true" class="form-control" type="file" name="file" id="fileToUpload">

                        </div>

                        <div class="col-md-4 form-group">
                            <input type="submit" value="Upload Pincodes"  class="btn btn-primary" name="submit">
                        </div>

                    </form>

                    <div class="col-md-2 form-group pull-right">
                        <form  class='bucket-form'  action="{{URL::route('admin.pincodes.samplecsv')}}" method="post">

                            <input type="submit" value="Sample CSV"  class="btn btn-info" name="submit">

                        </form>
                    </div>

                </div>

            </div>
            </div>
        </div>
    </div>
</section>
  

@stop

@section('myscripts')
<script type="text/javascript">

</script> 

@stop