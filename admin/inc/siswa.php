<?php
$no = 1;
$id = @$_GET['id'];

if(@$_SESSION['admin']) { ?>
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">Manajemenen Data Siswa</h1>
        </div>
    </div>
<?php
}

if(@$_GET['action'] == '') {

    if(@$_SESSION['admin']) { ?>
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-warning">
                    Admin tidak dapat mengedit data siswa. Admin hanya dapat mengaktifkan dan menonaktifkan serta menghapus akun siswa. Untuk mengedit data siswa yang berhak ialah siswa itu sendiri.
                </div>
            </div>
        </div>
    <?php
    } ?>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                <?php
                if(@$_GET['IDkelas'] == '') {
                    echo 'Data Siswa yang Aktif &nbsp; <a href="./laporan/cetak.php?data=siswa" target="_blank"></a>';
                } else if(@$_GET['IDkelas'] != '') {
                    echo "Data Siswa Per Kelas ".@$_GET['kelas']." yang Aktif &nbsp; <a href='?page=kelas' class='btn btn-warning btn-sm'>Kembali</a>";
                } ?>
                    
                </div>
                <div class="panel-body">
                	<div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="datasiswa">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>NIS</th>
                                    <th>Nama Lengkap</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Alamat</th>
                                    <th>Kelas</th>
                                    <?php if(@$_SESSION[admin]) { ?>
                                        <th>Status</th>
                                    <?php } ?>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php

                            if(@$_GET['IDkelas'] == '') {
                                $sql_siswa = mysqli_query($db, "SELECT * FROM tb_siswa JOIN tb_kelas ON tb_siswa.id_kelas = tb_kelas.id_kelas WHERE tb_siswa.status = 'aktif'") or die ($db->error);
                            } else if(@$_GET['IDkelas'] != '') {
                                $sql_siswa = mysqli_query($db, "SELECT * FROM tb_siswa JOIN tb_kelas ON tb_siswa.id_kelas = tb_kelas.id_kelas WHERE tb_siswa.status = 'aktif' AND tb_siswa.id_kelas = '$_GET[IDkelas]'") or die ($db->error);
                            }
                            
                            if(mysqli_num_rows($sql_siswa) > 0) {
    	                        while($data_siswa = mysqli_fetch_array($sql_siswa)) { ?>
    	                            <tr>
    	                                <td align="center"><?php echo $no++; ?></td>
    	                                <td><?php echo $data_siswa['nis']; ?></td>
    	                                <td><?php echo $data_siswa['nama_lengkap']; ?></td>
    	                                <td><?php echo $data_siswa['jenis_kelamin']; ?></td>
    	                                <td><?php echo $data_siswa['alamat']; ?></td>
                                        <td align="center"><?php echo $data_siswa['nama_kelas']; ?></td>
                                        <?php if(@$_SESSION[admin]) { ?>
        	                                <td><?php echo ucfirst($data_siswa['status']); ?></td>
                                        <?php } ?>
    	                                <td align="center">
                                            <?php if(@$_SESSION[admin]) { ?>
        	                                    <a href="?page=siswa&action=nonaktifkan&id=<?php echo $data_siswa['id_siswa']; ?>" class="badge" style="background-color:#f60;">Non aktifkan</a>
                                                <a onclick="return confirm('Yakin akan menghapus data ?');" href="?page=siswa&action=hapus&id=<?php echo $data_siswa['id_siswa']; ?>" class="badge" style="background-color:#f00;">Hapus</a>
                                            <?php } ?>
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
                        <script>
                        $(document).ready(function () {
                            $('#datasiswa').dataTable();
                        });
                        </script>
                    </div>
                </div>
            </div>
    	</div>
    </div>

<?php
} else if(@$_GET['action'] == 'nonaktifkan') {
    mysqli_query($db, "UPDATE tb_siswa SET status = 'tidak aktif' WHERE id_siswa = '$id'") or die ($db->error);
    echo "<script>window.location='?page=siswa';</script>";
} else if(@$_GET['action'] == 'hapus') {
    mysqli_query($db, "DELETE FROM tb_siswa WHERE id_siswa = '$id'") or die ($db->error);
    echo "<script>window.location='?page=siswa';</script>";
} else if(@$_GET['action'] == 'detail') {
    $sql_siswa_per_id = mysqli_query($db, "SELECT * FROM tb_siswa JOIN tb_kelas ON tb_siswa.id_kelas = tb_kelas.id_kelas WHERE id_siswa = '$_GET[IDsiswa]'") or die ($db->error);
    $data = mysqli_fetch_array($sql_siswa_per_id);
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Detail Data Siswa</div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table width="100%">
                            <tr>
                                <td align="right" width="46%"><b>NIS</b></td>
                                <td align="center">:</td>
                                <td width="46%"><?php echo $data['nis']; ?></td>
                            </tr>
                            <tr>
                                <td align="right"><b>Nama Lengkap</b></td>
                                <td align="center">:</td>
                                <td><?php echo $data['nama_lengkap']; ?></td>
                            </tr>
                            <tr>
                                <td align="right"><b>Tempat Tanggal Lahir</b></td>
                                <td align="center">:</td>
                                <td><?php echo $data['tempat_lahir'].", ".tgl_indo($data['tgl_lahir']); ?></td>
                            </tr>
                            <tr>
                                <td align="right"><b>Jenis Kelamin</b></td>
                                <td align="center">:</td>
                                <td><?php if($data['jenis_kelamin'] == 'L') { echo "Laki-laki"; } else { echo "Perempuan"; } ?></td>
                            </tr>
                            <tr>
                                <td align="right"><b>Agama</b></td>
                                <td align="center">:</td>
                                <td><?php echo $data['agama']; ?></td>
                            </tr>
                            <tr>
                                <td align="right"><b>Nama Ayah</b></td>
                                <td align="center">:</td>
                                <td><?php echo $data['nama_ayah']; ?></td>
                            </tr>
                            <tr>
                                <td align="right"><b>Nama Ibu</b></td>
                                <td align="center">:</td>
                                <td><?php echo $data['nama_ibu']; ?></td>
                            </tr>
                            <tr>
                                <td align="right"><b>Nomor Telepon</b></td>
                                <td align="center">:</td>
                                <td><?php echo $data['no_telp']; ?></td>
                            </tr>
                            <tr>
                                <td align="right"><b>Email</b></td>
                                <td align="center">:</td>
                                <td><?php echo $data['email']; ?></td>
                            </tr>
                            <tr>
                                <td align="right"><b>Alamat</b></td>
                                <td align="center">:</td>
                                <td><?php echo $data['alamat']; ?></td>
                            </tr>
                            <tr>
                                <td align="right"><b>Kelas</b></td>
                                <td align="center">:</td>
                                <td><?php echo $data['nama_kelas']; ?></td>
                            </tr>
                            <tr>
                                <td align="right"><b>Tahun Masuk</b></td>
                                <td align="center">:</td>
                                <td><?php echo $data['thn_masuk']; ?></td>
                            </tr>
                            <tr>
                                <td align="right" valign="top"><b>Foto</b></td>
                                <td align="center" valign="top">:</td>
                                <td>
                                    <div style="padding:10px 0;"><img width="250px" src="../img/foto_siswa/<?php echo $data['foto']; ?>" /></div>
                                </td>
                            </tr>
                            <?php if(@$_SESSION[admin]) { ?>
                                <tr>
                                    <td align="right"><b>Username</b></td>
                                    <td align="center">:</td>
                                    <td><?php echo $data['username']; ?></td>
                                </tr>
                                <tr>
                                    <td align="right"><b>Password</b></td>
                                    <td align="center">:</td>
                                    <td><?php echo $data['pass']; ?></td>
                                </tr>
                                <tr>
                                    <td align="right"><b>Status</b></td>
                                    <td align="center">:</td>
                                    <td><?php echo ucfirst($data['status']); ?></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
}
