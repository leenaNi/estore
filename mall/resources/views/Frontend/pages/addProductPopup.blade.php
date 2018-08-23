<style type="text/css">
.img-box {
    float: left;
    width: 300px;
    height: auto !important;
    margin-left: 20px;
}
</style>
<div class="box-body clearfix">
    {!! Form::open(['method' => 'post', 'files'=> true, 'id'=>'productAddPopUp' ,'url' => route("saveProduct") ]) !!}
    {!! Form::hidden('id',null) !!}
    {!! Form::hidden('id_img',null) !!}
    {!! Form::hidden('is_individual','1')  !!}
    {!! Form::hidden('is_avail', '1') !!}
    <input type="hidden" id="prod_img_url" name="prod_img_url" value="">
   
        <div class="form-group mb-15 clearfix" style="padding: 0 15px;">
        <div  id="addImg" class="add-img mobiletopmargin15">
            <input type="file" id="prodImg" name="images"  />
            <i class="fa fa-plus"></i><br>
            <span class="add-img-txt">Add Image</span>
        </div>
        <span id="error-product" class="text-danger"></span>
         <div class="img-box">  
            <div class="form-group">
               <div class="box-2">
                  <div class="product-popup"></div>
              </div>
            </div>
        </div>  
    </div>
<div class="clearfix"></div>
    <div class="form-group col-md-6">
        <label class="control-label">Product Type <span class="red-astrik"> *</span></label> 
          <!--{!! Form::select('prod_type',$prod_types,null,["class"=>'form-control prod_type validate[required]']) !!}-->
            <select class="form-control" name="prod_type">
            <option value="1">Simple</option>
<!--            <option value="3">Configurable</option>
            <option value="5">Downloadable Product</option>-->
        </select>
    </div>

    <div class="form-group  col-md-6">
        <label class="control-label">Product Name <span class="red-astrik"> *</span></label> 
       {!! Form::text('product',null, ["class"=>'form-control validate[required]' ,"placeholder"=>'Enter Product Name']) !!}
    </div>
 <div class="form-group  col-md-12 hide" id="attribute" >
        {!! Form::label('Attribute Set', 'Attribute Set',['class'=>'control-label']) !!}
        
            {!! Form::select('attr_set',$attr_sets,null,["class"=>'form-control validate[required]']) !!}
        
    </div>
    <div class="form-group col-md-6">
        <label class="control-label">MRP/Listing Price </label> <span class="red-astrik">*</span>
          {!! Form::number('price',null, ["class"=>'form-control validate[required]' ,"placeholder"=>'Enter MRP Price']) !!}
       
    </div>

    <div class="form-group col-md-6">
        <label class="control-label">Selling Price </label>
         {!! Form::number('selling_price',null, ["class"=>'form-control' ,"placeholder"=>'Enter Selling Price']) !!}
       
    </div>

    <div class="form-group col-md-12">
        <label class="control-label">Select Category </label>
        <select name="category[]" class="selectpicker validate[required] sel-cat-multi-drop col-md-12" multiple>
   <?php
                            $dash1 = " -- ";
                            echo "<ul>";
                            foreach ($rootsS as $root1)
                                renderNode2($root1, $dash1);
                            echo "</ul>";

                            function renderNode2($node, $dash1) {
                                echo "<li>";
                                echo "<option value='{$node->id}'   > {$dash1}{$node->category}</option>";
                                if ($node->children()->where("status",1)->count() > 0) {
                                    $dash1 .= " -- ";
                                    echo "<ul>";
                                    foreach ($node->children as $child)
                                        renderNode2($child, $dash1);
                                    echo "</ul>";
                                }
                                echo "</li>";
                            }
                            ?>
</select>

    </div>
  <div class="form-group col-md-4">
        <label class="control-label">Status </label>
      <label class="switch mobilenomargin">
  <input class="switch-input prodPopCheck"  name="status" id="prodStatus" value="1" type="checkbox" checked="" />
  <span class="switch-label"  data-on="Enabled" data-off="Disabled"></span> 
  <span class="switch-handle"></span> 
 </label>
    </div>

    <div class="form-group col-md-4">
        <label class="control-label">Trending </label>
      <label class="switch mobilenomargin">
  <input class="switch-input prodPopCheck" name="is_trending" id="tranding" value="0" type="checkbox" />
  <span class="switch-label"  data-on="Enabled" data-off="Disabled"></span> 
  <span class="switch-handle"></span> 
 </label>
    </div>

  
 @if($settingStatus['26'] == 1)
     <div class="form-group col-md-4">
        <label class="control-label">Manage Stock <span class="red-astrik"> *</span></label>
      <label class="switch">
  <input class="switch-input" name="is_stock" value="1" id="isStock" type="checkbox" checked="" />
  <span class="switch-label"  data-on="Enabled" data-off="Disabled"></span> 
  <span class="switch-handle"></span> 
 </label>
    </div>
    @else
    <input type="hidden" name="is_stock" value="0">
    @endif
   
    <div class="form-group col-md-12 text-right mobile-text-left">
              {!! Form::submit('Add',["class" => "btn btn-primary saveButton"]) !!}
           
        
<!--            <input class="btn btn-primary " type="submit" value="Next">-->
        
       
            {!! Form::close() !!} 
       <!--  <div class="col-md-4 pl-0">
            <button type="button" class="btn btn-default fullwidthbtn" data-dismiss="modal">Close</button>
        </div> -->
    </div>

    </form>
</div>

