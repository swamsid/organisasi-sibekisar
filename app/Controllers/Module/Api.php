<?php

namespace App\Controllers\Module;

use App\Controllers\BaseController;

use App\Models\ApiModel;
use App\Models\MasterModel;

class Api extends BaseController
{
    public function __construct(){
        $this->session = \Config\Services::session();
        if(!isset($_SESSION['user']) || empty($_SESSION['user'])) {
            header('Location: '.base_url('auth'));
            exit();
        }

        $this->mastermodel = new MasterModel();
        $this->apimodel = new ApiModel();

        $this->curl = \Config\Services::curlrequest();
        $this->success = array('message' => 'Proses simpan berhasil', 'type' => 'success', 'status' => 'ok');
        $this->delete = array('message' => 'Hapus data berhasil', 'type' => 'success', 'status' => 'ok');
        $this->failed = array('message' => 'Proses simpan gagal', 'type' => 'error', 'status' => false);
    }

    public function index(){
        $data['user'] = $_SESSION['user'];
        // $this->addScript("assets/js/apps/periode.js");

        $this->show('module/api/index', $data);
    }

    // API realisasi anggaran
        public function anggaran(){
            $data['user'] = $_SESSION['user'];
            $this->addScript("assets/js/apps/api/anggaran.js");

            $this->show('module/api/anggaran', $data);
        }

        public function getAnggaran(){
            $tahun  = $_GET['tahun'];
            $awal   = '';
            $akhir  = '';
            

            if(isset($_GET['awal']) && $dataAwal = explode('/', $_GET['awal'])){
                $awal   =  $dataAwal[2].'-'.$dataAwal[1].'-'.$dataAwal[0];
            }

            if(isset($_GET['akhir']) && $dataAkhir = explode('/', $_GET['akhir'])){
                $akhir   =  $dataAkhir[2].'-'.$dataAkhir[1].'-'.$dataAkhir[0];
            }

            $url = "https://api.bpkad.jatimprov.go.id/realisasi/biro-organisasi?username=ro_organisasi&password=EkfqzpxfM7CXAGlsNaFRGkP2QORShEKEeXEzpqkCzOdfnk00qrirNRshyccUY4KP&tgl_awal=".$awal."&tgl_akhir=".$akhir."&id_unit=0&tahun=" . $tahun;

            $response = $this->curl->request('GET', $url, ['verify' => false]);
            $row = json_decode($response->getBody());
            
            $response = [];

            if ($row) {
                foreach ($row->realisasi as $pp):
                    $cekPd = $this->apimodel->getPd(['id_tmp' => $pp->id_unit]);

                    if($cekPd){
                        array_push($response, [
                            'id_unit'       => $pp->id_unit,
                            'nama_unit'     => $pp->nama_unit,
                            'agr'           => number_format($pp->agr, 2),
                            'real'          => number_format($pp->real, 2),
                            'persen'        => ($pp->agr > 0) ? number_format((($pp->real / $pp->agr) * 100), 2) : 0,
                            'grup'          => (isset($pp->grup) ? $pp->grup : 1),
                            'tanggal'       => $_REQUEST['tahun'] . "-01-01",
                            'id_indikator'  => 'C020230201'
                        ]);
                    }
                    // $this->evaluasimodel->insertDataSerapan($data);
                endforeach;
                
                // $this->evaluasibulk($data);
            }

            usort($response, function($a, $b) { return strcmp($a['nama_unit'], $b['nama_unit']); });

            echo json_encode([
                'status'    => 'ok',
                'data'      => $response
            ]); return;
        }

    // end api
}