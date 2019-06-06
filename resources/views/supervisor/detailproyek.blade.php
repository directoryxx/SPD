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
                            @if($count == 5)
                                <center>
                                    <p> Terkunci , Anda telah memilih karyawan </p>

                                </center>
                            @else
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
                            @endif

                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                        <i class="fa fa-user"></i> Rekap dokumen manajer </div>
                        <div class="card-body">
                            @if($count_kat == $proyek_approve)
                                    @if($dokumenrekap == null)
                                    <form action="{{url('supervisor/uploaddokumen')}}" method="post" enctype="multipart/form-data">
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                                                </div>
                                                {{csrf_field()}}
                                                <input type="hidden" name="kategoriid" value="101">
                                                <input name="file" type="file" class="custom-file-input" id="inputGroupFile01"
                                                aria-describedby="inputGroupFileAddon01">
                                                <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                            </div>
                                            <div class="input-group text-center">
                                                <button type="submit" class="btn btn-success  mx-auto d-block">Upload</button>
                                            </div>
                                        </div>
                                    </form>
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
                                                Dokumen Sudah anda tolak
                                            </div>
                                        @else 
                                            <br/>
                                            <div class="alert alert-warning">
                                                Masih Menunggu persetujuan
                                            </div>
                                            
                                        @endif
                                        </center>
                                    @endif
                                
                            @else
                                <center><p>Dokumen belum disetujui semua</p></center>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                        <i class="fa fa-upload"></i> File yang sudah diupload </div>
                        <div class="card-body">
                            <center>
                                @if ($count > 1)
                                @foreach ($kategori_all as $kategori)
                                    @if($kategori->id == 101)

                                    @else 
                                        <div class="col-lg-12 text-center">
                                            <div class="card">
                                                <div class="card-header">
                                                <i class="fa fa-upload"></i> {{$kategori->kategori->namakategori}} </div>
                                                <div class="card-body"> 
                                                <center>
                                                <a target="_blank" href="/{{$kategori->lokasifile}}">Link Dokumen</a>
                                                <br/>
                                                @if ($kategori->status == 1)
                                                    <br/>
                                                    <div class="alert alert-success">
                                                        Dokumen Sudah anda terima
                                                    </div>
                                                @elseif ($kategori->status == 2)
                                                    <br/>
                                                    <div class="alert alert-warning">
                                                        Dokumen Sudah anda tolak
                                                    </div>
                                                @else 
                                                    <div class="float-sm-left">
                                                        <button onclick="event.preventDefault(); document.getElementById('accept-form{{$kategori->id}}').submit();" type="button" class="btn btn-success">Approve</button>
                                                        <form id="accept-form{{$kategori->id}}" action="{{ route('supervisor.acceptfile') }}" method="POST" style="display: none;">
                                                            @csrf
                                                            <input type="hidden" name="idfile" value="{{$kategori->id}}">

                                                        </form>
                                                    </div>
                                                    <div class="float-sm-right">
                                                        <button type="button" data-toggle="modal" data-target="#rejectmodal{{$kategori->id}}" class="btn btn-danger">Reject</button>
                                                        <div class="modal" id="rejectmodal{{$kategori->id}}">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">

                                                                <!-- Modal Header -->
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">Alasan Di tolak </h4>
                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                </div>

                                                                <!-- Modal body -->
                                                                <div class="modal-body">
                                                                    <form action="{{ route('supervisor.rejectfile') }}" method="POST">
                                                                    <div class="form-group">
                                                                        {{csrf_field()}}
                                                                        <input type="hidden" name="idfile" value="{{$kategori->id}}">
                                                                        <label for="exampleFormControlTextarea1">{{$kategori->namafile}}</label>
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
                                                    
                                                </div>
                                            </div>
                                    
                                        </div>
                                        @endif
                                    @endforeach
                                @elseif($count_kat == 0)
                                    <p> Tidak ada kategori , Silahkan hubungi admin </p>
                                @else 
                                    <p> Upload tidak tersedia, Silahkan tunjuk Karyawan</p>                                       
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
