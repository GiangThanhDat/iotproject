

<!-- Begin Page Content -->
<div class="container-fluid">
  <div class="row">
    <div class="col-md-4"></div>
    <div id="list-all-alert-success" class="alert alert-success alert-dismissible fade show text-center col-md-4" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <strong>Cập nhật thành công!!</strong><hr>
    </div>
    <div id="list-all-alert-fail" class="alert alert-danger alert-dismissible fade show text-center col-md-4" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <strong>Xẩy ra lổi, vui lòng kiểm tra lại</strong><hr>
    </div>
    <div class="col-md-4"></div>
  </div>
  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800" ><?php echo $data['model'] ?></h1>
  <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below. For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official DataTables documentation</a>.</p>                
  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6  class="m-0 font-weight-bold text-primary">DataTables Example</h6>
    </div>    
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Mả Trạm</th>
              <th>Tên Trạm</th>
              <th>Địa chỉ</th>
              <th class="text-center">Detail</th>
              <th class="text-center">Delete</th>
            </tr>
          </thead>
          <tfoot>
            <th>Mả Trạm</th>
            <th>Tên Trạm</th>
            <th>Địa chỉ</th>
            <th class="text-center">Detail</th>
            <th class="text-center">Delete</th>
          </tr>
        </tfoot>
        <tbody>               
        </tbody>
      </table>
    </div>
  </div>
</div>
</div>
<!-- /.container-fluid -->
