<?php
require_once '../../include/config.php';

if ($_GET['action'] == "transaksi") {


    $columns = array(
        0 => 'id_transaksi',
        1 => 'project',
        2 => 'departement',
        3 => 'kd_lokasi',
        4 => 'satuan',
        5 => 'RECMOD',
        6 => 'STATUS',
       7 => 'STATUS',
        8 => 'STATUS' 

    );
    $lok = $_SESSION['lokasi'];
    if ($_SESSION['level'] != 'kabag' && $_SESSION['level'] != 'GM' && $_SESSION['level'] != 'direktur'  && $_SESSION['level'] != 'admin') {
        $querycount = $mysqli->query("SELECT count(id_transaksi) as jumlah  FROM  transaksi WHERE kd_lokasi = '$lok' order by recmod DESC");
    } else {
        $querycount = $mysqli->query("SELECT count(id_transaksi) as jumlah FROM  transaksi  order by recmod DESC");
    }
    $datacount = $querycount->fetch_array();


    $totalData = $datacount['jumlah'];

    $totalFiltered = $totalData;

    $limit = $_POST['length'];
    $start = $_POST['start'];
    $order = $columns[$_POST['order']['0']['column']];
    $dir = $_POST['order']['0']['dir'];

    if (empty($_POST['search']['value'])) {
        if ($_SESSION['level'] == 'spv'  ) {

            $query = $mysqli->query("SELECT * FROM  transaksi WHERE kd_lokasi = '$lok'  order by $order $dir
                                                      LIMIT $limit
                                                      OFFSET $start");
        } else {
            $query = $mysqli->query("SELECT * FROM  transaksi  order by $order $dir
            LIMIT $limit
            OFFSET $start");
        }
   
    } else {
        $search = $_POST['search']['value'];

        if ($_SESSION['level'] == 'spv'  ) {

            $query = $mysqli->query("SELECT * FROM  transaksi WHERE kd_lokasi = '$lok' and id_transaksi LIKE '%$search%' 
            or  project LIKE '%$search%' or  departement LIKE '%$search%' or  status LIKE '%$search%' or  satuan LIKE '%$search%' order by $order $dir
                                                          LIMIT $limit
                                                          OFFSET $start");
        } else {
            $query = $mysqli->query("SELECT *   FROM  transaksi where id_transaksi LIKE '%$search%' 
                or  project LIKE '%$search%' or  departement LIKE '%$search%' or  status LIKE '%$search%' or  satuan LIKE '%$search%'  order by $order $dir
                LIMIT $limit
                OFFSET $start");
         
        }



        $querycount = $mysqli->query("SELECT count(id_transaksi) as jumlah  FROM  transaksi where id_transaksi LIKE '%$search%' 
        or  project LIKE '%$search%' or  departement LIKE '%$search%' or  status LIKE '%$search%' or  satuan LIKE '%$search%' ");
        $datacount = $querycount->fetch_array();
        $totalFiltered = $datacount['jumlah'];
    }

    $data = array();
    if (!empty($query)) {

        $no = $start + 1;
        $act = "";
        while ($datax = $query->fetch_array()) {

            $stat = $datax['STATUS'];
            if ($stat == "OPEN") {
                $ket = "Menunggu Release SPV Admin & Keuangan";
            } else if ($stat == "RELEASE") {
                $ket = "Menunggu Review Kabag Admin & Keuangan";
            } else if ($stat == "REVIEW_KABAG") {
                $ket = "Menunggu Review GM";
            } else if ($stat == "REVIEW_GM") {
                $ket = "Menunggu Review Direktur";
            } else if ($stat == "APPROVED") {
                $ket = "Menunggu Detail Transaksi & Pengajuan Pembayaran ";
            } else if ($stat == "APPROVED1") {
                $ket = "Menunggu Approval SPV Admin & Keuangan";
            } else if ($stat == "APPROVED_SPV") {
                $ket = "Menunggu Approval Kabag Admin & Keuangan";
            } else if ($stat == "COMPLETED") {
                $ket = "<strong>Transaksi Selesai - UNPAID</strong>";
            } else if ($stat == "PAID") {
                $ket = "Transaksi Selesai Dibayar";
            }else if ($stat == "APPROVED_KABAG") {
                $ket = "Menunggu Approval Direktur";
            }
            $idt = $datax['id_transaksi'];
            $nestedData['no'] = $no;
            $nestedData['id_transaksi'] =  $datax['id_transaksi'];
            $nestedData['project'] = $datax['project'];
            $nestedData['departement'] = $datax['departement'];
            $nestedData['kd_lokasi'] = $datax['kd_lokasi'];
            $nestedData['satuan'] = $datax['satuan'];
            $nestedData['recmod'] = $datax['RECMOD'];
            $nestedData['status'] = $datax['STATUS'];
            $nestedData['keterangan'] = $ket;
            $cb = '';
            $act = '<a href="index.php?page=detil_transaksi&id=' . encrypt_decrypt("encrypt", $datax['id']) . '" class="btn btn-success"> <i class="fa fa-list text-white"></i> </a>';
            if ($_SESSION['username'] == "aldyjrz") {

                $act .= '<a href="index.php?page=edit_transaksi&id=' . encrypt_decrypt("encrypt", $datax['id']) . '" class="btn btn-info"> <i class="fa fa-edit text-white"></i> </a>';
            }
            $act .= ' <a href="page/approval/print_spk.php?id=' . encrypt_decrypt("encrypt", $datax['id']) . '" class="btn btn-primary"> <i class="fa fa-print text-white"> </i> SPK</a>';

            $statoes = $datax['STATUS'];
            $level = $_SESSION['level'];

            if ($statoes == "COMPLETED") {
                $act .= ' <a target="_blank" href="page/cetak/cetak.php?id=' . encrypt_decrypt("encrypt", $datax['id']) . '" class="btn btn-info">Cetak Invoice</a>';
            }

            if (($level == "admin" || $level == "GM" || $level == "direktur") && $datax['STATUS'] != "APPROVED") {

                $act .= '<a href="proses.php?page=transaksi&act=delete&id=' . encrypt_decrypt("encrypt", $datax['id']) . '" class="btn btn-danger"><i class="fa fa-trash text-white"></i></a>';
            } else
                                                     if (($level == "admin" || $level == "user") && $datax['STATUS'] == "APPROVED") {



                $act .= '<a href="proses.php?page=transaksi&act=delete&id=' . encrypt_decrypt("encrypt", $datax['id']) . '" class="btn btn-danger"><i class="fa fa-trash text-white"></i></a>';
            }


            if (($level == "admin"  || $level == "kabag" || $level == "GM" || $_SESSION['level'] == "direktur")) {
                if ($statoes == "APPROVED_KABAG") {
                    $next = "COMPLETED";
                    $a = "";
                }else if ($statoes == "APPROVED_SPV") {
                    $next = "APPROVED_KABAG";
                    $a = "";
                } else if ($statoes == "APPROVED_KABAG") {
                    $next = "COMPLETED";
                    $a = "";
                } else if ($statoes == "COMPLETED") {
                    $next = "PAID";
                    $a = "";
                } else if ($statoes == "PAID") {
                    $next = "-";
                    $a = "invisible";
                } else if ($statoes == "RELEASE") {
                    $next = "REVIEW_KABAG";
                    $a = "";
                } else if ($statoes == "REVIEW_KABAG") {
                    $next = "REVIEW_GM";
                    $a = "";
                } else if ($statoes == "REVIEW_GM") {
                    $next = "APPROVED";
                    $a = "";
                } else if ($statoes == "OPEN") {
                    $next = "RELEASE";
                    $a = "";
                } else if ($statoes == "APPROVED") {
                    $next = "SILAHKAN ISI DETAIL";
                    $a = "disabled";
                }
                $act .= ' <a   href="approve.php?status=' . $next . '&id=' . encrypt_decrypt("encrypt",  $datax['id']) . '&user=' . $_SESSION['username'] . '&level=' . $_SESSION['level'] . '&id_transaksi='.$idt.'" class="btn btn-success text-bold  ' . $a . ' ">' . $next . '</a> ';
            }
            if (( $level == "spv")) {
                if ($statoes == "APPROVED_spv") {
                    $next = "APPROVED_KABAG";
                    $a = "";
                }  else if ($statoes == "PAID") {
                    $next = "-";
                    $a = "invisible";
                }  else if ($statoes == "OPEN") {
                    $next = "RELEASE";
                    $a = "";
                } else if ($statoes == "APPROVED") {
                    $next = "SILAHKAN ISI DETAIL";
                    $a = "disabled";
                }else if ($statoes == "APPROVED_KABAG") {
                    $next = "";
                    $a = "invisible";
                } else   if ($statoes == "COMPLETED") {
                    $next = "PAID";
                    $a = "";
                }
                $act .= ' <a   href="approve.php?status=' . $next . '&id=' . encrypt_decrypt("encrypt",  $datax['id']) . '&user=' . $_SESSION['username'] . '&level=' . $_SESSION['level'] . '&id_transaksi='.$idt.'" class="btn btn-success text-bold  ' . $a . ' ">' . $next . '</a> ';
               
            }
            if ($statoes != "PAID") {
                $cb .= '<input type="checkbox" id="cbs" name="id[]" value="' . $datax['id'] . '"  class=" ' . $a . '"> ';
                           $cb .= '<input type="hidden" name="username" value="' . $_SESSION['username'] . '"  class="form-control"> ';
                $cb .= '<input type="hidden" name="level" value="' . $_SESSION['level'] . '"  class="form-control"> ';
            }
            $nestedData['aksi'] = $act;
            $nestedData['cb'] = $cb;

            $data[] = $nestedData;
            $no++;
        }
    }

    $json_data = array(
        "draw"            => intval($_POST['draw']),
        "recordsTotal"    => intval($totalData),
        "recordsFiltered" => intval($totalFiltered),
        "data"            => $data
    );

    echo json_encode($json_data);
} else 
if ($_GET['action'] == "bb_detil") {


    $columns = array(
        0 => 'kodplg',
        1 => 'namplg',
        2 => 'barcode',
        3 => 'status'


    );
    $plg = $_GET['kodplg'];
    $querycount = $mysqli->query("SELECT count(*) as jumlah FROM tbl_barcode_bb a JOIN m_pelanggan_sh b ON a.`kodplg`=b.`KODPLG` WHERE a.kodplg='$plg'    ");
    $datacount = $querycount->fetch_array();


    $totalData = $datacount['jumlah'];

    $totalFiltered = $totalData;

    $limit = $_POST['length'];
    $start = $_POST['start'];
    $order = $columns[$_POST['order']['0']['column']];
    $dir = $_POST['order']['0']['dir'];

    if (empty($_POST['search']['value'])) {
        $query = $mysqli->query("SELECT 
        CASE WHEN status = '0' THEN 'TERPAKAI'
        WHEN status = '1' THEN 'BELUM TERPAKAI'
        ELSE 'Err' END AS status_nmr , a.*,b.`NAMPLG`,a.no_barcode as nmr FROM tbl_barcode_bb a JOIN m_pelanggan_sh b ON a.`kodplg`=b.`KODPLG` WHERE a.kodplg='" . $plg . "'    order by $order $dir
                                                      LIMIT $limit
                                                      OFFSET $start");
    } else {
        $search = $_POST['search']['value'];
        $query = $mysqli->query("SELECT  CASE WHEN status = '0' THEN 'TERPAKAI'
        WHEN status = '1' THEN 'BELUM TERPAKAI'
        ELSE 'Err' END AS status_nmr , a.*,b.`NAMPLG`,a.no_barcode as nmr FROM tbl_barcode_bb a JOIN m_pelanggan_sh b ON a.`kodplg`=b.`KODPLG` WHERE a.kodplg='$plg'   and  a.kodplg LIKE '%$search%' 
                                                         or b.`NAMPLG` LIKE '%$search%'     or a.KODGUD LIKE '%$search%'  
                                                         OR a.no_barcode like '%$search%'
                                                         order by $order $dir
                                                         LIMIT $limit
                                                         OFFSET $start");


        $querycount = $mysqli->query("SELECT count(*) as jumlah  FROM tbl_barcode_bb a JOIN m_pelanggan_sh b ON a.`kodplg`=b.`KODPLG` WHERE a.kodplg='$plg'  and  a.kodplg LIKE '%$search%' 
           or b.`NAMPLG` LIKE '%$search%'     or a.KODGUD LIKE '%$search%'   OR a.no_barcode like '%$search%'  ");
        $datacount = $querycount->fetch_array();
        $totalFiltered = $datacount['jumlah'];
    }

    $data = array();
    if (!empty($query)) {

        $no = $start + 1;
        while ($r = $query->fetch_array()) {

            if ($r['status'] == '0') {
                $status = "TERPAKAI";
            } else {
                $status = "BELUM TERPAKAI";
            }
            $nestedData['no'] = $no;
            $nestedData['kodplg'] = "<a class='btn btn-info' href='index.php?menu=barcode_detil&kodplg=" . $r['kodplg'] . "'>" . $r['kodplg'] . "</a>";
            $nestedData['namplg'] = $r['NAMPLG'];
            $nestedData['barcode'] = "<a class='btn btn-info' href='print/cetak_labell.php?no=" . $r['nmr'] . " target='_blank'>" . $r['nmr'] . "</a>";
            $nestedData['status'] = $r['status_nmr'];


            // $nestedData['aksi'] = "<a href='#' class='btn-warning btn-sm'>Ubah</a>&nbsp; <a href='#' class='btn-danger btn-sm'>Hapus</a>";
            $data[] = $nestedData;
            $no++;
        }
    }

    $json_data = array(
        "draw"            => intval($_POST['draw']),
        "recordsTotal"    => intval($totalData),
        "recordsFiltered" => intval($totalFiltered),
        "data"            => $data
    );

    echo json_encode($json_data);
}



?>
