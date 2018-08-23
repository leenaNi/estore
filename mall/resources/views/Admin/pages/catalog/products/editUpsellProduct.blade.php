
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

                      <form method="POST" action="{{route('admin.products.upsell.attach') }}" id="searchForm">

                        <input type="hidden" name="id" value="{{$prod->id}}">
                        <input type="hidden" name="productsRel">

                          <input type="hidden" name="id" value="{{$prod->id}}">
                          <input type="hidden" name="productsRel">

                          <div class="ui-widget form-group col-md-4 ">
                           <!-- <label for="related_prod">Related Product: </label> -->
                           <input id="related_prod" placeholder="You may also like" class="form-control" name="related_prod" >
                         </div>

                         <div class="col-md-4 hidden" id="prod_list">
                         <div id="prod_log" style="overflow: auto;" class="ui-widget-content"></div>
                         </div>

                         <div class="form-group col-md-2">
                          <input type="submit" name="search" class="btn sbtn btn-block" value="Add">

                        </div>

                      </form>

                    </div>
 <div class="table-responsive">
<!--                        {!! Form::model($prod,['method' => 'post','id'=>'RelUpProd' ,'files' =>true , 'url' => $action , 'class' => 'bucket-form' ]) !!}-->

                       
                        <!-- {!! Form::label('upsell_prods', 'UpSell Products') !!} -->
                        <table class="table relatedProds table-striped b-t b-light">
                            <thead>
                                <tr>
                               
                                    <th>Product</th>
                                    <th>Product Code</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                             
                                @foreach($relatedProd as $prod)
                                  @foreach($prod->upsellproducts as $prd )
 
                                <tr>
                               
                                    <td>{!! $prd->product !!}</td>
                                    <td>{!! $prd->product_code !!}</td>
                                    <td><a class="deleteUpsell"  id="{{$prd->id}}"  data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a></td>
                                   
                                  
                                @endforeach
                    @endforeach
                            </tbody>
                        </table>
                        
                        
                        </div>


  {!! Form::model($prod,['method' => 'post','id'=>'RelUpProd' ,'files' =>true , 'url' => $action , 'class' => 'bucket-form' ]) !!}

                    {!! Form::hidden('prod_id',$prod->id) !!}

                    {!! Form::hidden('return_url',null,['class'=>'rtUrl']) !!}
                    <div class="form-group">
                        {!! Form::button('Save & Exit',["class" => "btn btn-primary pull-right saveRelUpExit"]) !!}
                        {!! Form::button('Save & Continue',["class" => "btn btn-primary pull-right saveRelUpContine"]) !!}
                        {!! Form::button(' Next',["class" => "btn btn-primary pull-right saveRelNext $storeViesion"]) !!}
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
           source: "{{route('admin.products.upsell.related.search',['id'=>$prod->id])}}",  
           
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

            $(".rtUrl").val("{!! route('admin.products.view')!!}");
            $("#RelUpProd").submit();

        });

        $(".saveRelUpContine").click(function() {
            $(".rtUrl").val("{!! route('admin.products.upsell.product',['id'=>$prod->id])!!}");
            $("#RelUpProd").submit();

        });


   $(".saveRelNext").click(function() {
       var sco="{{$feature['sco']}}";       
       var storeversion = "{{ $store_version_id }}";
       //console.log(sco);
       $(".rtUrl").val("{!! route('admin.products.prodSeo',['id'=>$prod->id])!!}");
       // if(sco==1 && storeversion==1){
       //    $(".rtUrl").val("{!! route('admin.products.prodSeo',['id'=>$prod->id])!!}");  
       // }else{
       //   (".rtUrl").val("{!! route('admin.products.view')!!}");  
       // }
           
      $("#RelUpProd").submit();

        });

$('.deleteUpsell').click(function(){
   sync("{{ $prod->id }}", $(this).attr("id"), "{{ URL::route('admin.products.upsell.detach') }}",$(this)); 
})

//        $(".upsellProds input[type='checkbox']").click(function() {
//         
//                sync("{{ $prod->id }}", $(this).val(), "{{ URL::route('admin.products.upsell.detach') }}");
// 
//        });

  
  $(document).ready(function(){
	$("#search-prod").keyup(function(){
            var productValue=$(this).val();
            type="upsell";
                if(productValue !=' '){
		$.ajax({
		type: "POST",
		url: "{{route('admin.products.upsell.related.search',['id'=>$prod->id])}}",
		data:{ product:productValue},
		success: function(data){
                   if(data.length >0){
                    var option='<select name="prod_id[]" multiple="true" class="form-control">'
                $.each(data,function(key,value){
                 option+='<option value='+value.id+' >'+value.product+'</option>';   
                });
                
                //console.log(option);
                option+='</select>';
                   // alert(JSON.stringify(data));
                   
                     $("#suggesstion-box").empty();
			//$("#suggesstion-box").show();
			$("#suggesstion-box").append(option);
			
		}  
                }
		});
               }
	});
});

 function delelteUpsell(prod,Upsell_id){
 
        $.ajax({
            type: "POST",
            url: "{!! route('admin.products.upsell.detach') !!}",
            data: {id:prod,prod_id:Upsell_id},
            success: function(msg){
                 // window.location.href = "{{ route('admin.products.view')}}"
//                var data = msg;
//                var div = document.getElementById('desc_detail');
//                div.innerHTML = data.description;
//                $("#trigger_model").click();
            }
        });
    }

    function sync(id, prod_id, action,thisd) {
     
        $.ajax({
            url: action,
            type: "POST",
            data: {id: id, prod_id: prod_id},
            success: function(data) {
                 thisd.parent().parent().remove();  
              window.location.reload(true);  
            }
        });
    }

</script>
@stop