<?php

namespace App\Controllers;
use App\Models\EvaluasiModel;

class Home extends BaseController
{
    public function __construct()
    {
        $this->evaluasimodel = new EvaluasiModel();
    }

	public function index()
	{
        $data_['limit']=4;
        $data_['tahun']=(date("Y")-1);
        $data_['tag']='opd';
        $data['cettar'] = $this->evaluasimodel->findCettar($data_);

        $data1['limit']=1;
        $data1['tahun']=(date("Y")-1);
        $data1['id_aspek'] = 'C01';
        $data1['tag']='opd';
        $data['cepat'] = $this->evaluasimodel->findCettarAspek($data1);

        $data2['limit']=1;
        $data2['tahun']=(date("Y")-1);
        $data2['id_aspek'] = 'C02';
        $data2['tag']='opd';
        $data['efektif'] = $this->evaluasimodel->findCettarAspek($data2);

        $data3['limit']=1;
        $data3['tahun']=(date("Y")-1);
        $data3['id_aspek'] = 'C03';
        $data3['tag']='opd';
        $data['tanggap'] = $this->evaluasimodel->findCettarAspek($data3);

        $data4['limit']=1;
        $data4['tahun']=(date("Y")-1);
        $data4['id_aspek'] = 'C04';
        $data4['tag']='opd';
        $data['transparan'] = $this->evaluasimodel->findCettarAspek($data4);

        $data5['limit']=1;
        $data5['tahun']=(date("Y")-1);
        $data5['id_aspek'] = 'C05';
        $data5['tag']='opd';
        $data['akuntabel'] = $this->evaluasimodel->findCettarAspek($data5);

        $data6['limit']=1;
        $data6['tahun']=(date("Y")-1);
        $data6['id_aspek'] = 'C06';
        $data6['tag']='opd';
        $data['responsif'] = $this->evaluasimodel->findCettarAspek($data6);


        return view('home',$data);
	}

    public function kab()
    {
        $data_['limit']=4;
        $data_['tahun']=(date("Y")-1);
        $data_['tag']='kab';
        $data['cettar'] = $this->evaluasimodel->findCettar($data_);

        $data1['limit']=1;
        $data1['tahun']=(date("Y")-1);
        $data1['id_aspek'] = 'K01';
        $data1['tag']='kab';
        $data['cepat'] = $this->evaluasimodel->findCettarAspek($data1);

        $data2['limit']=1;
        $data2['tahun']=(date("Y")-1);
        $data2['id_aspek'] = 'K02';
        $data2['tag']='kab';
        $data['efektif'] = $this->evaluasimodel->findCettarAspek($data2);

        $data3['limit']=1;
        $data3['tahun']=(date("Y")-1);
        $data3['id_aspek'] = 'K03';
        $data3['tag']='kab';
        $data['tanggap'] = $this->evaluasimodel->findCettarAspek($data3);

        $data4['limit']=1;
        $data4['tahun']=(date("Y")-1);
        $data4['id_aspek'] = 'K04';
        $data4['tag']='kab';
        $data['transparan'] = $this->evaluasimodel->findCettarAspek($data4);

        $data5['limit']=1;
        $data5['tahun']=(date("Y")-1);
        $data5['id_aspek'] = 'K05';
        $data5['tag']='kab';
        $data['akuntabel'] = $this->evaluasimodel->findCettarAspek($data5);

        $data6['limit']=1;
        $data6['tahun']=(date("Y")-1);
        $data6['id_aspek'] = 'K06';
        $data6['tag']='kab';
        $data['responsif'] = $this->evaluasimodel->findCettarAspek($data6);


        return view('home_kab',$data);
    }
}
