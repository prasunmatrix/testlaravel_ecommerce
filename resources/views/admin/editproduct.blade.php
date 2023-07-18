@extends('admin.layoutadmin')
@section('title', $page_title)
@section('content')
<br/>
<section class="content">
  <div class="container-fluid">
    <div class="row">
    	<div class="col-md-2">
    	</div>	
      <!-- left column -->
      <div class="col-md-10">
        <div style="margin-left: 1046px;">
          <a href="{{ route('view.product') }}"><button type="button" class="btn btn-block btn-warning" style="font-weight: bold;">View Product</button></a>
        </div>
        <hr>
        <!-- general form elements -->
        <div class="card card-primary">
          @include('admin.include.successmessage')
          <div class="card-header">
            <h3 class="card-title">Edit Product</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form role="form" action="<?php route('edit.update.product',$product_id) ?>" method="post" id="addcategory-form" autocomplete="off" 
          	enctype="multipart/form-data">
          	<input type="hidden" value="<?=csrf_token()?>" name="_token">
            <input type="hidden" value="{{ $product_id }}" name="product_id">
            <div class="card-body">
              <div class="form-group">
                <label for="productcategory">Product Category</label>
                @php
                  $product_id=$getParticularProduct->id;
                  $cat_details=App\ProductCategory::selectRaw('GROUP_CONCAT(category) as category')->where('product_id',$product_id)->where('is_deleted','0')->first(); 
                  $categoryArray=explode(',',$cat_details->category);
                  //echo "<pre>";
                  //print_r($categoryArray); die();  
                @endphp
                <select class="form-control selectpicker" name="category[]" required multiple data-live-search="true">                  
                  @foreach($category as $c)
                    <option @if(in_array($c->category_id,$categoryArray)) selected @endif value="{{ $c->category_id }}">{{ $c->category_name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="productname">Product Name</label>
                <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Product Name" 
                required="required" value="{{ $getParticularProduct->product_name }}" />
              </div>
              <div class="form-group">
                <label for="productslug">Product Slug </label>
                <input type="text" name="product_slug" id="slug" class="form-control" required readonly placeholder="Product Slug" value="{{ $getParticularProduct->product_slug }}" />
              </div>
              <div class="form-group">
                <label for="skucode">Sku Code </label>
                <input type="text" name="sku_code" id="sku_code" class="form-control" required  placeholder="Sku Code" value="{{ $getParticularProduct->sku_code }}" />
              </div>              
              <div class="form-group">
                @if($getParticularProduct->feature_image !='')
                  <img src="{{ asset('resources/assets/admin/images/product/'.$getParticularProduct->feature_image) }}"  style="width: 90px;height: 60px;"><br/>
                @endif
                <label for="featureimage">Feature Image [MAX Size 2MB]</label><br/>
                <div class="input-group">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" name="feature_image" id="feature_image" />
                    <input type="hidden" name="feature_old_image" id="feature_old_image" value="{{ $getParticularProduct->feature_image }}" />
                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="productprice">Product Price </label>
                <div class="col-sm-12">
                  <div class="row">  
                    <div class="col-sm-2">
                      <span class="input-group-text">USD</span>
                    </div>
                    <div class="col-sm-10">
                      <input type="number" name="product_price" id="product_price" class="form-control" required  placeholder="Product Price" value="{{ $getParticularProduct->usd_price }}">
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="offerprice">Offer Price </label>
                <div class="col-sm-12">
                  <div class="row">  
                    <div class="col-sm-2">
                      <span class="input-group-text">USD</span>
                    </div>
                    <div class="col-sm-10">
                      <input type="number" name="offer_price" id="offer_price" class="form-control"  placeholder="Offer Price" value="{{ $getParticularProduct->usd_offer_price }}">
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="shortdesc">Short Description </label>
                <textarea name="short_desc" class="form-control ckeditor" placeholder="Short Description">{{ $getParticularProduct->short_desc }}</textarea>
              </div>
              <div class="form-group">
                <label for="longdesc">Long Description </label>
                <textarea name="long_desc" class="form-control ckeditor" placeholder="Long Description">{{ $getParticularProduct->long_desc }}</textarea>
              </div>
              <div class="form-group">
                <label for="aditionalinfo">Aditional Information</label>
                <textarea name="aditional_info" class="form-control ckeditor" placeholder="Aditional Information">{{ $getParticularProduct->aditional_info }}</textarea>
              </div>
              <div class="form-group">
                <label for="metatitle">Meta Title </label>              
                <input type="text" name="meta_title" class="form-control" placeholder="Meta Title" value="{{  $getParticularProduct->meta_title }}">              
              </div>
              <div class="form-group">
                <label for="metakeywords">Meta Keywords </label>
                <textarea name="meta_keywords" class="form-control" placeholder="Meta Keywords">{{ $getParticularProduct->meta_keywords }}</textarea> 
              </div>
              <div class="form-group">
                <label for="metadescription">Meta Description </label>
                <textarea name="meta_description" class="form-control" placeholder="Meta Description">{{ $getParticularProduct->meta_description }}</textarea>              
              </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
              <button type="submit" class="btn btn-primary" id="add_product">Update</button>
            </div>
          </form>
        </div>
        <!-- /.card -->
      </div>
      <!--/.col (left) -->
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</section>
@endsection