@extends('Admin.layouts.default')
@section('content')

<section class="content-header">
    <h1>
        Routes
        <!--        <small>Add/Edit/Delete</small>-->
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Rotes</li>
    </ol>
</section>

<section class="content">
    <div class="row">


        <div class="col-md-12">
            <div class="box">
                
                <div class="box-header box-tools filter-box col-md-9 noBorder">


          </div>
          
        <div class="clearfix"></div>
        <div class="box-body table-responsive no-padding">
            <table class="table table-striped table-hover tableVaglignMiddle">
                <thead>
                    <tr>
                        <th>URL Name</th>
                        <th>Route Name</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach ($routes as $route)
                  <tr>
                    <td>{{ $route->getPath() }}</td>
                    <td>{{ $route->getName() }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div><!-- /.box-body -->
        <div class="box-footer clearfix">
            <?php 
         //    if (empty(Input::get('search'))) {
         //     echo $taxInfo->render();
         // }
          ?> 

     </div>
 </div>
</div>
</div>
</section>

@stop 

