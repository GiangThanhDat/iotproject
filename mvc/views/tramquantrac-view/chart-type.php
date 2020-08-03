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
        <script type="text/javascript">
          const keys = <?= $data['keys'] ?>
        </script>
        <!-- Page level custom scripts -->
        <script src="./public/js/demo/chart-area-demo.js"></script>
        <script src="./public/js/demo/chart-pie-demo.js"></script>
        <script src="./public/js/demo/chart-bar-demo.js"></script>
