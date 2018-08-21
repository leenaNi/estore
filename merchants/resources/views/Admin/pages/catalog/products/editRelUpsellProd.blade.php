@extends('Admin.layouts.default')
@section('content')

<section class="content-header">
    <h1>
        Products

    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Products</li>
        <li class="active">Add/Edit</li>
    </ol>
</section>

<section class="content">
    <div class="nav-tabs-custom"> 
        {!! view('Admin.includes.productHeader',['id' => $prod->id, 'prod_type' => $prod->prod_type]) !!}
        <div class="tab-content">
            <div class="tab-pan-active" id="activity">
                <div class="panel-body">
                    <div class="search-box-header">
                        <div class="row">
                            <form method="post" action="{{route('admin.products.related.attach') }}"  id="searchForm">
                                <input type="hidden" name="id" value="{{$prod->id}}">

                                <div class="form-group col-md-4 ">
                                    <!-- <label for="related_prod">Related Product: </label> -->
                                    <input id="related_prod" class="form-control" name="related_prod" placeholder="Related Product">
                                </div>

                                <div class="col-md-4 hidden" id="prod_list">
                                 <div id="prod_log" style="overflow: auto;" class="ui-widget-content form-group"></div>
                                </div>

                                <div class="form-group col-md-2">
                                    <input type="submit" name="search" class="btn sbtn btn-block" value="Add">
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive">
                            <!--                        {!! Form::model($prod,['method' => 'post','id'=>'RelUpProd' ,'files' =>true , 'url' => $action , 'class' => 'bucket-form' ]) !!}-->

<!--                        <?php
                        $related_prods = $prod->relatedproducts->toArray();
                        $upsell_prods = $prod->upsellproducts->toArray();
                        ?>
                        {!! Form::label('upsell_prods', 'Related Products') !!}-->
                        <table class="table relatedProds table-striped b-t b-light">
                            <thead>
                                <tr>

                                    <th>Product</th>
                                    <th>Product Code</th>
                                    <th>Delete</th>
                                    <!--                                <th>Product Type</th>-->
                                    <!--                                <th>Categories</th>-->


                                </tr>
                            </thead>
                            <tbody>

                                @foreach($relatedProd as $prod)
                                @foreach($prod->relatedproducts as $prd )

                                <tr>

                                    <td>{!! $prd->product !!}</td>
                                    <td>{!! $prd->product_code !!}</td>
                                    <td> <a class="deleterelated" id="{{$prd->id}}"  data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a></td>
    <!--                                <td>
                                    <?php $prod_type = $prd->producttype->toArray(); ?>
                                        {!! $prod_type['type'] !!}
                                    </td>
                                    <td>
                                        <ul>
                                            @foreach($prd->categories as $cat)
                                            <li>
                                                <a href="{!! route('admin.category.edit',['id'=>$cat->id]) !!}" class="edit"> {!! $cat->category  !!}</a>
    
                                            </li>
                                            @endforeach  
    
                                        </ul>                                
                                    </td>-->


                                </tr>
                                @endforeach
                                @endforeach
                            </tbody>
                        </table>

                    </div>


                    {!! Form::model($prod,['method' => 'post','id'=>'RelUpProd' ,'files' =>true , 'url' => $action , 'class' => 'bucket-form' ]) !!}

                    {!! Form::hidden('prod_id',$prod->id) !!}

                    {!! Form::hidden('return_url',null,['class'=>'rtUrl']) !!}
                    <div class="form-group">
                        {!! Form::button('Exit',["class" => "btn btn-primary pull-right saveRelUpExit"]) !!}
                        {!! Form::button('Save & Continue',["class" => "btn btn-primary pull-right saveRelUpContine"]) !!}
                        {!! Form::button('Next',["class" => "btn btn-primary pull-right saveRelNext"]) !!}
                    </div>


                    {!! Form::close() !!}





                </div>




            </div>

        </div>
    </div>
</div>
</section>

@stop
@section('myscripts')
<script>
    $( function() {
        var prod_id=1;
        function log( message ) {
            $( "#prod_list" ).removeClass("hidden");
            $( "<div>" ).html( message ).prependTo( "#prod_log" );
            $( "#prod_log" ).scrollTop( 0 );
        }
        $( "#related_prod" ).autocomplete({
         source: "{{route('admin.products.related.search',['id'=>$prod->id])}}",  

//      source: function( request, response ) {
//          
//        $.ajax( {
//        type: "POST",
//        url: "{{route('admin.products.upsell.related.search')}}",        
//	data:{ product:request.term,id:prod_id},
//         success: function( data ) {
//              alert((data));   
//         response(data);
//          }
//        } );
//      },
minLength: 2,
select: function( event, ui ) {
    log( ui.item.product+ "<input type='hidden' name='prod_id[]' value='" + ui.item.id + "' ><a href='#' class='pull-right remove-rag'  ><i class='fa fa-trash'></i></a>" );
}
} );
        $( "#related_prod" ).data("ui-autocomplete")._renderItem = function (ul, item) {
            return $("<option>")
            .append( item.product )
            .appendTo(ul);
        };
        ;
    } );
    $('body').on('click', '.remove-rag', function (event) {
        /* Act on the event */
        event.preventDefault();
        jQuery(this).parent().remove();
         var kids = $('#prod_log').children();
         if(kids.length ==0){
            $( "#prod_list" ).addClass("hidden");   
        }    
       
    });
</script>
<script>



    $(".saveRelUpExit").click(function() {
             //   window.location.href = "{{ route('admin.products.view')}}";
             $(".rtUrl").val("{!! route('admin.products.view')!!}");
             $("#RelUpProd").submit();

         });

    $(".saveRelUpContine").click(function() {
        $(".rtUrl").val("{!! route('admin.products.upsell.related',['id'=>$prod->id])!!}");
        $("#RelUpProd").submit();

    });


    $(".saveRelNext").click(function() {
        var like_product = "{{ $feature['like-product'] }}";
           var sco = "{{ $feature['sco'] }}";
            var storeversion = "{{ $store_version_id }}";
           if(like_product ==1){
                $(".rtUrl").val("{!! route('admin.products.upsell.product',['id'=>$prod->id])!!}");
           }else if(sco ==1 && storeversion==2){
           $(".rtUrl").val("{!! route('admin.products.prodSeo',['id'=>$prod->id])!!}");   
            }else{
                 $(".rtUrl").val("{!!route('admin.products.view')!!}");
            }
       
        $("#RelUpProd").submit();

    });


    $(".deleterelated").click(function(e) {
        e.preventDefault;


        sync("{{ $prod->id }}", $(this).attr("id"), "{{ URL::route('admin.products.related.detach') }}",$(this));

    });

////        $(".upsellProds input[type='checkbox']").click(function() {
////            if ($(this).prop("checked")) {
////                sync("{{ $prod->id }}", $(this).val(), "{{ URL::route('admin.products.upsell.attach') }}");
////            } else {
////                sync("{{ $prod->id }}", $(this).val(), "{{ URL::route('admin.products.upsell.detach') }}");
////            }
////        });
//

//  $(document).ready(function(){
//      var prod_id="{{$prod->id}}";
//      type='related';
//	$("#search-prod").keyup(function(){
//            var productValue=$(this).val();
//            
//                if(productValue !=' '){
//		$.ajax({
//		type: "POST",
//		url: "{{route('admin.products.upsell.related.search')}}",
//		data:{ product:productValue,id:prod_id},
//		success: function(data){
//                   if(data.length >0){
//                    var option='<select name="prod_id[]" multiple="true" class="form-control">'
//                $.each(data,function(key,value){
//                 option+='<option value='+value.id+' >'+value.product+'</option>';   
//                });
//                
//                //console.log(option);
//                option+='</select>';
//                   // alert(JSON.stringify(data));
//                   
//                     $("#suggesstion-box").empty();
//			//$("#suggesstion-box").show();
//			$("#suggesstion-box").append(option);
//			
//		}else{
//                    $("#suggesstion-box").empty();  
//                }    
//                }
//		});
//               }
//	});
//});

function sync(id, prod_id, action,thisd) {

    $.ajax({
        url: action,
        type: "POST",
        data: {id: id, prod_id: prod_id},
        success:function(data) {

         //   window.location.replace('admin.products.upsell.related',["id"=>id]');  
       // window.location.reload(true); 
       thisd.parent().parent().remove();  

  }
});
}

</script>
@stop
