<?php

namespace App\Controllers;
use App\Controllers\Module\Master;
use App\Models\MasterModel;

class Read extends BaseController
{
    public function __construct()
    {
       // $this->evaluasimodel = new EvaluasiModel();
        $this->mastermodel = new MasterModel();
    }

    function tentang(){
        return view('tentang');
    }

    function opd($param=null){ 

        $data['kategori_unit'] = 'opd';
        $data['label']         = 'Perangkat Daerah/UOBK';
        $data['tag']           = 'opd';
        $data['dataPeriode']   = $this->mastermodel->getPeriode();

       if(isset($param) &&!empty($param)) {
           $data['id_unit_hash'] = $param;
           $data['unit']         = $this->mastermodel->getMUnit($data);
;
           return view('opd_detail', $data);
       }else {
           $data['unit'] = $this->mastermodel->findMUnit($data);
           
           return view('opd', $data);
       }
    }

    function uobk($param=null){ 

        $data['kategori_unit'] = 'uobk';
        $data['label']         = 'Perangkat Daerah/UOBK';
        $data['tag']           = 'uobk';
        $data['dataPeriode']   = $this->mastermodel->getPeriode();

       if(isset($param) &&!empty($param)) {
           $data['id_unit_hash'] = $param;
           $data['unit']         = $this->mastermodel->getMUnit($data);
;
           return view('opd_detail', $data);
       }else {
           $data['unit'] = $this->mastermodel->findMUnit($data);
           
           return view('opd', $data);
       }
    }

    function kab($param=null){
        $data['kategori_unit']  ='kab';
        $data['label']          ='Kabupaten/Kota';
        $data['tag']            = 'kab';
        $data['dataPeriode']    = $this->mastermodel->getPeriode();

        if(isset($param) &&!empty($param)) {
            $data['id_unit_hash'] = $param;
            $data['unit'] = $this->mastermodel->getMUnit($data);
            return view('opd_detail', $data);
        }else {
            $data['unit'] = $this->mastermodel->findMUnit($data);
            return view('opd', $data);
        }
    }

    function detail($params=null, $tag=null){

        // return json_encode($params);
        
        $data['param']          = empty($params) ? 'spirit' : $params;
        
        $param['periode']       = ($_GET && $_GET['t']) ? $_GET['t'] : (date('Y') - 1) ;
        $param['tag']           = isset($tag) && $tag ? $tag : 'opd';
        $param['kategori_unit'] = $param['tag'];

        $data['indikator']      = $this->mastermodel->findMIndikator($param);

        $data['unit'] = $this->mastermodel->findMUnit($param);
        $data['label']=((isset($tag) && $tag=='kab')?'Kabupaten/Kota':'Perangkat Daerah/UOBK');
        $data['tag'] = $param['tag'];

        if($params != 'spirit'){
            $data['idaspek'] = $_GET['ids'];
        }
        
        $data['tahun']   = $_GET['t'];
        $data['periode'] = $_GET['p'];
        $data['dataPeriode'] = $this->mastermodel->getPeriode();

        // return json_encode($data['page']);

        //if($data['kategori']=='spirit') $this->addScript("assets/landing/js/detail.js");
        //else $this->addScript("assets/landing/js/detail_aspek.js");

        // return json_encode($data['indikator']);
        return view('detail', $data);
    }

}
