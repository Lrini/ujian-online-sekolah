<?php
$no = 1;
$id = @$_GET['id'];

if(@$_SESSION['admin']) {

    if(@$_GET['action'] == '') { ?>

    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">Manajemenen Registrasi Siswa</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Data Siswa yang Registrasi (Mendaftar) &nbsp; <!-- <a href="./laporan/cetak.php?data=siswaregistrasi" target="_blank" class="btn btn-default btn-xs">Cetak Data Siswa</a>--></div>
                <div class="panel-body">
                	<div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>NIS</th>
                                    <th>Nama Lengkap</th>
                                    <th>Jenis Kelamin</th>
                                    <th>TTL</th>
                                    <th>Alamat</th>
                                    <th>Status</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $sql_siswa = mysqli_query($db, "SELECT * FROM tb_siswa WHERE status = 'tidak aktif'") or die ($db->error);
                            if(mysqli_num_rows($sql_siswa) > 0) {
    	                        while($data_siswa = mysqli_fetch_array($sql_siswa)) { ?>
    	                            <tr>
    	                                <td align="center"><?php echo $no++; ?></td>
    	                                <td><?php echo $data_siswa['nis']; ?></td>
    	                                <td><?php echo $data_siswa['nama_lengkap']; ?></td>
    	                                <td><?php echo $data_siswa['jenis_kelamin']; ?></td>
    	                                <td><?php echo $data_siswa['tempat_lahir'].", ".tgl_indo($data_siswa['tgl_lahir']); ?></td>
    	                                <td><?php echo $data_siswa['alamat']; ?></td>
    	                                <td><?php echo ucfirst($data_siswa['status']); ?></td>
    	                                <td align="center" width="200px">
    	                                    <a href="?page=siswaregistrasi&action=aktifkan&id=<?php echo $data_siswa['id_siswa']; ?>" class="badge" style="background-color:#390;">Aktifkan</a>
                                            <a onclick="return confirm('Yakin akan menghapus data ?');" href="?page=siswaregistrasi&action=hapus&id=<?php echo $data_siswa['id_siswa']; ?>" class="badge" style="background-color:#f00;">Hapus</a>
                                             <a href="?page=siswa&action=detail&IDsiswa=<?php echo $data_siswa['id_siswa']; ?>" class="badge">Detail</a>
    	                                </td>
    	                            </tr>
    	                        <?php
    		                    }
    		                } else { ?>
    							<tr>
                                    <td colspan="8" align="center">Data tidak ditemukan</td>
    							</tr>
    		                	<?php
    		                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    	</div>
    </div>

    <?php
    } else if(@$_GET['action'] == 'aktifkan') {
        mysqli_query($db, "UPDATE tb_siswa SET status = 'aktif' WHERE id_siswa = '$id'") or die ($db->error);
        echo "<script>window.location='?page=siswaregistrasi';</script>";
    } else if(@$_GET['action'] == 'hapus') {
        mysqli_query($db, "DELETE FROM tb_siswa WHERE id_siswa = '$id'") or die ($db->error);
        echo "<script>window.location='?page=siswaregistrasi';</script>";
    }

} else { ?>
	<div class="row">
	    <div class="col-xs-12">
	        <div class="alert alert-danger">Maaf Anda tidak punya hak akses masuk halaman ini!</div>
	    </div>
	</div>
	<?php
} ?>