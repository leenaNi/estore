
@extends('Admin.layouts.default')
@section('content')
<section class="content-header">
 <h1>
      
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">By Customers</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header box-tools filter-box col-md-9 noBorder col-sm-12 col-xs-12">
                    <form method="post" action="{{ route('admin.sales.bycustomerchart') }}">
                           <input type="hidden" value="dateSearch" name="dateSearch">
                        <div class="form-group col-md-4 col-sm-6 col-xs-12">
                            <label>From Date</label>
                              <input type="date" name="from_date" value="{{ !empty(Input::get('from_date'))?Input::get('from_date'):'' }}"  class="form-control fromDate " placeholder="From Date" autocomplete="off" id="">
                          
                        </div>
                         <div class="form-group col-md-4 col-sm-6 col-xs-12">
                             <label>To Date</label>
                                     <input type="date" name="to_date" value="{{ !empty(Input::get('to_date'))?Input::get('to_date'):'' }}"  class="form-control toDate col-md-3" placeholder="To Date" autocomplete="off" id="">
                        </div>
                        
                        <div class="form-group col-md-2 col-sm-6 col-xs-12">
                            <br>
                            <br>
                            <input type="submit" name="submit" class="btn btn-primary form-control noMob-leftmargin" value="Search">
                        </div>
                            <div class="form-group col-md-2 col-sm-6 col-xs-12 noMobBottomMargin">
                                <br>
                                <br>
                         <a  href="{{route('admin.sales.bycustomer')}}" class="medium btn btn-block noLeftMargin reset-btn">Reset</a>
                        </div>
                    </form> 
                </div>
                  <!--   <div class="box-header col-md-3 col-sm-12 col-xs-12">
                        <form method="post" id="CusExport" action="{{URL::route('admin.sales.orderByCustomerExport') }}">
                            <input type="hidden" value="dateSearch" name="dateSearch">
                            <input type="hidden" name="from_date" value="{{ !empty(Input::get('from_date'))?Input::get('from_date'):'' }}"  class="form-control fromDate " placeholder="From Date" autocomplete="off" id="">
                            <input type="hidden" name="to_date" value="{{ !empty(Input::get('to_date'))?Input::get('to_date'):'' }}"  class="form-control toDate col-md-3" placeholder="To Date" autocomplete="off" id="">
                            <input type="hidden" value="{{ !empty(Input::get('search')) ? Input::get('search') : '' }}" name="search" aria-controls="editable-sample" class="form-control medium" placeholder="Search Category"/>
                            <input type="button" class="cusExport btn btn-default pull-right col-md-12 mobAddnewflagBTN" value="Export">
                        </form>
                    </div>  -->
                <div class="clearfix"></div>
          
                <div class="dividerhr"></div>
           
            <div class="row">
             <div class="col-sm-12">
              
                <div class="col-sm-6">
                     <center>  <h1>Top Customers</h1>
                <canvas id="mycanvas" width="400" height="400">
                </canvas>  
                </center>      
               </div>
                  <div class="col-sm-6">
                    <center> <h1>Top Products</h1>
                     <canvas id="productCanvas" width="400" height="400"></canvas>  
                     </center>       
                 </div>
                
               </div>
            
                </div>
               
             <div class="clearfix"></div>
              
                <div class="dividerhr" ></div>
           
            <div class="row">
              <div class="col-sm-12">
                 <div class="table-responsive col-sm-6">
                            <table class="table no-margin">
                            
                                <tbody>
                                    @foreach($items as $item)
                                    <tr>
                                        <td>
                                        <div style="width: 20px; height: 20px; background-color: {{$item["color"]}}"></div>
                                    </td>
                                    <td>
                                        {{$item["customer_name"]}}
                                    </td>
                                    <td>
                                       Rs. {{$item["total"]}} 
                                    </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                   
                 <div class="table-responsive col-sm-6">
                    <table class="table no-margin">
                        <tbody>
                                    @foreach($products as $product)
                             
                                    <tr>
                                        <td>
                                        <div style="width: 20px; height: 20px; background-color: {{$product["color"]}}"></div>
                                    </td>
                                    <td>
                                        {{$product["product_name"]->product}}
                                    </td>
                                    <td>
                                        @if($product["product_name"]->selling_price>0)
                                        Rs. {{ number_format((@$product["product_name"]->selling_price* Session::get('currency_val')), 2, '.', '')}} 
                                        @else
                                        Rs. {{ number_format((@$product["product_name"]->price* Session::get('currency_val')), 2, '.', '')}} 
                                        @endif
                                    </td>
                                    <td class="pull-left">
                                        {{$product["quantity"]}}
                                    </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                </div>
            </div>
         </div>
  
       
 
</section>


@stop

@section('myscripts')
  <script>
    $(document).ready(function(){
       var ctx1 = $("#mycanvas").get(0).getContext("2d");
         var dataCustomers = [
            <?php 
                 foreach($items as $item)
                    {
                        ?>
                        {
                        value: {{$item['total']}},
                        color: "{{$item['color']}}",
                      
                        label: "{{$item['customer_name']}}",
                    },
                        <?php 
                      }
                    ?>
                   
                ];  
                var piechartCustomers = new Chart(ctx1).Pie(dataCustomers);
                var ctx2 = $("#productCanvas").get(0).getContext("2d");
                var dataProducts = [
                <?php 
                 foreach($products as $product)
                    {
                        ?>
                        {
                        value: {{$product['quantity']}},
                        color: "{{$product['color']}}",
                      
                        label: "{{$product["product_name"]->product}}",
                    },  
                        <?php 
                      }
                    ?> 
                ];
                var piechartProducts = new Chart(ctx2).Pie(dataProducts);
            });
        </script>
@stop