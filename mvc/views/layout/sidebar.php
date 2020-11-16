
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4" ng-controller="PhanQuyenNguoiDungController">

  <!-- Brand Logo -->
  <a href="index3.html" class="brand-link">
    <img src="./public/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
    style="opacity: .8">
    <span class="brand-text font-weight-light">Quản Lý Hệ Thống</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="./public/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="NhanSu/CaNhan" class="d-block">{{accountInfor.hovaten}}</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        
        <li class="nav-item">
          <a href="TongQuan" class="nav-link">
            <i class="nav-icon fas fa-th"></i>
            <p>
             Tổng Quan
           </p>
         </a>
       </li>
       <li class="nav-item">
        <a href="NhanSu" class="nav-link">
          <i class="nav-icon fas fa-address-card"></i>
          <p>
            Nhân Sự
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="TramQuanTrac" class="nav-link">
          <i class="nav-icon fas fa-broadcast-tower"></i>
          <p>
            Trạm Quan Trắc
          </p>
        </a>
      </li>          
    </ul>
  </nav>
  <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
</aside>