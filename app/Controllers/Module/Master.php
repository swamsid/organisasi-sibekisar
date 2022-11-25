<?php

namespace App\Controllers\Module;
use App\Controllers\BaseController;
use App\Models\MasterModel;

class Master extends BaseController
{
    public function __construct()
    {
        $this->session = \Config\Services::session();
        if(!isset($_SESSION['user']) || empty($_SESSION['user'])) {
            header('Location: '.base_url('auth'));
            exit();
        }
        $this->mastermodel = new MasterModel();

        $this->success = array('message' => 'Proses simpan berhasil', 'type' => 'success', 'status' => 'ok');
        $this->delete = array('message' => 'Hapus data berhasil', 'type' => 'success', 'status' => 'ok');
        $this->failed = array('message' => 'Proses simpan gagal', 'type' => 'error', 'status' => false);
    }

    public function unit($tag=null)
    {
        $data['user'] = $_SESSION['user'];
        $this->addScript("assets/js/apps/unit.js");
        $param['tag'] = (isset($tag) && $tag?$tag:'opd');
        $param['kategori_unit']=$param['tag'];
        $data['label']=((isset($tag) && $tag=='kab')?'Kabupaten/Kota':'Perangkat Daerah');
        $data['tag'] = $param['tag'];

        $this->show('module/unit/index', $data);
    }

    public function gridunit(){
        $param = $_REQUEST;
        $data = $this->mastermodel->findMUnit($param);
        $count = count($data);
        return $this->response->setJSON(json_encode(array(
            "iTotalRecords" => $count,
            "aaData" => $data
        )));
    }

    function simpan_unit(){
        $data = $_REQUEST;
        $data['is_aktif'] = (isset($_REQUEST['is_aktif'])?$_REQUEST['is_aktif']:0);
        $data['unit'] = str_replace("'", "`",$data['unit']);
        $resultUpload = do_uploaded_file("foto", "file", "");
        $data['foto_pejabat']=0;
        if($resultUpload) $data['foto_pejabat'] = $resultUpload['file_loc'];

        $where= array("id_unit"=>$data['id_unit']);
        $data_ = array("unit"=>$data['unit'],"nama_unit"=>$data['unit'],
            "pejabat"=>$data['pejabat'],
            "foto_pejabat"=>$data['foto_pejabat'],
            "alamat"=>$data['alamat'],
            "telp"=>$data['telp'],
            "website"=>$data['website'],
            "kategori_unit"=>$data['kategori_unit'],
            "jumlah_bidang"=>$data['jumlah_bidang'],
            "jumlah_upt"=>$data['jumlah_upt'],
            "jumlah_anggaran"=>$data['jumlah_anggaran'],
            "jumlah_sdm"=>$data['jumlah_sdm'],
            "email"=>$data['email'],
            "is_aktif"=>$data['is_aktif'],
            "medsos_fb"=>$data['medsos_fb'],
            "medsos_ig"=>$data['medsos_ig'],
            "medsos_twitter"=>$data['medsos_twitter']);
        if(isset($data['id_unit']) && !empty($data['id_unit'])) $result = $this->mastermodel->updateMUnit($data_,$where);
        else $result = $this->mastermodel->insertMUnit($data);


        if ($result) echo json_encode($this->success);
        else echo json_encode($this->failed);
    }

    /** indikator */

    public function indikator($tag=null)
    {
        $data['user'] = $_SESSION['user'];
        $this->addScript("assets/js/apps/indikator.js");
        $param['tag'] = (isset($tag) && $tag?$tag:'opd');
        $param['kategori_unit']='opd';
        $data['unit'] = $this->mastermodel->findMUnit($param);
        $data['tag'] = $param['tag'];
       // $data['indikator'] =$this->mastermodel->findMIndikator($param);

        $this->show('module/indikator/index', $data);
    }

    public function gridindikator()
    {
        $param = $_REQUEST;
        $data = $this->mastermodel->findMIndikator($param);
        $count = count($data);
        return $this->response->setJSON(json_encode(array(
            "iTotalRecords" => $count,
            "aaData" => $data
        )));
    }

    function simpan_indikator(){
        $data = $_REQUEST;

        if(empty($_REQUEST['id_indikator'])) {
            $row =  $this->mastermodel->generateid($data['id_aspek']);
            $data['id_indikator'] = $row->last_mr;
        }

        $dataUpdate = array('nilai_maks'=>$data['nilai_maks']);
        $where = array('id_aspek'=>$data['id_aspek']);
        //$results= $this->mastermodel->updateMAspek($dataUpdate,$where);

        $data['is_aktif'] = (isset($_REQUEST['is_aktif'])?$_REQUEST['is_aktif']:0);
        $data['indikator'] = str_replace("'", "`",$data['indikator']);
        $dataInsert = array('id_indikator'=>$data['id_indikator'],
            'indikator'=>$data['indikator'],
            'bobot'=>$data['bobot'],
            'opd_pengampu'=>$data['opd_pengampu'],
            'id_opd'=>$data['id_opd'],
            'tag'=>$data['tag'],
            'id_aspek'=>$data['id_aspek'],
            'is_aktif'=>$data['is_aktif']);

        $result = $this->mastermodel->insertMIndikator($dataInsert);

        if ($result) echo json_encode($this->success);
        else echo json_encode($this->failed);
    }
}