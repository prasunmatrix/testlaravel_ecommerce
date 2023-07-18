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
          <a href="{{ route('view.category') }}"><button type="button" class="btn btn-block btn-warning" style="font-weight: bold;">View Category</button></a>
        </div>
        <hr>
        <!-- general form elements -->
        <div class="card card-primary">
          @include('admin.include.successmessage')
          <div class="card-header">
            <h3 class="card-title">Edit Category</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form role="form" action="<?php route('edit.update.category',$category_id) ?>" method="post" id="editcategory-form" autocomplete="off" enctype="multipart/form-data">
          	<input type="hidden" value="<?=csrf_token()?>" name="_token">
            <input type="hidden" value="{{ $category_id }}" name="category_id">
            <div class="card-body">
              <div class="form-group">
                <label for="exampleInputEmail1">Category Name</label>
                <input type="text" class="form-control" id="category_name" name="category_name" placeholder="Category Name" 
                required="required" value="{{$getParticularCategory->category_name}}" />
              </div>
              <div class="form-group">
                <label for="categoryslug">Category Slug </label>
                <input type="text" name="category_slug" id="category_slug"    value="{{$getParticularCategory->category_slug}}" class="form-control" required="required" readonly placeholder="Category Slug"
                />
              </div>
              <div class="form-group">
                <img src="{{ asset('resources/assets/admin/images/category/'.$getParticularCategory->category_photo) }}"  style="width: 90px;height: 60px;"><br/>
                <label for="exampleInputFile">File input</label>
                <div class="input-group">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" name="category_new_photo" id="category_new_photo" />
                    <input type="hidden" name="category_photo" id="category_photo" value="{{ $getParticularCategory->category_photo }}">
                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                  </div>
                  <!-- <div class="input-group-append">
                    <span class="input-group-text" id="">Upload</span>
                  </div> -->
                </div>
              </div>
              <!-- <div class="form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Check me out</label>
              </div> -->
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
              <button type="submit" id="add_category" class="btn btn-primary">Update</button>
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