@extends('layouts.app')

@section('content')
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading"><h2>Edit Lembur Pegawai</div>
                    
                <div class="panel-body">
                    {!!Form::model($lemburpegawai,['method'=>'PATCH','route'=>['lembur_pegawai.update',$lemburpegawai->id]])!!}


                        
                            <div class="col-md-6">
                                <label for="Jabatan">Status Lama</label>
                                <input type="text" class="form-control" value="{{$->$penggajian->tunjanganModel->status}}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="Jabatan">Status Baru</label>
                                    <select class="col-md-6 form-control" name="status">
                                            <option name="status">perent</option>
                                            <option name="status">Menikah</option>
                                    </select>
                            </div>
                        
                           <div class="col-md-5">
                            <button type="submit" class="btn btn-primary form-control btn">edit</button>
                          </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    
@endsection
