<?php
require_once 'vendor/autoload.php';

use \Firebase\JWT\JWT;
use \Firebase\JWT\JWK;

// Your Google Sign-In client ID
$clientId = "115551103032-9bmhltoftioe48m5bo7op5oimuur7d8a.apps.googleusercontent.com";

// Get the JWT from the query parameter
$jwt =  $_SESSION['jwt'];

if (empty($jwt)) {
    echo json_encode(['error' => 'JWT is empty']);
    exit;
}

// Google's public keys URL
$publicKeysUrl = 'https://www.googleapis.com/oauth2/v3/certs';

// Fetch Google's public keys
$publicKeys = JWK::parseKeySet(json_decode(file_get_contents($publicKeysUrl), true));

try {
    // Decode the JWT using Google's public keys
    $decoded = JWT::decode($jwt, $publicKeys, ['RS256']);

    // You can access the decoded claims
    $data  =   $decoded;
} catch (\Exception $e) {
    // Handle JWT decoding errors

    if ($e->getMessage() == "Expired token") {
        echo "<script>window.location.href='index.php';</script>";
    }
}


?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/solid.min.css" integrity="sha512-pZlKGs7nEqF4zoG0egeK167l6yovsuL8ap30d07kA5AJUq+WysFlQ02DLXAmN3n0+H3JVz5ni8SJZnrOaYXWBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>

    #id_message__info_bb_umur   {
        border-radius:12pt;
        padding:10px;
    }
    #id_message__info_tb_umur {
        border-radius:12pt;
        padding:10px;
    }
    #id_message__info_bb_tb{
        border-radius:12pt;
        padding:10px;
    }
    body {
        font-family: 'Poppins' !important;
        font-size: 15px;
        line-height: 1.5;
    }

    span {
        font-family: 'Poppins' !important;
        font-weight: 700;
    }

    span {
        font-family: 'Poppins' !important;
        font-weight: normal;
    }

    h2 {
        font-family: 'Poppins' !important;
        font-size: 34px !important;
        line-height: 1.2 !important;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        margin: 0;
        margin-bottom: 0px;
        padding: 0;
        line-height: 1.2;
        word-break: break-word;
    }

    @media (max-width: 767px) {
        h2 {
            font-family: 'Poppins' !important;
            font-size: 30px !important;
            line-height: 1.2 !important;
        }
    }

    h4 {
        font-family: 'Poppins' !important;
        font-size: 26px !important;
    }

    figure {
        margin: 0px;
    }

    .header {
        background-color: transparent;
    }

    #header-section {
        background-color: white;
    }

    iframe {
        max-height: 138px !important;
    }

    table.cls_table__data_anak {
        font-family: 'Poppins' !important;
        width: 80%;
        border: none !important;
        text-align: left;
        background-color: transparent;
        td.border-width: none;
    }

    table.cls_table__data_anak td.cl_td__label {
        width: 70px !important;
    }

    table.cls_table__data_anak td.cl_td__variabel {
        width: 70px !important;
    }

    table.cls_table__data_anak td.cl_td__kolon {
        width: 10px !important;
    }

    table.cls_table__data_anak td.cl_td__spasi {
        width: 20px !important;
    }

    table.cls_table__data_anak_mobile {
        font-family: 'Poppins' !important;
        width: 100%;
        border: none !important;
        text-align: left;
        background-color: transparent;
        td.border-width: none;
    }

    table.cls_table__data_anak td,
    table.cls_table__data_anak_mobile td {
        border: none !important;
        padding: 2px;
    }

    .label,
    .header,
    .divider,
    .button,
    button {
        font-weight: normal !important;
    }

    img.cls_img__jenis_kelamin:hover {
        cursor: pointer;
    }

    input[type=text]:focus {
        border: 1px solid #8EC21F !important;
    }

    .clsHideElement {
        display: none !important;
        visibility: hidden;
    }

    .ui.basic.table tbody tr {
        border-bottom: none !important;
    }

    .ui.table:not(.unstackable) tr {
        padding-bottom: 0px !important;
        box-shadow: none !important;
        -webkit-box-shadow: none !important;
    }


    .fa,
    .far,
    .fa {
        font-family: "FontAwesome" !important;
    }
</style>
<!-- Content -->
<main role="main" class="col-md-12 ml-sm-auto col-lg-12 px-md-4 mt-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9 col-sm-10">

                <div class="card">
                    <div class="card-header pb-0 pt-0 px-1 bg-primary bg-lighten-3">
                        <div class="row">
                            <div class="col-md-9 col-sm-12">
                                <h3 class="mt-2 ml-lg-11 text-judul text-white">Kalkulator Stunting</h3>
                            </div>
                        </div>
                    </div>
                    <div id="id_segment__hasil_analisis" class="ui segment clsHideElement" style="width: 100%; text-align: center !important; padding-top: 2.5em !important; margin-left: auto; margin-right: auto;">
                        <div class="header" style="margin-bottom: .5em; font-family: 'Poppins'; font-size: 1.7em; color: #491A00;">Kalkulator Perhitungan</div>
                        <div class="header" style="font-family: 'Poppins'; font-size: 1.7em; color: #8EC21F;">Status Perkembangan Gizi Anak</div>
                        <div style="margin-top: 40px;"></div>
                        <p><!-- charts --></p>
                        <div class="ui horizontal divider" style="font-family: 'Poppins'; font-size:1.2em; font-weight: bold; text-transform: none; ">Berat Badan Menurut Umur</div>
                        
                        <div id="id_message__info_bb_umur" class="ui info message" style="background-color: #8EC21F; border-width:1px; border-color:#6F942D; color: white; text-align: left; box-shadow: none; -webkit-box-shadow: none;">
                            <div class="header" style="font-family: 'Poppins'; font-size: 1em; text-align: left; color: black;">
                                Anak Anda
                            </div>
                            <p> <span class="cl_span__data_anak"></span></p>
                            <div class="header" style="margin-top: 1em; font-family: 'Poppins'; font-size: 1em; text-align: left; color: black;">
                                Berat Badan Menurut Umur
                            </div>
                            <p> <span id="id_span__info_bb_umur"></span></p>
                            <div class="header" style="margin-top: 1em; font-family: 'Poppins'; font-size: 1em; text-align: left; color: black;">
                                Berat Badan Menurut Umur
                            </div>
                            <p> Rekomendasi <span id="id_span__rekomendasi_bb_umur"></span>
                        </div>
                        <div style="margin-top: 40px;"></div>
                        <div class="ui horizontal divider" style="font-family: 'Poppins'; font-size:1.2em; font-weight: bold; text-transform: none; ">Tinggi Badan Menurut Umur</div>
                      
                        <div id="id_message__info_tb_umur" class="ui info message" style="background-color: #8EC21F; border-width:1px; border-color:#6F942D; color: white; text-align: left; box-shadow: none; -webkit-box-shadow: none;">
                            <div class="header" style="font-family: 'Poppins'; font-size: 1em; text-align: left; color: black;">
                                Anak Anda
                            </div>
                            <p> <span class="cl_span__data_anak"></span></p>
                            <div class="header" style="margin-top: 1em; font-family: 'Poppins'; font-size: 1em; text-align: left; color: black;">
                                Tinggi Badan Menurut Umur
                            </div>
                            <p> <span id="id_span__info_tb_umur"></span></p>
                            <div class="header" style="margin-top: 1em; font-family: 'Poppins'; font-size: 1em; text-align: left; color: black;">
                                Tinggi Badan Menurut Umur
                            </div>
                            <p> Rekomendasi <span id="id_span__rekomendasi_tb_umur"></span>
                        </div>
                        <div style="margin-top: 40px;"></div>
                        <div class="ui horizontal divider" style="width: 100%; font-family: 'Poppins'; font-size:1em; font-weight: bold; text-transform: none;">Berat Badan Menurut Tinggi Badan</div>
                        
                        <div id="id_message__info_bb_tb" class="ui info message" style="background-color: #8EC21F; border-width:1px; border-color:#6F942D; color: white; text-align: left; box-shadow: none; -webkit-box-shadow: none;">
                            <div class="header" style="font-family: 'Poppins'; font-size: 1em; text-align: left; color: black;">
                                Anak Anda
                            </div>
                            <p> <span class="cl_span__data_anak"></span></p>
                            <div class="header" style="margin-top: 1em; font-family: 'Poppins'; font-size: 1em; text-align: left; color: black;">
                                Berat Badan Menurut Tinggi Badan
                            </div>
                            <p> <span id="id_span__info_bb_tb"></span></p>
                            <div class="header" style="margin-top: 1em; font-family: 'Poppins'; font-size: 1em; text-align: left; color: black;">
                                Berat Badan Menurut Tinggi Badan
                            </div>
                            <p> Rekomendasi <span id="id_span__rekomendasi_bb_tb"></span>
                        </div>
                        <form class="ui form">
                            <div class="field"><!-- button id="id_tombol__reset_zoom" class="large ui right labeled icon left floated button" type="submit" style="margin-top: 1em !important; color: black; font-family: 'Poppins'; font-size: 1.1em;"><i class="right zoom-out icon"></i>Reset Zoom</button --> <a  href='' class=" btn btn-success" ><i class="right redo icon"></i>Data Baru</a> </div>
                            </p>
                        </form>
                    </div>
                    <p><!-- formulir --></p>
                    <div id="id_segment__formulir" class="ui segment" style="width: 100%; text-align: center !important; padding-top: 2.5em !important; padding-bottom: 2.5em !important; margin-left: auto; margin-right: auto;">
                        <div class="header" style="margin-bottom: .5em; font-family: 'Poppins'; font-size: 1.7em; color: #491A00;">Kalkulator Perhitungan</div>
                        <div class="header" style="font-family: 'Poppins'; font-size: 1.7em; color: #8EC21F;">Status Perkembangan Gizi Anak</div>
                        <div style="margin-top: 40px;"></div>
                        <div style="width: 100%; text-align: center; border: none !important; text-align: center; font-family: 'Poppins'; font-size: 1.4em; color: #491A00;">Anak Anda : </div>
                        <table class="ui unstackable very basic two wide table" style="width:100%; border: none !important; margin-left: auto; margin-right: auto; font-family: 'Poppins'; line-height: 0px !important; font-weight: normal;">
                            <tr>
                                <td class="one wide" style="width: 50%; margin-top:1em; border: none; padding-bottom: 0px; text-align: center;"><img decoding="async" class="cls_img__jenis_kelamin" src=" data:image/png;base64,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" style="max-height:70%; max-width:70%; margin-left: auto; margin-right: auto;" alt="Anak laki-laki" /></p>
                                    <div style="height: 50px; font-weight: normal;">Laki-laki</div>
                                    <div class="cl_span__anak_laki" style="height: 50px;"><i class="fa-solid fa-check" style="color: #8EC21F; visibility: hidden;"></i></div>
                                </td>
                                <td class="one wide" style="width: 50%; margin-top:1em; border: none; padding-bottom: 0px; text-align: center;"><img decoding="async" class="cls_img__jenis_kelamin" src=" data:image/png;base64,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" style="max-height:70%; max-width:70%; margin-left: auto; margin-right: auto;" alt="Anak perempuan"></p>
                                    <div style="height: 50px; font-weight: normal;">Perempuan</div>
                                    <div class="cl_span__anak_perempuan" style="height: 50px;"><i class="fa-solid fa-check" style="font-size:10pt; color: #8EC21F; visibility: hidden;"></i></div>
                                </td>
                            </tr>
                        </table>
                        <p><!-- tabel kolom --></p>
                        <table class="ui very basic table" style="width:80%; border: none !important; margin-left: auto; margin-right: auto; margin-bottom: 0px !important; font-family: 'Poppins'; font-size: 1.1em;">
                            <tr>
                                <td style="width: 55%; border: none; font-size: 1.1em; font-weight: normal;">Usia Anak (0-60 bulan)</td>
                                <td style="width: 65%; border: none;">
    <div class="ui fluid right labeled input" style="position: relative;">
        <input type="text" id="id_kolom__umur" name="nm_kolom__umur" class="cls_kolom__hanya_desimal" maxlength="2" pattern="[0-9]+" inputmode="numeric" placeholder="" style="width: 220px; text-align: center;">
        <div class="ui basic label" style="position: absolute; top: 0; right: 0; height: 100%; width: 90px; background-color: #8EC21F; border-top-left-radius: 0px !important; border-bottom-left-radius: 0px !important;">Bulan</div>
    </div>
</td>

                            </tr>
                            <tr>
                                <td style="width: 65%; border: none; font-size: 1.1em; font-weight: normal;">Berat Badan Anak</td>
                                <td style="width: 35%; border: none;">
    <div class="ui fluid right labeled input" style="position: relative;">
        <input type="text" id="id_kolom__berat_badan" name="nm_kolom__berat_badan" class="cls_kolom__hanya_desimal" maxlength="5" pattern="[0-9]+" inputmode="numeric" placeholder="" style="width: 120px; text-align: center;">
        <div class="ui basic label" style="position: absolute; top: 0; right: 0; height: 100%; width: 70px; background-color: #8EC21F; border-top-left-radius: 0px !important; border-bottom-left-radius: 0px !important;">Kg</div>
    </div>
</td>

                            </tr>
                            <tr>
                                <td style="width: 65%; border: none; font-size: 1.1em; font-weight: normal;">Tinggi Badan Anak</td>
                                <td style="width: 35%; border: none;">
    <div class="ui fluid right labeled input" style="position: relative;">
        <input type="text" id="id_kolom__tinggi_badan" name="nm_kolom__tinggi_badan" class="cls_kolom__hanya_desimal" maxlength="6" pattern="[0-9]+" inputmode="numeric" placeholder="" style="width: 120px; text-align: center;">
        <div class="ui basic label" style="position: absolute; top: 0; right: 0; height: 100%; width: 70px; background-color: #8EC21F; border-top-left-radius: 0px !important; border-bottom-left-radius: 0px !important;">Cm</div>
    </div>
</td>

                            </tr>
                            <tr>
                                <td colspan="2" class="center aligned" style="border: none; font-size: .85em; font-weight: normal;"><strong>Note:</strong> Jika anak Anda belum bisa berdiri, pengukuran dilakukan dengan cara berbaring.</td>
                            </tr>
                            <tr>
                                <td colspan="2" class="center aligned" style="border: none;"><button id="id_tombol__hitung" class="btn btn-success " type="submit" style="margin-top: 1em !important; background-color: #8EC21F; color: black; font-family: 'Poppins'; font-size: 1.1em;"><i class="right arrow icon"></i>Hitung</button></td>
                            </tr>
                        </table>
                    </div>
                    <p> <!-- $[segment] --></p>
                    <p><!-- modal --></p>
                    <div id="id_modal__info" class="ui tiny modal" style="font-family: Poppins !important; font-size:1em;">
                        <div class="header" style="font-family: 'Poppins'; font-size: 1.1em;">Informasi Pengisian Data</div>
                        <div class="content" style="font-family: 'Poppins'; font-size: 1em;">
                            <span id="id_span__isi_modal"></span>
                        </div>
                        <div class="actions">
                            <div class="ui approve positive right labeled icon button" style="font-family: 'Poppins'; font-size: 1em; background-color: #8EC21F; color: black;">
                                Baik<br />
                                <i class="checkmark icon"></i>
                            </div>
                            </p>
                        </div>
                    </div>
                    <p><!-- modal konfirmasi --></p>
                    <div id="id_modal__konfirmasi" class="ui tiny modal" style="background-color: #8ec21f; font-family: Poppins !important; font-size: 1em;">
                        <div class="image content" style="background-color: #8ec21f; color: black; padding-bottom: .5em;">
                            <div class="description" style="width: 60%; background-color: #8ec21f; color: black;">
                                <div style="background-color: #8ec21f;">Pilih <span style="color: white;">konsultasi</span> jika Anda ingin konsultasikan perkembangan anak Anda.</div>
                                <div style="background-color: #8ec21f;color: white; margin-top: 1.2em;">Layanan konsultasi gratis</div>
                                </p>
                            </div>
                            <div class="ui medium image">
                                <img decoding="async" src=" data:image/png;base64,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" style="margin-left:auto; margin-right: auto;" />
                            </div>
                            </p>
                        </div>
                        <div class="actions" style="width: 93%; background-color: #8ec21f; border-top: 1px solid white; margin-left: auto; margin-right: auto; ">
                            <div class="ui deny left floated button" style="margin-left: 0px; font-family: 'Poppins'; font-size: 1em; background-color: black; color: white;">Konsultasi</div>
                            <div class="ui approve button" style="margin-right: 0px; font-family: 'Poppins'; font-size: 1em; background-color: black; color: white;">Ulangi</div>
                        </div>
                    </div>
                    <p><a href="http://s11.flagcounter.com/more/Ib"><img data-lazyloaded="1" src="data:image/gif;base64,R0lGODdhAQABAPAAAMPDwwAAACwAAAAAAQABAAACAkQBADs=" decoding="async" class="aligncenter" data-src="https://s11.flagcounter.com/mini/Ib/bg_FFFFFF/txt_000000/border_729C00/flags_0/" alt="Flag Counter" border="0" /><noscript><img decoding="async" class="aligncenter" src="https://s11.flagcounter.com/mini/Ib/bg_FFFFFF/txt_000000/border_729C00/flags_0/" alt="Flag Counter" border="0" /></noscript></a></p>
                </div>
            </div>
        </div>
        </section>
        
</main>

<div class='alert alert-warning text-center'>Sumber data: PERMENKES RI No. 2 Tahun 2020 tentang Standar Antropometri Anak, Buku Kesehatan Ibu dan Anak 2016 & Kalkulator dari https://temansigizi.com</div>

</div>
</div>


<script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script> 
<script type="text/javascript">
    $(document).ready(function() {
        var R, M, E;
        setTimeout(function() {
            $("#id_kolom__umur").val(""), $("#id_kolom__berat_badan").val(""), $("#id_kolom__tinggi_badan").val(""), $("#id_kolom__umur").focus()
        }, 200), $(document).on("keypress", "#id_kolom__umur", function(a) {
            (8 != a.which && (a.which < 48 || 57 < a.which) || 8 != a.which && (a.which < 48 || 57 < a.which)) && a.preventDefault()
        }), $(document).on("keypress", "#id_kolom__berat_badan", function(a) {
            var n;
            !(8 == a.which || 44 == a.which && -1 == $(this).val().indexOf(".") || 46 == a.which && -1 == $(this).val().indexOf(".")) && (a.which < 48 || 57 < a.which) || 44 == a.which && 0 == $(this).val().length || 46 == a.which && 0 == $(this).val().length ? a.preventDefault() : 44 == a.which || 46 == a.which ? (n = $.trim($(this).val()), console.log("-- nilai: " + n), n.split(","), (-1 < n.indexOf(",") || -1 < n.indexOf(".")) && (console.log("-- ada koma/titik"), n.slice(0, -1), console.log("-- nilai baru: " + n), a.preventDefault())) : 8 != a.which && (a.which < 48 || 57 < a.which) && -1 != $(this).val().indexOf(".") && 2 < $(this).val().substring($(this).val().indexOf("."), $(this).val().indexOf(".").length).length && a.preventDefault()
        }), $(document).on("blur", "#id_kolom__berat_badan", function() {
            var a = $.trim($(this).val()); - 1 < a.indexOf(",") && (a = a.replace(",", "."));
            a = (a = parseFloat(a)).toFixed(2);
            $(this).val(a), isNaN(a) && $(this).val("")
        }), $(document).on("keypress", "#id_kolom__tinggi_badan", function(a) {
            var n;
            !(8 == a.which || 44 == a.which && -1 == $(this).val().indexOf(".") || 46 == a.which && -1 == $(this).val().indexOf(".")) && (a.which < 48 || 57 < a.which) || 44 == a.which && 0 == $(this).val().length || 46 == a.which && 0 == $(this).val().length ? a.preventDefault() : 44 == a.which || 46 == a.which ? (n = $.trim($(this).val()), console.log("-- nilai: " + n), (-1 < n.indexOf(",") || -1 < n.indexOf(".")) && (console.log("-- ada koma/titik"), n.slice(0, -1), console.log("-- nilai baru: " + n), a.preventDefault())) : 8 != a.which && (a.which < 48 || 57 < a.which) && -1 != $(this).val().indexOf(".") && 2 < $(this).val().substring($(this).val().indexOf("."), $(this).val().indexOf(".").length).length && a.preventDefault()
        }), $(document).on("blur", "#id_kolom__tinggi_badan", function() {
            var a = $.trim($(this).val()); - 1 < a.indexOf(",") && (a = a.replace(",", "."));
            a = (a = parseFloat(a)).toFixed(2);
            $(this).val(a), isNaN(a) && $(this).val("")
        });

        function T(a, n) {
            for (var i = [], t = a.length, o = 0; o < t; o++) i.push(a[o][n]);
            return i
        }

        function Z(a, n, i) {
            var t = [],
                o = a.length;
            console.log("-- banyak label: " + o), console.log("-- isi label: " + P[1].warna);
            for (var e = 0; e < o; e++) t.push({
                label: a[e].nama,
                stack: a[e].stack,
                data: T(n, e + 1),
                backgroundColor: a[e].warna,
                borderColor: a[e].warna,
                borderWidth: 1,
                pointStyle: "cirlce",
                pointRadius: i,
                pointHoverRadius: 3,
                tension: .8
            });
            return console.log(t), t
        }
        var F, W, H, P = [{
                nama: "-3 SD",
                stack: "Stack 1",
                warna: "rgba(192, 0, 0)"
            }, {
                nama: "-2 SD",
                stack: "Stack 2",
                warna: "rgba(255, 0, 0)"
            }, {
                nama: "-1 SD",
                stack: "Stack 3",
                warna: "rgba(237, 212, 0)"
            }, {
                nama: "Median",
                stack: "Stack 4",
                warna: "rgba(0, 255, 0)"
            }, {
                nama: "+1 SD",
                stack: "Stack 5",
                warna: "rgba(237, 212, 0)"
            }, {
                nama: "+2 SD",
                stack: "Stack 6",
                warna: "rgba(255, 0, 0)"
            }, {
                nama: "+3 SD",
                stack: "Stack 7",
                warna: "rgba(192, 0, 0)"
            }],
            I = [
                [0, 2.1, 2.5, 2.9, 3.3, 3.9, 4.4, 5],
                [1, 2.9, 3.4, 3.9, 4.5, 5.1, 5.8, 6.6],
                [2, 3.8, 4.3, 4.9, 5.6, 6.3, 7.1, 8],
                [3, 4.4, 5, 5.7, 6.4, 7.2, 8, 9],
                [4, 4.9, 5.6, 6.2, 7, 7.8, 8.7, 9.7],
                [5, 5.3, 6, 6.7, 7.5, 8.4, 9.3, 10.4],
                [6, 5.7, 6.4, 7.1, 7.9, 8.8, 9.8, 10.9],
                [7, 5.9, 6.7, 7.4, 8.3, 9.2, 10.3, 11.4],
                [8, 6.2, 6.9, 7.7, 8.6, 9.6, 10.7, 11.9],
                [9, 6.4, 7.1, 8, 8.9, 9.9, 11, 12.3],
                [10, 6.6, 7.4, 8.2, 9.2, 10.2, 11.4, 12.7],
                [11, 6.8, 7.6, 8.4, 9.4, 10.5, 11.7, 13],
                [12, 6.9, 7.7, 8.6, 9.6, 10.8, 12, 13.3],
                [13, 7.1, 7.9, 8.8, 9.9, 11, 12.3, 13.7],
                [14, 7.2, 8.1, 9, 10.1, 11.3, 12.6, 14],
                [15, 7.4, 8.3, 9.2, 10.3, 11.5, 12.8, 14.3],
                [16, 7.5, 8.4, 9.4, 10.5, 11.7, 13.1, 14.6],
                [17, 7.7, 8.6, 9.6, 10.7, 12, 13.4, 14.9],
                [18, 7.8, 8.8, 9.8, 10.9, 12.2, 13.7, 15.3],
                [19, 8, 8.9, 10, 11.1, 12.5, 13.9, 15.6],
                [20, 8.1, 9.1, 10.1, 11.3, 12.7, 14.2, 15.9],
                [21, 8.2, 9.2, 10.3, 11.5, 12.9, 14.5, 16.2],
                [22, 8.4, 9.4, 10.5, 11.8, 13.2, 14.7, 16.5],
                [23, 8.5, 9.5, 10.7, 12, 13.4, 15, 16.8],
                [24, 8.6, 9.7, 10.8, 12.2, 13.6, 15.3, 17.1]
            ],
            K = [
                [25, 8.8, 9.8, 11, 12.4, 13.9, 15.5, 17.5],
                [26, 8.9, 10, 11.2, 12.5, 14.1, 15.8, 17.8],
                [27, 9, 10.1, 11.3, 12.7, 14.3, 16.1, 18.1],
                [28, 9.1, 10.2, 11.5, 12.9, 14.5, 16.3, 18.4],
                [29, 9.2, 10.4, 11.7, 13.1, 14.8, 16.6, 18.7],
                [30, 9.4, 10.5, 11.8, 13.3, 15, 16.9, 19],
                [31, 9.5, 10.7, 12, 13.5, 15.2, 17.1, 19.3],
                [32, 9.6, 10.8, 12.1, 13.7, 15.4, 17.4, 19.6],
                [33, 9.7, 10.9, 12.3, 13.8, 15.6, 17.6, 19.9],
                [34, 9.8, 11, 12.4, 14, 15.8, 17.8, 20.2],
                [35, 9.9, 11.2, 12.6, 14.2, 16, 18.1, 20.4],
                [36, 10, 11.3, 12.7, 14.3, 16.2, 18.3, 20.7],
                [37, 10.1, 11.4, 12.9, 14.5, 16.4, 18.6, 21],
                [38, 10.2, 11.5, 13, 14.7, 16.6, 18.8, 21.3],
                [39, 10.3, 11.6, 13.1, 14.8, 16.8, 19, 21.6],
                [40, 10.4, 11.8, 13.3, 15, 17, 19.3, 21.9],
                [41, 10.5, 11.9, 13.4, 15.2, 17.2, 19.5, 22.1],
                [42, 10.6, 12, 13.6, 15.3, 17.4, 19.7, 22.4],
                [43, 10.7, 12.1, 13.7, 15.5, 17.6, 20, 22.7],
                [44, 10.8, 12.2, 13.8, 15.7, 17.8, 20.2, 23],
                [45, 10.9, 12.4, 14, 15.8, 18, 20.5, 23.3],
                [46, 11, 12.5, 14.1, 16, 18.2, 20.7, 23.6],
                [47, 11.1, 12.6, 14.3, 16.2, 18.4, 20.9, 23.9],
                [48, 11.2, 12.7, 14.4, 16.3, 18.6, 21.2, 24.2],
                [49, 11.3, 12.8, 14.5, 16.5, 18.8, 21.4, 24.5],
                [50, 11.4, 12.9, 14.7, 16.7, 19, 21.7, 24.8],
                [51, 11.5, 13.1, 14.8, 16.8, 19.2, 21.9, 25.1],
                [52, 11.6, 13.2, 15, 17, 19.4, 22.2, 25.4],
                [53, 11.7, 13.3, 15.1, 17.2, 19.6, 22.4, 25.7],
                [54, 11.8, 13.4, 15.2, 17.3, 19.8, 22.7, 26],
                [55, 11.9, 13.5, 15.4, 17.5, 20, 22.9, 26.3],
                [56, 12, 13.6, 15.5, 17.7, 20.2, 23.2, 26.6],
                [57, 12.1, 13.7, 15.6, 17.8, 20.4, 23.4, 26.9],
                [58, 12.2, 13.8, 15.8, 18, 20.6, 23.7, 27.2],
                [59, 12.3, 14, 15.9, 18.2, 20.8, 23.9, 27.6],
                [60, 12.4, 14.1, 16, 18.3, 21, 24.2, 27.9]
            ],
            U = [
                [0, 2, 2.4, 2.8, 3.2, 3.7, 4.2, 4.8],
                [1, 2.7, 3.2, 3.6, 4.2, 4.8, 5.5, 6.2],
                [2, 3.4, 3.9, 4.5, 5.1, 5.8, 6.6, 7.5],
                [3, 4, 4.5, 5.2, 5.8, 6.6, 7.5, 8.5],
                [4, 4.4, 5, 5.7, 6.4, 7.3, 8.2, 9.3],
                [5, 4.8, 5.4, 6.1, 6.9, 7.8, 8.8, 10],
                [6, 5.1, 5.7, 6.5, 7.3, 8.2, 9.3, 10.6],
                [7, 5.3, 6, 6.8, 7.6, 8.6, 9.8, 11.1],
                [8, 5.6, 6.3, 7, 7.9, 9, 10.2, 11.6],
                [9, 5.8, 6.5, 7.3, 8.2, 9.3, 10.5, 12],
                [10, 5.9, 6.7, 7.5, 8.5, 9.6, 10.9, 12.4],
                [11, 6.1, 6.9, 7.7, 8.7, 9.9, 11.2, 12.8],
                [12, 6.3, 7, 7.9, 8.9, 10.1, 11.5, 13.1],
                [13, 6.4, 7.2, 8.1, 9.2, 10.4, 11.8, 13.5],
                [14, 6.6, 7.4, 8.3, 9.4, 10.6, 12.1, 13.8],
                [15, 6.7, 7.6, 8.5, 9.6, 10.9, 12.4, 14.1],
                [16, 6.9, 7.7, 8.7, 9.8, 11.1, 12.6, 14.5],
                [17, 7, 7.9, 8.9, 10, 11.4, 12.9, 14.8],
                [18, 7.2, 8.1, 9.1, 10.2, 11.6, 13.2, 15.1],
                [19, 7.3, 8.2, 9.2, 10.4, 11.8, 13.5, 15.4],
                [20, 7.5, 8.4, 9.4, 10.6, 12.1, 13.7, 15.7],
                [21, 7.6, 8.6, 9.6, 10.9, 12.3, 14, 16],
                [22, 7.8, 8.7, 9.8, 11.1, 12.5, 14.3, 16.4],
                [23, 7.9, 8.9, 10, 11.3, 12.8, 14.6, 16.7],
                [24, 8.1, 9, 10.2, 11.5, 13, 14.8, 17]
            ],
            N = [
                [25, 8.2, 9.2, 10.3, 11.7, 13.3, 15.1, 17.3],
                [26, 8.4, 9.4, 10.5, 11.9, 13.5, 15.4, 17.7],
                [27, 8.5, 9.5, 10.7, 12.1, 13.7, 15.7, 18],
                [28, 8.6, 9.7, 10.9, 12.3, 14, 16, 18.3],
                [29, 8.8, 9.8, 11.1, 12.5, 14.2, 16.2, 18.7],
                [30, 8.9, 10, 11.2, 12.7, 14.4, 16.5, 19],
                [31, 9, 10.1, 11.4, 12.9, 14.7, 16.8, 19.3],
                [32, 9.1, 10.3, 11.6, 13.1, 14.9, 17.1, 19.6],
                [33, 9.3, 10.4, 11.7, 13.3, 15.1, 17.3, 20],
                [34, 9.4, 10.5, 11.9, 13.5, 15.4, 17.6, 20.3],
                [35, 9.5, 10.7, 12, 13.7, 15.6, 17.9, 20.6],
                [36, 9.6, 10.8, 12.2, 13.9, 15.8, 18.1, 20.9],
                [37, 9.7, 10.9, 12.4, 14, 16, 18.4, 21.3],
                [38, 9.8, 11.1, 12.5, 14.2, 16.3, 18.7, 21.6],
                [39, 9.9, 11.2, 12.7, 14.4, 16.5, 19, 22],
                [40, 10.1, 11.3, 12.8, 14.6, 16.7, 19.2, 22.3],
                [41, 10.2, 11.5, 13, 14.8, 16.9, 19.5, 22.7],
                [42, 10.3, 11.6, 13.1, 15, 17.2, 19.8, 23],
                [43, 10.4, 11.7, 13.3, 15.2, 17.4, 20.1, 23.4],
                [44, 10.5, 11.8, 13.4, 15.3, 17.6, 20.4, 23.7],
                [45, 10.6, 12, 13.6, 15.5, 17.8, 20.7, 24.1],
                [46, 10.7, 12.1, 13.7, 15.7, 18.1, 20.9, 24.5],
                [47, 10.8, 12.2, 13.9, 15.9, 18.3, 21.2, 24.8],
                [48, 10.9, 12.3, 14, 16.1, 18.5, 21.5, 25.2],
                [49, 11, 12.4, 14.2, 16.3, 18.8, 21.8, 25.5],
                [50, 11.1, 12.6, 14.3, 16.4, 19, 22.1, 25.9],
                [51, 11.2, 12.7, 14.5, 16.6, 19.2, 22.4, 26.3],
                [52, 11.3, 12.8, 14.6, 16.8, 19.4, 22.6, 26.6],
                [53, 11.4, 12.9, 14.8, 17, 19.7, 22.9, 27],
                [54, 11.5, 13, 14.9, 17.2, 19.9, 23.2, 27.4],
                [55, 11.6, 13.2, 15.1, 17.3, 20.1, 23.5, 27.7],
                [56, 11.7, 13.3, 15.2, 17.5, 20.3, 23.8, 28.1],
                [57, 11.8, 13.4, 15.3, 17.7, 20.6, 24.1, 28.5],
                [58, 11.9, 13.5, 15.5, 17.9, 20.8, 24.4, 28.8],
                [59, 12, 13.6, 15.6, 18, 21, 24.6, 29.2],
                [60, 12.1, 13.7, 15.8, 18.2, 21.2, 24.9, 29.5]
            ],
            j = [
                [0, 44.2, 46.1, 48, 49.9, 51.8, 53.7, 55.6],
                [1, 48.9, 50.8, 52.8, 54.7, 56.7, 58.6, 60.6],
                [2, 52.4, 54.4, 56.4, 58.4, 60.4, 62.4, 64.4],
                [3, 55.3, 57.3, 59.4, 61.4, 63.5, 65.5, 67.6],
                [4, 57.6, 59.7, 61.8, 63.9, 66, 68, 70.1],
                [5, 59.6, 61.7, 63.8, 65.9, 68, 70.1, 72.2],
                [6, 61.2, 63.3, 65.5, 67.6, 69.8, 71.9, 74],
                [7, 62.7, 64.8, 67, 69.2, 71.3, 73.5, 75.7],
                [8, 64, 66.2, 68.4, 70.6, 72.8, 75, 77.2],
                [9, 65.2, 67.5, 69.7, 72, 74.2, 76.5, 78.7],
                [10, 66.4, 68.7, 71, 73.3, 75.6, 77.9, 80.1],
                [11, 67.6, 69.9, 72.2, 74.5, 76.9, 79.2, 81.5],
                [12, 68.6, 71, 73.4, 75.7, 78.1, 80.5, 82.9],
                [13, 69.6, 72.1, 74.5, 76.9, 79.3, 81.8, 84.2],
                [14, 70.6, 73.1, 75.6, 78, 80.5, 83, 85.5],
                [15, 71.6, 74.1, 76.6, 79.1, 81.7, 84.2, 86.7],
                [16, 72.5, 75, 77.6, 80.2, 82.8, 85.4, 88],
                [17, 73.3, 76, 78.6, 81.2, 83.9, 86.5, 89.2],
                [18, 74.2, 76.9, 79.6, 82.3, 85, 87.7, 90.4],
                [19, 75, 77.7, 80.5, 83.2, 86, 88.8, 91.5],
                [20, 75.8, 78.6, 81.4, 84.2, 87, 89.8, 92.6],
                [21, 76.5, 79.4, 82.3, 85.1, 88, 90.9, 93.8],
                [22, 77.2, 80.2, 83.1, 86, 89, 91.9, 94.9],
                [23, 78, 81, 83.9, 86.9, 89.9, 92.9, 95.9],
                [24, 78.7, 81.7, 84.8, 87.8, 90.9, 93.9, 97]
            ],
            J = [
                [25, 78.6, 81.7, 84.9, 88, 91.1, 94.2, 97.3],
                [26, 79.3, 82.5, 85.6, 88.8, 92, 95.2, 98.3],
                [27, 79.9, 83.1, 86.4, 89.6, 92.9, 96.1, 99.3],
                [28, 80.5, 83.8, 87.1, 90.4, 93.7, 97, 100.3],
                [29, 81.1, 84.5, 87.8, 91.2, 94.5, 97.9, 101.2],
                [30, 81.7, 85.1, 88.5, 91.9, 95.3, 98.7, 102.1],
                [31, 82.3, 85.7, 89.2, 92.7, 96.1, 99.6, 103],
                [32, 82.8, 86.4, 89.9, 93.4, 96.9, 100.4, 103.9],
                [33, 83.4, 86.9, 90.5, 94.1, 97.6, 101.2, 104.8],
                [34, 83.9, 87.5, 91.1, 94.8, 98.4, 102, 105.6],
                [35, 84.4, 88.1, 91.8, 95.4, 99.1, 102.7, 106.4],
                [36, 85, 88.7, 92.4, 96.1, 99.8, 103.5, 107.2],
                [37, 85.5, 89.2, 93, 96.7, 100.5, 104.2, 108],
                [38, 86, 89.8, 93.6, 97.4, 101.2, 105, 108.8],
                [39, 86.5, 90.3, 94.2, 98, 101.8, 105.7, 109.5],
                [40, 87, 90.9, 94.7, 98.6, 102.5, 106.4, 110.3],
                [41, 87.5, 91.4, 95.3, 99.2, 103.2, 107.1, 111],
                [42, 88, 91.9, 95.9, 99.9, 103.8, 107.8, 111.7],
                [43, 88.4, 92.4, 96.4, 100.4, 104.5, 108.5, 112.5],
                [44, 88.9, 93, 97, 101, 105.1, 109.1, 113.2],
                [45, 89.4, 93.5, 97.5, 101.6, 105.7, 109.8, 113.9],
                [46, 89.8, 94, 98.1, 102.2, 106.3, 110.4, 114.6],
                [47, 90.3, 94.4, 98.6, 102.8, 106.9, 111.1, 115.2],
                [48, 90.7, 94.9, 99.1, 103.3, 107.5, 111.7, 115.9],
                [49, 91.2, 95.4, 99.7, 103.9, 108.1, 112.4, 116.6],
                [50, 91.6, 95.9, 100.2, 104.4, 108.7, 113, 117.3],
                [51, 92.1, 96.4, 100.7, 105, 109.3, 113.6, 117.9],
                [52, 92.5, 96.9, 101.2, 105.6, 109.9, 114.2, 118.6],
                [53, 93, 97.4, 101.7, 106.1, 110.5, 114.9, 119.2],
                [54, 93.4, 97.8, 102.3, 106.7, 111.1, 115.5, 119.9],
                [55, 93.9, 98.3, 102.8, 107.2, 111.7, 116.1, 120.6],
                [56, 94.3, 98.8, 103.3, 107.8, 112.3, 116.7, 121.2],
                [57, 94.7, 99.3, 103.8, 108.3, 112.8, 117.4, 121.9],
                [58, 95.2, 99.7, 104.3, 108.9, 113.4, 118, 122.6],
                [59, 95.6, 100.2, 104.8, 109.4, 114, 118.6, 123.2],
                [60, 96.1, 100.7, 105.3, 110, 114.6, 119.2, 123.9]
            ],
            L = [
                [0, 43.6, 45.4, 47.3, 49.1, 51, 52.9, 54.7],
                [1, 47.8, 49.8, 51.7, 53.7, 55.6, 57.6, 59.5],
                [2, 51, 53, 55, 57.1, 59.1, 61.1, 63.2],
                [3, 53.5, 55.6, 57.7, 59.8, 61.9, 64, 66.1],
                [4, 55.6, 57.8, 59.9, 62.1, 64.3, 66.4, 68.6],
                [5, 57.4, 59.6, 61.8, 64, 66.2, 68.5, 70.7],
                [6, 58.9, 61.2, 63.5, 65.7, 68, 70.3, 72.5],
                [7, 60.3, 62.7, 65, 67.3, 69.6, 71.9, 74.2],
                [8, 61.7, 64, 66.4, 68.7, 71.1, 73.5, 75.8],
                [9, 62.9, 65.3, 67.7, 70.1, 72.6, 75, 77.4],
                [10, 64.1, 66.5, 69, 71.5, 73.9, 76.4, 78.9],
                [11, 65.2, 67.7, 70.3, 72.8, 75.3, 77.8, 80.3],
                [12, 66.3, 68.9, 71.4, 74, 76.6, 79.2, 81.7],
                [13, 67.3, 70, 72.6, 75.2, 77.8, 80.5, 83.1],
                [14, 68.3, 71, 73.7, 76.4, 79.1, 81.7, 84.4],
                [15, 69.3, 72, 74.8, 77.5, 80.2, 83, 85.7],
                [16, 70.2, 73, 75.8, 78.6, 81.4, 84.2, 87],
                [17, 71.1, 74, 76.8, 79.7, 82.5, 85.4, 88.2],
                [18, 72, 74.9, 77.8, 80.7, 83.6, 86.5, 89.4],
                [19, 72.8, 75.8, 78.8, 81.7, 84.7, 87.6, 90.6],
                [20, 73.7, 76.7, 79.7, 82.7, 85.7, 88.7, 91.7],
                [21, 74.5, 77.5, 80.6, 83.7, 86.7, 89.8, 92.9],
                [22, 75.2, 78.4, 81.5, 84.6, 87.7, 90.8, 94],
                [23, 76, 79.2, 82.3, 85.5, 88.7, 91.9, 95],
                [24, 76.7, 80, 83.2, 86.4, 89.6, 92.9, 96.1]
            ],
            q = [
                [25, 76.8, 80, 83.3, 86.6, 89.9, 93.1, 96.4],
                [26, 77.5, 80.8, 84.1, 87.4, 90.8, 94.1, 97.4],
                [27, 78.1, 81.5, 84.9, 88.3, 91.7, 95, 98.4],
                [28, 78.8, 82.2, 85.7, 89.1, 92.5, 96, 99.4],
                [29, 79.5, 82.9, 86.4, 89.9, 93.4, 96.9, 100.3],
                [30, 80.1, 83.6, 87.1, 90.7, 94.2, 97.7, 101.3],
                [31, 80.7, 84.3, 87.9, 91.4, 95, 98.6, 102.2],
                [32, 81.3, 84.9, 88.6, 92.2, 95.8, 99.4, 103.1],
                [33, 81.9, 85.6, 89.3, 92.9, 96.6, 100.3, 103.9],
                [34, 82.5, 86.2, 89.9, 93.6, 97.4, 101.1, 104.8],
                [35, 83.1, 86.8, 90.6, 94.4, 98.1, 101.9, 105.6],
                [36, 83.6, 87.4, 91.2, 95.1, 98.9, 102.7, 106.5],
                [37, 84.2, 88, 91.9, 95.7, 99.6, 103.4, 107.3],
                [38, 84.7, 88.6, 92.5, 96.4, 100.3, 104.2, 108.1],
                [39, 85.3, 89.2, 93.1, 97.1, 101, 105, 108.9],
                [40, 85.8, 89.8, 93.8, 97.7, 101.7, 105.7, 109.7],
                [41, 86.3, 90.4, 94.4, 98.4, 102.4, 106.4, 110.5],
                [42, 86.8, 90.9, 95, 99, 103.1, 107.2, 111.2],
                [43, 87.4, 91.5, 95.6, 99.7, 103.8, 107.9, 112],
                [44, 87.9, 92, 96.2, 100.3, 104.5, 108.6, 112.7],
                [45, 88.4, 92.5, 96.7, 100.9, 105.1, 109.3, 113.5],
                [46, 88.9, 93.1, 97.3, 101.5, 105.8, 110, 114.2],
                [47, 89.3, 93.6, 97.9, 102.1, 106.4, 110.7, 114.9],
                [48, 89.8, 94.1, 98.4, 102.7, 107, 111.3, 115.7],
                [49, 90.3, 94.6, 99, 103.3, 107.7, 112, 116.4],
                [50, 90.7, 95.1, 99.5, 103.9, 108.3, 112.7, 117.1],
                [51, 91.2, 95.6, 100.1, 104.5, 108.9, 113.3, 117.7],
                [52, 91.7, 96.1, 100.6, 105, 109.5, 114, 118.4],
                [53, 92.1, 96.6, 101.1, 105.6, 110.1, 114.6, 119.1],
                [54, 92.6, 97.1, 101.6, 106.2, 110.7, 115.2, 119.8],
                [55, 93, 97.6, 102.2, 106.7, 111.3, 115.9, 120.4],
                [56, 93.4, 98.1, 102.7, 107.3, 111.9, 116.5, 121.1],
                [57, 93.9, 98.5, 103.2, 107.8, 112.5, 117.1, 121.8],
                [58, 94.3, 99, 103.7, 108.4, 113, 117.7, 122.4],
                [59, 94.7, 99.5, 104.2, 108.9, 113.6, 118.3, 123.1],
                [60, 95.2, 99.9, 104.7, 109.4, 114.2, 118.9, 123.7]
            ],
            G = [
                [45, 1.9, 2, 2.2, 2.4, 2.7, 3, 3.3],
                [45.5, 1.9, 2.1, 2.3, 2.5, 2.8, 3.1, 3.4],
                [46, 2, 2.2, 2.4, 2.6, 2.9, 3.1, 3.5],
                [46.5, 2.1, 2.3, 2.5, 2.7, 3, 3.2, 3.6],
                [47, 2.1, 2.3, 2.5, 2.8, 3, 3.3, 3.7],
                [47.5, 2.2, 2.4, 2.6, 2.9, 3.1, 3.4, 3.8],
                [48, 2.3, 2.5, 2.7, 2.9, 3.2, 3.6, 3.9],
                [48.5, 2.3, 2.6, 2.8, 3, 3.3, 3.7, 4],
                [49, 2.4, 2.6, 2.9, 3.1, 3.4, 3.8, 4.2],
                [49.5, 2.5, 2.7, 3, 3.2, 3.5, 3.9, 4.3],
                [50, 2.6, 2.8, 3, 3.3, 3.6, 4, 4.4],
                [50.5, 2.7, 2.9, 3.1, 3.4, 3.8, 4.1, 4.5],
                [51, 2.7, 3, 3.2, 3.5, 3.9, 4.2, 4.7],
                [51.5, 2.8, 3.1, 3.3, 3.6, 4, 4.4, 4.8],
                [52, 2.9, 3.2, 3.5, 3.8, 4.1, 4.5, 5],
                [52.5, 3, 3.3, 3.6, 3.9, 4.2, 4.6, 5.1],
                [53, 3.1, 3.4, 3.7, 4, 4.4, 4.8, 5.3],
                [53.5, 3.2, 3.5, 3.8, 4.1, 4.5, 4.9, 5.4],
                [54, 3.3, 3.6, 3.9, 4.3, 4.7, 5.1, 5.6],
                [54.5, 3.4, 3.7, 4, 4.4, 4.8, 5.3, 5.8],
                [55, 3.6, 3.8, 4.2, 4.5, 5, 5.4, 6],
                [55.5, 3.7, 4, 4.3, 4.7, 5.1, 5.6, 6.1],
                [56, 3.8, 4.1, 4.4, 4.8, 5.3, 5.8, 6.3],
                [56.5, 3.9, 4.2, 4.6, 5, 5.4, 5.9, 6.5],
                [57, 4, 4.3, 4.7, 5.1, 5.6, 6.1, 6.7],
                [57.5, 4.1, 4.5, 4.9, 5.3, 5.7, 6.3, 6.9],
                [58, 4.3, 4.6, 5, 5.4, 5.9, 6.4, 7.1],
                [58.5, 4.4, 4.7, 5.1, 5.6, 6.1, 6.6, 7.2],
                [59, 4.5, 4.8, 5.3, 5.7, 6.2, 6.8, 7.4],
                [59.5, 4.6, 5, 5.4, 5.9, 6.4, 7, 7.6],
                [60, 4.7, 5.1, 5.5, 6, 6.5, 7.1, 7.8],
                [60.5, 4.8, 5.2, 5.6, 6.1, 6.7, 7.3, 8],
                [61, 4.9, 5.3, 5.8, 6.3, 6.8, 7.4, 8.1],
                [61.5, 5, 5.4, 5.9, 6.4, 7, 7.6, 8.3],
                [62, 5.1, 5.6, 6, 6.5, 7.1, 7.7, 8.5],
                [62.5, 5.2, 5.7, 6.1, 6.7, 7.2, 7.9, 8.6],
                [63, 5.3, 5.8, 6.2, 6.8, 7.4, 8, 8.8],
                [63.5, 5.4, 5.9, 6.4, 6.9, 7.5, 8.2, 8.9],
                [64, 5.5, 6, 6.5, 7, 7.6, 8.3, 9.1],
                [64.5, 5.6, 6.1, 6.6, 7.1, 7.8, 8.5, 9.3],
                [65, 5.7, 6.2, 6.7, 7.3, 7.9, 8.6, 9.4],
                [65.5, 5.8, 6.3, 6.8, 7.4, 8, 8.7, 9.6],
                [66, 5.9, 6.4, 6.9, 7.5, 8.2, 8.9, 9.7],
                [66.5, 6, 6.5, 7, 7.6, 8.3, 9, 9.9],
                [67, 6.1, 6.6, 7.1, 7.7, 8.4, 9.2, 10],
                [67.5, 6.2, 6.7, 7.2, 7.9, 8.5, 9.3, 10.2],
                [68, 6.3, 6.8, 7.3, 8, 8.7, 9.4, 10.3],
                [68.5, 6.4, 6.9, 7.5, 8.1, 8.8, 9.6, 10.5],
                [69, 6.5, 7, 7.6, 8.2, 8.9, 9.7, 10.6],
                [69.5, 6.6, 7.1, 7.7, 8.3, 9, 9.8, 10.8],
                [70, 6.6, 7.2, 7.8, 8.4, 9.2, 10, 10.9],
                [70.5, 6.7, 7.3, 7.9, 8.5, 9.3, 10.1, 11.1],
                [71, 6.8, 7.4, 8, 8.6, 9.4, 10.2, 11.2],
                [71.5, 6.9, 7.5, 8.1, 8.8, 9.5, 10.4, 11.3],
                [72, 7, 7.6, 8.2, 8.9, 9.6, 10.5, 11.5],
                [72.5, 7.1, 7.6, 8.3, 9, 9.8, 10.6, 11.6],
                [73, 7.2, 7.7, 8.4, 9.1, 9.9, 10.8, 11.8],
                [73.5, 7.2, 7.8, 8.5, 9.2, 10, 10.9, 11.9],
                [74, 7.3, 7.9, 8.6, 9.3, 10.1, 11, 12.1],
                [74.5, 7.4, 8, 8.7, 9.4, 10.2, 11.2, 12.2],
                [75, 7.5, 8.1, 8.8, 9.5, 10.3, 11.3, 12.3],
                [75.5, 7.6, 8.2, 8.8, 9.6, 10.4, 11.4, 12.5],
                [76, 7.6, 8.3, 8.9, 9.7, 10.6, 11.5, 12.6],
                [76.5, 7.7, 8.3, 9, 9.8, 10.7, 11.6, 12.7],
                [77, 7.8, 8.4, 9.1, 9.9, 10.8, 11.7, 12.8],
                [77.5, 7.9, 8.5, 9.2, 10, 10.9, 11.9, 13],
                [78, 7.9, 8.6, 9.3, 10.1, 11, 12, 13.1],
                [78.5, 8, 8.7, 9.4, 10.2, 11.1, 12.1, 13.2],
                [79, 8.1, 8.7, 9.5, 10.3, 11.2, 12.2, 13.3],
                [79.5, 8.2, 8.8, 9.5, 10.4, 11.3, 12.3, 13.4],
                [80, 8.2, 8.9, 9.6, 10.4, 11.4, 12.4, 13.6],
                [80.5, 8.3, 9, 9.7, 10.5, 11.5, 12.5, 13.7],
                [81, 8.4, 9.1, 9.8, 10.6, 11.6, 12.6, 13.8],
                [81.5, 8.5, 9.1, 9.9, 10.7, 11.7, 12.7, 13.9],
                [82, 8.5, 9.2, 10, 10.8, 11.8, 12.8, 14],
                [82.5, 8.6, 9.3, 10.1, 10.9, 11.9, 13, 14.2],
                [83, 8.7, 9.4, 10.2, 11, 12, 13.1, 14.3],
                [83.5, 8.8, 9.5, 10.3, 11.2, 12.1, 13.2, 14.4],
                [84, 8.9, 9.6, 10.4, 11.3, 12.2, 13.3, 14.6],
                [84.5, 9, 9.7, 10.5, 11.4, 12.4, 13.5, 14.7],
                [85, 9.1, 9.8, 10.6, 11.5, 12.5, 13.6, 14.9],
                [85.5, 9.2, 9.9, 10.7, 11.6, 12.6, 13.7, 15],
                [86, 9.3, 10, 10.8, 11.7, 12.8, 13.9, 15.2],
                [86.5, 9.4, 10.1, 11, 11.9, 12.9, 14, 15.3],
                [87, 9.5, 10.2, 11.1, 12, 13, 14.2, 15.5],
                [87.5, 9.6, 10.4, 11.2, 12.1, 13.2, 14.3, 15.6],
                [88, 9.7, 10.5, 11.3, 12.2, 13.3, 14.5, 15.8],
                [88.5, 9.8, 10.6, 11.4, 12.4, 13.4, 14.6, 15.9],
                [89, 9.9, 10.7, 11.5, 12.5, 13.5, 14.7, 16.1],
                [89.5, 10, 10.8, 11.6, 12.6, 13.7, 14.9, 16.2],
                [90, 10.1, 10.9, 11.8, 12.7, 13.8, 15, 16.4],
                [90.5, 10.2, 11, 11.9, 12.8, 13.9, 15.1, 16.5],
                [91, 10.3, 11.1, 12, 13, 14.1, 15.3, 16.7],
                [91.5, 10.4, 11.2, 12.1, 13.1, 14.2, 15.4, 16.8],
                [92, 10.5, 11.3, 12.2, 13.2, 14.3, 15.6, 17],
                [92.5, 10.6, 11.4, 12.3, 13.3, 14.4, 15.7, 17.1],
                [93, 10.7, 11.5, 12.4, 13.4, 14.6, 15.8, 17.3],
                [93.5, 10.7, 11.6, 12.5, 13.5, 14.7, 16, 17.4],
                [94, 10.8, 11.7, 12.6, 13.7, 14.8, 16.1, 17.6],
                [94.5, 10.9, 11.8, 12.7, 13.8, 14.9, 16.3, 17.7],
                [95, 11, 11.9, 12.8, 13.9, 15.1, 16.4, 17.9],
                [95.5, 11.1, 12, 12.9, 14, 15.2, 16.5, 18],
                [96, 11.2, 12.1, 13.1, 14.1, 15.3, 16.7, 18.2],
                [96.5, 11.3, 12.2, 13.2, 14.3, 15.5, 16.8, 18.4],
                [97, 11.4, 12.3, 13.3, 14.4, 15.6, 17, 18.5],
                [97.5, 11.5, 12.4, 13.4, 14.5, 15.7, 17.1, 18.7],
                [98, 11.6, 12.5, 13.5, 14.6, 15.9, 17.3, 18.9],
                [98.5, 11.7, 12.6, 13.6, 14.8, 16, 17.5, 19.1],
                [99, 11.8, 12.7, 13.7, 14.9, 16.2, 17.6, 19.2],
                [99.5, 11.9, 12.8, 13.9, 15, 16.3, 17.8, 19.4],
                [100, 12, 12.9, 14, 15.2, 16.5, 18, 19.6],
                [100.5, 12.1, 13, 14.1, 15.3, 16.6, 18.1, 19.8],
                [101, 12.2, 13.2, 14.2, 15.4, 16.8, 18.3, 20],
                [101.5, 12.3, 13.3, 14.4, 15.6, 16.9, 18.5, 20.2],
                [102, 12.4, 13.4, 14.5, 15.7, 17.1, 18.7, 20.4],
                [102.5, 12.5, 13.5, 14.6, 15.9, 17.3, 18.8, 20.6],
                [103, 12.6, 13.6, 14.8, 16, 17.4, 19, 20.8],
                [103.5, 12.7, 13.7, 14.9, 16.2, 17.6, 19.2, 21],
                [104, 12.8, 13.9, 15, 16.3, 17.8, 19.4, 21.2],
                [104.5, 12.9, 14, 15.2, 16.5, 17.9, 19.6, 21.5],
                [105, 13, 14.1, 15.3, 16.6, 18.1, 19.8, 21.7],
                [105.5, 13.2, 14.2, 15.4, 16.8, 18.3, 20, 21.9],
                [106, 13.3, 14.4, 15.6, 16.9, 18.5, 20.2, 22.1],
                [106.5, 13.4, 14.5, 15.7, 17.1, 18.6, 20.4, 22.4],
                [107, 13.5, 14.6, 15.9, 17.3, 18.8, 20.6, 22.6],
                [107.5, 13.6, 14.7, 16, 17.4, 19, 20.8, 22.8],
                [108, 13.7, 14.9, 16.2, 17.6, 19.2, 21, 23.1],
                [108.5, 13.8, 15, 16.3, 17.8, 19.4, 21.2, 23.3],
                [109, 14, 15.1, 16.5, 17.9, 19.6, 21.4, 23.6],
                [109.5, 14.1, 15.3, 16.6, 18.1, 19.8, 21.7, 23.8],
                [110, 14.2, 15.4, 16.8, 18.3, 20, 21.9, 24.1]
            ],
            Q = [
                [65, 5.9, 6.3, 6.9, 7.4, 8.1, 8.8, 9.6],
                [65.5, 6, 6.4, 7, 7.6, 8.2, 8.9, 9.8],
                [66, 6.1, 6.5, 7.1, 7.7, 8.3, 9.1, 9.9],
                [66.5, 6.1, 6.6, 7.2, 7.8, 8.5, 9.2, 10.1],
                [67, 6.2, 6.7, 7.3, 7.9, 8.6, 9.4, 10.2],
                [67.5, 6.3, 6.8, 7.4, 8, 8.7, 9.5, 10.4],
                [68, 6.4, 6.9, 7.5, 8.1, 8.8, 9.6, 10.5],
                [68.5, 6.5, 7, 7.6, 8.2, 9, 9.8, 10.7],
                [69, 6.6, 7.1, 7.7, 8.4, 9.1, 9.9, 10.8],
                [69.5, 6.7, 7.2, 7.8, 8.5, 9.2, 10, 11],
                [70, 6.8, 7.3, 7.9, 8.6, 9.3, 10.2, 11.1],
                [70.5, 6.9, 7.4, 8, 8.7, 9.5, 10.3, 11.3],
                [71, 6.9, 7.5, 8.1, 8.8, 9.6, 10.4, 11.4],
                [71.5, 7, 7.6, 8.2, 8.9, 9.7, 10.6, 11.6],
                [72, 7.1, 7.7, 8.3, 9, 9.8, 10.7, 11.7],
                [72.5, 7.2, 7.8, 8.4, 9.1, 9.9, 10.8, 11.8],
                [73, 7.3, 7.9, 8.5, 9.2, 10, 11, 12],
                [73.5, 7.4, 7.9, 8.6, 9.3, 10.2, 11.1, 12.1],
                [74, 7.4, 8, 8.7, 9.4, 10.3, 11.2, 12.2],
                [74.5, 7.5, 8.1, 8.8, 9.5, 10.4, 11.3, 12.4],
                [75, 7.6, 8.2, 8.9, 9.6, 10.5, 11.4, 12.5],
                [75.5, 7.7, 8.3, 9, 9.7, 10.6, 11.6, 12.6],
                [76, 7.7, 8.4, 9.1, 9.8, 10.7, 11.7, 12.8],
                [76.5, 7.8, 8.5, 9.2, 9.9, 10.8, 11.8, 12.9],
                [77, 7.9, 8.5, 9.2, 10, 10.9, 11.9, 13],
                [77.5, 8, 8.6, 9.3, 10.1, 11, 12, 13.1],
                [78, 8, 8.7, 9.4, 10.2, 11.1, 12.1, 13.3],
                [78.5, 8.1, 8.8, 9.5, 10.3, 11.2, 12.2, 13.4],
                [79, 8.2, 8.8, 9.6, 10.4, 11.3, 12.3, 13.5],
                [79.5, 8.3, 8.9, 9.7, 10.5, 11.4, 12.4, 13.6],
                [80, 8.3, 9, 9.7, 10.6, 11.5, 12.6, 13.7],
                [80.5, 8.4, 9.1, 9.8, 10.7, 11.6, 12.7, 13.8],
                [81, 8.5, 9.2, 9.9, 10.8, 11.7, 12.8, 14],
                [81.5, 8.6, 9.3, 10, 10.9, 11.8, 12.9, 14.1],
                [82, 8.7, 9.3, 10.1, 11, 11.9, 13, 14.2],
                [82.5, 8.7, 9.4, 10.2, 11.1, 12.1, 13.1, 14.4],
                [83, 8.8, 9.5, 10.3, 11.2, 12.2, 13.3, 14.5],
                [83.5, 8.9, 9.6, 10.4, 11.3, 12.3, 13.4, 14.6],
                [84, 9, 9.7, 10.5, 11.4, 12.4, 13.5, 14.8],
                [84.5, 9.1, 9.9, 10.7, 11.5, 12.5, 13.7, 14.9],
                [85, 9.2, 10, 10.8, 11.7, 12.7, 13.8, 15.1],
                [85.5, 9.3, 10.1, 10.9, 11.8, 12.8, 13.9, 15.2],
                [86, 9.4, 10.2, 11, 11.9, 12.9, 14.1, 15.4],
                [86.5, 9.5, 10.3, 11.1, 12, 13.1, 14.2, 15.5],
                [87, 9.6, 10.4, 11.2, 12.2, 13.2, 14.4, 15.7],
                [87.5, 9.7, 10.5, 11.3, 12.3, 13.3, 14.5, 15.8],
                [88, 9.8, 10.6, 11.5, 12.4, 13.5, 14.7, 16],
                [88.5, 9.9, 10.7, 11.6, 12.5, 13.6, 14.8, 16.1],
                [89, 10, 10.8, 11.7, 12.6, 13.7, 14.9, 16.3],
                [89.5, 10.1, 10.9, 11.8, 12.8, 13.9, 15.1, 16.4],
                [90, 10.2, 11, 11.9, 12.9, 14, 15.2, 16.6],
                [90.5, 10.3, 11.1, 12, 13, 14.1, 15.3, 16.7],
                [91, 10.4, 11.2, 12.1, 13.1, 14.2, 15.5, 16.9],
                [91.5, 10.5, 11.3, 12.2, 13.2, 14.4, 15.6, 17],
                [92, 10.6, 11.4, 12.3, 13.4, 14.5, 15.8, 17.2],
                [92.5, 10.7, 11.5, 12.4, 13.5, 14.6, 15.9, 17.3],
                [93, 10.8, 11.6, 12.6, 13.6, 14.7, 16, 17.5],
                [93.5, 10.9, 11.7, 12.7, 13.7, 14.9, 16.2, 17.6],
                [94, 11, 11.8, 12.8, 13.8, 15, 16.3, 17.8],
                [94.5, 11.1, 11.9, 12.9, 13.9, 15.1, 16.5, 17.9],
                [95, 11.1, 12, 13, 14.1, 15.3, 16.6, 18.1],
                [95.5, 11.2, 12.1, 13.1, 14.2, 15.4, 16.7, 18.3],
                [96, 11.3, 12.2, 13.2, 14.3, 15.5, 16.9, 18.4],
                [96.5, 11.4, 12.3, 13.3, 14.4, 15.7, 17, 18.6],
                [97, 11.5, 12.4, 13.4, 14.6, 15.8, 17.2, 18.8],
                [97.5, 11.6, 12.5, 13.6, 14.7, 15.9, 17.4, 18.9],
                [98, 11.7, 12.6, 13.7, 14.8, 16.1, 17.5, 19.1],
                [98.5, 11.8, 12.8, 13.8, 14.9, 16.2, 17.7, 19.3],
                [99, 11.9, 12.9, 13.9, 15.1, 16.4, 17.9, 19.5],
                [99.5, 12, 13, 14, 15.2, 16.5, 18, 19.7],
                [100, 12.1, 13.1, 14.2, 15.4, 16.7, 18.2, 19.9],
                [100.5, 12.2, 13.2, 14.3, 15.5, 16.9, 18.4, 20.1],
                [101, 12.3, 13.3, 14.4, 15.6, 17, 18.5, 20.3],
                [101.5, 12.4, 13.4, 14.5, 15.8, 17.2, 18.7, 20.5],
                [102, 12.5, 13.6, 14.7, 15.9, 17.3, 18.9, 20.7],
                [102.5, 12.6, 13.7, 14.8, 16.1, 17.5, 19.1, 20.9],
                [103, 12.8, 13.8, 14.9, 16.2, 17.7, 19.3, 21.1],
                [103.5, 12.9, 13.9, 15.1, 16.4, 17.8, 19.5, 21.3],
                [104, 13, 14, 15.2, 16.5, 18, 19.7, 21.6],
                [104.5, 13.1, 14.2, 15.4, 16.7, 18.2, 19.9, 21.8],
                [105, 13.2, 14.3, 15.5, 16.8, 18.4, 20.1, 22],
                [105.5, 13.3, 14.4, 15.6, 17, 18.5, 20.3, 22.2],
                [106, 13.4, 14.5, 15.8, 17.2, 18.7, 20.5, 22.5],
                [106.5, 13.5, 14.7, 15.9, 17.3, 18.9, 20.7, 22.7],
                [107, 13.7, 14.8, 16.1, 17.5, 19.1, 20.9, 22.9],
                [107.5, 13.8, 14.9, 16.2, 17.7, 19.3, 21.1, 23.2],
                [108, 13.9, 15.1, 16.4, 17.8, 19.5, 21.3, 23.4],
                [108.5, 14, 15.2, 16.5, 18, 19.7, 21.5, 23.7],
                [109, 14.1, 15.3, 16.7, 18.2, 19.8, 21.8, 23.9],
                [109.5, 14.3, 15.5, 16.8, 18.3, 20, 22, 24.2],
                [110, 14.4, 15.6, 17, 18.5, 20.2, 22.2, 24.4],
                [110.5, 14.5, 15.8, 17.1, 18.7, 20.4, 22.4, 24.7],
                [111, 14.6, 15.9, 17.3, 18.9, 20.7, 22.7, 25],
                [111.5, 14.8, 16, 17.5, 19.1, 20.9, 22.9, 25.2],
                [112, 14.9, 16.2, 17.6, 19.2, 21.1, 23.1, 25.5],
                [112.5, 15, 16.3, 17.8, 19.4, 21.3, 23.4, 25.8],
                [113, 15.2, 16.5, 18, 19.6, 21.5, 23.6, 26],
                [113.5, 15.3, 16.6, 18.1, 19.8, 21.7, 23.9, 26.3],
                [114, 15.4, 16.8, 18.3, 20, 21.9, 24.1, 26.6],
                [114.5, 15.6, 16.9, 18.5, 20.2, 22.1, 24.4, 26.9],
                [115, 15.7, 17.1, 18.6, 20.4, 22.4, 24.6, 27.2],
                [115.5, 15.8, 17.2, 18.8, 20.6, 22.6, 24.9, 27.5],
                [116, 16, 17.4, 19, 20.8, 22.8, 25.1, 27.8],
                [116.5, 16.1, 17.5, 19.2, 21, 23, 25.4, 28],
                [117, 16.2, 17.7, 19.3, 21.2, 23.3, 25.6, 28.3],
                [117.5, 16.4, 17.9, 19.5, 21.4, 23.5, 25.9, 28.6],
                [118, 16.5, 18, 19.7, 21.6, 23.7, 26.1, 28.9],
                [118.5, 16.7, 18.2, 19.9, 21.8, 23.9, 26.4, 29.2],
                [119, 16.8, 18.3, 20, 22, 24.1, 26.6, 29.5],
                [119.5, 16.9, 18.5, 20.2, 22.2, 24.4, 26.9, 29.8],
                [120, 17.1, 18.6, 20.4, 22.4, 24.6, 27.2, 30.1]
            ],
            V = [
                [45, 1.9, 2.1, 2.3, 2.5, 2.7, 3, 3.3],
                [45.5, 2, 2.1, 2.3, 2.5, 2.8, 3.1, 3.4],
                [46, 2, 2.2, 2.4, 2.6, 2.9, 3.2, 3.5],
                [46.5, 2.1, 2.3, 2.5, 2.7, 3, 3.3, 3.6],
                [47, 2.2, 2.4, 2.6, 2.8, 3.1, 3.4, 3.7],
                [47.5, 2.2, 2.4, 2.6, 2.9, 3.2, 3.5, 3.8],
                [48, 2.3, 2.5, 2.7, 3, 3.3, 3.6, 4],
                [48.5, 2.4, 2.6, 2.8, 3.1, 3.4, 3.7, 4.1],
                [49, 2.4, 2.6, 2.9, 3.2, 3.5, 3.8, 4.2],
                [49.5, 2.5, 2.7, 3, 3.3, 3.6, 3.9, 4.3],
                [50, 2.6, 2.8, 3.1, 3.4, 3.7, 4, 4.5],
                [50.5, 2.7, 2.9, 3.2, 3.5, 3.8, 4.2, 4.6],
                [51, 2.8, 3, 3.3, 3.6, 3.9, 4.3, 4.8],
                [51.5, 2.8, 3.1, 3.4, 3.7, 4, 4.4, 4.9],
                [52, 2.9, 3.2, 3.5, 3.8, 4.2, 4.6, 5.1],
                [52.5, 3, 3.3, 3.6, 3.9, 4.3, 4.7, 5.2],
                [53, 3.1, 3.4, 3.7, 4, 4.4, 4.9, 5.4],
                [53.5, 3.2, 3.5, 3.8, 4.2, 4.6, 5, 5.5],
                [54, 3.3, 3.6, 3.9, 4.3, 4.7, 5.2, 5.7],
                [54.5, 3.4, 3.7, 4, 4.4, 4.8, 5.3, 5.9],
                [55, 3.5, 3.8, 4.2, 4.5, 5, 5.5, 6.1],
                [55.5, 3.6, 3.9, 4.3, 4.7, 5.1, 5.7, 6.3],
                [56, 3.7, 4, 4.4, 4.8, 5.3, 5.8, 6.4],
                [56.5, 3.8, 4.1, 4.5, 5, 5.4, 6, 6.6],
                [57, 3.9, 4.3, 4.6, 5.1, 5.6, 6.1, 6.8],
                [57.5, 4, 4.4, 4.8, 5.2, 5.7, 6.3, 7],
                [58, 4.1, 4.5, 4.9, 5.4, 5.9, 6.5, 7.1],
                [58.5, 4.2, 4.6, 5, 5.5, 6, 6.6, 7.3],
                [59, 4.3, 4.7, 5.1, 5.6, 6.2, 6.8, 7.5],
                [59.5, 4.4, 4.8, 5.3, 5.7, 6.3, 6.9, 7.7],
                [60, 4.5, 4.9, 5.4, 5.9, 6.4, 7.1, 7.8],
                [60.5, 4.6, 5, 5.5, 6, 6.6, 7.3, 8],
                [61, 4.7, 5.1, 5.6, 6.1, 6.7, 7.4, 8.2],
                [61.5, 4.8, 5.2, 5.7, 6.3, 6.9, 7.6, 8.4],
                [62, 4.9, 5.3, 5.8, 6.4, 7, 7.7, 8.5],
                [62.5, 5, 5.4, 5.9, 6.5, 7.1, 7.8, 8.7],
                [63, 5.1, 5.5, 6, 6.6, 7.3, 8, 8.8],
                [63.5, 5.2, 5.6, 6.2, 6.7, 7.4, 8.1, 9],
                [64, 5.3, 5.7, 6.3, 6.9, 7.5, 8.3, 9.1],
                [64.5, 5.4, 5.8, 6.4, 7, 7.6, 8.4, 9.3],
                [65, 5.5, 5.9, 6.5, 7.1, 7.8, 8.6, 9.5],
                [65.5, 5.5, 6, 6.6, 7.2, 7.9, 8.7, 9.6],
                [66, 5.6, 6.1, 6.7, 7.3, 8, 8.8, 9.8],
                [66.5, 5.7, 6.2, 6.8, 7.4, 8.1, 9, 9.9],
                [67, 5.8, 6.3, 6.9, 7.5, 8.3, 9.1, 10],
                [67.5, 5.9, 6.4, 7, 7.6, 8.4, 9.2, 10.2],
                [68, 6, 6.5, 7.1, 7.7, 8.5, 9.4, 10.3],
                [68.5, 6.1, 6.6, 7.2, 7.9, 8.6, 9.5, 10.5],
                [69, 6.1, 6.7, 7.3, 8, 8.7, 9.6, 10.6],
                [69.5, 6.2, 6.8, 7.4, 8.1, 8.8, 9.7, 10.7],
                [70, 6.3, 6.9, 7.5, 8.2, 9, 9.9, 10.9],
                [70.5, 6.4, 6.9, 7.6, 8.3, 9.1, 10, 11],
                [71, 6.5, 7, 7.7, 8.4, 9.2, 10.1, 11.1],
                [71.5, 6.5, 7.1, 7.7, 8.5, 9.3, 10.2, 11.3],
                [72, 6.6, 7.2, 7.8, 8.6, 9.4, 10.3, 11.4],
                [72.5, 6.7, 7.3, 7.9, 8.7, 9.5, 10.5, 11.5],
                [73, 6.8, 7.4, 8, 8.8, 9.6, 10.6, 11.7],
                [73.5, 6.9, 7.4, 8.1, 8.9, 9.7, 10.7, 11.8],
                [74, 6.9, 7.5, 8.2, 9, 9.8, 10.8, 11.9],
                [74.5, 7, 7.6, 8.3, 9.1, 9.9, 10.9, 12],
                [75, 7.1, 7.7, 8.4, 9.1, 10, 11, 12.2],
                [75.5, 7.1, 7.8, 8.5, 9.2, 10.1, 11.1, 12.3],
                [76, 7.2, 7.8, 8.5, 9.3, 10.2, 11.2, 12.4],
                [76.5, 7.3, 7.9, 8.6, 9.4, 10.3, 11.4, 12.5],
                [77, 7.4, 8, 8.7, 9.5, 10.4, 11.5, 12.6],
                [77.5, 7.4, 8.1, 8.8, 9.6, 10.5, 11.6, 12.8],
                [78, 7.5, 8.2, 8.9, 9.7, 10.6, 11.7, 12.9],
                [78.5, 7.6, 8.2, 9, 9.8, 10.7, 11.8, 13],
                [79, 7.7, 8.3, 9.1, 9.9, 10.8, 11.9, 13.1],
                [79.5, 7.7, 8.4, 9.1, 10, 10.9, 12, 13.3],
                [80, 7.8, 8.5, 9.2, 10.1, 11, 12.1, 13.4],
                [80.5, 7.9, 8.6, 9.3, 10.2, 11.2, 12.3, 13.5],
                [81, 8, 8.7, 9.4, 10.3, 11.3, 12.4, 13.7],
                [81.5, 8.1, 8.8, 9.5, 10.4, 11.4, 12.5, 13.8],
                [82, 8.1, 8.8, 9.6, 10.5, 11.5, 12.6, 13.9],
                [82.5, 8.2, 8.9, 9.7, 10.6, 11.6, 12.8, 14.1],
                [83, 8.3, 9, 9.8, 10.7, 11.8, 12.9, 14.2],
                [83.5, 8.4, 9.1, 9.9, 10.9, 11.9, 13.1, 14.4],
                [84, 8.5, 9.2, 10.1, 11, 12, 13.2, 14.5],
                [84.5, 8.6, 9.3, 10.2, 11.1, 12.1, 13.3, 14.7],
                [85, 8.7, 9.4, 10.3, 11.2, 12.3, 13.5, 14.9],
                [85.5, 8.8, 9.5, 10.4, 11.3, 12.4, 13.6, 15],
                [86, 8.9, 9.7, 10.5, 11.5, 12.6, 13.8, 15.2],
                [86.5, 9, 9.8, 10.6, 11.6, 12.7, 13.9, 15.4],
                [87, 9.1, 9.9, 10.7, 11.7, 12.8, 14.1, 15.5],
                [87.5, 9.2, 10, 10.9, 11.8, 13, 14.2, 15.7],
                [88, 9.3, 10.1, 11, 12, 13.1, 14.4, 15.9],
                [88.5, 9.4, 10.2, 11.1, 12.1, 13.2, 14.5, 16],
                [89, 9.5, 10.3, 11.2, 12.2, 13.4, 14.7, 16.2],
                [89.5, 9.6, 10.4, 11.3, 12.3, 13.5, 14.8, 16.4],
                [90, 9.7, 10.5, 11.4, 12.5, 13.7, 15, 16.5],
                [90.5, 9.8, 10.6, 11.5, 12.6, 13.8, 15.1, 16.7],
                [91, 9.9, 10.7, 11.7, 12.7, 13.9, 15.3, 16.9],
                [91.5, 10, 10.8, 11.8, 12.8, 14.1, 15.5, 17],
                [92, 10.1, 10.9, 11.9, 13, 14.2, 15.6, 17.2],
                [92.5, 10.1, 11, 12, 13.1, 14.3, 15.8, 17.4],
                [93, 10.2, 11.1, 12.1, 13.2, 14.5, 15.9, 17.5],
                [93.5, 10.3, 11.2, 12.2, 13.3, 14.6, 16.1, 17.7],
                [94, 10.4, 11.3, 12.3, 13.5, 14.7, 16.2, 17.9],
                [94.5, 10.5, 11.4, 12.4, 13.6, 14.9, 16.4, 18],
                [95, 10.6, 11.5, 12.6, 13.7, 15, 16.5, 18.2],
                [95.5, 10.7, 11.6, 12.7, 13.8, 15.2, 16.7, 18.4],
                [96, 10.8, 11.7, 12.8, 14, 15.3, 16.8, 18.6],
                [96.5, 10.9, 11.8, 12.9, 14.1, 15.4, 17, 18.7],
                [97, 11, 12, 13, 14.2, 15.6, 17.1, 18.9],
                [97.5, 11.1, 12.1, 13.1, 14.4, 15.7, 17.3, 19.1],
                [98, 11.2, 12.2, 13.3, 14.5, 15.9, 17.5, 19.3],
                [98.5, 11.3, 12.3, 13.4, 14.6, 16, 17.6, 19.5],
                [99, 11.4, 12.4, 13.5, 14.8, 16.2, 17.8, 19.6],
                [99.5, 11.5, 12.5, 13.6, 14.9, 16.3, 18, 19.8],
                [100, 11.6, 12.6, 13.7, 15, 16.5, 18.1, 20],
                [100.5, 11.7, 12.7, 13.9, 15.2, 16.6, 18.3, 20.2],
                [101, 11.8, 12.8, 14, 15.3, 16.8, 18.5, 20.4],
                [101.5, 11.9, 13, 14.1, 15.5, 17, 18.7, 20.6],
                [102, 12, 13.1, 14.3, 15.6, 17.1, 18.9, 20.8],
                [102.5, 12.1, 13.2, 14.4, 15.8, 17.3, 19, 21],
                [103, 12.3, 13.3, 14.5, 15.9, 17.5, 19.2, 21.3],
                [103.5, 12.4, 13.5, 14.7, 16.1, 17.6, 19.4, 21.5],
                [104, 12.5, 13.6, 14.8, 16.2, 17.8, 19.6, 21.7],
                [104.5, 12.6, 13.7, 15, 16.4, 18, 19.8, 21.9],
                [105, 12.7, 13.8, 15.1, 16.5, 18.2, 20, 22.2],
                [105.5, 12.8, 14, 15.3, 16.7, 18.4, 20.2, 22.4],
                [106, 13, 14.1, 15.4, 16.9, 18.5, 20.5, 22.6],
                [106.5, 13.1, 14.3, 15.6, 17.1, 18.7, 20.7, 22.9],
                [107, 13.2, 14.4, 15.7, 17.2, 18.9, 20.9, 23.1],
                [107.5, 13.3, 14.5, 15.9, 17.4, 19.1, 21.1, 23.4],
                [108, 13.5, 14.7, 16, 17.6, 19.3, 21.3, 23.6],
                [108.5, 13.6, 14.8, 16.2, 17.8, 19.5, 21.6, 23.9],
                [109, 13.7, 15, 16.4, 18, 19.7, 21.8, 24.2],
                [109.5, 13.9, 15.1, 16.5, 18.1, 20, 22, 24.4],
                [110, 14, 15.3, 16.7, 18.3, 20.2, 22.3, 24.7]
            ],
            X = [
                [65, 5.6, 6.1, 6.6, 7.2, 7.9, 8.7, 9.7],
                [65.5, 5.7, 6.2, 6.7, 7.4, 8.1, 8.9, 9.8],
                [66, 5.8, 6.3, 6.8, 7.5, 8.2, 9, 10],
                [66.5, 5.8, 6.4, 6.9, 7.6, 8.3, 9.1, 10.1],
                [67, 5.9, 6.4, 7, 7.7, 8.4, 9.3, 10.2],
                [67.5, 6, 6.5, 7.1, 7.8, 8.5, 9.4, 10.4],
                [68, 6.1, 6.6, 7.2, 7.9, 8.7, 9.5, 10.5],
                [68.5, 6.2, 6.7, 7.3, 8, 8.8, 9.7, 10.7],
                [69, 6.3, 6.8, 7.4, 8.1, 8.9, 9.8, 10.8],
                [69.5, 6, 6.9, 7.5, 8.2, 9, 9.9, 10.9],
                [70, 6.4, 7, 7.6, 8.3, 9.1, 10, 11.1],
                [70.5, 6.5, 7.1, 7.7, 8.4, 9.2, 10.1, 11.2],
                [71, 6.6, 7.1, 7.8, 8.5, 9.3, 10.3, 11.3],
                [71.5, 6.7, 7.2, 7.9, 8.6, 9.4, 10.4, 11.5],
                [72, 6.7, 7.3, 8, 8.7, 9.5, 10.5, 11.6],
                [72.5, 6.8, 7.4, 8.1, 8.8, 9.7, 10.6, 11.7],
                [73, 6.9, 7.5, 8.1, 8.9, 9.8, 10.7, 11.8],
                [73.5, 7, 7.6, 8.2, 9, 9.9, 10.8, 12],
                [74, 7, 7.6, 8.3, 9.1, 10, 11, 12.1],
                [74.5, 7.1, 7.7, 8.4, 9.2, 10.1, 11.1, 12.2],
                [75, 7.2, 7.8, 8.5, 9.3, 10.2, 11.2, 12.3],
                [75.5, 7.2, 7.9, 8.6, 9.4, 10.3, 11.3, 12.5],
                [76, 7.3, 8, 8.7, 9.5, 10.4, 11.4, 12.6],
                [76.5, 7.4, 8, 8.7, 9.6, 10.5, 11.5, 12.7],
                [77, 7.5, 8.1, 8.8, 9.6, 10.6, 11.6, 12.8],
                [77.5, 7.5, 8.2, 8.9, 9.7, 10.7, 11.7, 12.9],
                [78, 7.6, 8.3, 9, 9.8, 10.8, 11.8, 13.1],
                [78.5, 7.7, 8.4, 9.1, 9.9, 10.9, 12, 13.2],
                [79, 7.8, 8.4, 9.2, 10, 11, 12.1, 13.3],
                [79.5, 7.8, 8.5, 9.3, 10.1, 11.1, 12.2, 13.4],
                [80, 7.9, 8.6, 9.4, 10.2, 11.2, 12.3, 13.6],
                [80.5, 8, 8.7, 9.5, 10.3, 11.3, 12.4, 13.7],
                [81, 8.1, 8.8, 9.6, 10.4, 11.4, 12.6, 13.9],
                [81.5, 8.2, 8.9, 9.7, 10.6, 11.6, 12.7, 14],
                [82, 8.3, 9, 9.8, 10.7, 11.7, 12.8, 14.1],
                [82.5, 8.4, 9.1, 9.9, 10.8, 11.8, 13, 14.3],
                [83, 8.5, 9.2, 10, 10.9, 11.9, 13.1, 14.5],
                [83.5, 8.5, 9.3, 10.1, 11, 12.1, 13.3, 14.6],
                [84, 8.6, 9.4, 10.2, 11.1, 12.2, 13.4, 14.8],
                [84.5, 8.7, 9.5, 10.3, 11.3, 12.3, 13.5, 14.9],
                [85, 8.8, 9.6, 10.4, 11.4, 12.5, 13.7, 15.1],
                [85.5, 8.9, 9.7, 10.6, 11.5, 12.6, 13.8, 15.3],
                [86, 9, 9.8, 10.7, 11.6, 12.7, 14, 15.4],
                [86.5, 9.1, 9.9, 10.8, 11.8, 12.9, 14.2, 15.6],
                [87, 9.2, 10, 10.9, 11.9, 13, 14.3, 15.8],
                [87.5, 9.3, 10.1, 11, 12, 13.2, 14.5, 15.9],
                [88, 9.4, 10.2, 11.1, 12.1, 13.3, 14.6, 16.1],
                [88.5, 9.5, 10.3, 11.2, 12.3, 13.4, 14.8, 16.3],
                [89, 9.6, 10.4, 11.4, 12.4, 13.6, 14.9, 16.4],
                [89.5, 9.7, 10.5, 11.5, 12.5, 13.7, 15.1, 16.6],
                [90, 9.8, 10.6, 11.6, 12.6, 13.8, 15.2, 16.8],
                [90.5, 9.9, 10.7, 11.7, 12.8, 14, 15.4, 16.9],
                [91, 10, 10.9, 11.8, 12.9, 14.1, 15.5, 17.1],
                [91.5, 10.1, 11, 11.9, 13, 14.3, 15.7, 17.3],
                [92, 10.2, 11.1, 12, 13.1, 14.4, 15.8, 17.4],
                [92.5, 10.3, 11.2, 12.1, 13.3, 14.5, 16, 17.6],
                [93, 10.4, 11.3, 12.3, 13.4, 14.7, 16.1, 17.8],
                [93.5, 10.5, 11.4, 12.4, 13.5, 14.8, 16.3, 17.9],
                [94, 10.6, 11.5, 12.5, 13.6, 14.9, 16.4, 18.1],
                [94.5, 10.7, 11.6, 12.6, 13.8, 15.1, 16.6, 18.3],
                [95, 10.8, 11.7, 12.7, 13.9, 15.2, 16.7, 18.5],
                [95.5, 10.8, 11.8, 12.8, 14, 15.4, 16.9, 18.6],
                [96, 10.9, 11.9, 12.9, 14.1, 15.5, 17, 18.8],
                [96.5, 11, 12, 13.1, 14.3, 15.6, 17.2, 19],
                [97, 11.1, 12.1, 13.2, 14.4, 15.8, 17.4, 19.2],
                [97.5, 11.2, 12.2, 13.3, 14.5, 15.9, 17.5, 19.3],
                [98, 11.3, 12.3, 13.4, 14.7, 16.1, 17.7, 19.5],
                [98.5, 11.4, 12.4, 13.5, 14.8, 16.2, 17.9, 19.7],
                [99, 11.5, 12.5, 13.7, 14.9, 16.4, 18, 19.9],
                [99.5, 11.6, 12.7, 13.8, 15.1, 16.5, 18.2, 20.1],
                [100, 11.7, 12.8, 13.9, 15.2, 16.7, 18.4, 20.3],
                [100.5, 11.9, 12.9, 14.1, 15.4, 16.9, 18.6, 20.5],
                [101, 12, 13, 14.2, 15.5, 17, 18.7, 20.7],
                [101.5, 12.1, 13.1, 14.3, 15.7, 17.2, 18.9, 20.9],
                [102, 12.2, 13.3, 14.5, 15.8, 17.4, 19.1, 21.1],
                [102.5, 12.3, 13.4, 14.6, 16, 17.5, 19.3, 21.4],
                [103, 12.4, 13.5, 14.7, 16.1, 17.7, 19.5, 21.6],
                [103.5, 12.5, 13.6, 14.9, 16.3, 17.9, 19.7, 21.8],
                [104, 12.6, 13.8, 15, 16.4, 18.1, 19.9, 22],
                [104.5, 12.8, 13.9, 15.2, 16.6, 18.2, 20.1, 22.3],
                [105, 12.9, 14, 15.3, 16.8, 18.4, 20.3, 22.5],
                [105.5, 13, 14.2, 15.5, 16.9, 18.6, 20.5, 22.7],
                [106, 13.1, 14.3, 15.6, 17.1, 18.8, 20.8, 23],
                [106.5, 13.3, 14.5, 15.8, 17.3, 19, 21, 23.2],
                [107, 13.4, 14.6, 15.9, 17.5, 19.2, 21.2, 23.5],
                [107.5, 13.5, 14.7, 16.1, 17.7, 19.4, 21.4, 23.7],
                [108, 13.7, 14.9, 16.3, 17.8, 19.6, 21.7, 24],
                [108.5, 13.8, 15, 16.4, 18, 19.8, 21.9, 24.3],
                [109, 13.9, 15.2, 16.6, 18.2, 20, 22.1, 24.5],
                [109.5, 14.1, 15.4, 16.8, 18.4, 20.3, 22.4, 24.8],
                [110, 14.2, 15.5, 17, 18.6, 20.5, 22.6, 25.1],
                [110.5, 14.4, 15.7, 17.1, 18.8, 20.7, 22.9, 25.4],
                [111, 14.5, 15.8, 17.3, 19, 20.9, 23.1, 25.7],
                [111.5, 14.7, 16, 17.5, 19.2, 21.2, 23.4, 26],
                [112, 14.8, 16.2, 17.7, 19.4, 21.4, 23.6, 26.2],
                [112.5, 15, 16.3, 17.9, 19.6, 21.6, 23.9, 26.5],
                [113, 15.1, 16.5, 18, 19.8, 21.8, 24.2, 26.8],
                [113.5, 15.3, 16.7, 18.2, 20, 22.1, 24.4, 27.1],
                [114, 15.4, 16.8, 18.4, 20.2, 22.3, 24.7, 27.4],
                [114.5, 15.6, 17, 18.6, 20.5, 22.6, 25, 27.8],
                [115, 15.7, 17.2, 18.8, 20.7, 22.8, 25.2, 28.1],
                [115.5, 15.9, 17.3, 19, 20.9, 23, 25.5, 28.4],
                [116, 16, 17.5, 19.2, 21.1, 23.3, 25.8, 28.7],
                [116.5, 16.2, 17.7, 19.4, 21.3, 23.5, 26.1, 29],
                [117, 16.3, 17.8, 19.6, 21.5, 23.8, 26.3, 29.3],
                [117.5, 16.5, 18, 19.8, 21.7, 24, 26.6, 29.6],
                [118, 16.6, 18.2, 19.9, 22, 24.2, 26.9, 29.9],
                [118.5, 16.8, 18.4, 20.1, 22.2, 24.5, 27.2, 30.3],
                [119, 16.9, 18.5, 20.3, 22.4, 24.7, 27.4, 30.6],
                [119.5, 17.1, 18.7, 20.5, 22.6, 25, 27.7, 30.9],
                [120, 17.3, 18.9, 20.7, 22.8, 25.2, 28, 31.2]
            ],
            Y = "";
        $(document).on("click", ".cls_img__jenis_kelamin", function() {
            "Anak laki-laki" == $(this).attr("alt") ? (Y = "l", $(".cl_span__anak_perempuan").html(""), $(".cl_span__anak_laki").html('<i class="fa-solid fa-check" style="font-size:40pt; color: #8EC21F;"></i>')) : ($(".cl_span__anak_laki").html(""), $(".cl_span__anak_perempuan").html('<i class="fa-solid fa-check" style="color: #8EC21F;font-size:40pt ; "></i>'), Y = "p"), setTimeout(function() {
                $("#id_kolom__umur").focus(), $(".cls_img__jenis_kelamin").css("opacity", "1")
            }, 200)
        }), $(document).on("click", "#id_tombol__hitung", function(a) {
            a.preventDefault(), R = $("#id_kolom__umur").val(), M = $("#id_kolom__berat_badan").val(), E = $("#id_kolom__tinggi_badan").val();
            var n = /^[-+]?[0-9]+\.[0-9]+$/;
            if ("" == R || "" == Y || "" == M || "" == E) {
                if ("" == Y) return $("#id_span__isi_modal").html("Mohon memilih <strong>Jenis Kelamin</strong> anak (klik gambar icon anak)."), void $("#id_modal__info").modal({
                    inverted: !0
                }).modal("show");
                if ("" == R) return $("#id_kolom__umur").focus(), $("#id_span__isi_modal").html("Mohon mengisi <strong>kolom Usia Anak</strong>."), void $("#id_modal__info").modal({
                    inverted: !0
                }).modal("show");
                if (R < 0 || 60 < R) return $("#id_kolom__umur").focus(), $("#id_span__isi_modal").html("Mohon mengisi <strong>kolom Usia Anak</strong> dalam rentang usia <strong>0 - 60</strong> bulan."), void $("#id_modal__info").modal({
                    inverted: !0
                }).modal("show");
                if ("" == M) return $("#id_kolom__berat_badan").focus(), $("#id_span__isi_modal").html("Mohon mengisi <strong>kolom Berat Badan Anak</strong>."), void $("#id_modal__info").modal({
                    inverted: !0
                }).modal("show");
                if ("" == E) return $("#id_kolom__tinggi_badan").focus(), $("#id_span__isi_modal").html("Mohon mengisi <strong>kolom Tinggi Badan Anak</strong>."), void $("#id_modal__info").modal({
                    inverted: !0
                }).modal("show")
            } else {
                if (!/^[0-9]+$/.test(R)) return $("#id_kolom__umur").val(""), $("#id_kolom__umur").focus(), $("#id_span__isi_modal").html("Mohon isian berupa angka dalam <strong>kolom Usia Anak</strong>."), void $("#id_modal__info").modal({
                    inverted: !0
                }).modal("show");
                if (!M.match(n)) return $("#id_kolom__berat_badan").val(""), $("#id_kolom__berat_badan").focus(), $("#id_span__isi_modal").html("Mohon isian berupa angka (desimal) dalam <strong>kolom Berat Badan Anak</strong>."), void $("#id_modal__info").modal({
                    inverted: !0
                }).modal("show");
                if (!E.match(n)) return $("#id_kolom__tinggi_badan").val(""), $("#id_kolom__tinggi_badan").focus(), $("#id_span__isi_modal").html("Mohon isian berupa angka (desimal) dalam <strong>kolom Tinggi Badan Anak</strong>."), void $("#id_modal__info").modal({
                    inverted: !0
                }).modal("show")
            }
            var i = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent),
                t = ".00" == M.substr(M.length - 3) ? M.slice(0, -3) : M,
                o = ".00" == E.substr(E.length - 3) ? E.slice(0, -3) : E,
                e = '<table class="cls_table__data_anak"><tr><td style="width:15px;padding-left:0px;padding-right:0px;"><i class=\'angle right icon\'></i></td><td class="cl_td__label">Jenis Kelamin</td><td class="cl_td__kolon">:</td><td class="cl_td__variabel">' + ("l" == Y ? "Laki-laki" : "Perempuan") + '</td><td class="cl_td__spasi">&nbsp;</td><td style="width:15px;padding-left:0px;padding-right:0px;"><i class=\'angle right icon\'></i></td><td class="cl_td__label">Berat Badan</td><td class="cl_td__kolon">:</td><td class="cl_td__variabel">' + t + " Kg</td></tr><tr><td style=\"width:15px;padding-left:0px;padding-right:0px;\"><i class='angle right icon'></i></td><td>Usia</td><td>:</td><td>" + R + " Bulan</td><td>&nbsp;</td><td style=\"width:15px;padding-left:0px;padding-right:0px;\"><i class='angle right icon'></i></td><td>Tinggi Badan</td><td>:</td><td>" + o + " Cm</td></tr></table>",
                a = '<table class="cls_table__data_anak_mobile"><tr><td style="width:15px;padding-left:0px;padding-right:0px;"><i class=\'angle right icon\'></i></td><td style="width:120px;">Jenis Kelamin</td><td style="width:8px;">:</td><td>' + ("l" == Y ? "Laki-laki" : "Perempuan") + "</td></tr><tr><td style=\"width:15px;padding-left:0px;padding-right:0px;\"><i class='angle right icon'></i></td><td>Berat Badan</td><td>:</td><td>" + t + " Kg</td></tr><tr><td style=\"width:15px;padding-left:0px;padding-right:0px;\"><i class='angle right icon'></i></td><td>Usia</td><td>:</td><td>" + R + " Bulan</td></tr><tr><td style=\"width:15px;padding-left:0px;padding-right:0px;\"><i class='angle right icon'></i></td><td>Tinggi Badan</td><td>:</td><td>" + o + " Cm</td></tr></table>";
            $(".cl_span__data_anak").html(i ? a : e), $(".cls_span__rentang_umur").html(0 <= R && R <= 24 ? "0 - 24" : "25 - 60"), $(".cls_span__jenis_kelamin").html("l" == Y ? "Laki-laki" : "Perempuan");
            var n = 0 <= R && R <= 24 ? I : K,
                t = 0 <= R && R <= 24 ? U : N,
                o = 0 <= R && R <= 24 ? j : J,
                i = 0 <= R && R <= 24 ? L : q,
                a = 0 <= R && R <= 24 ? G : Q,
                e = 0 <= R && R <= 24 ? V : X,
                d = "l" == Y ? n : t,
                l = "l" == Y ? o : i,
                s = "l" == Y ? a : e,
                r = "l" == Y ? n : t,
                _ = "l" == Y ? o : i,
                m = "l" == Y ? a : e,
                g = [];
            for (O in d) R == d[O][0] ? g.push(M) : g.push(null);
            var e = {
                    label: "Anak Anda",
                    stack: "Stack 0",
                    data: g,
                    backgroundColor: "rgba(0, 0, 255)",
                    borderColor: "rgba(0, 0, 255)",
                    borderWidth: 1,
                    pointStyle: "cirlce",
                    pointRadius: 3,
                    pointHoverRadius: 4,
                    animations: {
                        hover: {
                            mode: !1
                        },
                        radius: {
                            duration: 300,
                            easing: "linear",
                            loop: !0,
                            delay: 0
                        }
                    }
                },
                h = Z(P, d, 0);
            h.unshift(e);
            var c = [];
            for (O in l) R == l[O][0] ? c.push(E) : c.push(null);
            var e = {
                    label: "Anak Anda",
                    stack: "Stack 0",
                    data: c,
                    backgroundColor: "rgba(0, 0, 255)",
                    borderColor: "rgba(0, 0, 255)",
                    borderWidth: 1,
                    pointStyle: "cirlce",
                    pointRadius: 2,
                    pointHoverRadius: 3,
                    animations: {
                        hover: {
                            mode: !1
                        },
                        radius: {
                            duration: 300,
                            easing: "linear",
                            loop: !0,
                            delay: 0
                        }
                    }
                },
                u = Z(P, l, 0);
            u.unshift(e), E *= 2, E = Math.round(E), E /= 2;
            var b = [];
            for (O in s) E == s[O][0] ? b.push(M) : b.push(null);
            var p, k, f, v, w, y, x, B, S, A, z, C, O, e = {
                    label: "Anak Anda",
                    stack: "Stack 0",
                    data: b,
                    backgroundColor: "rgba(0, 0, 255)",
                    borderColor: "rgba(0, 0, 255)",
                    borderWidth: 1,
                    pointStyle: "cirlce",
                    pointRadius: 2,
                    pointHoverRadius: 3,
                    animations: {
                        hover: {
                            mode: !1
                        },
                        radius: {
                            duration: 300,
                            easing: "linear",
                            loop: !0,
                            delay: 0
                        }
                    }
                },
                D = Z(P, s, 0);
            for (O in D.unshift(e), d) R == d[O][0] && (p = d[O][1], k = d[O][2], d[O][3], f = d[O][4], d[O][5], v = d[O][6], d[O][7]);
            for (O in M < p ? $("#id_span__info_bb_umur").html(" Berat badan anak anda menurut umur <strong>Sangat Kurang</strong>, perlu perbaikan gizi dengan makanan sehat dan bergizi.") : p <= M && M < k ? $("#id_span__info_bb_umur").html("Berat badan anak anda menurut umur <strong>Kurang</strong>, perlu perbaikan gizi dengan makanan sehat dan bergizi.") : k <= M && M <= v ? $("#id_span__info_bb_umur").html("Berat badan anak anda menurut umur <strong>Normal</strong>, tetap pertahankan dengan memberi makanan sehat dan bergizi.") : v < M && $("#id_span__info_bb_umur").html("Berat badan anak anda menurut umur <strong>Lebih</strong>, perlu perbaikan gizi dengan makanan sehat dan bergizi."), $("#id_span__rekomendasi_bb_umur").html("berat badan anak seharusnya <strong>" + f + " kg</strong>."), l) R == l[O][0] && (w = l[O][1], y = l[O][2], l[O][3], x = l[O][4], l[O][5], B = l[O][6], l[O][7]);
            for (O in E < w ? $("#id_span__info_tb_umur").html("Berdasarkan umur, tinggi badan anak dalam kategori <strong>sangat pendek</strong>.") : w <= E && E < y ? $("#id_span__info_tb_umur").html("Berdasarkan umur, tinggi badan anak dalam kategori <strong>pendek</strong>.") : y <= E && E <= B ? $("#id_span__info_tb_umur").html("Tinggi badan anak <strong>sudah sesuai dengan umur</strong>.") : B < E && $("#id_span__info_tb_umur").html("Berdasarkan umur, tinggi badan anak dalam <strong>kategori sangat tinggi</strong>."), $("#id_span__rekomendasi_tb_umur").html("tinggi badan anak seharusnya <strong>" + x + " cm</strong>."), s) E == s[O][0] && (S = s[O][1], A = s[O][2], s[O][3], z = s[O][4], s[O][5], C = s[O][6], s[O][7]);
            M < S ? $("#id_span__info_bb_tb").html("Berdasarkan tinggi badan, berat badan anak dalam <strong>kategori Gizi Buruk</strong>.") : S <= M && M < A ? $("#id_span__info_bb_tb").html("Berdasarkan tinggi badan, berat badan anak dalam <strong>kategori Gizi Kurang</strong>.") : A <= M && M <= C ? $("#id_span__info_bb_tb").html("Berdasarkan tinggi badan, berat badan anak anda <strong>Gizi Baik / Normal</strong>.") : C <= M && $("#id_span__info_bb_tb").html("Berdasarkan tinggi badan, berat badan anak dalam <strong>kategori Gizi Lebih </strong>."), $("#id_span__rekomendasi_bb_tb").html("berat badan anak seharusnya <strong>" + z + " kg</strong>."), $("#id_segment__formulir").fadeOut("slow", function() {
                $("#id_segment__hasil_analisis").removeClass("clsHideElement").fadeIn("slow", function() {
                    $("html, body").animate({
                        scrollTop: $("#id_segment__hasil_analisis").offset().top
                    }, 1e3)
                })
            })
        }), $(document).on("click", "#id_tombol__data_baru", function(a) {
            window.reload();
      
        }), $(document).on("click", "#id_tombol__reset_zoom", function(a) {
            a.preventDefault(), F.resetZoom(), W.resetZoom(), H.resetZoom()
        }), $(window).on("orientationchange", function(a) {
            F.resize(), W.resize(), H.resize(), F.resetZoom(), W.resetZoom(), H.resetZoom()
        })
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js" integrity="sha512-GWzVrcGlo0TxTRvz9ttioyYJ+Wwk9Ck0G81D+eO63BaqHaJ3YZX9wuqjwgfcV/MrB2PhaVX9DkYVhbFpStnqpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>