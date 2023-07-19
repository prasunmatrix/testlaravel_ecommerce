@extends('admin.layoutadmin')
@section('title', $page_title)
@section('content')
<br/>
<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-2">
          </div>
          <div class="col-10">
            <!-- /.card -->
            <!-- <div style="margin-left: 1046px;"> -->
            <div style="margin-left: 830px;">  
              <a href="{{ route('add.form.product') }}"><button type="button" class="btn btn-block btn-warning" style="font-weight: bold;">Add Product</button></a>
            </div>
            <hr>
            <div class="card card-primary">
              @include('admin.include.successmessage')
              <div class="card-header">
                <h3 class="card-title">View Product</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Sl.No.</th>
                    <th>Category</th>
                    <th>Name</th>
                    <th>Update Status</th>
                    <th>Status</th>
                    <th>Action</th>  
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($allProduct as $key=>$value)  
                    <tr>
                      <td>{{ $key+1 }}</td>
                      <td>
                      @php
                      $product_id=$value->id;
                      $categoryDetails = App\ProductCategory::join('categories', 
                                            'product_category.category', '=', 'categories.category_id')
                                    ->select('product_category.*','categories.category_name')
                                    ->where('product_category.product_id', $product_id)
                                    ->getQuery()
                                    ->get();
                      @endphp
                      @php($i=1)
                      @foreach($categoryDetails as $category)
                      <p><b>( {{ $i }} )</b> {{ $category->category_name }}</p>
                      @php($i++)
                      @endforeach
                      </td>
                      <td>{{ $value->product_name }}</td>
                      <td>
                        <select class="form-control" name="is_popular" id="is_popular" onchange='update_popular("{{$value->id}}",this.value)' required>
                          <option value="">Select Option</option>
                          <option @if($value->is_popular==1) selected @endif value="1">Set As Popular</option>
                          <option @if($value->is_popular==0) selected @endif value="0">Deactivate Popular</option>
                        </select>  
                      </td>
                      @if($value->is_active==1)
                      <td><a href="{{ url('change-status-product/'.$value->id.'/0') }}" class="btn btn-success btn-sm" onclick="return confirm('Are you want to inactive this product ?');">Active</a></td>
                      @else
                      <td><a href="{{ url('change-status-product/'.$value->id.'/1') }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you want to active this product ?');">Inactive</a></td>
                      @endif
                      <td>
                        <a href="{{ url('edit-product/'.$value->id) }}" class="btn btn-info btn-sm"><i class="fas fa-pencil-alt"></i> Edit</a>
                        <a href="{{ url('delete-product/'.$value->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you want to delete this product ?');"><i class="fas fa-trash"></i> Delete</a>
                      </td>
                    </tr>
                  @endforeach
                  <!-- <tr>
                    <td>Presto</td>
                    <td>Nintendo DS browser</td>
                    <td>Nintendo DS</td>
                    <td>8.5</td>
                    <td>C/A<sup>1</sup></td>
                  </tr>
                  <tr>
                    <td>KHTML</td>
                    <td>Konqureror 3.1</td>
                    <td>KDE 3.1</td>
                    <td>3.1</td>
                    <td>C</td>
                  </tr>
                  <tr>
                    <td>KHTML</td>
                    <td>Konqureror 3.3</td>
                    <td>KDE 3.3</td>
                    <td>3.3</td>
                    <td>A</td>
                  </tr>
                  <tr>
                    <td>KHTML</td>
                    <td>Konqureror 3.5</td>
                    <td>KDE 3.5</td>
                    <td>3.5</td>
                    <td>A</td>
                  </tr>
                  <tr>
                    <td>Tasman</td>
                    <td>Internet Explorer 4.5</td>
                    <td>Mac OS 8-9</td>
                    <td>-</td>
                    <td>X</td>
                  </tr>
                  <tr>
                    <td>Tasman</td>
                    <td>Internet Explorer 5.1</td>
                    <td>Mac OS 7.6-9</td>
                    <td>1</td>
                    <td>C</td>
                  </tr>
                  <tr>
                    <td>Tasman</td>
                    <td>Internet Explorer 5.2</td>
                    <td>Mac OS 8-X</td>
                    <td>1</td>
                    <td>C</td>
                  </tr>
                  <tr>
                    <td>Misc</td>
                    <td>NetFront 3.1</td>
                    <td>Embedded devices</td>
                    <td>-</td>
                    <td>C</td>
                  </tr>
                  <tr>
                    <td>Misc</td>
                    <td>NetFront 3.4</td>
                    <td>Embedded devices</td>
                    <td>-</td>
                    <td>A</td>
                  </tr>
                  <tr>
                    <td>Misc</td>
                    <td>Dillo 0.8</td>
                    <td>Embedded devices</td>
                    <td>-</td>
                    <td>X</td>
                  </tr>
                  <tr>
                    <td>Misc</td>
                    <td>Links</td>
                    <td>Text only</td>
                    <td>-</td>
                    <td>X</td>
                  </tr>
                  <tr>
                    <td>Misc</td>
                    <td>Lynx</td>
                    <td>Text only</td>
                    <td>-</td>
                    <td>X</td>
                  </tr>
                  <tr>
                    <td>Misc</td>
                    <td>IE Mobile</td>
                    <td>Windows Mobile 6</td>
                    <td>-</td>
                    <td>C</td>
                  </tr>
                  <tr>
                    <td>Misc</td>
                    <td>PSP browser</td>
                    <td>PSP</td>
                    <td>-</td>
                    <td>C</td>
                  </tr>
                  <tr>
                    <td>Other browsers</td>
                    <td>All others</td>
                    <td>-</td>
                    <td>-</td>
                    <td>U</td>
                  </tr> -->
                  </tbody>
                  <!-- <tfoot>
                  <tr>
                    <th>Rendering engine</th>
                    <th>Browser</th>
                    <th>Platform(s)</th>
                    <th>Engine version</th>
                    <th>CSS grade</th>
                  </tr>
                  </tfoot> -->
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
@endsection