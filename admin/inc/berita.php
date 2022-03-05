<div class="row">
    <div class="col-md-12">
        <h1 class="page-header">Management Berita</h1>
    </div>
</div>

<?php
if(@$_GET['action'] == '') { ?>
	<div class="row">
		<div class="col-md-12">
	        <div class="panel panel-default">
	            <div class="panel-heading">Data Berita &nbsp; <a href="?page=berita&action=tambah" class="btn btn-primary btn-xs">Tambah Data</a> &nbsp; <!--<a href="./laporan/cetak.php?data=berita" target="_blank" class="btn btn-default btn-xs">Cetak</a>--></div>
	            <div class="panel-body">
	                <div class="table-responsive">
	                    <table class="table table-striped table-bordered table-hover" id="databerita">
	                        <thead>
	                            <tr>
	                                <th>#</th>
	                                <th>Judul</th>
	                                <th>Isi</th>
	                                <th>Tanggal Posting</th>
	                                <th>Penerbit</th>
	                                <th>Status</th>
	                                <th>Opsi</th>
	                            </tr>
	                        </thead>
	                        <tbody>
							<?php
	                        $no = 1;
	                        if(@$_SESSION['admin']) {
		                        $sql_berita = mysqli_query($db, "SELECT * FROM tb_berita") or die($db->error);
	                        } else if(@$_SESSION['pengajar']) {
	                        	$sql_berita = mysqli_query($db, "SELECT * FROM tb_berita WHERE penerbit = '$_SESSION[pengajar]'") or die($db->error);
	                        }

	                        if(mysqli_num_rows($sql_berita) > 0) {
	                        	while($data_berita = mysqli_fetch_array($sql_berita)) { ?>
									<tr>
										<td align="center"><?php echo $no++; ?></td>
										<td><?php echo $data_berita['judul']; ?></td>
										<td><?php echo substr($data_berita['isi'], 0, 50)." ..."; ?></td>
										<td><?php echo tgl_indo($data_berita['tgl_posting']); ?></td>
										<td>
											<?php
											if($data_berita['penerbit'] == 'admin') {
												echo "Admin";
											} else {
												$sql_pengajar = mysqli_query($db, "SELECT * FROM tb_pengajar WHERE id_pengajar = '$data_berita[penerbit]'") or die($db->error);
												$data_pengajar = mysqli_fetch_array($sql_pengajar);
												echo $data_pengajar['nama_lengkap'];
											} ?>
										</td>
										<td><?php echo ucfirst($data_berita['status']); ?></td>
										<td align="center" width="90px">
											<a href="?page=berita&action=edit&id=<?php echo $data_berita['id_berita']; ?>" class="btn btn-success btn-xs">Edit</a>
	                                        <a onclick="return confirm('Yakin akan menghapus data?');" href="?page=berita&action=hapus&id=<?php echo $data_berita['id_berita']; ?>" class="btn btn-danger btn-xs">Hapus</a>
                                        </td>
									</tr>
								<?php
	                        	}
	                        } else {
	                        	echo '<tr><td colspan="7" align="center">Data tidak ditemukan</td></tr>';
	                        } ?>
	                        </tbody>
	                    </table>
	                    <script>
                        $(document).ready(function () {
                            $('#databerita').dataTable();
                        });
                        </script>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
<?php
} else if(@$_GET['action'] == 'tambah') { ?>
	<div class="row">
		<div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Tambah Berita &nbsp; <a href="?page=berita" class="btn btn-warning btn-xs">Kembali</a></div>
                <div class="panel-body">
                	<form method="post">
                    	<div class="form-group">
                            <label>Judul *</label>
                            <input type="text" name="judul" class="form-control" required />
                        </div>
                        <div class="form-group">
                            <label>Isi *</label>
                            <textarea name="isi" class="form-control" rows="15" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Status Terbit</label>
                            <select name="status" class="form-control">
								<option value="aktif">Aktif</option>
								<option value="tidak aktif">Tidak Aktif</option>
                            </select>
                        </div>
                        <div class="form-group">
	                        <input type="submit" name="simpan" value="Simpan" class="btn btn-success" />
	                        <button type="reset" class="btn btn-danger"><i class="fa fa-refresh"></i> Reset</button>
                        </div>
                    </form>
                    <?php
                    if(@$_POST['simpan']) {
                    	$judul = @mysqli_real_escape_string($db, $_POST['judul']);
                    	$isi = @mysqli_real_escape_string($db, $_POST['isi']);
                    	$status = @mysqli_real_escape_string($db, $_POST['status']);
                    	if(@$_SESSION[admin]) {
                            mysqli_query($db, "INSERT INTO tb_berita VALUES('', '$judul', '$isi', now(), 'admin', '$status')") or die ($db->error);           
                        } else if(@$_SESSION[pengajar]) {
                        	mysqli_query($db, "INSERT INTO tb_berita VALUES('', '$judul', '$isi', now(), '$_SESSION[pengajar]', '$status')") or die ($db->error);
                        }
                        echo '<script>window.location="?page=berita";</script>';
                    } ?>
                </div>
            </div>
        </div>
    </div>
<?php
} else if(@$_GET['action'] == 'edit') { ?>
	<div class="row">
		<div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Berita &nbsp; <a href="?page=berita" class="btn btn-warning btn-xs">Kembali</a></div>
                <div class="panel-body">
                <?php
                $sql_beritaID = mysqli_query($db, "SELECT * FROM tb_berita WHERE id_berita = '$_GET[id]'") or die($db->error);
                $data_beritaID = mysqli_fetch_array($sql_beritaID); ?>
                	<form method="post">
                    	<div class="form-group">
                            <label>Judul *</label>
                            <input type="text" name="judul" value="<?php echo $data_beritaID['judul']; ?>" class="form-control" required />
                        </div>
                        <div class="form-group">
                            <label>Isi *</label>
                            <textarea name="isi" class="form-control" rows="15" required><?php echo $data_beritaID['isi']; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Status Terbit</label>
                            <select name="status" class="form-control">
								<option value="aktif">Aktif</option>
								<option value="tidak aktif" <?php if($data_beritaID['status'] == 'tidak aktif') { echo "selected"; } ?>>Tidak Aktif</option>
                            </select>
                        </div>
                        <div class="form-group">
	                        <input type="submit" name="simpan" value="Simpan" class="btn btn-success" />
	                        <button type="reset" class="btn btn-danger"><i class="fa fa-refresh"></i> Reset</button>
                        </div>
                    </form>
                    <?php
                    if(@$_POST['simpan']) {
                    	$judul = @mysqli_real_escape_string($db, $_POST['judul']);
                    	$isi = @mysqli_real_escape_string($db, $_POST['isi']);
                    	$status = @mysqli_real_escape_string($db, $_POST['status']);
                        mysqli_query($db, "UPDATE tb_berita SET judul = '$judul', isi = '$isi', status = '$status' WHERE id_berita = '$_GET[id]'") or die ($db->error);           
                    	echo '<script>window.location="?page=berita";</script>';
                    } ?>
                </div>
            </div>
        </div>
    </div>
<?php
} else if(@$_GET['action'] == 'hapus') {
	mysqli_query($db, "DELETE FROM tb_berita WHERE id_berita = '$_GET[id]'") or die($db->error);
	echo '<script>window.location="?page=berita";</script>';
} ?>