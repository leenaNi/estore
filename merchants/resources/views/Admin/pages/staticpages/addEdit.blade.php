@extends('Admin.layouts.default')
@section('content')

<section class="content-header">
    <h1>
        Online Pages
        <small>Add/Edit</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active"> Online Pages </li>
        <li class="active">Add/Edit</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div>
            <p style="color: red;text-align: center;">{{ Session::get('messege') }}</p>
        </div>

        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    {!! Form::model($page, ['method' => 'post', 'files'=> true, 'url' => $action ]) !!}

                        <div class="clearfix"></div>
                   
                    <div class="form-group{{ $errors->has('page_name') ? ' has-error' : '' }}">
                        <div class="col-md-2 text-right"> 
                        {!! Form::label('page_name', 'Page Name ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                        </div> 
                        <div class="col-md-10"> 
                        {!! Form::hidden('id',null) !!}
                            {!! Form::text('page_name',null, ["class"=>'form-control validate[required]',"id"=>'page_name' ,"placeholder"=>'Enter Page Name']) !!}
                            <span id='error_msg'></span>
                            @if ($errors->has('page_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('page_name') }}</strong>
                                </span>
                            @endif
                            
                        </div>
                        <div class="clearfix"></div>
                        </div>
                    
                   {!! Form::hidden('url_key',null, ["id"=>'url_key']) !!}
                          
                  
                    @if($page->url_key=='about-us')
                    <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                    <div class="col-md-2 text-right">
                        {!!Form::label('image','Image ',['class'=>'control-label ']) !!}<span class="red-astrik"> *</span>
</div>
<div class="col-md-8">
                            <input type="file" name="image" id="image" onchange="readURL(this);" />

                            @if ($errors->has('image'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('image') }}</strong>
                                </span>
                            @endif
</div>

<div class="col-md-10 col-md-offset-2">
                            <img id="select_image" src="#" alt="Selected Image" style="display: none;" />
</div>
             @if($page->image)
                        <div class="form-group col-md-2 pull-right">
                                                <div class='col-md-12'>
                                                    <button class="deleteImages btn btn denger" catImgId="{{$page->id}}"  >Delete</button>     
                                                </div>
                                                    
                                            </div>  
             @endif
                        
                        </div>
                     
                    @endif
              

                  
                 <div class="clearfix"></div>
              
                @if($page->url_key != 'contact-us')
                    <div class="form-group">
                        <div class="col-md-2 text-right"> 
                         {!! Form::label('description', 'Short Description',['class'=>'']) !!}
                          </div> 
                         <div class="col-md-10">   
                       
                      <textarea class="form-control" id="des111" name="description" ><?= $page->description ?></textarea>
                      </div>
      
                   @endif   

                        </div>
                 <br/>
          
           <div class="clearfix"></div>
                    <div class="form-group">
                        <div class="col-md-2 text-right">
                        {!!Form::label('sort_order','Sort order ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                        </div> 
                        <div class="col-md-10">   
                        {!! Form::text('sort_order',null, ["class"=>'form-control validate[required]',"id"=>'sort_order' ,"placeholder"=>'sort order']) !!}

                          
                        </div>
                         <div class="clearfix"></div>
                    </div>
                    
                

                    <div class="form-group">
                        <div class="col-md-2 text-right">
                        {!!Form::label('is_menu','Show in Menu ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                        </div> 
                        <div class="col-md-10">
                        {!! Form::select('is_menu',["0"=>"No","1"=>"Yes"],null, ["class"=>'form-control validate[required]',"placeholder"=>'Is Manu']) !!}
                        </div>
                         <div class="clearfix"></div>
                          
                        </div>
                    <?php  
                    $contacts =json_decode($page->contact_details); 
                    if($contacts) { ?>
                    @foreach($contacts as $key=>$value)
                    
                          <?php  
                          if($key=='state' || $key=='country'){ 
                          if($key=='state'){
                              $value1=$state;
                          }else if($key=='country'){
                              $value1=$coutries;
                          }?>
                              <div class="form-group">
                        <div class="col-md-2 text-right">
                         {!! Form::label($key, ucfirst(str_replace('_',' ',$key)),['class'=>'']) !!}
                          </div> 
                        <div class="col-md-10">
                       {!! Form::select("details[$key]",$value1,$value,["class"=>"form-control pull-left $key "]) !!}
                                   
                     
                        </div>
                             <div class="clearfix"></div>
                    </div>
                            
                      <?php    }else { ?>
                            
                        <div class="form-group">
                        <div class="col-md-2 text-right">
                         {!! Form::label($key, ucfirst(str_replace('_',' ',$key)),['class'=>'']) !!}
                          </div> 
                        <div class="col-md-10">
                       {!! Form::text("details[$key]",$value ,["class"=>'form-control pull-left $key']) !!}
                                   
                     
                        </div>
                             <div class="clearfix"></div>
                    </div>
                      <?php } ?>
                    @endforeach
                    <?php } ?>
                    <div class="form-group">
                        <div class="col-md-2 text-right">
                        {!!Form::label('status','Status ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                          </div> 
                        <div class="col-md-10"> 
                        {!! Form::select('status',["0"=>"Disabled","1"=>"Enabled"],null, ["class"=>'form-control validate[required]', "id"=>'status' ,"placeholder"=>'Status']) !!}

                          
                        </div>
                         <div class="clearfix"></div>
                    </div>
                

                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="pull-right">
                                {!! Form::submit('Submit',["class" => "btn btn-primary noLeftMargin"]) !!}
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section> 
@stop 

@section('myscripts')
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
<script src="https://cdn.ckeditor.com/4.10.0/standard/ckeditor.js"></script>-->
      <script>
                             
                             editor = CKEDITOR.replace( 'des111' );</script>

<script>
//CKEDITOR.replace( 'description' );

 
  
//CKEDITOR.replace(jQuery('.description'));
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#select_image')
                    .attr('src', e.target.result)
                    .width(150)
                    .height(200);
            };

            reader.readAsDataURL(input.files[0]);
            $("#select_image").show();
        }
    }

    @php
        if($page->image){
            @endphp
            $('#select_image')
                    .attr('src',"{{Config('constants.adminStaticPageImgPath').'/'.$page->image }}")
                    .width(150)
                    .height(200);
            $("#select_image").show();
            @php
        }
    @endphp
</script>
<script>
   $('.country').change(function(){
    var id = $('.country').val();
    $.ajax({
    type: "POST",
            url: "{{ route('admin.contact.getState') }}",
            data: {country_id: id},
            cache: false,
            success: function (response) {
            console.log('@@@@' + response);
            var option = '';
            if (response) {
            $.each(response, function(key, value){
            option += "<option value=" + key + ">" + value + "</option>";
            })
                    $('.state').html(option);
            //  alert(option);
            }

            }, error: function (e) {
    console.log(e.responseText);
    }
    });
    });  
    
     $("body").delegate('.deleteImages', 'click', function (e) {
            var ele = $(this);
            $('#select_image').attr("src",'');
            var imagId = ele.attr("catImgId");
             $.ajax({
            type: "POST",
            url: "{{ route('admin.staticpages.imgdelete') }}",
            data: {imgId: imagId},
            cache: false,
            success: function (response) {
               
                if (response['status'] == 'success') {
                   
                  location.reload();
                } else{
                    
                }
                  
            }, error: function (e) {
                console.log(e.responseText);
            }
        });
          
    });
</script>


@stop