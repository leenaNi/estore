
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

                    <form method="POST" action="{{route('admin.product.vendors.save') }}" id="searchForm">

                       <input type="hidden" name="id" value="{{$prod->id}}">
                        
                          <input type="hidden" name="returnUrl" class="rtnUrl">
                          <div class="ui-widget form-group col-md-4 ">
                          
                           <input id="related_prod" placeholder="Vendor Name" class="form-control" name="related_prod" >
                         </div>
                         <div class="clearfix"></div>
                         <div style="display:none" id="vendor_list">
                         
                         </div>
                         <div class="col-md-4 hidden" id="prod_list">
                         <div id="prod_log" style="overflow: auto;" class="ui-widget-content">
                           
                         </div>
                         </div>
                         <div class="clearfix"></div>
                   

                      </form>

                    </div>
                    <div class="table-responsive">
                       <table class="table relatedProds table-striped b-t b-light">
                            <thead>
                                <tr>
                               
                                    <th>Vendor</th>
                                    <th>Priority</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                              @if(!$vendors->isEmpty())
                                @foreach($vendors as $vendor)
                                <tr>
                                    <td>{!! @$vendor->vendor->firstname !!} {!! @$vendor->vendor->lastname !!}</td>
                                    <td>{!! $vendor->sort !!}</td>
                                    
                                    <td>
                                   
                                    <a class="deleteVendor"  id="{!! $vendor->vendor_id !!}"  data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a></td>
                                    </tr>       
                                @endforeach
                              @endif

                             
                            </tbody>
                        </table>
                        
                        
                        </div>

                    <div class="form-group">
                    <button href="{{route('admin.products.view') }}" class="btn btn-primary pull-right ext">Save & Exit</button>
                    <button href="" class="btn btn-primary pull-right save-cnt">Save & Continue</button>
                    <button class="btn btn-primary pull-right nxt">Save & Next</button>
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
$( function() {
    var prod_id=1;
    function log( message ) {
        $( "#prod_list" ).removeClass("hidden");
      $( "<div>" ).html( message ).prependTo( "#prod_log" );
      $( "#prod_log" ).scrollTop( 0 );
    }
    $("#related_prod").autocomplete({
      source: "{{route('admin.product.vendors.search',['id' => $prod->id ])}}",  
      minLength: 2,
      select: function( event, ui ) {
        $("#vendor_list").show();
       var input_tag = '<div><div class="col-md-4">'+
          '<input placeholder="Vendor Name" class="form-control col-md-2" name="vendor" value="'+ui.item.firstname+'" readOnly="true" >'+
          '<input id="vendor_id" name="vendor_id[]" type="hidden" value="'+ui.item.id+'" ></div><div class="col-md-2"><input id="sort_id" type="number" placeholder="Priority" class="form-control col-md-2 validate[required] " name="sort['+ui.item.id+']" ></div>'+'<a href="#" class="remove-rag"><i class="fa fa-trash"></i></a></div><br>'
      $("#vendor_list").append(input_tag);
        // log( ui.item.firstname+ "<input type='hidden' name='vendor_id[]' value='" + ui.item.id + "' ><a href='#' class='pull-right remove-rag'  ><i class='fa fa-trash'></i></a><input type='number' name='sort['"+ui.item.id+"']' value='' />" );
      }
    } );
    $( "#related_prod" ).data("ui-autocomplete")._renderItem = function (ul, item) {
      console.log(item);
            return $("<option>")
                    .append( item.firstname+' '+ item.lastname )
                    .appendTo(ul);
        };
       //  ;
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
  
      $(".nxt").click(function() {
          var like_product = "{{ $feature['like-product'] }}";
         var sco = "{{ $feature['sco'] }}";
         var storeversion = "{{ $store_version_id }}";
         var related_prod = "{{ $feature['related-products']}}";
         if(related_prod ==1){
          $(".rtnUrl").val("{!! route('admin.products.upsell.related',['id' => $prod->id]) !!}");
      }else if(like_product==1){
                $(".rtUrl").val("{!! route('admin.products.upsell.product',['id'=>$prod->id])!!}");  
               
            }else if(sco==1 && storeversion==2){
               $(".rtUrl").val("{!! route('admin.products.prodSeo',['id'=>$prod->id])!!}");   
            }else{
                 $(".rtUrl").val("{!!route('admin.products.view')!!}");
            }
             $("#searchForm").submit();
        });
        $(".save-cnt").click(function(){
          $(".rtnUrl").val("{!!route('admin.product.vendors',['id' => $prod->id]) !!}");
          $("#searchForm").submit();
        })

        $(".ext").click(function() {
            $(".rtnUrl").val("{!! route('admin.products.view') !!}");
            $("#searchForm").submit();
        });

      $('.deleteVendor').click(function(){
        var cnf = confirm('Are you sure you want to delete this vendor?')
         var vendor_id = $(this).attr('id');
         if(cnf){
            sync("{{ $prod->id }}", vendor_id, "{{ URL::route('admin.product.vendors.delete') }}",$(this).val()); 
         }
      })


    function sync(id, prod_id, action,thisd) {
     
        $.ajax({
            url: action,
            type: "POST",
            data: {id: id, vendor_id: prod_id},
            success: function(data) {
              window.location.reload(true);  
            }
        });
    }

</script>
@stop