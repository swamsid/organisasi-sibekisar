<?php

namespace App\Controllers;

use App\Models\EvaluasiModel;
use App\Models\MasterModel;
use Mpdf\Mpdf;

//use TCPDF;

class Apps extends BaseController
{

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->curl = \Config\Services::curlrequest();
        $this->evaluasimodel = new EvaluasiModel();
        $this->mastermodel = new MasterModel();

        $this->success = array('message' => 'Proses simpan berhasil', 'type' => 'success', 'status' => 'ok');
        $this->success_sync = array('message' => 'Proses sinkronisasi berhasil dilakukan', 'type' => 'success', 'status' => 'ok');
        $this->delete = array('message' => 'Hapus data berhasil', 'type' => 'success', 'status' => 'ok');
        $this->failed = array('message' => 'Proses simpan gagal', 'type' => 'error', 'status' => false);
    }

    public function sync_serapan()
    {
        //$data['username']='ro_organisasi';
        //$url='https://api.bpkad.jatimprov.go.id/penyerapan?username=ro_organisasi&password=EkfqzpxfM7CXAGlsNaFRGkP2QORShEKEeXEzpqkCzOdfnk00qrirNRshyccUY4KP&tgl='.date("Y-m-d").'&id_unit=0';
        $url = "https://api.bpkad.jatimprov.go.id/realisasi/biro-organisasi?username=ro_organisasi&password=EkfqzpxfM7CXAGlsNaFRGkP2QORShEKEeXEzpqkCzOdfnk00qrirNRshyccUY4KP&tgl_awal=" . $_REQUEST['tahun'] . "-01-01&tgl_akhir=" . $_REQUEST['tahun'] . "-12-31&id_unit=0&tahun=" . $_REQUEST['tahun'];

        return $url;

        $response = $this->curl->request('GET', $url, ['verify' => false]);
        $row = json_decode($response->getBody());
        // var_dump($row);

        if ($row) {
            foreach ($row->realisasi as $pp):
                $data = array(
                    'id_unit' => $pp->id_unit,
                    'nama_unit' => $pp->nama_unit,
                    'agr' => $pp->agr,
                    'real' => $pp->real,
                    'persen' => (($pp->real / $pp->agr) * 100),
                    'grup' => (isset($pp->grup) ? $pp->grup : 1),
                    'tanggal' => $_REQUEST['tahun'] . "-01-01",
                    'id_indikator' => 'C0201'
                );
                $this->evaluasimodel->insertDataSerapan($data);
            endforeach;
            if (!isset($_REQUEST['tahun'])) $data['tahun'] = date("Y");
            else $data['tahun'] = $_REQUEST['tahun'];
            $this->evaluasibulk($data);
        }
    }

    public function evaluasibulk($data)
    {
        //$data = $_REQUEST;
        $row = $this->evaluasimodel->evaluasibulk($data);
        $i = 0;
        foreach ($row as $key) :
            $i++;
            $fzeropadded = sprintf("%04d", $key->id_unit);
            $mulai = sprintf("%02d", 1);


            $id_indikator = $key->id_indikator;
            $id_evaluasi = $key->tahun . $mulai . $fzeropadded . '_' . $id_indikator;
            $nilai_akhir = (number_format($key->persen, 2) * ($key->bobot / 100));
            $dataKomponen = array(
                'id_indikator' => $id_indikator,
                'id_evaluasi' => $id_evaluasi,
                'nilai_konversi' => number_format($key->persen, 2),
                'nilai_akhir' => number_format($nilai_akhir, 2),
                'bobot' => ($key->bobot / 100),
                'nilai_maks' => $key->nilai_maks,
                'bulan_mulai' => 1,
                'bulan_selesai' => 1,
                'tahun' => $key->tahun,
                'id_unit' => $key->id_unit,
                'periode' => 'tahunan',
                'timestamp' => date("Y-m-d H:i:s"),
                'id_user' => 1
            );
            $result = $this->evaluasimodel->insertData($dataKomponen);
        endforeach;
        if ($result && $i == count($row, 1)) {
            $this->evaluasimodel->call_sp_aspek();
            $b = $this->evaluasimodel->call_sp_spirit();
            if ($b && $i == count($row, 1)) echo json_encode($this->success);
            exit;
        }
    }

    public function index()
    {
        if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
            header('Location: ' . base_url('auth'));
            //return redirect()->tto('auth');
            exit();
        }
        $data['user'] = $_SESSION['user'];
        //$this->addScript("assets/vendors/js/vendor.bundle.base.js");
        $this->addScript("assets/vendors/chart.js/Chart.min.js");
        $this->addScript("assets/vendors/chartist/chartist.min.js");
        $this->addScript("assets/vendors/progressbar.js/progressbar.min.js");
        $this->addScript("assets/js/dashboard.js");
        $this->show('apps/main', $data);
    }

    public function profile()
    {
        if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
            header('Location: ' . base_url('auth'));
            //return redirect()->to('auth');
            exit();
        }
        $this->addScript("assets/js/apps/profile.js");
        $data['user'] = $_SESSION['user'];

        $this->show('apps/profile', $data);
    }

    public function dashboard()
    {
        if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
            header('Location: ' . base_url('auth'));
            //return redirect()->to('auth');
            exit();
        }
        $data['user'] = $_SESSION['user'];
        $this->addScript("assets/vendors/highchart/highcharts.js");
        $this->addScript("assets/vendors/chart.js/Chart.min.js");
        $this->addScript("assets/vendors/progressbar.js/progressbar.min.js");
        $this->addScript("assets/js/dashboard.js");
        $this->show('apps/main', $data);
    }

    public function rekap()
    {
        $data['user'] = $_SESSION['user'];
        return view('apps/main', $data);
    }

    /*public function evaluasi(){
        return redirect()->to(site_url('module/evaluasi'));
    }*/

    public function gridnilai()
    {
        $data = $_REQUEST;
        // return json_encode($data);
        $eval = $this->evaluasimodel->findDetailNilaiBaru($data);
        // return json_encode($eval);
        $count = count($eval);
        return $this->response->setJSON($eval);
    }

    public function reportdinilai()
    {
        $data = $_REQUEST;

        $data['tahun'] = date("Y");
        $eval = $this->evaluasimodel->reportJumlahDinilai($data);
        /* $count = count($eval);
         return $this->response->setJSON($eval);*/
        return $this->response->setJSON(json_encode(array(
            "iTotalRecords" => count($eval),
            "aaData" => $eval
        )));
    }

    function cetak($id = null, $tahun = null, $tag = null)
    {
        // return 'okee';
        $data['id_unit']    = $id;
        $data['tahun']      = $tahun;
        $data['tag']        = $tag;

        $dataTahunTable = $this->mastermodel->findPeriode([ 'id_periode' => $tahun ]);

        $indikator = $this->evaluasimodel->findDetailNilaiBaru($data);
        $unitGet   = $this->mastermodel->findMUnit([ 'id_unit' => $data['id_unit'] ]);

        $html = '';
        $aspek = array();
        $unit = array();

        // return json_encode($indikator);

        foreach ($indikator as $key):
            $temp = array(
                "id_aspek" => $key->id_aspek,
                "nilai_maks" => $key->bobot,
                "total_nilai" => $key->total_nilai,
                "aspek" => $key->aspek
            );
            if (!in_array($temp, $aspek)) array_push($aspek, $temp);

            $tempunit = array(
                "unit" => $key->unit,
                "skor_total" => $key->nilai,
                "nilai_huruf" => $key->nilai_huruf,
                "predikat" => $key->predikat
            );
            if (!in_array($tempunit, $unit)) array_push($unit, $tempunit);
        endforeach;

        $rowspan = array_count_values(array_column($indikator, 'id_aspek'));
        foreach ($unit as $runit) {
            $html .= "
                        <table width='100%' style='margin-bottom: 25px;'>
                            <tbody>
                                <tr>
                                    <td width='75%' style='text-align: left; display: block; line-height: 26px;'>
                                        <span style='font-weight: bold; font-size: 16pt; margin-bottom: 300px;'>Raport Budaya Kerja CETTAR</span> <br/>
                                        <span style='line-height: 200px; margin-top: 300px;'>".$unitGet[0]->unit."</span> <br/>
                                        <span style='font-size: 10pt; font-weight: normal; margin-top: 5px;font-style: italic; color: #555;'>Tahun " . $dataTahunTable->tahun_periode."</span>
                                    </td>
                                    <td width='25%' style='text-align: right;'>
                                        
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        
                        <table width='100%' class='table' cellpadding='2' cellspacing='1' border='1' style='border-collapse: collapse; margin-top: 5px;'>
                            <thead>
                                <tr>
                                    <th width='13%' style='background: #eee; padding: 10px 0px;'>Spirit Budaya Kerja</th>
                                    <th width='7%' style='background: #eee; padding: 10px 0px;'>Bobot</th>
                                    <th width='7%' style='background: #eee; padding: 10px 0px;'>Total Nilai</th>
                                    <th width='17%' style='background: #eee; padding: 10px 0px;'>Indikator Penilaian</th>
                                    <th width='7%' style='background: #eee; padding: 10px 0px;'>Bobot</th>
                                    <th width='7%' style='background: #eee; padding: 10px 0px;'>Nilai</th>
                                    <th width='7%' style='background: #eee; padding: 10px 0px;'>Nilai Awal</th>
                                    <th width='7%' style='background: #eee; padding: 10px 0px;'>Nilai Konversi</th>                                        
                                    <th width='28%' style='background: #eee; padding: 10px 0px;'>Keterangan</th>
                                </tr>
                            </thead>

                            <tbody>";
            foreach ($aspek as $row) {
                $i = 0;
                $html .= '<tr valign="top">
                            <td rowspan="' . ($rowspan[$row['id_aspek']] + 0) . '" valign="top" style="vertical-align : top !important; text-align: left; padding: 10px; font-weight: 600;">
                                ' . strtoupper($row['aspek']) . '
                            </td>
                            <td rowspan="' . ($rowspan[$row['id_aspek']] + 0) . '" valign="top" style="vertical-align : top !important; text-align: center; padding: 10px;">
                                ' . $row['nilai_maks'] . '
                            </td>
                            <td rowspan="' . ($rowspan[$row['id_aspek']] + 0) . '" valign="top" style="vertical-align : top !important; text-align:center; padding: 10px;">'
                                . $this->is_decimal($row['total_nilai']) .
                            '</td>';

                foreach ($indikator as $key) {
                    if ($key->id_aspek == $row['id_aspek']) {
                        $i++;
                        $print = (!$key->keterangan) ? $key->opd_pengampu : $key->keterangan;
                        if ($i == 1) $html .= " ";
                        else $html .= "<tr valign='top'>";
                        $html .= '
                                    <td valign="top" style="height: 40px; padding: 10px;">' . $key->indikator . '</td>
                                    <td valign="top" align="center" style="height: 40px; padding: 10px;">
                                        ' . $this->is_decimal($key->bobot_aspek) . '
                                    </td>
                                    <td valign="top" align="center" style="height: 40px; padding: 10px;">
                                        <b>' . $this->is_decimal($key->nilai_aspek) . '</b>
                                    </td>
                                    <td valign="top" align="center" style="height: 40px; padding: 10px;">
                                        <b>' . $key->nilai_awal . '</b>
                                    </td>
                                    <td valign="top" align="center" style="height: 40px; padding: 10px;">
                                        <b>' . $this->is_decimal($key->nilai_konversi) . '</b>
                                    </td>
                                    <td valign="top" style="height: 40px; padding: 10px;">
                                        ' . $print . '
                                    </td>
                                </tr>';
                    }
                }
            }
            $html .= "</tbody><tfoot>
                        <tr><th colspan='2'>Skor Total</th><th colspan='7'>" . $runit['skor_total'] . "</th> </tr>
                        <tr><th colspan='2'>Nilai</th><th colspan='7'>" . $runit['nilai_huruf'] . "</th> </tr>
                        <tr><th colspan='2'>Predikat</th><th colspan='7'>" . $runit['predikat'] . "</th> </tr>
                        </tfoot></table>";
        }

        $mpdf = new Mpdf(['debug' => FALSE, 'mode' => 'utf-8', 'orientation' => 'L']);

        $mpdf->WriteHTML($html);
        $mpdf->Output('raport_cettar.pdf', 'I');
        exit;
    }

    public function is_decimal( $val )
    {
        if(is_numeric( $val ) && floor( $val ) != $val)
            return number_format($val, 2);

        return number_format($val, 0);
    }

    public function gridevaluasi()
    {
        $data = $_REQUEST;
        $eval = $this->evaluasimodel->findData($data);
        $count = count($eval);
        return $this->response->setJSON(json_encode(array(
            "iTotalRecords" => $count,
            "aaData" => $eval
        )));
    }

    public function gridrekapcettar()
    {
        $data = $_REQUEST;
        // return json_encode($data);
        $eval = $this->evaluasimodel->findCettar($data);
        $count = count($eval);

        return $this->response->setJSON($eval);
    }

    public function chartcettar()
    {
        $data = $_REQUEST;
        $eval = $this->evaluasimodel->findCettar($data);
        if ($eval) {
            $result = array();
            $unit = array();
            $series = array();
            foreach ($eval as $key) {
                $series[] = array('name' => strtOUpper(trim($key->unit)), 'y' => $key->nilai);
                $unit[] = strtOUpper(trim($key->unit));
            }
            $result[] = array('unit' => $unit, 'series' => $series);
        }
        return $this->response->setJSON($result);
    }

    public function gridrekapaspek()
    {
        $data = $_REQUEST;
        // return json_encode($data);
        $eval = $this->evaluasimodel->findCettarAspek($data);
        $aspek = $this->evaluasimodel->findAspek([ 'periode' => $data['tahun'], 'tag' => $data['tag']]);
        $rekapAspek = [];

        foreach($aspek as $key => $dataAspek){
            $data1['limit'] = 1;
            $data1['tahun']= $data['tahun'];
            $data1['id_aspek'] = $dataAspek->id_aspek;
            $data1['tag']= $data['tag'];

            array_push($rekapAspek, $this->evaluasimodel->findCettarAspek($data1));
        }

        $count = count($eval);

        return $this->response->setJSON(
            [
                'aspek'         => $aspek,
                'eval'          => $eval,
                'rekapAspek'    => $rekapAspek
            ]
        );
    }

    function getdetail()
    {
        $data = $this->evaluasimodel->getData($_REQUEST);
        return $this->response->setJSON(json_encode($data));
    }

    function finddetail()
    {
        $data = $this->evaluasimodel->findData($_REQUEST);
        return $this->response->setJSON(json_encode($data));
    }

    function finddetailbyindikator()
    {        
        $data = $this->evaluasimodel->findPenilaian($_REQUEST);

        $response = [
            'status'    => 'success',
            'data'      => $data
        ];

        return json_encode($response);
    }

    /** Evaluasi */

    public function evaluasi($tag = null, $id_indikator = null)
    {
        if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
            header('Location: ' . base_url('auth'));
            //return redirect()->to('auth');
            exit();
        }

        $data['tag'] = $tag;

        $this->addScript("assets/js/apps/evaluasi.js");
        $this->show('apps/evaluasibyindikator', $data);
    }

    public function rapor($tag = null, $id_indikator = null)
    {


        $data['user'] = $_SESSION['user'];
        $param['tag'] = (isset($tag) && $tag ? $tag : 'opd');
        $param['kategori_unit'] = $param['tag'];

        $data['unit'] = $this->mastermodel->findMUnit($param);

        if ($_SESSION['user']->id_role == 1) $data['id_unit'] = '';
        else $data['id_unit'] = $_SESSION['user']->id_unit;

        $this->addScript("assets/js/apps/rapor.js");
        $this->addScript("assets/vendors/datatables/rg/jquery.dataTables.min.js");
        $this->addScript("assets/vendors/datatables/rg/dataTables.rowsGroup.js");

        // $data['id_indikator'] = (isset($id_indikator) && $id_indikator ? $id_indikator : '');
        // $data['indikator'] = $this->mastermodel->findMIndikator($param);

        $data['label']      = ((isset($tag) && $tag == 'kab') ? 'Kabupaten/Kota' : 'Perangkat Daerah');
        $data['tag']        = $param['tag'];
        $data['periode']    = $this->mastermodel->getPeriode();
        
        $this->show('apps/rapor', $data);
    }

    public function verifikasi($tag = null, $id_indikator = null)
    {
        $data['user'] = $_SESSION['user'];
        $param['tag'] = (isset($tag) && $tag ? $tag : 'opd');
        $param['kategori_unit'] = $param['tag'];
        $data['unit'] = $this->mastermodel->findMUnit($param);
        if ($_SESSION['user']->id_role == 1) $data['id_unit'] = '';
        else $data['id_unit'] = $_SESSION['user']->id_unit;

        $this->addScript("assets/js/apps/verifikasi.js");
        // $this->addScript("assets/vendors/datatables/dataTables.rowGroup.min.js");
        $data['id_indikator'] = (isset($id_indikator) && $id_indikator ? $id_indikator : '');
        // $data['unit'] = $this->mastermodel->findMUnit();
        /*if (!$indikator = cache('indikator')){
            $indikator = $this->mastermodel->findMIndikator();
            cache()->save('indikator', $indikator, 1000);
        }
        $data['indikator'] = $this->cache->get('indikator');*/
        $data['label'] = ((isset($tag) && $tag == 'kab') ? 'Kabupaten/Kota' : 'Perangkat Daerah');
        $data['indikator'] = $this->mastermodel->findMIndikator($param);
        $data['tag'] = $param['tag'];
        $this->show('apps/verifikasi', $data);
    }

    public function rangking($kategori = null, $tag = null)
    {
        $data['user'] = $_SESSION['user'];
        $this->addScript("assets/vendors/highchart/highcharts.js");
        /*if (!$indikator = cache('indikator')){
            $indikator = $this->mastermodel->findMIndikator();
            cache()->save('indikator', $indikator, 1000);
        }*/

        $data['periode'] = $this->mastermodel->getPeriode();

        $param['tag'] = (isset($tag) && $tag ? $tag : 'opd');
        $param['kategori_unit'] = $param['tag'];
        $param['periode'] = (count($data['periode']) > 0) ? $data['periode'][count($data['periode']) - 1]->id_periode : 0;;
        // $data['indikator'] = $this->cache->get('indikator');
        $data['indikator'] = $this->mastermodel->findMIndikator($param);
        $data['unit'] = $this->mastermodel->findMUnit($param);
        $data['tag'] = $param['tag'];
        $data['label'] = ((isset($tag) && $tag == 'kab') ? 'Kabupaten/Kota' : 'Perangkat Daerah');

        if ($kategori == 'cettar') $this->addScript("assets/js/apps/rekap_cettar.js");
        if ($kategori == 'spirit') $this->addScript("assets/js/apps/rekap_aspek.js");

        $this->show('rekap/cettar', $data);
    }

    function simpanevaluasi()
    {
        if (empty($_POST)) echo json_encode($this->failed);

        // return json_encode($_POST);

        // return json_encode([ 'status' => 'success' ]); 

        // $mulai = sprintf("%02d", $_POST['bulan_mulai']);
        // $mulai = sprintf("%02d", date('d-m-Y'));

        // return json_encode($mulai);

        if (!empty($_POST['id_indikator'])) {
            $i = 0;
            foreach ($_POST['id_unit'] as $index => $key) {
                
                $i++;
                $id_indikator = $_POST['id_indikator'];
                $id_unit = $key;
                $fzeropadded = sprintf("%04d", $id_unit);
                $id_evaluasi = $_POST['tahun'] . $fzeropadded . '_' . $id_indikator;

                $nilai = ($_POST['nilai_konversi'][$index] == "") ? 0 : (float) str_replace(',', '.', $_POST['nilai_konversi'][$index]);
                $bobot = (float) ($_POST['bobot'] / 100);

                $nilai_akhir = ($nilai * $bobot);
                // return json_encode($nilai_akhir);

                $dataKomponen = array(
                    'id_indikator'      => $id_indikator,
                    'id_evaluasi'       => $id_evaluasi,
                    'nilai_awal'        => $_POST['nilai_awal'][$index],
                    'nilai_konversi'    => $nilai,
                    'nilai_akhir'       => $nilai_akhir,
                    'bobot'             => $bobot,
                    'nilai_maks'        => $_POST['nilai_maks'],
                    'bulan_mulai'       => '1',
                    'bulan_selesai'     => '1',
                    'tahun'             => $_POST['periode'],
                    'id_unit'           => $key,
                    'periode'           => $_POST['tahun'],
                    'user_verifikasi'   => '0',
                    'catatan_verifikasi' => '',
                    'waktu_verifikasi'  => '',
                    'is_verify'         => '0',
                    'timestamp'         => date("Y-m-d H:i:s"),
                    'id_user'           => $_SESSION['user']->id_user
                );

                // return json_encode($dataKomponen);

                $result = $this->evaluasimodel->insertData($dataKomponen);
            }
            if ($result && $i == count($_POST['id_unit'], 1)) {
                $this->evaluasimodel->call_sp_aspek();
                $b = $this->evaluasimodel->call_sp_spirit();
                if ($b && $i == count($_POST['id_unit'], 1)) echo json_encode($this->success);
                exit;
            }
        }

    }

    function simpanverifikasi()
    {
        if (empty($_POST)) echo json_encode($this->failed);
        if (!empty($_POST['id_indikator'])) {
            $i = 0;
            foreach ($_POST['id_indikator'] as $key) {
                $id_indikator = $key;
                $id_evaluasi = $_POST['id_evaluasi' . $id_indikator];
                $where = array('id_evaluasi' => $id_evaluasi);
                if (isset($_POST['is_verify' . $id_indikator])) {
                    $dataKomponen = array(
                        'user_verifikasi' => (empty($_POST['user_verifikasi' . $id_indikator]) ? $_SESSION['user']->id_user : $_POST['user_verifikasi' . $id_indikator]),
                        'catatan_verifikasi' => $_POST['catatan_verifikasi' . $id_indikator],
                        'waktu_verifikasi' => (!empty($_POST['waktu_verifikasi' . $id_indikator]) && $_POST['waktu_verifikasi' . $id_indikator] != '0000-00-00 00:00:00' ? $_POST['waktu_verifikasi' . $id_indikator] : date("Y-m-d H:i:s")),
                        'is_verify' => 1
                    );
                    $result = $this->evaluasimodel->updateData($dataKomponen, $where);
                }
                $i++;
            }
            if ($result && $i == count($_POST['id_indikator'], 1)) {
                echo json_encode($this->success);
                exit;
            }
        }

    }

    // tambahan 
    function getPeriodeDanIndikator(){
        $params = $_REQUEST;
        $params['periode'] = 1;
        $periode    = $this->mastermodel->getPeriode();

        $dataIndikator = [
            'tag'       => $params['tag'],
            'periode'   => $periode[(count($periode) - 1)]->id_periode,
            'id_unit'   => $_SESSION['user']->id_unit
        ];

        $indikator = $this->mastermodel->findMIndikator($dataIndikator);

        $response   = [
            'periode'       => $periode,
            'selected'      => $periode[(count($periode) - 1)]->tahun_periode,
            'id_selected'   => $periode[(count($periode) - 1)]->id_periode,
            'indikator'     => $indikator
        ];

        return json_encode($response);
    }

    function getIndikatorByPeriode(){
        $params = $_REQUEST;

        $config = [
            'id_unit'    => $_SESSION['user']->id_unit
        ];

        if(!empty($params['periode'])){
            $config['periode'] = $params['periode'];
        }

        if(!empty($params['tag'])){
            $config['tag'] = $params['tag'];
        }

        $indikator = $this->mastermodel->findMIndikator($config);

        $response   = [
            'indikator'     => $indikator
        ];

        return json_encode($response);
    }

    /** End Evaluasi */

    /* Tambahan setelah revisi */

    function getPeriode(){
        $params     = $_REQUEST;
        $dataTable  = $this->mastermodel->getPeriode();

        $data       = [
            'data'      => $dataTable,
            'selected'  => $dataTable[(count($dataTable) - 1)]->tahun_periode
        ];

        return json_encode($data);
    }

    function savePeriode(){
        $params         = $_REQUEST;

        $find   = $this->mastermodel->findPeriode([ 'tahun_periode' => $params['periode'] ]);    

        if($find){
            return json_encode([
                'status'    => 'error',
                'message'   => 'Data periode '.$params['periode'].' sudah ada'
            ]);
        }

        $getId = $this->mastermodel->getIdPeriode();
        $id    = ($getId && $getId->id_periode) ? ((int) $getId->id_periode + 1) : 1;

        $dataPeriode    = [
            'id_periode'        => $id,
            'tahun_periode'     => $params['periode'],
            'tanggal_dibuat'    => date('Y-m-d H:i:s'),
        ];

        $result2    = $this->mastermodel->insertPeriode($dataPeriode);
        $dataAspek      = [];

        foreach($params['aspek'] as $key => $aspek){
            array_push($dataAspek, [
                'id_aspek'      => ($params['tag'][$key] == 'opd') ? 'C0'.$params['periode'].''.str_pad(($key + 1), 2, '0', STR_PAD_LEFT) : 'K0'.$params['periode'].''.str_pad(($key + 1), 2, '0', STR_PAD_LEFT),
                'periode'       => $id,
                'aspek'         => $params['aspek'][$key],
                'nilai_maks'    => $params['nilai_maks'][$key],
                'keterangan'    => $params['keterangan'][$key],
                'is_aktif'      => '1',
                'tag'           => $params['tag'][$key],
                'icon'          => $params['icon'][$key],
            ]);

        }
        
        $result     = $this->mastermodel->insertAspek($dataAspek);

        if($result){
            return json_encode([
                'status'    => 'sukses'
            ]);
        }
    }

    function deletePeriode(){
        $params         = $_REQUEST;
        $dataPeriode    = [
            'tahun_periode' => $params['periode'],
        ];

        $result         = $this->mastermodel->deletePeriode($dataPeriode);

        if($result){
            return json_encode([
                'status'    => 'sukses'
            ]);
        }
    }

    function updatePeriode(){
        $params         = $_REQUEST;


        $dataPeriode    = [
            'tahun_periode' => $params['periode'],
        ];

        $where    = [
            'id_periode' => $params['id_periode'],
        ];

        $find   = $this->mastermodel->findPeriode($dataPeriode);    

        if($find && $find->id_periode != $params['id_periode']){
            return json_encode([
                'status'    => 'error',
                'message'   => 'Data periode '.$params['periode'].' sudah ada'
            ]);
        }

        $result = $this->mastermodel->updatePeriode($dataPeriode, $where);

        if($result){
            return json_encode([
                'status'    => 'sukses'
            ]);
        }
    }

    function bobotTerakhir(){
        $dataTable  = $this->mastermodel->bobotTerakhir();

        $data       = [
            'data'      => $dataTable
        ];

        return json_encode($data);
    }

}
