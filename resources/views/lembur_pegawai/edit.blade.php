@extends('layouts.app')

@section('content')
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading"><h2>Edit Lembur Pegawai</div>
                    
                <div class="panel-body">
                    {!!Form::model($lemburpegawai,['method'=>'PATCH','route'=>['lembur_pegawai.update',$lemburpegawai->id]])!!}


                        
                            <div class="col-md-6">
                                <label for="jumlah_jam" >Jumlah Jam Lembur</label>
                                <input id="jumlah_jam" value="{{$lemburpegawai->jumlah_jam}}" type="text" class="form-control" name="jumlah_jam" autofocus>

                                    <span class="help-block">
                                        <strong>{{ $errors->first('jumlah_jam') }}</strong>
                                    </span>
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
