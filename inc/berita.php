<div class="row">
    <div class="col-md-12">
        <h4 class="page-head-line">Halaman Berita / Info</h4>
    </div>
</div>

<div class="row">
    <div class="col-md-5">
        <div class="notice-board">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Daftar Berita (klik judul untuk membaca isi)
                    <div class="pull-right" >
                        <div class="dropdown">
                          <button class="btn btn-success dropdown-toggle btn-xs" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
                            <span class="glyphicon glyphicon-cog"></span>
                            <span class="caret"></span>
                          </button>
                          <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                            <li role="presentation"><a role="menuitem" tabindex="-1" href="">Refresh</a></li>
                          </ul>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <ul>
                        <?php
                        $sql_berita = mysqli_query($db, "SELECT * FROM tb_berita WHERE status = 'aktif' ORDER BY tgl_posting DESC LIMIT 0, 4") or die($db->error);
                        while($data_berita = mysqli_fetch_array($sql_berita)) { ?>
                          <li>
                              <?php
                              if(@$_GET['hal'] == 'daftar') { ?>
                                <a href="?hal=daftar&page=berita&action=detail&id_berita=<?php echo $data_berita['id_berita']; ?>">
                                <?php
                              } else { ?>
                                <a href="?page=berita&action=detail&id_berita=<?php echo $data_berita['id_berita']; ?>">
                                <?php
                              } ?>
                               <span class="glyphicon glyphicon-align-left text-success" ></span> 
                                <?php echo $data_berita['judul']; ?> &nbsp; 
                              </a>
                          </li>
                        <?php
                        } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    <?php
    if(@$_GET['action'] == 'detail') {
    ?>
      <div class="col-md-7">
        <div class="notice-board">
          <div class="panel panel-default">
          <div class="panel-heading">Detail Berita</div> 
          <div class="panel-body">
          <?php
          $sql_berita_detail = mysqli_query($db, "SELECT * FROM tb_berita WHERE id_berita = '$_GET[id_berita]'") or die($db->error);
          $data_berita_detail = mysqli_fetch_array($sql_berita_detail);
          ?>
            <h3 align="center"><?php echo $data_berita_detail['judul']; ?></h3>
            By : <span class="label label-warning">
                <?php
                if($data_berita_detail['penerbit'] == 'admin') {
                  echo "Admin";
                } else {
                  $sql_pengajar = mysqli_query($db, "SELECT * FROM tb_pengajar WHERE id_pengajar = '$data_berita_detail[penerbit]'") or die($db->error);
                  $data_pengajar = mysqli_fetch_array($sql_pengajar);
                  echo $data_pengajar['nama_lengkap'];
                } ?>
            </span> &nbsp; 
            <span class="label label-info"><?php echo tgl_indo($data_berita_detail['tgl_posting']); ?></span>
            <hr />
            <div>
              <?php echo nl2br($data_berita_detail['isi']); ?>
            </div>
          </div>
          </div>
        </div>
      </div>
    <?php
    } ?>
</div>