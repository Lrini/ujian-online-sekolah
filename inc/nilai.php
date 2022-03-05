<div class="row">
    <div class="col-md-12">
        <h4 class="page-head-line">Nilai</h4>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <?php
            $no = 1;
            $sql_cek_nilai_pilgan = mysqli_query($db, "SELECT * FROM tb_nilai_pilgan JOIN tb_topik_quiz ON tb_nilai_pilgan.id_tq = tb_topik_quiz.id_tq JOIN tb_mapel ON tb_topik_quiz.id_mapel = tb_mapel.id WHERE id_siswa = '$_SESSION[siswa]'") or die ($db->error);
            ?>
            <div class="panel-heading">Data Nilai Ujian Anda &nbsp;<!-- <?php if(mysqli_num_rows($sql_cek_nilai_pilgan) > 0) { ?><a href="./admin/laporan/cetak.php?data=nilaipersiswa" target="_blank" class="btn btn-default btn-sm">Cetak Nilai</a><?php } ?>--></div>
            <div class="panel-body">
                <div class="table-responsive">
                	<table class="table table-striped table-bordered table-hover">
                		<tr>
                			<th>#</th>
                			<th>Mata Pelajaran</th>
                			<th>Judul Ujian</th>
                			<th>Presentase Nilai Pilihan Ganda</th>
                			<th>Presentase Nilai Essay</th>
                			<th>Nilai Total</th>
                		</tr>
                		<?php
                		if(mysqli_num_rows($sql_cek_nilai_pilgan) > 0) {
                			while($data_nilai_pilgan = mysqli_fetch_array($sql_cek_nilai_pilgan)) { ?>
                				<tr>
	                				<td><?php echo $no++; ?></td>
                					<td><?php echo $data_nilai_pilgan['mapel']; ?></td>
                					<td><?php echo $data_nilai_pilgan['judul']; ?></td>
                					<td>
                                        Benar : <?php echo $data_nilai_pilgan['benar']; ?> soal<br />
                                        Salah : <?php echo $data_nilai_pilgan['salah']; ?> soal<br />
                                        Tidak dikerjakan : <?php echo $data_nilai_pilgan['tidak_dikerjakan']; ?> soal<br />
                                        Presentase : <?php echo $data_nilai_pilgan['presentase']; ?>
                                    </td>
                					<?php
                					$sql_cek_jawaban = mysqli_query($db, "SELECT * FROM tb_jawaban WHERE id_tq = '$data_nilai_pilgan[id_tq]' AND id_siswa = '$_SESSION[siswa]'") or die ($db->error);
                					$data_jawaban = mysqli_fetch_array($sql_cek_jawaban);
                					if(mysqli_num_rows($sql_cek_jawaban) > 0) {
                						$sql_cek_nilai_essay = mysqli_query($db, "SELECT * FROM tb_nilai_essay WHERE id_tq = '$data_nilai_pilgan[id_tq]' AND id_siswa = '$_SESSION[siswa]'") or die ($db->error);
                						$data_nilai_essay = mysqli_fetch_array($sql_cek_nilai_essay);
                						if(mysqli_num_rows($sql_cek_nilai_essay) > 0) { ?>
                							<td><?php  echo $data_nilai_essay['nilai']; ?></td>
                							<td><?php echo ($data_nilai_pilgan['presentase']+$data_nilai_essay['nilai'])/2; ?></td>
                							<?php
                						} else {
                							echo "<td>Soal essay belum dikoreksi</td>";
                							echo "<td>Menunggu soal essay dikoreksi</td>";
                						}
                					} else { ?>
										<td>Ujian ini tidak ada soal essay</td>
										<td><?php echo $data_nilai_pilgan['presentase']; ?></td>
                					<?php
                					} ?>
                				</tr>
                			<?php
	                		}
                		} else {
                            echo '<tr><td colspan="6" align="center">Tidak ada data nilai, mungkin Anda belum mengikuti ujian</td></tr>';
                        } ?>
                	</table>
               	</div>
            </div>
        </div>
    </div>
</div>