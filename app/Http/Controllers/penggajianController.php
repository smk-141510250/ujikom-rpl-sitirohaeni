<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\penggajianModel ;
use App\tunjangan_pegawaiModel ;
use App\pegawaiModel ;
use App\tunjanganModel ;
use App\jabatanModel ;
use App\golonganModel;
use App\kategori_lemburModel ;
use App\lembur_pegawaiModel ;
use Input ;
use Validator ;
use auth ;
class PenggajianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $penggajian=penggajianModel::paginate(3);
        return view('penggajian.index',compact('penggajian'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $tunjangans=tunjangan_pegawaiModel::paginate(10);
        return view('penggajian.create',compact('tunjangans'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $penggajians=Input::all();
         // dd($penggajian);
        
        $where=tunjangan_pegawaiModel::where('id',$penggajians['tunjangan_pegawai_id'])->first();
        // dd($where);
        $wherepenggajian=penggajianModel::where('tunjangan_pegawai_id',$where->id)->first();
        // dd($wherepenggajian);
        $wheretunjangan=tunjanganModel::where('id',$where->kode_tunjangan_id)->first();
        // dd($wheretunjangan);
        $wherepegawai=pegawaiModel::where('id',$where->pegawai_id)->first();
        // dd($wherepegawai);
        $wherekategori_lembur=kategori_lemburModel::where('jabatan_id',$wherepegawai->jabatan_id)->where('golongan_id',$wherepegawai->golongan_id)->first();
         // dd($wherekategori_lembur);
        $wherelemburpegawai=lembur_pegawaiModel::where('pegawai_id',$wherepegawai->id)->first();
        // dd($wherelemburpegawai);
        $wherejabatan=jabatanModel::where('id',$wherepegawai->jabatan_id)->first();
        // dd($wherejabatan);
        $wheregolongan=golonganModel::where('id',$wherepegawai->golongan_id)->first();
        // dd($wheregolongan);

        $penggajians=new penggajianModel ;
        if (isset($wherepenggajian)) {
            $error=true ;
            $tunjangans=tunjangan_pegawaiModel::paginate(10);
            return view('penggajian.create',compact('tunjangans','error'));
        }
        elseif (!isset($wherelemburpegawai)) {
            $nol=0 ;
            $penggajians->jumlah_jam_lembur=$nol;
            $penggajian->jumlah_uang_lembur=$nol ;

            $penggajians->gaji_pokok=$wherejabatan->besaran_uang+$wheregolongan->besaran_uang;
            $penggajians->total_gaji=($wheretunjangan->besaran_uang)+($wherejabatan->besaran_uang+$wheregolongan->besaran_uang);
                $penggajians->status_pengambilan=0 ;
            $penggajians->tanggal_pengambilan =date('d-m-y');
        $penggajians->tunjangan_pegawai_id=Input::get('tunjangan_pegawai_id');
        $penggajians->petugas_penerimaan=auth::User()->name ;
        $penggajians->save();
        }
        elseif (!isset($wherelemburpegawai)||!isset($wherekategori_lembur)) {
            $nol=0 ;
            $penggajians->jumlah_jam_lembur=$nol;
            $penggajians->jumlah_uang_lembur=$nol ;
            $penggajians->gaji_pokok=$wherejabatan->besaran_uang+$wheregolongan->besaran_uang;
            $penggajians->total_gaji=($wheretunjangan->besaran_uang)+($wherejabatan->besaran_uang+$wheregolongan->besaran_uang);
            $penggajians->status_pengambilan=0 ;
            $penggajians->tanggal_pengambilan =date('d-m-y');
        $penggajians->tunjangan_pegawai_id=Input::get('tunjangan_pegawai_id');
        $penggajians->petugas_penerimaan=auth::user()->name ;
        $penggajians->save();
        }
        else{

            $penggajians->jumlah_jam_lembur=$wherelemburpegawai->jumlah_jam;
            $penggajians->jumlah_uang_lembur=$wherelemburpegawai->jumlah_jam*$wherekategori_lembur->besaran_uang ;
            $penggajians->gaji_pokok=$wherejabatan->besaran_uang+$wheregolongan->besaran_uang;
            $penggajians->total_gaji=($wherelemburpegawai->jumlah_jam*$wherekategori_lembur->besaran_uang)+($wheretunjangan->besaran_uang)+($wherejabatan->besaran_uang+$wheregolongan->besaran_uang);
            $penggajians->tanggal_pengambilan =date('d-m-y');
            $penggajians->tunjangan_pegawai_id=Input::get('tunjangan_pegawai_id');
            $penggajians->status_pengambilan=0 ;
            $penggajians->petugas_penerimaan=auth::user()->name ;
            $penggajians->save();
            }
            return redirect('penggajian');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $penggajians=penggajianModel::find($id);
        return view('penggajian.read',compact('penggajians'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $lemburpegawai=lembur_pegawaiModel::all();
        $penggajian=penggajianModel::find($id);
        return view('penggajian.edit',compact('penggajian','lemburpegawai'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $Update=Request::all();
        $penggajian=penggajianModel::find($id);
        $penggajian->update($Update);
        return redirect('penggajian');
    }
        //
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        penggajianModel::find($id)->delete();
        return redirect('penggajian');
    }
}
