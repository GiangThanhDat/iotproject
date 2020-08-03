        <div class="container-fluid">
          <!-- Content Row -->
          <div class="row">
            <div class="col-xl-12 col-lg-12">
              <!-- Area Chart -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Chart</h6>
                </div>
                <div class="card-body">
                  <div class="chart-area">
                    <canvas id="myAreaChart"></canvas>
                  </div>
                  <hr>
                </div>
              </div>
          </div>
        </div>
<?php   
  $masterController = new controller;               
  $CamBienModel = $masterController->model("cambien");
  $DaiLuongModel = $masterController->model("dailuongdo");

  $cambienList = json_decode($CamBienModel->listAll(),true);
  $dailuongList = json_decode($DaiLuongModel->listAll(),true);
  $sensorMeasuresList = json_decode($data['sensorMeasuresList'],true);
  $sensorsStationList = json_decode($data['sensorsStationList'],true);
  $unitsList = json_decode($data['unitsList'],true);
  $tram_dang_xem = json_decode($data['tram_obj'],true);
  $ma_tram = $tram_dang_xem['ma_tram'];

?>
<div class="container-fluid">
  <hr>
  <!-- <div class="row"> -->
    <div class="card-columns ">
      <?php foreach ($sensorMeasuresList as $value): ?>
        <?php 
      // prepare data
      // print_r($CamBienModel->getByKey($value['ma_cambien']));      
      // print_r($DaiLuongModel->getByKey($value['ma_dailuong']));
        $cambienObj = json_decode($CamBienModel->getByKey($value['ma_cambien']),true);
        $dailuongObj = json_decode($DaiLuongModel->getByKey($value['ma_dailuong']),true);   
        $ma_cambien = $cambienObj['ma_cambien'];
        $ma_dailuong = $dailuongObj['ma_dailuong'];

        ?>      
        <!-- style="width: 610px;" -->
        <div class="card bg-primary text-white text-center" style="width:auto;height: 300px;" > 
          <div class="card-header bg-success">
            <div class="row">
              <div class="col-md-10 bg-white text-black rounded">
                <p style="color: black;">Bảng Giá Trị-Đo Lường</p>
                <!-- <p style="color: black;"><?= $ma_cambien ?>_<?= $ma_dailuong ?></p> -->
              </div>
              <div class="col-md-2" style="text-align:right">
                <div class="">
                  <button type="label" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="setting" value="1">
                    <i class="fa fa-cog"></i>
                  </button>
                  <ul class="dropdown-menu pull-right" style="padding: 10px 10px">
                    <li>
                      <a href="admin/show/dailuongdo" class="btn btn-outline-success btn-sm">Cài đặt chi tiết<i class="fa fa-cog"></i></a>
                    </li>
                    <li>
                      <form action="collect/editDL/<?= $ma_tram ?>/<?= $ma_dailuong ?>" method="POST">
                        <div class="input-group">
                          <span class="input-group-addon">Ngưỡng cảnh báo trên</span>
                          <input type="number" step="any" name="nguon_tren" required="" value="<?= $dailuongObj['nguon_tren'] ?>">
                          <span class="input-group-addon">Ngưỡng cảnh báo dưới</span>
                          <input type="number" step="any" name="nguon_duoi" required="" value="<?= $dailuongObj['nguon_duoi'] ?>">
                        </div>      
                        <div class="input-group">
                          <span class="input-group-addon">Màu sắc cảnh báo</span>
                          <input type="color" value="<?= $dailuongObj['mau'] ?>" name="mau" required="" style="width:100%">
                        </div>  
                        <br>
                        <input class="btn btn-primary" value="Lưu lại" type="submit">
                      </form>
                    </li>
                  </ul>
                </div>
              </div>            
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12 border rounded">  
                <hr>
                <div class="row">
                  <div class="col-6"><p class="card-text small"><?= $cambienObj['ten_cambien'] ?></p></div> 
                  <div class="col-6"><p class="card-text small"><?= $dailuongObj['ten_dailuong'] ?></p></div>                   
                </div>
                <div class="row">
                  <div class="col-3"><p class="card-text small" id="val_<?= $ma_tram ?>_<?= $ma_cambien ?>_<?= $ma_dailuong ?>"></p></div>
                  <div class="col-3"><span class="card-text small"><?= $dailuongObj['ten_donvi'] ?></span></div>
                  <div class="col-4"><p class="card-text small" id="time_<?= $ma_tram ?>_<?= $ma_cambien ?>_<?= $ma_dailuong ?>"></p></div>
                </div>
                <hr>
              </div>
            </div>
          </div>  
          <div class="card-footer bg-info">
            <a href="collect/chart/<?= $ma_tram ?>/<?= $ma_cambien ?>/<?= $ma_dailuong ?>" class="btn btn-primary btn-sm">Xem chi tiết</a>
          </div>        
        </div>  
      <?php endforeach ?>
    </div>
  <!-- </div> -->
  <hr>
</div>
<script type="text/javascript">
  const idStation = <?= $ma_tram ?>;
  const sensorMeasuresList = <?= $data['sensorMeasuresList'] ?>;
</script>
<script src="./public/js/demo/loadData.js"></script>                
        <script type="text/javascript">
          const keys = <?= $data['keys'] ?>
        </script>
        <!-- Page level custom scripts -->
        <script src="./public/js/demo/chart-area-demo.js"></script>
        <script src="./public/js/demo/chart-pie-demo.js"></script>
        <script src="./public/js/demo/chart-bar-demo.js"></script>
