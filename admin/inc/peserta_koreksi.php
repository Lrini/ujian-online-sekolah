<div class="row">
	<div class="panel panel-default">
	    <div class="panel-heading">
	        Data Siswa yang Mengikuti Ujian &nbsp; <a href="?page=quiz" class="btn btn-danger btn-sm">Kembali</a>
	    </div>
	    <div class="panel-body">
            <div class="table-responsive">
				<table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Status Hasil</th>
                            <th>Nilai Total</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
					<?php
					$sql_siswa_mengikuti_tes = mysqli_query($db, "SELECT * FROM tb_nilai_pilgan JOIN tb_siswa ON tb_nilai_pilgan.id_siswa = tb_siswa.id_siswa JOIN tb_kelas ON tb_siswa.id_kelas = tb_kelas.id_kelas WHERE id_tq = '$id_tq'") or die ($db->error);
                    if(mysqli_num_rows($sql_siswa_mengikuti_tes) > 0) {
    					while($data_siswa_mengikuti_tes = mysqli_fetch_array($sql_siswa_mengikuti_tes)) {
    						?>
                            <tr>
                                <td align="center" width="40px"><?php echo $no++; ?></td>
                                <td><?php echo $data_siswa_mengikuti_tes['nama_lengkap']; ?></td>
                                <td><?php echo $data_siswa_mengikuti_tes['nama_kelas']; ?></td>
                            	<?php
                            	$sql_pilgan = mysqli_query($db, "SELECT * FROM tb_nilai_pilgan WHERE id_siswa = '$data_siswa_mengikuti_tes[id_siswa]' AND id_tq = '$id_tq'") or die ($db->error);
                            	$data_pilgan = mysqli_fetch_array($sql_pilgan);
                                $sql_jwb = mysqli_query($db, "SELECT * FROM tb_jawaban WHERE id_siswa = '$data_siswa_mengikuti_tes[id_siswa]' AND id_tq = '$id_tq'") or die ($db->error);
                            	$sql_essay = mysqli_query($db, "SELECT * FROM tb_nilai_essay WHERE id_siswa = '$data_siswa_mengikuti_tes[id_siswa]' AND id_tq = '$id_tq'") or die ($db->error);
                            	$data_essay = mysqli_fetch_array($sql_essay);
                            	?>
                            	<td>
                            		Nilai soal pilihan ganda : <?php echo $data_pilgan['presentase']; ?><br />
                            		Nilai soal essay : 
                            		<?php
                                    if(mysqli_num_rows($sql_jwb) > 0) {
                                		if(mysqli_num_rows($sql_essay) > 0) {
                                			echo $data_essay['nilai'];
                                		} else {
                                			echo "(belum dikoreksi)";
                                		}
                                    } else {
                                        echo "Ujian ini tidak ada soal essay";
                                    } ?>
                            	</td>
                                <?php
                                $sql_cek_jawaban = mysqli_query($db, "SELECT * FROM tb_jawaban WHERE id_tq = '$_GET[id_tq]'") or die ($db->error);
                                    $data_jawaban = mysqli_fetch_array($sql_cek_jawaban);
                                if(mysqli_num_rows($sql_cek_jawaban) > 0) {
                                    if(mysqli_num_rows($sql_essay) > 0) { ?>
                                        <td><?php echo ($data_pilgan['presentase'] + $data_essay['nilai']) / 2; ?></td>
                                        <?php
                                    } else {
                                        echo "<td>Menunggu soal essay dikoreksi</td>";
                                    }
                                } else { ?>
                                    <td><?php echo $data_pilgan['presentase']; ?></td>
                                <?php
                                } ?>
                                <td align="center" width="220px">
                                    <?php
                                    if(mysqli_num_rows($sql_jwb) > 0) {
                                        if(mysqli_num_rows($sql_essay) > 0) { ?>
                                            <a href="?page=quiz&action=koreksi&hal=editessay&id_tq=<?php echo $id_tq; ?>&id_siswa=<?php echo $data_siswa_mengikuti_tes['id_siswa']; ?>&id_nilai=<?php echo $data_essay['id']; ?>" class="badge" style="background-color:#f60;">Edit Koreksi Essay</a>
                                        <?php
                                        } else { ?>
                                            <a href="?page=quiz&action=koreksi&hal=essay&id_tq=<?php echo $id_tq; ?>&id_siswa=<?php echo $data_siswa_mengikuti_tes['id_siswa']; ?>" class="badge" style="background-color:#f60;">Koreksi Jawaban Essay</a>
                                        <?php
                                        }
                                    } ?>
                                    <a onclick="return confirm('Yakin akan menghapus siswa ini dari daftar peserta ujian?');" href="?page=quiz&action=hapuspeserta&id_tq=<?php echo $id_tq; ?>&id_siswa=<?php echo $data_siswa_mengikuti_tes['id_siswa']; ?>" class="badge" style="background-color:#f00;">Hapus Siswa dari Peserta Ujian</a>
                                </td>
                            </tr>
    					<?php
    					}
                    } else {
                        echo '<tr><td colspan="6" align="center">Data tidak ditemukan</td></tr>';
                    } ?>
                    </tbody>
                </table>
                <?php if(mysqli_num_rows($sql_siswa_mengikuti_tes) > 0) { ?>
                    <a href="./laporan/cetak.php?data=quiz&id_tq=<?php echo $id_tq; ?>" target="_blank" class="btn btn-default btn-sm">Cetak</a>
                <?php } ?>
            </div>
        </div>
	</div>
</div>