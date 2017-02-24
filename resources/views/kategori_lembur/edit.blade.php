@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">update lembur pegawai </div>
                <div class="panel-body">

                {!! Form::model($kategori_lemburs,['method'=>'PATCH','route'=>['kategori_lembur.update',$kategori_lemburs->id]])!!}
                     <div class="form-group">
                        {!! Form::label('kode lembur', 'kode lembur') !!}
                        {!! Form::text('kode_lembur',null,['class'=>'form-control']) !!}
                          @if ($errors->has('kode_lembur'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('kode_lembur') }}</strong>
                                    </span>
                            @endif
                    </div>
                     <div class="col-md-6 col-sm-6 col-xs-12">
                        <select class="form-control" col-md-7 col-sx-12 name="jabatan_id">
                            @foreach ($jabatans as $jabatans)
                            <option value="{{$jabatans->id}}">{{ $kategori_lemburs->jabatanModel->nama_jabatan}}
                            </option>
                            @endforeach

                        </select>
                    </div>
                    </div>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <select class="form-control" col-md-7 col-sx-12 name="golongan_id">
                            @foreach ($golongans as $golongans)
                            <option value="{{$jabatans->id}}">{{ $kategori_lemburs->golonganModel->nama_golongan}}</option>
                            @endforeach
                        </select>
                    </div>                    
                    <div class="form-group">
                        {!! Form::label('besaran uang', 'besaran uang') !!}
                        {!! Form::text('besaran_uang',null,['class'=>'form-control']) !!}
                    </div>
                    @if ($errors->has('besaran_uang'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('besaran_uang') }}</strong>
                                    </span>
                    @endif
                    <div class="form-group">
                        {!! Form::submit('SAVE', ['class' => 'btn btn-primary form-control']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
