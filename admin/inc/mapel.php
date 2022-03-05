<div class="row">
    <div class="col-md-12">
        <h1 class="page-header">Manajemen Mata Pelajaran</h1>
    </div>
</div>

<?php
$id = @$_GET['id'];
$no = 1;

if(@$_SESSION[admin]) {

    echo '<div class="row">';
    if(@$_GET['action'] == '') { ?>
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"><a href="?page=mapel&action=tambah" class="btn btn-primary btn-sm">Tambah Data</a> &nbsp; <!--<a href="./laporan/cetak.php?data=mapel" target="_blank" class="btn btn-default btn-sm">Cetak</a>--></div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Kode Mapel</th>
                                    <th>Mapel</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $sql_mapel = mysqli_query($db, "SELECT * FROM tb_mapel") or die ($db->error);
                            if(mysqli_num_rows($sql_mapel) > 0) {
	                            while($data_mapel = mysqli_fetch_array($sql_mapel)) { ?>
	                                <tr>
	                                    <td><?php echo $no++; ?></td>
	                                    <td><?php echo $data_mapel['kode_mapel']; ?></td>
	                                    <td><?php echo $data_mapel['mapel']; ?></td>
	                                    <td align="center" width="150px">
	                                        <a href="?page=mapel&action=edit&id=<?php echo $data_mapel['id']; ?>" class="badge" style="background-color:#f60;">Edit</a>
	                                        <a onclick="return confirm('Yakin akan menghapus data?');" href="?page=mapel&action=hapus&id=<?php echo $data_mapel['id']; ?>" class="badge" style="background-color:#f00;">Hapus</a>
	                                    </td>
	                                </tr>
	                            <?php
	                            }
                            } else {
                            	echo '<td colspan="4" align="center">Tidak ada data</td>';
                        	} ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php
    } else if(@$_GET['action'] == 'tambah') { ?>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Tambah Data Mata Pelajaran &nbsp; <a href="?page=mapel" class="btn btn-warning btn-sm">Kembali</a></div>
                <div class="panel-body">
                    <form method="post">
                        <div class="form-group">
                            <label>Kode Mapel *</label>
                            <input type="text" name="kode_mapel" class="form-control" placeholder="Ex: A1" required />
                        </div>
                        <div class="form-group">
                            <label>Mapel *</label>
                            <input type="text" name="mapel" class="form-control" placeholder="Ex: Bahasa Indonesia" required />
                        </div>
                        <div class="form-group">
                            <input type="submit" name="simpan" value="Simpan" class="btn btn-success" />
                            <input type="reset" value="Reset" class="btn btn-danger" />
                        </div>
                    </form>
                    <?php
                    if(@$_POST['simpan']) {
                        $kode_mapel = @mysqli_real_escape_string($db, $_POST['kode_mapel']);
                        $mapel = @mysqli_real_escape_string($db, $_POST['mapel']);
                        mysqli_query($db, "INSERT INTO tb_mapel VALUES('', '$kode_mapel', '$mapel')") or die ($db->error);
                        echo "<script>window.location='?page=mapel';</script>";
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
    } else if(@$_GET['action'] == 'edit') { ?>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Data Mata Pelajaran &nbsp; <a href="?page=mapel" class="btn btn-warning btn-sm">Kembali</a></div>
                <div class="panel-body">
                    <form method="post">
                    	<?php
                    	$sql_mapel_id = mysqli_query($db, "SELECT * FROM tb_mapel WHERE id = '$id'") or die ($db->error);
                    	$data_mapel_id = mysqli_fetch_array($sql_mapel_id);
                    	?>
                        <div class="form-group">
                            <label>Kode Mapel *</label>
                            <input type="text" name="kode_mapel" value="<?php echo $data_mapel_id['kode_mapel']; ?>" class="form-control" placeholder="Ex: A1" required />
                        </div>
                        <div class="form-group">
                            <label>Mapel *</label>
                            <input type="text" name="mapel" value="<?php echo $data_mapel_id['mapel']; ?>" class="form-control" placeholder="Ex: Bahasa Indonesia" required />
                        </div>
                        <div class="form-group">
                            <input type="submit" name="simpan" value="Simpan" class="btn btn-success" />
                            <input type="reset" value="Reset" class="btn btn-danger" />
                        </div>
                    </form>
                    <?php
                    if(@$_POST['simpan']) {
                        $kode_mapel = @mysqli_real_escape_string($db, $_POST['kode_mapel']);
                        $mapel = @mysqli_real_escape_string($db, $_POST['mapel']);
                        mysqli_query($db, "UPDATE tb_mapel SET kode_mapel = '$kode_mapel', mapel = '$mapel' WHERE id = '$id'") or die ($db->error);
                        echo "<script>window.location='?page=mapel';</script>";
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
    } else if(@$_GET['action'] == 'hapus') {
        mysqli_query($db, "DELETE FROM tb_mapel WHERE id = '$id'") or die ($db->error);  
        echo "<script>window.location='?page=mapel';</script>"; 
    }
    echo "</div>";

} else if(@$_SESSION[pengajar]) {

	echo '<div class="row">';
    if(@$_GET['action'] == '') { ?>
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Mata Pelajaran yang Anda Ajar &nbsp; <a href="?page=mapel&action=tambah" class="btn btn-primary btn-sm">Tambah Data</a></div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Kode Mapel</th>
                                    <th>Mapel</th>
                                    <th>Kelas</th>
                                    <th>Keterangan</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $sql_mapel_ajar = mysqli_query($db, "SELECT * FROM tb_mapel_ajar JOIN tb_mapel ON tb_mapel_ajar.id_mapel = tb_mapel.id JOIN tb_kelas ON tb_mapel_ajar.id_kelas = tb_kelas.id_kelas WHERE tb_mapel_ajar.id_pengajar = '$_SESSION[pengajar]'") or die ($db->error);
                            if(mysqli_num_rows($sql_mapel_ajar) > 0) {
	                            while($data_mapel_ajar = mysqli_fetch_array($sql_mapel_ajar)) { ?>
	                                <tr>
	                                    <td><?php echo $no++; ?></td>
	                                    <td><?php echo $data_mapel_ajar['kode_mapel']; ?></td>
	                                    <td><?php echo $data_mapel_ajar['mapel']; ?></td>
	                                    <td><?php echo $data_mapel_ajar['nama_kelas']; ?></td>
	                                    <td><?php echo $data_mapel_ajar['keterangan']; ?></td>
	                                    <td align="center" width="150px">
	                                        <a href="?page=mapel&action=edit&id=<?php echo $data_mapel_ajar[0]; ?>" class="badge" style="background-color:#f60;">Edit</a>
	                                        <a onclick="return confirm('Yakin akan menghapus data?');" href="?page=mapel&action=hapus&id=<?php echo $data_mapel_ajar[0]; ?>" class="badge" style="background-color:#f00;">Hapus</a>
	                                    </td>
	                                </tr>
	                            <?php
	                            }
                            } else {
                            	echo '<td colspan="6" align="center">Tidak ada data</td>';
                        	} ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php
    } else if(@$_GET['action'] == 'tambah') { ?>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Tambah Mata Pelajaran yang Anda Ajar &nbsp; <a href="?page=mapel" class="btn btn-warning btn-sm">Kembali</a></div>
                <div class="panel-body">
                    <form method="post">
                        <div class="form-group">
                            <label>Mapel *</label>
                            <select name="mapel" class="form-control" required>
                            	<option value="">- Pilih -</option>
                            	<?php
                            	$sql_mapel = mysqli_query($db, "SELECT * FROM tb_mapel") or die ($db->error);
                            	while($data_mapel = mysqli_fetch_array($sql_mapel)) {
                            		echo '<option value="'.$data_mapel['id'].'">'.$data_mapel['mapel'].'</option>';
                            	} ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kelas yang Anda Ajar *</label>
                            <select name="kelas" class="form-control" required>
                            	<option value="">- Pilih -</option>
                            	<?php
                            	$sql_kelas = mysqli_query($db, "SELECT * FROM tb_kelas_ajar JOIN tb_kelas ON tb_kelas_ajar.id_kelas = tb_kelas.id_kelas WHERE tb_kelas_ajar.id_pengajar = '$_SESSION[pengajar]'") or die ($db->error);
                            	while($data_kelas = mysqli_fetch_array($sql_kelas)) {
                            		echo '<option value="'.$data_kelas['id_kelas'].'">'.$data_kelas['nama_kelas'].'</option>';
                            	} ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Keterangan</label>
                            <input type="text" name="ket" class="form-control" />
                        </div>
                        <div class="form-group">
                            <input type="submit" name="simpan" value="Simpan" class="btn btn-success" />
                            <input type="reset" value="Reset" class="btn btn-danger" />
                        </div>
                    </form>
                    <?php
                    if(@$_POST['simpan']) {
                        $mapel = @mysqli_real_escape_string($db, $_POST['mapel']);
                        $kelas = @mysqli_real_escape_string($db, $_POST['kelas']);
                        $pengajar = @$_SESSION['pengajar'];
                        $ket = @mysqli_real_escape_string($db, $_POST['ket']);
                        mysqli_query($db, "INSERT INTO tb_mapel_ajar VALUES('', '$mapel', '$kelas', '$pengajar', '$ket')") or die ($db->error);
                        echo "<script>window.location='?page=mapel';</script>";
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
    } else if(@$_GET['action'] == 'edit') { ?>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Mata Pelajaran yang Anda Ajar &nbsp; <a href="?page=mapel" class="btn btn-warning btn-sm">Kembali</a></div>
                <div class="panel-body">
                    <form method="post">
	                    <?php
	                    $sql_mapel_ajar_id = mysqli_query($db, "SELECT * FROM tb_mapel_ajar JOIN tb_mapel ON tb_mapel_ajar.id_mapel = tb_mapel.id JOIN tb_kelas ON tb_mapel_ajar.id_kelas = tb_kelas.id_kelas WHERE tb_mapel_ajar.id = '$id'") or die ($db->error);
	                    $data_mapel_ajar_id = mysqli_fetch_array($sql_mapel_ajar_id);
	                    ?>
                        <div class="form-group">
                            <label>Mapel *</label>
                            <select name="mapel" class="form-control" required>
                            	<option value="<?php echo $data_mapel_ajar_id['id']; ?>"><?php echo $data_mapel_ajar_id['mapel']; ?></option>
                            	<option value="">- Pilih -</option>
                            	<?php
                            	$sql_mapel = mysqli_query($db, "SELECT * FROM tb_mapel") or die ($db->error);
                            	while($data_mapel = mysqli_fetch_array($sql_mapel)) {
                            		echo '<option value="'.$data_mapel['id'].'">'.$data_mapel['mapel'].'</option>';
                            	} ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kelas yang Anda Ajar *</label>
                            <select name="kelas" class="form-control" required>
                            	<option value="<?php echo $data_mapel_ajar_id['id_kelas']; ?>"><?php echo $data_mapel_ajar_id['nama_kelas']; ?></option>
                            	<option value="">- Pilih -</option>
                            	<?php
                            	$sql_kelas = mysqli_query($db, "SELECT * FROM tb_kelas_ajar JOIN tb_kelas ON tb_kelas_ajar.id_kelas = tb_kelas.id_kelas WHERE tb_kelas_ajar.id_pengajar = '$_SESSION[pengajar]'") or die ($db->error);
                            	while($data_kelas = mysqli_fetch_array($sql_kelas)) {
                            		echo '<option value="'.$data_kelas['id_kelas'].'">'.$data_kelas['nama_kelas'].'</option>';
                            	} ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Keterangan</label>
                            <input type="text" name="ket" value="<?php echo $data_mapel_ajar_id['keterangan']; ?>" class="form-control" />
                        </div>
                        <div class="form-group">
                            <input type="submit" name="edit" value="Simpan" class="btn btn-success" />
                            <input type="reset" value="Reset" class="btn btn-danger" />
                        </div>
                    </form>
                    <?php
                    if(@$_POST['edit']) {
                        $mapel = @mysqli_real_escape_string($db, $_POST['mapel']);
                        $kelas = @mysqli_real_escape_string($db, $_POST['kelas']);
                        $ket = @mysqli_real_escape_string($db, $_POST['ket']);
                        mysqli_query($db, "UPDATE tb_mapel_ajar SET id_mapel = '$mapel', id_kelas = '$kelas', keterangan = '$ket' WHERE id = '$id'") or die ($db->error);
                        echo "<script>window.location='?page=mapel';</script>";
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
    } else if(@$_GET['action'] == 'hapus') {
        mysqli_query($db, "DELETE FROM tb_mapel_ajar WHERE id = '$id'") or die ($db->error);  
        echo "<script>window.location='?page=mapel';</script>"; 
    }
    echo "</div>";

} ?>