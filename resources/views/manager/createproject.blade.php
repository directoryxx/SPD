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
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <strong>Tambah</strong> Proyek 
                        </div>

                        <form class="form-horizontal" action="{{url('manager/createproject')}}" method="post" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label" for="hf-email">Nama Proyek</label>
                                <div class="col-md-9">
                                    {{csrf_field()}}
                                    <input required class="form-control" id="hf-email" name="namaproyek" type="text" name="hf-email" placeholder="Masukkan nama proyek...." autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label" for="hf-email">Lokasi Proyek</label>
                                <div class="col-md-9">
                                    {{csrf_field()}}
                                    <input required class="form-control" id="hf-email" name="lokasiproyek" type="text" name="hf-email" placeholder="Masukkan lokasi proyek...." autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label" for="hf-email">PT Pengaju</label>
                                <div class="col-md-9">
                                    <input  required class="form-control" id="hf-email" name="ptpengaju" type="text" name="hf-email" placeholder="Masukkan PT Pengaju..." autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label" for="hf-email">Supervisor</label>
                                <div class="col-md-9">
                                    <select class="form-control" name="spvid" id="sel1">
                                        @foreach ($users as $user)
                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 col-form-label" for="hf-email">Upload Proyek Masuk</label>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                                            </div>
                                            {{csrf_field()}}
                                            <input name="file" type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-sm btn-primary" type="submit">
                            <i class="fa fa-dot-circle-o"></i> Simpan</button>
                        </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                        <i class="fa fa-align-justify"></i> <strong>Daftar</strong> Proyek </div>
                        <div class="card-body">
                            <table class="table table-responsive-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nama Proyek</th>
                                        <th>Lokasi Proyek</th>
                                        <th>PT Pengaju</th>
                                        <th>Created At</th>                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($proyeks as $proyek)
                                    <tr>
                                        <td><a href="/manager/proyek/{{$proyek->id}}">{{$proyek->namaproyek}}</a></td>
                                        <td>{{$proyek->lokasiproyek}}</td>
                                        <td>{{$proyek->ptpengaju}}</td>    
                                        <td>{{$proyek->created_at}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!--
                            <ul class="pagination">
                                <li class="page-item">
                                    <a class="page-link" href="#">Prev</a>
                                </li>
                                <li class="page-item active">
                                    <a class="page-link" href="#">1</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">2</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">3</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">4</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">Next</a>
                                </li>
                            </ul>
                            -->
                        </div>
                    </div>
                </div>
            </div>
           
        </div>
    </div>
</div>
@endsection
