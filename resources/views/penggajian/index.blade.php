
@extends('layouts/index2')
@section('content')

</style>
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading"><h2>Table Penggajian</div>
                    <div>
                    <div class="col-md-6">
                        <a href="{{url('penggajian/create')}}" class="btn btn-primary form-control">Tambah Data penggajian</a>
                    </div>

                    <div class="col-md-6">
                        <a class="btn btn-primary form-control" href="{{url('lembur_pegawai')}}">Silahkan Masuk Lembur Pegawai</a><hr>
                    </div>
                        <center>{{$penggajian->links()}}</center>
                    </div>
                    <table class="table table-striped table-hover table-bordered">

                        <thead>
                        <tr class="bg-info">
                        <th>No</th>
                        <td>Foto</td>
                        <th>Nama pegawai</th>
                        <th>Nip pegawai</th> 
                        <th>Status pengambilan</th>
                        <th colspan="2">Action</th>
                        </tr>
                        </thead>
                        @php
                            $no=1 ;
                        @endphp
                        @foreach($penggajian as $penggajians)
                            <tr>
                        <td>{{$no++}}</td>                        
                        <td><img height="120px" alt="Smiley face" width="120px" class="img-circle" src="asset/image/{{$penggajians->tunjangan_pegawaiModel->pegawaiModel->foto}}"></td>
                        <td>{{$penggajians->tunjangan_pegawaiModel->pegawaiModel->User->name}}</td>
                        <td>{{$penggajians->tunjangan_pegawaiModel->pegawaiModel->nip}}</td>
                        <td><b>@if($penggajians->tanggal_pengambilan == ""&&$penggajians->status_pengambilan == "0")
                            Gaji Belum Diambil
                        els@eif($penggajians->tanggal_pengambilan == ""||$penggajians->status_pengambilan == "0")
                            Gaji Belum Diambil
                        @else
                            Gaji Sudah Diambil Pada {{$penggajians->tanggal_pengambilan}}
                        @endif</b></td>
                                <div>
                                    <td><a class="btn btn-primary form-control" href="{{route('penggajian.show',$penggajians->id)}}">Detail</a></td>
                          
                                     <td>{!!Form::open(['method'=>'DELETE','route'=>['penggajian.destroy',$penggajians->id]])!!}
                                    {!!Form::submit('Delete',['class'=>'btn btn-danger col-md-12'])!!}</td>
                                    {!!Form::close()!!}
                                </tr>
                        </center>
                        </div> 
                        @endforeach
                        
                    </table>
                </div>

            </div>
        </div>
        
@endsection

