<?php
error_reporting(E_ALL);
if(@$_GET['hal'] == 'essay') { ?>
    <div class="row">
    	<div class="panel panel-default">
    	    <div class="panel-heading">
    	        Koreksi Jawaban Essay &nbsp; <a onclick="self.history.back();" class="btn btn-warning btn-sm">Kembali</a>
    	    </div>
            <form action="" method="post">
    	    <div class="panel-body">
                <div class="table-responsive">
                    <table width="100%">
                        <?php
                        $urut = 1;
                        $sqlFoo = "SELECT tj.id_siswa, 
                            tse.id_essay, 
                            tse.pertanyaan, tj.jawaban
                        	FROM tb_soal_essay tse
                            LEFT JOIN tb_jawaban tj 
                                ON tj.id_soal = tse.id_essay AND tj.id_siswa = $_GET[id_siswa]
                            WHERE tse.id_tq = $id_tq";
                        $sql_jawaban = mysqli_query($db, $sqlFoo) or die ($db->error);
                        $jumlah_soal = mysqli_num_rows($sql_jawaban);
                        while($data_jawaban = mysqli_fetch_array($sql_jawaban)) { ?>
                            <tr>
                                <td width="10%" valign="top">( <?php echo $no++; ?> )</td>
                                <td>
                                    <table class="table">
                                        <tr>
                                            <td><b>Pertanyaan :</b></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo htmlentities ($data_jawaban['pertanyaan'], ENT_COMPAT, 'UTF-8'); ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Jawaban :</b></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo htmlentities($data_jawaban['jawaban'], ENT_COMPAT, 'UTF-8'); ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Presentase nilai tiap soal :</b></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label class="radio-inline">
                                                    <input type="radio" name="nilai_essay[<?php echo $urut++; ?>]" value="10">10
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="nilai_essay[<?php echo $urut++; ?>]" value="20">20
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="nilai_essay[<?php echo $urut++; ?>]" value="30">30
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="nilai_essay[<?php echo $urut++; ?>]" value="40">40
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="nilai_essay[<?php echo $urut++; ?>]" value="50">50
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="nilai_essay[<?php echo $urut++; ?>]" value="60">60
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="nilai_essay[<?php echo $urut++; ?>]" value="70">70
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="nilai_essay[<?php echo $urut++; ?>]" value="80">80
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="nilai_essay[<?php echo $urut++; ?>]" value="90">90
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="nilai_essay[<?php echo $urut++; ?>]" value="100">100
                                                </label>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        <?php
                        } ?>
                    </table>
                </div>
            </div>
            <div class="panel-footer">
                <input type="submit" name="simpan_koreksi" value="Simpan" class="btn btn-primary btn-sm" />
                <input type="reset" value="Reset" class="btn btn-danger btn-sm" />
            </div>
            </form>
            <?php
            $nilai = 0;
            if(@$_POST['simpan_koreksi']) {
                foreach(@$_POST['nilai_essay'] as $key => $value) {
                    $nilai = $nilai + $value;
                }
                $nilai_total = $nilai / $jumlah_soal;
                mysqli_query($db, "INSERT INTO tb_nilai_essay VALUES('', '$id_tq', '$_GET[id_siswa]', '$nilai_total')") or die ($db->error);
                echo "<script>window.location='?page=quiz&action=pesertakoreksi&id_tq=".$id_tq."';</script>";
            }
            ?>
    	</div>
    </div>
<?php
} else if(@$_GET['hal'] == 'editessay') { ?>
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                Edit Koreksi Jawaban Essay &nbsp; <a onclick="self.history.back();" class="btn btn-warning btn-sm">Kembali</a>
            </div>
            <form action="" method="post">
            <div class="panel-body">
                <div class="table-responsive">
                    <table width="100%">
                        <?php
                        $urut = 1;
                        $sqlFoo = "SELECT tj.id_siswa, 
                            tse.id_essay, 
                            tse.pertanyaan, tj.jawaban
                        	FROM tb_soal_essay tse
                            LEFT JOIN tb_jawaban tj 
                                ON tj.id_soal = tse.id_essay AND tj.id_siswa = $_GET[id_siswa]
                            WHERE tse.id_tq = $id_tq";
                        $sql_jawaban = mysqli_query($db, $sqlFoo) or die ($db->error);
                        $jumlah_soal = mysqli_num_rows($sql_jawaban);
                        $fucking_duplicates = [];
                        while($data_jawaban = mysqli_fetch_array($sql_jawaban)) { 
                            if (in_array($data_jawaban['id_essay'], $fucking_duplicates)) {
                                continue;
                            }
                            array_push($fucking_duplicates, $data_jawaban['id_essay']);
                            ?>
                            <tr>
                                <td width="10%" valign="top">( <?php echo $no++; ?> )</td>
                                <td>
                                    <table class="table">
                                        <tr>
                                            <td><b>Pertanyaan :</b></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo $data_jawaban['pertanyaan']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Jawaban :</b></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo $data_jawaban['jawaban']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Presentase tiap soal <small>(Untuk mengedit silahkan pilih ulang nilainya)</small> :</b></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label class="radio-inline">
                                                    <input type="radio" name="nilai_essay[<?php echo $urut++; ?>]" value="10">10
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="nilai_essay[<?php echo $urut++; ?>]" value="20">20
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="nilai_essay[<?php echo $urut++; ?>]" value="30">30
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="nilai_essay[<?php echo $urut++; ?>]" value="40">40
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="nilai_essay[<?php echo $urut++; ?>]" value="50">50
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="nilai_essay[<?php echo $urut++; ?>]" value="60">60
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="nilai_essay[<?php echo $urut++; ?>]" value="70">70
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="nilai_essay[<?php echo $urut++; ?>]" value="80">80
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="nilai_essay[<?php echo $urut++; ?>]" value="90">90
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="nilai_essay[<?php echo $urut++; ?>]" value="100">100
                                                </label>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        <?php
                        } ?>
                    </table>
                </div>
            </div>
            <div class="panel-footer">
                <input type="submit" name="simpan_koreksi" value="Simpan" class="btn btn-primary btn-sm" />
                <input type="reset" value="Reset" class="btn btn-danger btn-sm" />
            </div>
            </form>
            <?php
            $nilai = 0;
            if(@$_POST['simpan_koreksi']) {
                foreach(@$_POST['nilai_essay'] as $key => $value) {
                    $nilai = $nilai + $value;
                }
                $nilai_total = $nilai / $jumlah_soal;
                mysqli_query($db, "UPDATE tb_nilai_essay SET nilai = '$nilai_total' WHERE id = '$_GET[id_nilai]'") or die ($db->error);
                echo "<script>window.location='?page=quiz&action=pesertakoreksi&id_tq=".$id_tq."';</script>";
            }
            ?>
        </div>
    </div>
<?php
} ?>