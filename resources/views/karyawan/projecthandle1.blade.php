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
                                <p> Ditunjuk Oleh : {{$proyek_by->name}}</p>
                            </center>

                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                        <i class="fa fa-book"></i> File Upload </div>
                        <div class="card-body">
                            <form action="{{route('karyawan.fileupload')}}" method="post" enctype="multipart/form-data">
                            <div class="input-group custom-file">
                                    {{csrf_field()}}
                                    
                                    <input name="file" type="file" class="custom-file-input" id="inputGroupFile01"
                                    aria-describedby="inputGroupFileAddon01">
                                    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                            </div>
                            <div class="input-group">
                                    <select name="kategoriid" class="form-control" id="exampleFormControlSelect1">
                                        <option>--Kategori--</option>
                                        @foreach ($kategori_semua as $katas)
                                            <option value="{{$katas->id}}">{{$katas->namakategori}}</option>
                                        @endforeach
                                    </select>
                            </div>
                            <div class="input-group text-center">
                                        <button type="submit" class="btn btn-success  mx-auto d-block">Upload</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                        <i class="fa fa-upload"></i> File yang sudah di upload </div>
                        <div class="card-body">
                            <center>
                                @foreach ($kat_all as $kategori)
                                        @if($kategori->id == 101)

                                        @else 
                                            <div class="col-lg-12 text-center">
                                                <div class="card">
                                                    <div class="card-header">
                                                    <i class="fa fa-upload"></i> {{$kategori->kategori->namakategori}} </div>
                                                    <div class="card-body"> 
                                                    
                                                    <a target="_blank" href="/storage/{{$kategori->lokasifile}}">Link Dokumen</a>
                                                    <br/>
                                                    @if ($kategori->status == 1)
                                                        <br/>
                                                        <div class="alert alert-success">
                                                            Dokumen Sudah anda terima
                                                        </div>
                                                    @elseif ($kategori->status == 2)
                                                        <br/>
                                                        <div class="alert alert-danger">
                                                            Dokumen Sudah anda tolak
                                                        </div>
                                                    @else 
                                                        <br/>
                                                        <div class="alert alert-warning">
                                                            Masih menunggu persetujuan
                                                        </div>
                                                        
                                                    @endif
                                                    
                                                        
                                                    </div>
                                                </div>
                                        
                                            </div>
                                        @endif
                                @endforeach
                           
                            </center>

                        </div>
                    </div>
                </div>
            </div>
           
        </div>
    </div>
</div>
@endsection
