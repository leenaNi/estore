@extends('Admin.layouts.default')
@section('content') 
<section class="content-header">   
    <h1>
        SMS<!--  Subscription -->
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">SMS <!-- Subscription --></li>
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
                <div class="box-header box-tools filter-box col-md-9 noBorder">
                  
<!--                        <form action="{{route('admin.smsSubscription.view') }}" method="get" >
                            <input type="hidden" name="dataSearch" value="dataSearch"/>
                              <div class="form-group col-md-3">
                                <input type="text" name="SM"  class="form-control  " placeholder="Search pincode">
                            </div>
                              
                             
                               <div class="form-group col-sm-2">
                                <input type="submit" name="submit" vlaue='Submit' class='form-control btn btn-primary'>
                            </div>
                            <div class="from-group col-sm-2">
                                <a href="{{route('admin.smsSubscription.view') }}" class="form-control btn btn-default">Reset </a>
                            </div>
                        </form>-->
                    </div>   

                    
                    <div class="box-header col-md-3">
                       <a href="{{route('admin.smsSubscription.addEdit') }}" class="btn btn-default pull-right col-md-12" type="button">Purchase SMS</a>
                   </div> 
                   <div class="clearfix"></div>
                   <div class="dividerhr"></div>
                   <div class="form-group col-md-4 ">
                    <div class="button-filter-search pl0">
                      SMS Balance: 558
                  </div>
              </div> 
              <div class="clearfix"></div>
              
              <div class="box-body table-responsive no-padding">
                <table class="table  table-hover general-table tableVaglignMiddle">
                    <thead>
                        <tr>
                            <!--                                <th>Sr No</th>-->
                            <th>Purchase Date</th>
                            <th>No of Sms</th>
                            <th>Purchased by</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($smsSubscription) >0)
                        @foreach($smsSubscription as $sms)

                        <tr>
                            <!--                                <td>{{ $sms->id }}</td>-->
                            <td>{{date("d M Y",strtotime($sms->created_at)) }}</td>
                            <td>{{ $sms->no_of_sms }}</td>
                            <td>{{ $sms->users->firstname }} {{ $sms->users->lastname }}</td>
                            <td>{{ $sms->status==1? 'Successful':'Failed'}}</td>
                            
                        </tr>
                        @endforeach
                        @else
                        <tr><td colspan="4">No Records Found</td></tr>
                        @endif
                        
                    </tbody>
                </table>
            </div><!-- /.box-body -->
            
            <div class="box-footer clearfix">
                
               {{$smsSubscription->links() }}
           </div>
       </div>
   </div>
</div>
</section>

@stop

@section('myscripts')
<script>
 
</script>

@stop
