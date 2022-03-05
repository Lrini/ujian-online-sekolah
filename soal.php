<?php
@session_start();
include "+koneksi.php";

$id_tq = @$_GET['id_tq'];
$no = 1;
$no2 = 1;
$sql_tq = mysqli_query($db, "SELECT * FROM tb_topik_quiz JOIN tb_mapel ON tb_topik_quiz.id_mapel = tb_mapel.id WHERE id_tq = '$id_tq'") or die ($db->error);
$data_tq = mysqli_fetch_array($sql_tq);
?>
<script src="style/assets/js/jquery-1.11.1.js"></script>
<script src="style/assets/js/bootstrap.js"></script>
<script>
var waktunya;
waktunya = <?php echo $data_tq['waktu_soal']; ?>;
var waktu;
var jalan = 0;
var habis = 0;

function init(){
    checkCookie();
    mulai();
}
function keluar(){
    if(habis==0){
        setCookie('waktux',waktu,365);
    }else{
        setCookie('waktux',0,-1);
    }
}
function mulai(){
    jam = Math.floor(waktu/3600);
    sisa = waktu%3600;
    menit = Math.floor(sisa/60);
    sisa2 = sisa%60
    detik = sisa2%60;
    if(detik<10){
        detikx = "0"+detik;
    }else{
        detikx = detik;
    }
    if(menit<10){
        menitx = "0"+menit;
    }else{
        menitx = menit;
    }
    if(jam<10){
        jamx = "0"+jam;
    }else{
        jamx = jam;
    }
    document.getElementById("divwaktu").innerHTML = jamx+" Jam : "+menitx+" Menit : "+detikx +" Detik";
    waktu --;
    if(waktu>0){
        t = setTimeout("mulai()",1000);
        jalan = 1;
    }else{
        if(jalan==1){
            clearTimeout(t);
        }
        habis = 1;
        document.getElementById("kirim").click();
    }
}
function selesai(){    
    if(jalan==1){
        clearTimeout(t);
    }
    habis = 1;
}
function getCookie(c_name){
    if (document.cookie.length>0){
        c_start=document.cookie.indexOf(c_name + "=");
        if (c_start!=-1){
            c_start=c_start + c_name.length+1;
            c_end=document.cookie.indexOf(";",c_start);
            if (c_end==-1) c_end=document.cookie.length;
            return unescape(document.cookie.substring(c_start,c_end));
        }
    }
    return "";
}
function setCookie(c_name,value,expiredays){
    var exdate=new Date();
    exdate.setDate(exdate.getDate()+expiredays);
    document.cookie=c_name+ "=" +escape(value)+((expiredays==null) ? "" : ";expires="+exdate.toGMTString());
}
function checkCookie(){
    waktuy=getCookie('waktux');
    if (waktuy!=null && waktuy!=""){
        waktu = waktuy;
    }else{
        waktu = waktunya;
        setCookie('waktux',waktunya,7);
    }
}
</script>
<script type="text/javascript">
    window.history.forward();
    function noBack(){ window.history.forward(); }
</script>

<?php
if(@$_SESSION['siswa']) { ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>Ujian Online E-Learning SMK Indonesia</title>
    <link href="style/assets/css/bootstrap.css" rel="stylesheet" />
    <link href="style/assets/css/font-awesome.css" rel="stylesheet" />
    <link href="style/assets/css/style.css" rel="stylesheet" />
    <style type="text/css">
    .mrg-del {
        margin: 0;
        padding: 0;
    }
    </style>
</head>
<body onload="init(),noBack();" onpageshow="if (event.persisted) noBack();" onunload="keluar()">

<div class="navbar navbar-inverse set-radius-zero">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="./">
                <img src="style/assets/img/logo.png" />
            </a>
        </div>

        <div class="left-div">
            <div class="user-settings-wrapper">
                <ul class="nav">
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                            <span class="glyphicon glyphicon-user" style="font-size: 25px;"></span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="content-wrapper">
    <div class="container">
		<div class="row">
		    <div class="col-md-12">
		        <h4 class="page-head-line">Test : <u><?php echo $data_tq['judul']; ?></u><br />Mapel : <u><?php echo $data_tq['mapel']; ?></u></h4>
		    </div>
		</div>

		<div class="row">
			<div class="col-md-4">
		        <div class="panel panel-default">
		            <div class="panel-heading"><b>Info <small>(Sisa waktu Anda)</small></b></div>
		            <div class="panel-body">
			            <h3 align="center"><span id="divwaktu"></span></h3>
		            </div>
		        </div>
		    </div>

		    <div class="col-md-8">
		    	<form action="inc/proses_soal.php" method="post">
					<?php
                    $sql_soal_pilgan = mysqli_query($db, "SELECT * FROM tb_soal_pilgan WHERE id_tq = '$id_tq' ORDER BY rand()") or die ($db->error);
					if(mysqli_num_rows($sql_soal_pilgan) > 0) {
                    ?>
                        <div class="panel panel-default">
                            <div class="panel-heading"><b>Soal Pilihan Ganda</b></div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <?php
                                    while($data_soal_pilgan = mysqli_fetch_array($sql_soal_pilgan)) { ?>
        								<table class="table">
        							    	<tr>
        							    		<td width="10%">( <?php echo $no++; ?> )</td>
        							            <td><b><?php echo $data_soal_pilgan['pertanyaan']; ?></b></td>
        							        </tr>
                                            <?php if($data_soal_pilgan['gambar'] != '') { ?>
                                                <tr>
                                                    <td></td>
                                                    <td>
                                                        <img width="500px" src="admin/img/gambar_soal_pilgan/<?php echo $data_soal_pilgan['gambar']; ?>" />
                                                    </td>
                                                </tr>
                                            <?php } ?>
        							        <tr>
        							        	<td></td>
        							            <td>
                                                    <div class="radio mrg-del">
                                                        <label>
                                                            <input type="radio" name="soal_pilgan[<?php echo $data_soal_pilgan['id_pilgan']; ?>]" value="A" /> A. <?php echo $data_soal_pilgan['pil_a']; ?>
                                                        </label>
                                                    </div>
                                                </td>
        							        </tr>
        							        <tr>
        							        	<td></td>
        							            <td>
                                                    <div class="radio mrg-del">
                                                        <label>
                                                            <input type="radio" name="soal_pilgan[<?php echo $data_soal_pilgan['id_pilgan']; ?>]" value="B" /> B. <?php echo $data_soal_pilgan['pil_b']; ?>
                                                        </label>
                                                    </div>
                                                </td>
        							        </tr>
        							        <tr>
        							        	<td></td>
        							            <td>
                                                    <div class="radio mrg-del">
                                                        <label>
                                                            <input type="radio" name="soal_pilgan[<?php echo $data_soal_pilgan['id_pilgan']; ?>]" value="C" /> C. <?php echo $data_soal_pilgan['pil_c']; ?>
                                                        </label>
                                                    </div>
                                                </td>
        							        </tr>
        							        <tr>
        							        	<td></td>
        							            <td>
                                                    <div class="radio mrg-del">
                                                        <label>
                                                            <input type="radio" name="soal_pilgan[<?php echo $data_soal_pilgan['id_pilgan']; ?>]" value="D" /> D. <?php echo $data_soal_pilgan['pil_d']; ?>
                                                        </label>
                                                    </div>
                                                </td>
        							        </tr>
        							        <tr>
        							        	<td></td>
        							            <td>
                                                    <div class="radio mrg-del">
                                                        <label>
                                                            <input type="radio" name="soal_pilgan[<?php echo $data_soal_pilgan['id_pilgan']; ?>]" value="E" /> E. <?php echo $data_soal_pilgan['pil_e']; ?>
                                                        </label>
                                                    </div>
                                                </td>
        							        </tr>
        								</table>
                                    <?php
                                    } ?>
                                    <input type="hidden" name="jumlahsoalpilgan" value="<?php echo mysqli_num_rows($sql_soal_pilgan); ?>" />
    							</div>
    			            </div>
    			        </div>
                    <?php
                    }

                    $sql_soal_essay = mysqli_query($db, "SELECT * FROM tb_soal_essay WHERE id_tq = '$id_tq' ORDER BY rand()") or die ($db->error);
                    if(mysqli_num_rows($sql_soal_essay) > 0) {
                    ?>
                        <div class="panel panel-default">
                            <div class="panel-heading"><b>Soal Essay</b></div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <?php
                                    while($data_soal_essay = mysqli_fetch_array($sql_soal_essay)) { ?>
                                        <table class="table">
                                            <tr>
                                                <td width="10%">( <?php echo $no2++; ?> )</td>
                                                <td><b><?php echo $data_soal_essay['pertanyaan']; ?></b></td>
                                            </tr>
                                            <?php if($data_soal_essay['gambar'] != '') { ?>
                                                <tr>
                                                    <td></td>
                                                    <td>
                                                        <img width="660px" src="admin/img/gambar_soal_essay/<?php echo $data_soal_essay['gambar']; ?>" />
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                            <tr>
                                                <td>Jawab</td>
                                                <td>
                                                    <textarea name="soal_essay[<?php echo $data_soal_essay['id_essay']; ?>]" class="form-control" rows="3"></textarea>
                                                </td>
                                            </tr>
                                        </table>
                                    <?php
                                    } ?>
                                </div>
                            </div>
                        </div>
                    <?php
                    } ?>
                    
                    <input type="hidden" name="id_tq" value="<?php echo $id_tq; ?>" />

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div>
                                <a id="selesai" class="btn btn-info">Selesai</a>
                                <input type="reset" value="Reset Jawaban" class="btn btn-danger" />
                            </div>
                            <div id="konfirm" style="display:none; margin-top:15px;">
                                Apakah Anda yakin sudah selesai mengerjakan soal dan akan mengirim jawaban? &nbsp; <input onclick="selesai();" type="submit" id="kirim" value="Ya" class="btn btn-info btn-sm" />
                            </div>
                            <script type="text/javascript">
                            $("#selesai").click(function() {
                                $("#konfirm").fadeIn(1000);
                            });
                            </script>
                        </div>
                    </div>
		        </form>
		    </div>
		</div>

	</div>
</div>

<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                &copy; LP3I College Kupang
            </div>

        </div>
    </div>
</footer>

</body>
</html>

<?php
} else {
	echo "<script>window.location='./';</script>";
} ?>