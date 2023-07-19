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
              <a href="{{ route('add.form.category') }}"><button type="button" class="btn btn-block btn-warning" style="font-weight: bold;">Add Category</button></a>
            </div>
            <hr>
            <div class="card card-primary">
              @include('admin.include.successmessage')
              <div class="card-header">
                <h3 class="card-title">View Category</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Sl.No.</th>
                    <th>Category Name</th>
                    <th>Category Image</th>
                    <th>Created At</th>
                    <th>Status</th>
                    <th>Action</th>  
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($allCategory as $key=>$value)  
                    <tr>
                      <td>{{ $key+1 }}</td>
                      <td>{{ $value->category_name }}</td>
                      <td><img src="{{ asset('resources/assets/admin/images/category/'.$value->category_photo) }}"  style="width: 90px;height: 60px;"></td>
                      <td>{{ date("jS F Y", strtotime($value->created_at)) }}</td>
                      @if($value->is_active==1)
                      <td><a href="{{ url('change-status-category/'.$value->category_id.'/0') }}" class="btn btn-success btn-sm" onclick="return confirm('Are you want to inactive this category ?');">Active</a></td>
                      @else
                      <td><a href="{{ url('change-status-category/'.$value->category_id.'/1') }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you want to active this category ?');">Inactive</a></td>
                      @endif
                      <td>
                        <a href="{{ url('edit-category/'.$value->category_id) }}" class="btn btn-info btn-sm"><i class="fas fa-pencil-alt"></i> Edit</a>
                        <a href="{{ url('delete-category/'.$value->category_id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you want to delete this category ?');"><i class="fas fa-trash"></i> Delete</a>
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