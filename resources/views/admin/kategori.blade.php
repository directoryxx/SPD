@extends('layouts.app')

@section('content')
<div>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Kategori</li>
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
                            <strong>Tambah</strong> Kategori Dokumen
                        </div>

                        <form class="form-horizontal" action="{{url('admin/kategori')}}" method="post">
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label" for="hf-email">Nama Kategori Dokumen</label>
                                <div class="col-md-9">
                                    {{csrf_field()}}
                                    <input class="form-control" id="hf-email" name="namakategori" type="text" name="hf-email" placeholder="Masukkan nama kategori..." autocomplete="off">
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
                        <i class="fa fa-align-justify"></i> <strong>Daftar</strong> Kategori Dokumen</div>
                        <div class="card-body">
                            <table class="table table-responsive-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nama Kategori</th>
                                        <th>Created At</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kategori as $kategoris)
                                    <tr>
                                        <td>{{$kategoris->namakategori}}</td>
                                        <td>{{$kategoris->created_at}}</td>
                                        <td>
                                            @if($kategoris->id == 101)
        
                                            @else
                                                <span class="badge badge-warning"><a data-toggle="modal" data-target="#exampleModal{{$kategoris->id}}" href="">Edit</a></span>
                                                <span class="badge badge-danger"><a onclick="event.preventDefault(); document.getElementById('delete-form{{$kategoris->id}}').submit();" href="{{url('admin/kategori/')}}/{{$kategoris->id}}">Hapus</a></span>
                                                <form id="delete-form{{$kategoris->id}}" action="{{url('admin/kategori/')}}/{{$kategoris->id}}" method="POST" style="display: none;">
                                                    @csrf
                                                    {{method_field('DELETE')}}
                                                </form>

                                            @endif
                                        </td>
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
                            @foreach ($kategori as $kategoris)
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal{{$kategoris->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{url('admin/kategori')}}/{{$kategoris->id}}" method="post">
                                    <div class="modal-body">
                                        
                                            <div class="form-group">
                                                {{method_field('PUT')}}
                                                <label for="exampleInputEmail1">Nama Kategori</label>
                                                <input value="{{$kategoris->namakategori}}" class="form-control" id="hf-email" name="namakategori" type="text" name="hf-email" placeholder="Masukkan nama kategori..." autocomplete="off">
                                                {{csrf_field()}}
                                            </div>
                                        
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                    </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
           
        </div>
    </div>
</div>
@endsection
