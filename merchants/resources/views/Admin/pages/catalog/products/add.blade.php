
<div class="modal-header addProduct-modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Add New Product  (1000px W X 1000px H)</h4>
</div>

<div class="box-body">
    {!! Form::open(['method' => 'post', 'files'=> true, 'id'=>'addProductFrm', 'url' => route("admin.products.save") ]) !!}
    {!! Form::hidden('id',null) !!}
    {!! Form::hidden('id_img',null) !!}
    {!! Form::hidden('is_individual','1')  !!}
    {!! Form::hidden('is_avail', '1') !!}
    {!! Form::hidden('return_url', null,["class"=>'retunUrl']) !!}
     {!! Form::hidden('added_by', Session::get('loggedinAdminId')) !!}
     <input type="hidden" id="prod_img_url" name="prod_img_url" value="">

        <div class="form-group mb-15 clearfix" style="padding: 0 15px;">
        <div  id="addImg" class="add-img">
            <input type="file" id="chooseImg" name="images" />
            <i class="fa fa-plus"></i><br>
            <span class="add-img-txt">Add Image</span>
        </div>
         <span id="error-product" class="text-danger"></span>
         <div class="img-box">
            <div class="form-group">
               <div class="box-2">
                  <div class="result-product" style="height: 200px"></div>
              </div>
            </div>
        </div>
       
    </div>
<div class="clearfix"></div>
    <div class="form-group col-md-6">
        <label class="control-label">Product Type <span class="red-astrik"> *</span></label>
          {!! Form::select('prod_type',$prod_types,null,["class"=>'form-control prod_type validate[required]']) !!}

    </div>

    <div class="form-group  col-md-6">
        <label class="control-label">Product Name <span class="red-astrik"> *</span></label>
       {!! Form::text('product',null, ["class"=>'form-control validate[required]' ,"placeholder"=>'Enter Product Name']) !!}
    </div>
 <div class="form-group  col-md-12 hide" id="attribute" >
        {!! Form::label('Attribute Set', 'Attribute Set',['class'=>'control-label']) !!}

            {!! Form::select('attr_set',$attr_sets,null,["class"=>'form-control validate[required]']) !!}

    </div>
    <div class="form-group col-md-6" id="listingprice">
        <label class="control-label">MRP/Listing Price </label> <span class="red-astrik">*</span>
          {!! Form::number('price',null, ["class"=>'form-control priceConvertTextBox validate[required]','min'=>0 ,"placeholder"=>'Enter Mrp Price']) !!}

    </div>

    <div class="form-group col-md-6" id="sellprice">
        <label class="control-label">Selling Price </label>
        {!! Form::number('selling_price',null, ["class"=>'form-control priceConvertTextBox','min'=>0 ,"placeholder"=>'Enter Selling Price']) !!}

    </div>
 @if($settingStatus['stock'] == 1)
 <div class="form-group col-md-6 stockcheck" id="prodstock">
        <label class="control-label">Stock </label>
        {!! Form::number('stock',null, ["class"=>'form-control validate[required]','min'=>0 ,"placeholder"=>'Enter stock']) !!}

    </div>
 @endif
    <div class="form-group col-md-12">
        <label class="control-label">Select Category </label>
        <select name="category[]" class="selectpicker validate[required] sel-cat-multi-drop col-md-12" multiple>
   <?php
$dash1 = " -- ";
echo "<ul>";
foreach ($rootsS as $root1) {
    renderNode2($root1, $dash1);
}

echo "</ul>";

function renderNode2($node, $dash1)
{
    echo "<li>";
    echo "<option value='{$node->id}'   > {$dash1}{$node->categoryName->category}</option>";
    if ($node->children()->where("status", 1)->count() > 0) {
        $dash1 .= " -- ";
        echo "<ul>";
        foreach ($node->children as $child) {
            renderNode2($child, $dash1);
        }

        echo "</ul>";
    }
    echo "</li>";
}
?>
</select>

    </div>


  <div class="form-group col-md-4">
        <label class="control-label">Status </label>
      <label class="switch">
  <input class="switch-input"  name="status" id="prodStatus" value="1" type="checkbox" checked="" />
  <span class="switch-label"  data-on="Enabled" data-off="Disabled"></span>
  <span class="switch-handle"></span>
 </label>
    </div>

    <div class="form-group col-md-4">
        <label class="control-label">Trending </label>
      <label class="switch">
  <input class="switch-input" name="is_trending" id="tranding" value="0" type="checkbox" />
  <span class="switch-label"  data-on="Enabled" data-off="Disabled"></span>
  <span class="switch-handle"></span>
 </label>
    </div>


 @if($settingStatus['stock'] == 1)
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

    <div class="form-group col-md-12 text-right">
              {!! Form::submit('Add',["class" => "btn btn-primary saveButton"]) !!}


            <input class="btn btn-primary nextButton" type="submit" value="Next">


            {!! Form::close() !!}
       <!--  <div class="col-md-4 pl-0">
            <button type="button" class="btn btn-default fullwidthbtn" data-dismiss="modal">Close</button>
        </div> -->
    </div>

    </form>
</div>


</div>
