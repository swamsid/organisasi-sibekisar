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
        $data['kategori_unit']='opd';
        $data['label']='Perangkat Daerah';
        $data['tag']='opd';
       if(isset($param) &&!empty($param)) {
           $data['id_unit_hash'] = $param;
           $data['unit'] = $this->mastermodel->getMUnit($data);
           return view('opd_detail', $data);
       }else {
           $data['unit'] = $this->mastermodel->findMUnit($data);
           return view('opd', $data);
       }
    }

    function kab($param=null){
        $data['kategori_unit']='kab';
        $data['label']='Kabupaten/Kota';
        $data['tag']='kab';
        if(isset($param) &&!empty($param)) {
            $data['id_unit_hash'] = $param;
            $data['unit'] = $this->mastermodel->getMUnit($data);
            return view('opd_detail', $data);
        }else {
            $data['unit'] = $this->mastermodel->findMUnit($data);
            return view('opd', $data);
        }
    }



    function detail($params=null,$tag=null){
        $data['param'] = (empty($params)?'spirit':$params);
        $param['tag'] = (isset($tag) && $tag?$tag:'opd');
        $param['kategori_unit']=$param['tag'];

        $data['indikator']=$this->mastermodel->findMIndikator($param);
        $data['unit'] = $this->mastermodel->findMUnit($param);
        $data['label']=((isset($tag) && $tag=='kab')?'Kabupaten/Kota':'Perangkat Daerah');
        $data['tag'] = $param['tag'];
        switch($data['param']){
            case 'cepat':
                if($param['tag']=='opd') $data['idaspek']='C01';
                else $data['idaspek']='K01';
                break;
            case 'efektif':
                if($param['tag']=='opd') $data['idaspek']='C02';
                else $data['idaspek']='K02';
                break;
            case 'tanggap':
                if($param['tag']=='opd') $data['idaspek']='C03';
                else $data['idaspek']='K03';
                break;
            case 'transparan':
                if($param['tag']=='opd') $data['idaspek']='C04';
                else $data['idaspek']='K04';
                break;
            case 'akuntabel':
                if($param['tag']=='opd') $data['idaspek']='C05';
                else $data['idaspek']='K05';
                break;
            case 'responsif':
                if($param['tag']=='opd') $data['idaspek']='C06';
                else $data['idaspek']='K06';
                break;
        }

        //if($data['kategori']=='spirit') $this->addScript("assets/landing/js/detail.js");
        //else $this->addScript("assets/landing/js/detail_aspek.js");
        return view('detail',$data);
    }

}
