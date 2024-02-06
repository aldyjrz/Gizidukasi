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



<!-- Content -->
<main role="main" class="col-md-12 ml-sm-auto col-lg-12 px-md-4 mt-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 col-sm-10">

                <div class="card">
                    <div class="card-header pb-0 pt-0 px-1 bg-primary bg-lighten-3">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <h3 class="mt-2 ml-lg-11 text-judul text-white">Kalkulator Stunting</h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body">
                            <div class="col-xl-12" id="start">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="bd-bottom mb-1">
                                                <h6>Jenis Kelamin
                                                    <span class="danger"> *</span>
                                                </h6>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <select name="jenis_kelamin" class="form-control blok filterval" id="jenis_kelamin" style="width: 100%;">
                                                        <option selected value="laki">Laki - Laki</option>
                                                        <option value="Perempuan">Perempuan</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="bd-bottom mb-1">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <h6>Umur
                                                            <span class="danger"> *</span>
                                                        </h6>
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="checkedbalita" style="word-wrap:break-word; float:right">
                                                            <input type="checkbox" id="checkedbalita" name="checkedbalita" value="balita">
                                                            Balita
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="input-group mb-3">
                                                        <input type="number" placeholder="Satuan Tahun" name="umur" id="umur" class="form-control">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text" style="display: none;" id="basic-addonbulan">Bulan</span>
                                                            <span class="input-group-text" id="basic-addontahun">Tahun</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="bd-bottom mb-1">
                                                <h6>Tinggi Badan
                                                    <span class="danger"> *</span>
                                                </h6>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="input-group mb-3">
                                                        <input type="number" placeholder="Satuan Sentimeter" name="tinggi" id="tinggi" class="form-control">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text" id="basic-addon2">CM</span>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="bd-bottom mb-1">
                                                <h6>Berat Badan
                                                    <span class="danger"> *</span>
                                                </h6>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="input-group mb-3">
                                                        <input type="number" placeholder="Satuan Kilogram" name="berat" id="berat" class="form-control">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text" id="basic-addon2">KG</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="bd-bottom mb-1">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <h6>TB/U(Stunting)
                                                            <span class="danger"> *</span>
                                                        </h6>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="info" style="cursor: pointer;position: relative !important;">
                                                            <i class="ft ft-alert-circle text-info border-0" data-toggle="popover" data-content="Stunting adalah gagal tumbuh akibat akumulasi ketidakcukupan zat gizi yang berlangsung lama" data-original-title="Stunting" data-trigger="click" data-placement="top" style="float:right;font-size: 14pt !important; cursor: pointer;"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <input type="text" name="tbu" id="tbu" class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="bd-bottom mb-1">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <h6>IMT
                                                            <span class="danger"> *</span>
                                                        </h6>
                                                    </div>
                                                    <div class="col-6">
                                                        <i class="ft ft-alert-circle text-info seru border-0" data-toggle="popover" data-content="Merupakan proksi heuristik untuk lemak tubuh manusia berdasarkan berat badan seseorang dan tinggi." data-original-title="Indeks Massa Tubuh" data-trigger="click" data-placement="top" style="float:right;"></i>
                                                        <!-- <a href="#" style="float:right;" data-trigger="focus" data-placement="top" data-toggle="popover" title="IMT = Indeks Massa Tubuh" data-content="Didapat dari berat badan di bagi tinggi badan kuadrat">Info</a> -->

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <input type="text" name="imt" id="imt" class="form-control" readonly>
                                                </div>
                                            </div>
               </div>
                                    </div>
                                </div>
                            </div>
</div>

                    </div>
                </div>
</main>

<div class='alert alert-warning text-center'>Sumber data: PERMENKES RI No. 2 Tahun 2020 tentang Standar Antropometri Anak, Buku Kesehatan Ibu dan Anak 2016</div>
                         
</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script type="text/javascript">
    $('#checkedbalita').change(function() {
        if (this.checked) {
            $("#umur").attr("placeholder", "Satuan Bulan");
            $("#basic-addontahun").hide();
            $("#basic-addonbulan").show();
            pengecekan();
        } else {
            $("#umur").attr("placeholder", "Satuan Tahun");
            $("#basic-addonbulan").hide();
            $("#basic-addontahun").show();
            pengecekan();
        }
    });

    $("#tinggi").change(function() {
        pengecekan();
    });
    $("#jenis_kelamin").on('change', function() {
        pengecekan();
    });
    $("#umur").change(function() {
        pengecekan();
    });
    $("#berat").change(function() {
        pengecekan();
    });

    function pengecekan() {
        tinggi = $("#tinggi").val();
        berat = $("#berat").val();
        if ($("#checkedbalita").is(':checked')) {
            if (umur = $("#umur").val() != "") {
                umur = $("#umur").val() + "bulan";
            } else {
                umur = "";
            }
        } else {
            umur = $("#umur").val();
        }
        // alert(umur);
        // alert(berat);
        if (tinggi != "" && berat != "" && umur != "") {
            tbu = stunting(tinggi, umur);
            imt = kategorigizi(tinggi, berat);
            $("#tbu").val(tbu);
            $("#imt").val(imt);
        } else {
            $("#tbu").val("");
            $("#imt").val("");
        }
    }

    function stunting(tinggi, unur) {
        umur = umur;
        if (umur == "1bulan") {
            if (tinggi <= 51) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == "2bulan") {
            if (tinggi <= 54) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == "3bulan") {
            if (tinggi <= 57) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == "4bulan") {
            if (tinggi <= 60) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == "5bulan") {
            if (tinggi <= 62) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == "6bulan") {
            if (tinggi <= 63) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == "7bulan") {
            if (tinggi <= 65) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == "8bulan") {
            if (tinggi <= 66) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == "9bulan") {
            if (tinggi <= 67) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == "10bulan") {
            if (tinggi <= 68) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == "11bulan") {
            if (tinggi <= 70) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == "12bulan") {
            if (tinggi <= 71) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == "13bulan") {
            if (tinggi <= 72) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == "14bulan") {
            if (tinggi <= 73) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == "15bulan") {
            if (tinggi <= 75) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == "16bulan") {
            if (tinggi <= 75) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == "17bulan") {
            if (tinggi <= 76) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == "18bulan") {
            if (tinggi <= 77) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == "19bulan") {
            if (tinggi <= 78) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == "20bulan") {
            if (tinggi <= 79) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == "21bulan") {
            if (tinggi <= 79) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == "23bulan") {
            if (tinggi <= 81) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == "24bulan") {
            if (tinggi <= 81) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == "25bulan") {
            if (tinggi <= 82) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == "26bulan") {
            if (tinggi <= 82) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == "27bulan") {
            if (tinggi <= 83) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == "28bulan") {
            if (tinggi <= 84) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == "29bulan") {
            if (tinggi <= 84) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == "30bulan") {
            if (tinggi <= 85) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == "31bulan") {
            if (tinggi <= 86) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == "32bulan") {
            if (tinggi <= 86) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == "33bulan") {
            if (tinggi <= 87) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == "34bulan") {
            if (tinggi <= 87) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == "35bulan") {
            if (tinggi <= 88) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == "36bulan") {
            if (tinggi <= 88) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == "37bulan") {
            if (tinggi <= 89) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == "38bulan") {
            if (tinggi <= 90) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == "39bulan") {
            if (tinggi <= 90) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == "40bulan") {
            if (tinggi <= 91) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == "41bulan") {
            if (tinggi <= 91) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == "42bulan") {
            if (tinggi <= 91) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == "43bulan") {
            if (tinggi <= 92) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == "44bulan") {
            if (tinggi <= 93) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == "45bulan") {
            if (tinggi <= 93) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == "46bulan") {
            if (tinggi <= 94) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == "47bulan") {
            if (tinggi <= 94) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == "48bulan") {
            if (tinggi <= 95) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == "49bulan") {
            if (tinggi <= 95) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == "50bulan") {
            if (tinggi <= 96) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == "51bulan") {
            if (tinggi <= 96) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == "52bulan") {
            if (tinggi <= 97) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == "53bulan") {
            if (tinggi <= 97) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == "54bulan") {
            if (tinggi <= 98) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == "55bulan") {
            if (tinggi <= 98) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == "56bulan") {
            if (tinggi <= 99) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == "57bulan") {
            if (tinggi <= 99) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == "58bulan") {
            if (tinggi <= 100) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == "59bulan") {
            if (tinggi <= 100) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == "60bulan") {
            if (tinggi <= 102) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == 1) {
            if (tinggi <= 71) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == 2) {
            if (tinggi <= 81) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == 3) {
            if (tinggi <= 88) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == 4) {
            if (tinggi <= 95) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == 5) {
            if (tinggi <= 102) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == 6) {
            if (tinggi <= 105) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == 7) {
            if (tinggi <= 110) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == 8) {
            if (tinggi <= 114) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == 9) {
            if (tinggi <= 120) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == 10) {
            if (tinggi <= 125) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == 11) {
            if (tinggi <= 130) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == 12) {
            if (tinggi <= 135) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == 13) {
            if (tinggi <= 140) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == 14) {
            if (tinggi <= 147) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == 15) {
            if (tinggi <= 154) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == 16) {
            if (tinggi <= 157) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == 17) {
            if (tinggi <= 160) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == 18) {
            if (tinggi <= 161) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else if (umur == 19) {
            if (tinggi <= 162) {
                hasil = 'Ya';
            } else {
                hasil = 'Tidak';
            }
        } else {
            hasil = 'Umur Tidak Termasuk Ke Dalam Hitungan Stunting';
        }
        return hasil;
    }

    function kategorigizi(tinggi, berat) {
        rumus1 = tinggi / 100;
        rumus2 = rumus1 * rumus1;
        rumus = berat / rumus2;
        jenis_kelamin = $("#jenis_kelamin").val();
        console.log(jenis_kelamin);

        if (jenis_kelamin == 'Perempuan') {
            if (rumus > 27) {
                imt = "Obesitas";
            } else if (rumus >= 23) {
                imt = "Kegemukan";
            } else if (rumus >= 17) {
                imt = "Normal";
            } else if (rumus < 17 && rumus > 13) {
                imt = "Kurus";
            } else if (rumus < 14) {
                imt = "Sangat Kurus";
            }
        } else {
            if (rumus > 27) {
                imt = "Obesitas";
            } else if (rumus >= 25) {
                imt = "Kegemukan";
            } else if (rumus >= 18) {
                imt = "Normal";
            } else if (rumus < 18 && rumus > 14) {
                imt = "Kurus";
            } else if (rumus < 15) {
                imt = "Sangat Kurus";
            }
        }
        return imt;
    }
</script>
<script>
    function calculateAge() {
        // Get the selected birth date
        var birthDate = new Date(document.getElementById('tglLahir').value);

        // Get the current date
        var currentDate = new Date();

        // Calculate the age in months
        var ageInMonths = (currentDate.getFullYear() - birthDate.getFullYear()) * 12 + (currentDate.getMonth() - birthDate.getMonth());

        // Update the umur input field
        document.getElementById('umur').value = ageInMonths;
    }
</script>