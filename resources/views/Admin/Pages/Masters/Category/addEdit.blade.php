@extends('Admin.Layouts.default')

@section('contents')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Add/Edit

    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.masters.category.view') }}"><i class="fa fa-dashboard"></i>Category</a></li>
        <li class="active">Add/Edit</li>
    </ol>
</section>
<section class="content">
    <div class="row">


        <div class="col-xs-12">
            <div class="box pt50">
                {{ Form::model($category, ['route' => ['admin.masters.category.saveUpdate', $category->id], 'class'=>'form-horizontal','id'=>'categoryForm','method'=>'post','files'=>true]) }}
                {{ Form::hidden('id',(Input::get('id')?Input::get('id'):null)) }}
                <div class="box-body">
                    <div class="form-group">
                        {{ Form::label('Category *', 'Category *', ['class' => 'col-sm-3 control-label']) }}
                        
                        <div class="col-sm-6 col-xs-12">
                            {{Form::text('category',  null, ['class'=>'form-control validate[required]']) }}
                        </div>
                    </div>
                   
                    
                    <div class="form-group">
                        {{ Form::label('Status *', 'Status *', ['class' => 'col-sm-3 control-label']) }}
                        <div class="col-sm-6 col-xs-12">
                            {{Form::select('status',[''=>'Please Select','1'=>'Enabled','0'=>'Disabled'],null ,['class'=>'form-control']) }}
                        </div>
                    </div>
                         <div class="form-group">
                        {{ Form::label('Master Categories *', 'Master Categories  *', ['class' => 'col-sm-3 control-label']) }}
                        <span class="lable btn getHelp label-info" data-h='[  "Starters",  "Main Course",  "Desserts",  "Beverages"  "Soft Drinks",  "Pizza",  "Salad",  "Soups",  "Others"]'>Help</span>
                        <div class="col-sm-6 col-xs-12">
                            {{Form::text('categories',   html_entity_decode($category->categories), ['class'=>'form-control']) }}
                        </div>
                    </div>
                    
                       <div class="form-group">
                        {{ Form::label('Attribute Sets *', 'Attribute Sets*', ['class' => 'col-sm-3 control-label']) }}
                                                <span class="lable btn getHelp label-info" data-h='["Default","Weight","Size"]'>Help</span>

                        <div class="col-sm-6 col-xs-12">
                            {{Form::text('attribute_sets',   html_entity_decode($category->attribute_sets), ['class'=>'form-control']) }}
                        </div>
                    </div>
                      <div class="form-group">
                        {{ Form::label('Attributes*', 'Attributes*', ['class' => 'col-sm-3 control-label']) }}
                                                                        <span class="lable btn getHelp label-info" data-h='[  {    "attr": "Weight",    "placeholder": "Select Weight", "attrset_id": 2  },  {    "attr": "Size",    "placeholder": "Select Size", "attrset_id": 3  }]'>Help</span>

                        <div class="col-sm-6 col-xs-12">
                            {{Form::text('attributes',  html_entity_decode($category->attributes), ['class'=>'form-control']) }}
                        </div>
                    </div>
                    
                      <div class="form-group">
                        {{ Form::label('Attribute Values*', 'Attribute Values', ['class' => 'col-sm-3 control-label']) }}
                           <span class="lable btn getHelp label-info" data-h='[{"attr_id":1,"option_name":"1kg","option_value":1},  {"attr_id":1,"option_name":"2kg","option_value":2},  {"attr_id":1,"option_name":"3kg","option_value":3},  {"attr_id":1,"option_name":"5kg","option_value":4},  {"attr_id":2,"option_name":"Full","option_value":1},  {"attr_id":2,"option_name":"Half","option_value":2} ]'>Help</span>

                        <div class="col-sm-6 col-xs-12">
                            {{Form::text('attribute_values',  html_entity_decode($category->attribute_values), ['class'=>'form-control']) }}
                        </div>
                    </div>
                    
                    <label> Home Page 3 Boxes</label>
                   
                    
                    <div class="existingImg">
                                     <?php  if (!empty($category->threebox_image)) {  
      $banners=json_decode(($category->threebox_image),true);
      foreach($banners as $banner){
           $bannerlogo = asset('public/admin/themes/') . "/" . @$banner['banner'];
                        ?>
                       <div class="row form-group">
                                <div class="col-sm-3">
                                    <img src="{{$bannerlogo }}" class="displayImage" height="40%" width="60%"></img> 
                                </div>
                                <div class="col-sm-2">
                                    <input  name="banner[]" type="file" class="form-control filestyle "  data-input="false"><span class="span-mand span-mand-setright"> *</span>
                                    <!-- <input  name="images[]" type="file" class="form-control"  > -->
                                </div>

                                 <div class="col-sm-2">
                                    {!! Form::text('banner_text[]',@$banner['banner_text'], ["class"=>'form-control ' ,"placeholder"=>'Text']) !!}
                                    
                                </div>


                                <div class="col-sm-2">
                                    {!! Form::text('sort_order[]',$banner['sort_order'], ["class"=>'form-control ' ,"placeholder"=>'Sort Order']) !!}
                                    
                                </div>
                                 <div class="col-sm-2">
                                    {!! Form::select('banner_status[]',[1=>'Enabled',2=>'Disabled'],@$banner['banner_status'], ["class"=>'form-control ' ,"placeholder"=>'Status']) !!}
                                    
                                </div>
                                
<!--                     <a href="javascript:void();"  data-toggle="tooltip" title="Add New" class="addMoreImg"><i class="fa fa-plus btn btn-lg btn-plen"></i></a> -->
                            </div>        
                    
      <?php } }else{   ?>
                        
                        
                        
                    <div class="row form-group">
                                <div class="col-sm-3">
                                </div>
                                <div class="col-sm-2">
                                    <input  name="banner[]" type="file" class="form-control filestyle"  data-input="false">
                                    <!-- <input  name="images[]" type="file" class="form-control"  > -->
                                </div>

                                <div class="col-sm-2">
                                    {!! Form::text('banner_text[]',null, ["class"=>'form-control ' ,"placeholder"=>'Default Text']) !!}
                                    
                                </div>


                                <div class="col-sm-2">
                                    {!! Form::text('sort_order[]',null, ["class"=>'form-control' ,"placeholder"=>'Sort Order']) !!}
                                    
                                </div>
                                  <div class="col-sm-2">
                                    {!! Form::select('banner_status[]',[1=>'Enabled',2=>'Disabled'],null ,["class"=>'form-control ' ,"placeholder"=>'Status ']) !!}
                                    
                                </div>
                                

                </div>
                        
                                      <div class="row form-group">
                                <div class="col-sm-3">
                                </div>
                                <div class="col-sm-2">
                                    <input  name="banner[]" type="file" class="form-control filestyle "  data-input="false">
                                    <!-- <input  name="images[]" type="file" class="form-control"  > -->
                                </div>

                                <div class="col-sm-2">
                                    {!! Form::text('banner_text[]',null, ["class"=>'form-control ' ,"placeholder"=>'Default Text']) !!}
                                    
                                </div>


                                <div class="col-sm-2">
                                    {!! Form::text('sort_order[]',null, ["class"=>'form-control ' ,"placeholder"=>'Sort Order']) !!}
                                    
                                </div>
                              <div class="col-sm-2">
                                    {!! Form::select('banner_status[]',[1=>'Enabled',2=>'Disabled'],null ,["class"=>'form-control' ,"placeholder"=>'Status ']) !!}
                                    
                                </div>
                                

                </div>
                                      <div class="row form-group">
                                <div class="col-sm-3">
                                </div>
                                <div class="col-sm-2">
                                    <input  name="banner[]" type="file" class="form-control filestyle"  data-input="false">
                                    <!-- <input  name="images[]" type="file" class="form-control"  > -->
                                </div>

                                <div class="col-sm-2">
                                    {!! Form::text('banner_text[]',null, ["class"=>'form-control',"placeholder"=>'Default Text']) !!}
                                    
                                </div>


                                <div class="col-sm-2">
                                    {!! Form::text('sort_order[]',null, ["class"=>'form-control ' ,"placeholder"=>'Sort Order']) !!}
                                    
                                </div>
                                <div class="col-sm-2">
                                    {!! Form::select('banner_status[]',[1=>'Enabled',2=>'Disabled'],null ,["class"=>'form-control ' ,"placeholder"=>'Status ']) !!}
                                    
                                </div>
                                

                </div>
      <?php } ?>
                    </div>   
                </div>

                <div class="box-footer">
                <div class="row">
                    <div class="col-md-3 col-md-offset-3 text-left">
                    {{Form::submit('Save & Exit', ['class'=>'btn btn-info mr10']) }}
                    </div>
                </div>
                </div>


                {{ Form::close() }}
            </div>
        </div>
        
         <div class="addNew" style="display: none;">

                    <div class="row form-group">
                        <div class="col-sm-3">
                        </div>
                        <div class="col-sm-2">
                          <input  name="banner[]" type="file" class="form-control filestyle " data-input="false">

                        </div>
                    <div class="col-sm-2">
                                    {!! Form::text('banner_text[]',null, ["class"=>'form-control ' ,"placeholder"=>'Default Text']) !!}
                                    
                                </div>
                        <div class="col-sm-2">
                            {!! Form::text('sort_order[]',null, ["class"=>'form-control ' ,"placeholder"=>'Sort Order']) !!}
                        </div>
                        <div class="col-sm-2">
                            {!! Form::text('banner_status[]',null, ["class"=>'form-control ' ,"placeholder"=>'Status']) !!}
                        </div>
                        <div class="col-sm-1">
                          
                            <a href="javascript:void();"  data-toggle="tooltip" title="Delete" class="deleteImg"><i class="fa fa-trash btn-lg btn btn-plen"></i></a> 
                        </div>
                    </div> 
                </div> 
        
        
        
    </div>
</section>
<!-- /.content -->

@stop

@section('myscripts')
<script>
      $(".addMoreImg").click(function() {
        $(".existingImg").append($(".addNew").html());
    });
    
    $("body").on("click", ".deleteImg", function() {

     //   alert("sdfsdf");
     $(this).parent().parent().remove();
 });
    $(".getHelp").on("click",function(){
       info = $(this).attr('data-h'); 
       alert(info);
    });
    
//    $("#categoryForm").validate({
//       
//        rules: {
//            category: {
//                required: true
//
//            },
//            status: {
//                required: true
//
//            }
//        },
//        messages: {
//            category: {
//                required: "Please Enter Category"
//
//            },
//            status: {
//                required: "Please Select Status"
//            }
//        },
//        errorPlacement: function (error, element) {
//            var name = $(element).attr("name");
//            var errorDiv = $(element).parent();
//            errorDiv.append(error);
//            //  error.appendTo($("#" + name + "_login_validate"));
//        }
//
//    });

</script>
@stop