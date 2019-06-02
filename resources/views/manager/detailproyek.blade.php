@extends('layouts.app')

@section('content')
<div>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Proyek</li>
    </ol>
    <div class="container">
        <div class="card-body">
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif
            <div class="row justify-content-md-center">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                        <i class="fa fa-book"></i> {{$proyek->namaproyek}} </div>
                        <div class="card-body">
                            <center>
                                <p> Nama Proyek : {{$proyek->namaproyek}}</p>
                                <p> Lokasi Proyek : {{$proyek->lokasiproyek}}</p>
                                <p> PT Pengaju : {{$proyek->ptpengaju}}</p>
                                <p> Proyek Masuk : <a href="/{{$proyek->lokasifileproyekmasuk}}">Link Dokumen</a></p>
                            </center>

                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                        <i class="fa fa-user"></i> Karyawan yg ditunjuk </div>
                        <div class="card-body">
                            @if($count < 5)
                                <center>
                                    <p> Supervisor belum menunjuk karyawan</p>
                                </center>

                            @else
                                <center>
                                    <p> Terkunci , Anda telah memilih karyawan </p>

                                </center>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                        <i class="fa fa-book"></i> Rekap dokumen manajer </div>
                        <div class="card-body">
                            @if($count_kat == $proyek_approve)
                                @if($dokumenrekap != null)
                                    @if($dokumenrekap->id == null)
                                        <center>
                                            <p>Dokumen belum diupload oleh supervisor</p>
                                        </center>
                                    @else
                                        <center>
                                        <a target="_blank" href="/{{$dokumenrekap->lokasifile}}">Link Dokumen</a>
                                        <br/>
                                        @if ($dokumenrekap->status == 1)
                                            <br/>
                                            <div class="alert alert-success">
                                                Dokumen Sudah anda terima
                                            </div>
                                        @elseif ($dokumenrekap->status == 2)
                                            <br/>
                                            <div class="alert alert-warning">
                                                Dokumen sudah di tolak
                                            </div>
                                        @else 
                                        <div class="float-sm-left">
                                            <button onclick="event.preventDefault(); document.getElementById('accept-form{{$dokumenrekap->id}}').submit();" type="button" class="btn btn-success">Approve</button>
                                            <form id="accept-form{{$dokumenrekap->id}}" action="{{ route('manager.acceptfile') }}" method="POST" style="display: none;">
                                                @csrf
                                                <input type="hidden" name="idproyek" value="{{$dokumenrekap->proyek_id}}">
                                                <input type="hidden" name="idfile" value="{{$dokumenrekap->id}}">

                                            </form>
                                        </div>
                                        <div class="float-sm-right">
                                            <button type="button" data-toggle="modal" data-target="#rejectmodal{{$dokumenrekap->id}}" class="btn btn-danger">Reject</button>
                                            <div class="modal" id="rejectmodal{{$dokumenrekap->id}}">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Alasan Di tolak </h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <div class="modal-body">
                                                        <form action="{{ route('manager.rejectfile') }}" method="POST">
                                                        <div class="form-group">
                                                            {{csrf_field()}}
                                                            <input type="hidden" name="idfile" value="{{$dokumenrekap->id}}">
                                                            <label for="exampleFormControlTextarea1">{{$dokumenrekap->namafile}}</label>
                                                            <textarea name="komentar" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                                        </div>
                                                        <button type="submit" class="btn btn-danger" >Simpan</button>
                                                        </form>
                                                    </div>

                                                    <!-- Modal footer -->
                                                    
                                                    </div>
                                                </div>
                                            </div>
                                        </div><br>
                                            
                                        @endif
                                        </center>
                                    @endif
                                @else
                                    <center>
                                        <p> Belum ada<p>
                                    </center>
                                @endif
                            @else
                                <p>Dokumen belum disetujui semua</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                        <i class="fa fa-upload"></i> File Upload </div>
                        <div class="card-body">
                            <center>
                                @if ($count < 5)
                                    
                                    <p> Upload tidak tersedia, Silahkan tunjuk Karyawan</p>   
                                @elseif($count_kat == 0)
                                    <p> Tidak ada kategori , Silahkan hubungi admin </p>

                                @else 

                                        @foreach ($kategori_all as $kategori)
                                        @if($kategori->id == 10)

                                        @else 
                                            <div class="col-lg-12 text-center">
                                                <div class="card">
                                                    <div class="card-header">
                                                    <i class="fa fa-upload"></i> {{$kategori->namakategori}} </div>
                                                    <div class="card-body">
                                                        
                                                            
                                                                @if(count($kategori->fileproyek) > 0)
                                                                        @foreach ($kategori->fileproyek as $file) 
                                                                            @if ($file->lokasifile != null)                                                                   
                                                                                <a target="_blank" href="/{{$file->lokasifile}}">Link Dokumen</a>
                                                                                <br/>
                                                                                @if ($file->status == 1)
                                                                                    <br/>
                                                                                    <div class="alert alert-success">
                                                                                        Dokumen Sudah anda terima
                                                                                    </div>
                                                                                @elseif ($file->status == 2)
                                                                                    <br/>
                                                                                    <div class="alert alert-warning">
                                                                                        Dokumen sudah di tolak
                                                                                    </div>
                                                                                @else 
                                                                                    <br/>
                                                                                    <div class="alert alert-warning">
                                                                                        Dokumen belum disetujui supervisor
                                                                                    </div>


                                                                                @endif

                                                                            @endif
                                                                        @endforeach
                                                                
                                                                @else
                                                                    <p>Karyawan Belum Upload File</p>
                                                                @endif
                                                                <br/>

                                                                
                                                                
                                                            
                                                            <br/>
                                                    </div>
                                                </div>
                                        
                                            </div>
                                            @endif
                                            @endforeach
                                        

                                @endif
                            </center>

                        </div>
                    </div>
                </div>
            </div>
           
        </div>
    </div>
</div>
@endsection
