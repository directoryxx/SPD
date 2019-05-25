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
                        <i class="fa fa-user"></i> Karyawan yg ditunjuk </div>
                        <div class="card-body">
                            @if($count < 5)
                                <form action="{{url('supervisor/detailproyek')}}/{{$id}}" method="post">
                                    <div class="form-group">
                                        <label for="email">Karyawan 1:</label>
                                        {{csrf_field()}}
                                        <select name="karyawan[]" class="form-control" id="exampleFormControlSelect1">
                                            
                                            @foreach ($karyawans as $karyawan)
                                                <option value="{{$karyawan->id}}">{{$karyawan->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Karyawan 2:</label>
                                        <select class="form-control" name="karyawan[]" id="exampleFormControlSelect1">
                                            @foreach ($karyawans as $karyawan)
                                                <option value="{{$karyawan->id}}">{{$karyawan->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Karyawan 3:</label>
                                        <select class="form-control"  name="karyawan[]" id="exampleFormControlSelect1">
                                            @foreach ($karyawans as $karyawan)
                                                <option value="{{$karyawan->id}}">{{$karyawan->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Karyawan 4:</label>
                                        <select class="form-control" name="karyawan[]" id="exampleFormControlSelect1">
                                            @foreach ($karyawans as $karyawan)
                                                <option value="{{$karyawan->id}}">{{$karyawan->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </form>

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
                        <i class="fa fa-upload"></i> File Upload </div>
                        <div class="card-body">
                            <center>
                                @if ($count < 5)

                                    <p> Upload tidak tersedia, Silahkan tunjuk Karyawan</p>   
                                @elseif($count_kat == 0)
                                    <p> Tidak ada kategori , Silahkan hubungi admin </p>

                                @else 
                                        @foreach ($kategori_all as $kategori)
                                            <div class="col-lg-12 text-center">
                                                <div class="card">
                                                    <div class="card-header">
                                                    <i class="fa fa-upload"></i> {{$kategori->namakategori}} </div>
                                                    <div class="card-body">
                                                        
                                                            
                                                                @if(count($kategori->fileproyek) > 0)
                                                                        @foreach ($kategori->fileproyek as $file) 
                                                                            @if ($file->lokasifile != null)                                                                   
                                                                                <a target="_blank" href="{{$file->lokasifile}}">Link Dokumen</a>
                                                                                <br/>
                                                                                <br/>
                                                                                <div class="float-sm-left">
                                                                                    <button type="button" class="btn btn-success">Approve</button>
                                                                                
                                                                                </div><br>
                                                                                <div class="float-sm-right">
                                                                                    <button type="button" class="btn btn-danger">Reject</button>
                                                                                
                                                                                </div><br>

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
