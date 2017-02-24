<?php

namespace App\Http\Controllers;

use App\pegawaiModel;
use App\User;
use App\golonganModel;
use App\jabatanModel;
use Input;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Request;



class pegawaiController extends Controller
{
    use RegistersUsers;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    

    public function index()
    {
         $pegawai=pegawaiModel::paginate(5);
        return view('pegawai.index',compact('pegawai'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {       $user=User::all();
            $jabatan=jabatanModel::all();
            $golongan=golonganModel::all();
        return view('pegawai.create',compact('pegawai','golongan','jabatan'));
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = array('email' => 'required|unique:users',
                        'password' => 'required|min:6|confirmed',
                        'name' => 'required',
                        'permision' =>'required',
                        'nip' => 'required|min:11|numeric|unique:pegawai',
                        'jabatan_id' =>'required',
                        'golongan_id' => 'required',
                        'foto' => 'required',
                         );

        $message =array('email.unique' =>'Gunakan Email Lain' ,
                        'name.required' =>'Wajib Isi',
                        'email.required' =>'Wajib Isi',
                        'password.unique' =>'wajib isi',
                        'password.confirmed' =>'Masukan Password Yang Benar',
                        'permision.required' =>'Wajib isi',
                        'nip.unique' =>'Gunakan Nip Lain',
                        'nip.required' =>'Wajib isi',
                        'nip.min' =>'Min 11',
                        'nip.numeric' =>'Input Dengan Angka',
                        'jabatan_id.required' =>'Wajib isi',
                        'golongan_id.required' =>'Wajib isi');


        $val=validator::make(Input::all(),$rules,$message);
        if($val->fails())
        {
            return redirect('pegawai/create')
            ->withErrors($val)
            ->withInput();

        }



         $file =Input::file('foto');
       $distributor=public_path().'/asset/image';
       //mendafatkan nama klien asli
       $filename=$file->getClientOriginalName();
       $uploadsuccess=$file->move($distributor,$filename);
       
       if (Input::hasfile('foto')) {
            $akun=new User ;
            $akun->name=Input::get('name');
             $akun->email=Input::get('email');
             $akun->password=bcrypt(Input::get('password'));
             $akun->permision=Input::get('permision');
             $akun->save();

             $pegawai=new pegawaiModel ;
             $pegawai->nip=Input::get('nip');
             $pegawai->foto=$filename;
             $pegawai->jabatan_id=Input::get('jabatan_id');
             $pegawai->golongan_id=Input::get('golongan_id');
             $pegawai->user_id=$akun->id;
             $pegawai->save();
         }
         return redirect('pegawai');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pegawai=pegawaiModel::find($id);
        $jabatan=jabatanModel::all();
        $golongan=golonganModel::all();
        return view('pegawai.edit',compact('pegawai','jabatan','golongan'));
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
        //
        $pegawai = Input::all();
        $pegawai=pegawaiModel::where('id',$id)->first();
        
        if ($pegawai->nip != Request('nip')) {
            $rules = array(
                        'name' => 'required',
                        'permision' =>'required',
                        'nip' => 'required|min:11|numeric|unique:pegawai',
                        'email' => 'required',
                        'jabatan_id' =>'required',
                        'golongan_id' => 'required',
                        'foto' => 'required',
                        'kode_lembur' => 'unique'
                         );
        }
        elseif ($pegawai->User->email != Request('email')) {
            $rules = array('email' => 'required|unique:users',
                        'nip' => 'required|min:11|numeric',
                        'name' => 'required',
                        'permision' =>'required',
                        'jabatan_id' =>'required',
                        'golongan_id' => 'required',
                        'foto' => 'required',
                        'kode_lembur' => 'unique'
                         );
        }
        
        else
        {
            $rules = array('email' => 'required',
                        'name' => 'required',
                        'permision' =>'required',
                        'nip' => 'required|min:11|numeric',
                        'jabatan_id' =>'required',
                        'golongan_id' => 'required',
                        'foto' => 'required',
                        'kode_lembur' => 'unique'
                         );
        }
             
        $message =array('email.unique' =>'Gunakan Email Lain' ,
                        'name.required' =>'Wajib Isi',
                        'email.required' =>'Wajib Isi',
                        'password.confirmed' =>'Masukan Password Yang Benar',
                        'permision.required' =>'Wajib isi',
                        'nip.unique' =>'Gunakan Nip Lain',
                        'nip.required' =>'Wajib isi',
                        'nip.min' =>'Min 11',
                        'nip.numeric' =>'Input Dengan Angka',
                        'jabatan_id.required' =>'Wajib isi',
                        'golongan_id.required' =>'Wajib isi');


        $val=validator::make(Input::all(),$rules,$message);
        if($val->fails())
        {
            return redirect('pegawai/'.$id.'/edit')
            ->withErrors($val)
            ->withInput();
        }
            $user=new User ;
                $user=array('name'=>Input::get('name'),
                                'email'=>Input::get('email'),
                                'permision'=>Input::get('permision')
                                );
        
            User::where('id',$pegawai->user_id)->update($user);
            $update=Input::all();
            $logo =Input::file('foto') ;
            $upload='asset/image';
            $filename=$logo->getClientOriginalName();
            $success=$logo->move($upload,$filename);

            if($success){
                $pegawai=new pegawaiModel ;
                $pegawai=array('foto'=>$filename,
                                'nip'=>Input::get('nip'),
                                'jabatan_id'=>Input::get('jabatan_id'),
                                'golongan_id'=>Input::get('golongan_id'),
                                );

                    pegawaiModel::where('id',$id)->update($pegawai);
                    // User::where('id',$pegawai->id_user)->update($akun);

                return redirect('pegawai');
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
         pegawaiModel::find($id)->delete();
        return redirect('pegawai');
    }
}
