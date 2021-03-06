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
                        <i class="fa fa-upload"></i> File Upload </div>
                        <div class="card-body">
                            <center>
                                    @foreach ($kategori_all as $kategori)
                                        @if($kategori->created_at == null)

                                        @else 
                                        <div class="col-lg-12 text-center">
                                        <div class="card">
                                            <div class="card-header">
                                            <i class="fa fa-upload"></i> {{$kategori->namakategori}} </div>
                                            <div class="card-body">
                                                
                                                        @php($i=0)
                                                        @if(count($kategori->fileproyek) > 0)
                                                                
                                                                @foreach ($kategori->fileproyek as $file) 
                                                                    
                                                                    @if($file->kategori_id == 101)
                                                                        <p>skip</p>
                                                                    @else
                                                                        @php($i++)
                                                                        @if ($file->lokasifile != null)                                                                   
                                                                            <a href="/storage/{{$file->lokasifile}}">Link Dokumen</a>
                                                                            <br/>
                                                                            <br/>
                                                                            
                                                                            
                                                                            @if ($file->status == 1)
                                                                                <br/>
                                                                                <div class="alert alert-success">
                                                                                    <strong>Status:</strong> Dokumen sudah diterima
                                                                                </div>
                                                                            @elseif ($file->status == 2)
                                                                                <br/>
                                                                                <div class="alert alert-danger">
                                                                                    <strong>Status:</strong> Dokumen anda di tolak
                                                                                    <p>Alasan : {{$file->komentar}}.</p>
                                                                                </div>
                                                                                @if(($fileaccept != $filereject) || ($filereject != $filewaiting))
                                                                                    @if(App\Fileproyek::countfile($file->kategori_id,$file->proyek_id) == $i)
                                                                                        @if($filewaiting == 0)
                                                                                        <form action="{{url('karyawan/uploaddokumen')}}" method="post" enctype="multipart/form-data">
                                                                                            <div class="input-group">
                                                                                                <div class="custom-file">
                                                                                                        <div class="input-group-prepend">
                                                                                                            <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                                                                                                        </div>
                                                                                                            {{csrf_field()}}
                                                                                                            <input type="hidden" name="kategoriid" value="{{$kategori->id}}">
                                                                                                            <input name="file" type="file" class="custom-file-input" id="inputGroupFile01"
                                                                                                            aria-describedby="inputGroupFileAddon01">
                                                                                                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                                                                                </div>
                                                                                                <div class="input-group text-center">
                                                                                                        <button type="submit" class="btn btn-success  mx-auto d-block">Upload</button>
                                                                                                </div>
                                                                                            </div>
                                                                                        </form>
                                                                                        @endif
                                                                                    @endif
                                                                                @endif
                                                                            @else
                                                                                <div class="alert alert-warning">
                                                                                    <strong>Status:</strong> Masih menunggu persetujuan
                                                                                </div>
                                                                            @endif 
                                                                            
                                                                        @endif


                                                                    @endif
                                                                    
                                                                @endforeach
                                                        
                                                        @else
                                                            <form action="{{url('karyawan/uploaddokumen')}}" method="post" enctype="multipart/form-data">
                                                                <div class="input-group">
                                                                    <div class="custom-file">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                                                                            </div>
                                                                                {{csrf_field()}}
                                                                                <input type="hidden" name="kategoriid" value="{{$kategori->id}}">
                                                                                <input name="file" type="file" class="custom-file-input" id="inputGroupFile01"
                                                                                aria-describedby="inputGroupFileAddon01">
                                                                                <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                                                    </div>
                                                                    <div class="input-group text-center">
                                                                            <button type="submit" class="btn btn-success  mx-auto d-block">Upload</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        @endif

                                                        
                                                        
                                                    
                                                    <br/>
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
