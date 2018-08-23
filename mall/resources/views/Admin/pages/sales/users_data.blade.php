@extends('theSoul.layouts.default')
@section('content')

<div class="row">
    <div class="col-sm-12">
        <section class="panel">
            <header class="panel-heading">
               Customers
                <span class="tools pull-right">
                    <a href="javascript:;" class="fa fa-chevron-down"></a>
                    <a href="javascript:;" class="fa fa-cog"></a>
                    <a href="javascript:;" class="fa fa-times"></a>
                </span>
            </header>

            <div class="panel-body">
                <div class="adv-table editable-table ">
                    <div class="clearfix">
                        <div class="btn-group pull-left col-md-12">

                        </div>


                    </div>
                    <div class="space15"></div>
                    <br />
                    <table class="table  prodSalesTable  table-hover general-table">
                        <thead>
                            <tr>

                                <th>Year</th>
                                <th>Total New Customers Acquired </th>
                                <th>Customers who have ordered atleast once</th>
                                <th>Customers who have ordered more than once till date</th>
                                <th>Customers who have ordered more than twice till date</th>
                                <th>% customers who have transacted more than once</th>
                                <th>% customers who have transacted more than twice</th>


                            </tr>
                        </thead>
                        <tbody>



                          
                            @foreach($customers as $cust)
                            <tr>

                                <td>{{ $cust->year }}</td>
                                <td>{{ $cust->users }}</td>

                                <?php
                                $orders1 = DB::table("orders")
                                        ->where("order_status", "!=", 0)
                                        ->select("user_id", DB::raw('YEAR(created_at)'), DB::raw('count(id) as orderCount'))
                                        ->groupBy("user_id")
                                        ->where(DB::raw('YEAR(created_at)'), "=", $cust->year)
                                        ->get();
                                $arr1 = [];
                                $arr2 = [];
                                $arrMoreThan2 = [];


                                foreach ($orders1 as $ord) {



                                    if ($ord->orderCount == 1) {

                                        array_push($arr1, $ord->orderCount);
                                    }
                                    if ($ord->orderCount > 1 ) {
                                        array_push($arr2, $ord->user_id);
                                    }

                                    if ($ord->orderCount > 2) {
                                        array_push($arrMoreThan2, $ord->user_id);
                                    }
                                }
                                ?>


                                <td>{{ count($arr1) }}</td>         

                                <td>{{ count($arr2) }}</td>     

                                <td>{{ count($arrMoreThan2) }}</td>  

                                 <td>{{  round((count($arr2)/$cust->users)*100)   }}</td>  
                                  <td>{{ round((count($arrMoreThan2)/$cust->users) * 100)}}</td>  
                                

                            </tr>


                            @endforeach
                            
                        </tbody>
                    </table>


                </div>

            </div>
    </div>
</section>
</div>
</div>

@stop

