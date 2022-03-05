<div class="row">
    <div class="col-md-12">
        <h1 class="page-header">Manajemen Tugas / Quiz</h1>
    </div>
</div>

<?php
$id = @$_GET['id'];
$id_tq = @$_GET['id_tq'];
$no = 1;
if(@$_SESSION[admin]) {
    $sql_topik = mysqli_query($db, "SELECT * FROM tb_topik_quiz JOIN tb_kelas ON tb_topik_quiz.id_kelas = tb_kelas.id_kelas JOIN tb_mapel ON tb_topik_quiz.id_mapel = tb_mapel.id ORDER BY tgl_buat DESC") or die ($db->error);
    $pembuat = "admin";
} else if(@$_SESSION[pengajar]) {
    $sql_topik = mysqli_query($db, "SELECT * FROM tb_topik_quiz JOIN tb_kelas ON tb_topik_quiz.id_kelas = tb_kelas.id_kelas JOIN tb_mapel ON tb_topik_quiz.id_mapel = tb_mapel.id WHERE pembuat != 'admin' AND pembuat = '$_SESSION[pengajar]' ORDER BY tgl_buat DESC") or die ($db->error);
    $pembuat = @$_SESSION['pengajar'];
} 

if(@$_GET['action'] == '') { ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Daftar Topik Quiz / Tugas &nbsp; <a href="?page=quiz&action=tambah" class="btn btn-primary btn-sm">Tambah Topik</a> &nbsp; <!--<a href="./laporan/cetak.php?data=topikquiz" target="_blank" class="btn btn-default btn-sm">Cetak</a>--></div>
                <div class="panel-body">
                    <div class="table-responsive">                        
                        <table class="table table-striped table-bordered table-hover" id="dataquiz">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Judul</th>
                                    <th>Kelas</th>
                                    <th>Mapel</th>
                                    <th>Tanggal Pembuatan</th>
                                    <?php
                                    if(@$_SESSION['admin']) {
                                        echo "<th>Pembuat</th>";
                                    } ?>
                                    <th>Waktu</th>
                                    <th>Info</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            if(mysqli_num_rows($sql_topik) > 0) {
                                while($data_topik = mysqli_fetch_array($sql_topik)) { ?>
                                    <tr>
                                        <td align="center"><?php echo $no++; ?></td>
                                        <td><?php echo $data_topik['judul']; ?></td>
                                        <td align="center"><?php echo $data_topik['nama_kelas']; ?></td>
                                        <td><?php echo $data_topik['mapel']; ?></td>
                                        <td><?php echo tgl_indo($data_topik['tgl_buat']); ?></td>
                                        <?php
                                        if(@$_SESSION['admin']) {
                                            if($data_topik['pembuat'] == 'admin') {
                                                echo "<td>Admin</td>";
                                            } else {
                                                $sql1 = mysqli_query($db, "SELECT * FROM tb_pengajar WHERE id_pengajar = '$data_topik[pembuat]'") or die($db->error);
                                                $data1 = mysqli_fetch_array($sql1);
                                                echo "<td>".$data1['nama_lengkap']."</td>";
                                            }
                                        } ?>
                                        <td><?php echo $data_topik['waktu_soal'] / 60 ." menit"; ?></td>
                                        <td><?php echo $data_topik['info']; ?></td>
                                        <td align="center"><?php echo ucfirst($data_topik['status']); ?></td>
                                        <td align="center">
                                            <a href="?page=quiz&action=edit&id=<?php echo $data_topik['id_tq']; ?>" class="badge" style="background-color:#f60;">Edit</a>
                                            <a onclick="return confirm('Hati-hati saat menghapus topik quiz karena Anda akan menghapus semua data yang berhubungan dengan topik ini, termasuk data soal dan nilai. Apakah Anda tetap yakin akan menghapus topik ini?');" href="?page=quiz&action=hapus&id_tq=<?php echo $data_topik['id_tq']; ?>" class="badge" style="background-color:#f00;">Hapus</a>
                                            <br /><a href="?page=quiz&action=buatsoal&id=<?php echo $data_topik['id_tq']; ?>" class="badge">Buat Soal</a>
                                            <a href="?page=quiz&action=daftarsoal&id=<?php echo $data_topik['id_tq']; ?>" class="badge">Daftar Soal</a>
                                            <a href="?page=quiz&action=pesertakoreksi&id_tq=<?php echo $data_topik['id_tq']; ?>" class="badge">Peserta & Koreksi</a>
                                        </td>
                                    </tr>
                                <?php
                                }
                            } else {
                            	echo '<td colspan="9" align="center">Tidak ada data</td>';
                        	} ?>
                            </tbody>
                        </table>
                        <script>
                        $(document).ready(function () {
                            $('#dataquiz').dataTable();
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
                <div class="panel-heading">Tambah Tugas / Quiz &nbsp; <a href="?page=quiz" class="btn btn-warning btn-sm">Kembali</a></div>
                <div class="panel-body">
                    <form method="post">
                        <div class="form-group">
                            <label>Judul *</label>
                            <input type="text" id="judul" name="judul" class="form-control" placeholder="Ex: Ulangan Harian 1" required />
                        </div>
                        <div class="form-group">
                            <label>Kelas *</label>                            
                            <div class="wadah_kelas">
                                <div id="ke-1">
                                <select name="kelas" class="form-control x">
                                    <option value="">- Pilih -</option>
                                    <?php
                                    $sql_kelas = mysqli_query($db, "SELECT * FROM tb_kelas") or die ($db->error);
                                    while($data_kelas = mysqli_fetch_array($sql_kelas)) {
                                        echo '<option value="'.$data_kelas['id_kelas'].'">'.$data_kelas['nama_kelas'].'</option>';
                                    } ?>
                                </select>
                                </div>
                                <a style="margin:3px 0 4px 0;" class="tambah_kelas btn btn-primary btn-xs">Tambah Kelas Lain</a> <small><i>(Klik button untuk menambahkan kelas lain, max. 10 kelas)</i></small>
                            </div>
                            <a href="" style="margin:2px 0; display:none;" class="del-kls btn btn-danger btn-xs">Delete Kelas Lain</a>
                        </div>
                        <div class="form-group">
                            <label>Mapel *</label>
                            <select id="mapel" name="mapel" class="form-control" required>
                                <option value="">- Pilih -</option>
                                <?php
                                $sql_mapel = mysqli_query($db, "SELECT * FROM tb_mapel") or die ($db->error);
                                while($data_mapel = mysqli_fetch_array($sql_mapel)) {
                                    echo '<option value="'.$data_mapel['id'].'">'.$data_mapel['mapel'].'</option>';
                                } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Pembuatan *</label>
                            <input type="date" id="tgl_buat" name="tgl_buat" value="<?php echo date('Y-m-d'); ?>" class="form-control" required />
                        </div>
                        <div class="form-group">
                            <label>Waktu Soal * <sub>(dalam menit)</sub></label>
                            <input type="text" id="waktu_soal" name="waktu_soal" class="form-control" required />
                        </div>
                        <div class="form-group">
                            <label>Info</label>
                            <textarea name="info" id="info" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="aktif">Aktif</option>
                                <option value="tidak aktif">Tidak Aktif</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <a class="save btn btn-success">Simpan</a>
                            <!-- <input type="submit" id="simpan" name="simpan" value="Simpan" class="btn btn-success" /> -->
                            <input type="reset" value="Reset" class="btn btn-danger" />
                        </div>
                    </form>
                    <div id="hasil"></div>
                    <?php
                    $isikelas = null;
                    $sql_kelas = mysqli_query($db, "SELECT * FROM tb_kelas") or die ($db->error);
                    while($data_kelas = mysqli_fetch_array($sql_kelas)) {
                        $isikelas .= '<option value="'.$data_kelas['id_kelas'].'">'.$data_kelas['nama_kelas'].'</option>';;
                    }
                    $isikelas2 = $isikelas;
                    ?>
                    <script type="text/javascript">
                    $(document).ready(function() {
                        var ke =  1;
                        var x = 1;
                        $(".tambah_kelas").click(function(e){ //on add input button click
                            e.preventDefault();
                            if(x < 10){ //max input box allowed
                                x++;
                                ke++;
                                $(".wadah_kelas").append('<div id="ke-'+ke+'"><select style="margin-bottom:2px;" name="kelas" class="form-control x"><option value="">- Pilih -</option><?php echo $isikelas2; ?></select> <div>'); //add input box
                            }
                            $(".del-kls").fadeIn();
                        });
                        
                        $(".wadah_kelas").on("click",".del", function(e){ //user click on remove text
                            e.preventDefault(); $(this).parent('div').remove(); x--;
                        });
                    });

                    $(".save").click(function() {
                        var judul = $("#judul").val();
                        var mapel = $("#mapel").val();
                        var tgl_buat = $("#tgl_buat").val();
                        var waktu_soal = $("#waktu_soal").val();
                        var info = $("#info").val();
                        var status = $("#status").val();
                        var pembuat = "<?php echo $pembuat; ?>";
                        var ke =  $('.wadah_kelas > div > select').length;
                        for(var i = 1; i <= ke; i++) {
                            var kelas = $("#ke-"+i+" > select.x").val();
                            $.ajax({
                                url : 'inc/save_quiz.php',
                                type : 'post',
                                data : 'judul='+judul+'&mapel='+mapel+'&tgl_buat='+tgl_buat+'&waktu_soal='+waktu_soal+'&info='+info+'&status='+status+'&pembuat='+pembuat+'&kelas='+kelas,
                                success : function(msg) {
                                    $("#hasil").html(msg);
                                }
                            });
                        }
                    });
                    </script>
                </div>
            </div>
        </div>
    </div>
    <?php
} else if(@$_GET['action'] == 'edit') { ?>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Tugas / Quiz &nbsp; <a href="?page=quiz" class="btn btn-warning btn-sm">Kembali</a></div>
                <div class="panel-body">
                <?php
                $sql_topik_id = mysqli_query($db, "SELECT * FROM tb_topik_quiz JOIN tb_kelas ON tb_topik_quiz.id_kelas = tb_kelas.id_kelas JOIN tb_mapel ON tb_topik_quiz.id_mapel = tb_mapel.id WHERE id_tq = '$id'") or die ($db->error);
                $data_topik_id = mysqli_fetch_array($sql_topik_id);
                ?>
                    <form method="post">
                        <div class="form-group">
                            <label>Judul *</label>
                            <input type="text" name="judul" value="<?php echo $data_topik_id['judul']; ?>" class="form-control" required />
                        </div>
                        <div class="form-group">
                            <label>Kelas *</label>
                            <select name="kelas" class="form-control" required>
                                <option value="<?php echo $data_topik_id['id_kelas']; ?>"><?php echo $data_topik_id['nama_kelas']; ?></option>
                                <option value="">- Pilih -</option>
                                <?php
                                $sql_kelas = mysqli_query($db, "SELECT * FROM tb_kelas") or die ($db->error);
                                while($data_kelas = mysqli_fetch_array($sql_kelas)) {
                                    echo '<option value="'.$data_kelas['id_kelas'].'">'.$data_kelas['nama_kelas'].'</option>';
                                } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Mapel *</label>
                            <select name="mapel" class="form-control" required>
                                <option value="<?php echo $data_topik_id['id_mapel']; ?>"><?php echo $data_topik_id['mapel']; ?></option>
                                <option value="">- Pilih -</option>
                                <?php
                                $sql_mapel = mysqli_query($db, "SELECT * FROM tb_mapel") or die ($db->error);
                                while($data_mapel = mysqli_fetch_array($sql_mapel)) {
                                    echo '<option value="'.$data_mapel['id'].'">'.$data_mapel['mapel'].'</option>';
                                } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Pembuatan *</label>
                            <input type="date" name="tgl_buat" value="<?php echo $data_topik_id['tgl_buat']; ?>" class="form-control" required />
                        </div>
                        <div class="form-group">
                            <label>Waktu Soal * <sub>(dalam menit)</sub></label>
                            <input type="text" name="waktu_soal" value="<?php echo $data_topik_id['waktu_soal'] / 60; ?>" class="form-control" required />
                        </div>
                        <div class="form-group">
                            <label>Info</label>
                            <textarea name="info" class="form-control" rows="3"><?php echo $data_topik_id['info']; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="aktif">Aktif</option>
                                <option value="tidak aktif" <?php if($data_topik_id['status'] == 'tidak aktif') { echo "selected"; } ?>>Tidak Aktif</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="simpan" value="Simpan" class="btn btn-success" />
                            <input type="reset" value="Reset" class="btn btn-danger" />
                        </div>
                    </form>
                    <?php
                    if(@$_POST['simpan']) {
                        $judul = @mysqli_real_escape_string($db, $_POST['judul']);
                        $kelas = @mysqli_real_escape_string($db, $_POST['kelas']);
                        $mapel = @mysqli_real_escape_string($db, $_POST['mapel']);
                        $tgl_buat = @mysqli_real_escape_string($db, $_POST['tgl_buat']);
                        $waktu_soal = @mysqli_real_escape_string($db, $_POST['waktu_soal']) * 60;
                        $info = @mysqli_real_escape_string($db, $_POST['info']);
                        $status = @mysqli_real_escape_string($db, $_POST['status']);
                        mysqli_query($db, "UPDATE tb_topik_quiz SET judul = '$judul', id_kelas = '$kelas', id_mapel = '$mapel', tgl_buat = '$tgl_buat', pembuat = '$pembuat', waktu_soal = '$waktu_soal', info = '$info', status = '$status' WHERE id_tq = '$id'") or die ($db->error);
                        echo "<script>window.location='?page=quiz';</script>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php
} else if(@$_GET['action'] == 'hapus') {
    mysqli_query($db, "DELETE FROM tb_topik_quiz WHERE id_tq = '$_GET[id_tq]'") or die ($db->error);
    mysqli_query($db, "DELETE FROM tb_soal_pilgan WHERE id_tq = '$_GET[id_tq]'") or die ($db->error);
    mysqli_query($db, "DELETE FROM tb_soal_essay WHERE id_tq = '$_GET[id_tq]'") or die ($db->error);
    mysqli_query($db, "DELETE FROM tb_jawaban WHERE id_tq = '$_GET[id_tq]'") or die ($db->error);
    mysqli_query($db, "DELETE FROM tb_nilai_pilgan WHERE id_tq = '$_GET[id_tq]'") or die ($db->error);
    mysqli_query($db, "DELETE FROM tb_nilai_essay WHERE id_tq = '$_GET[id_tq]'") or die ($db->error);
    echo "<script>window.location='?page=quiz';</script>";
} else if(@$_GET['action'] == 'buatsoal') {
    include "buat_soal.php";
} else if(@$_GET['action'] == 'daftarsoal') {
    include "daftar_soal.php";
} else if(@$_GET['action'] == 'pesertakoreksi') {
    include "peserta_koreksi.php";
} else if(@$_GET['action'] == 'koreksi') {
    include "koreksi.php";
} else if(@$_GET['action'] == 'hapuspeserta') {
    mysqli_query($db, "DELETE FROM tb_jawaban WHERE id_tq = '$_GET[id_tq]' AND id_siswa = '$_GET[id_siswa]'") or die ($db->error);
    mysqli_query($db, "DELETE FROM tb_nilai_pilgan WHERE id_tq = '$_GET[id_tq]' AND id_siswa = '$_GET[id_siswa]'") or die ($db->error);
    mysqli_query($db, "DELETE FROM tb_nilai_essay WHERE id_tq = '$_GET[id_tq]' AND id_siswa = '$_GET[id_siswa]'") or die ($db->error);
    echo "<script>window.location='?page=quiz&action=pesertakoreksi&id_tq=".@$_GET['id_tq']."';</script>";
} ?>