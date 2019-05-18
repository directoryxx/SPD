@extends('layouts.app')

@section('content')
<div>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Users</li>
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
                            <strong>Tambah</strong> Users 
                        </div>

                        <form class="form-horizontal" action="{{url('admin/users')}}" method="post">
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label" for="hf-email">Nama</label>
                                <div class="col-md-9">
                                    {{csrf_field()}}
                                    <input class="form-control" id="hf-email" name="nama" type="text" name="hf-email" placeholder="Masukkan nama..." autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label" for="hf-email">Email</label>
                                <div class="col-md-9">
                                    {{csrf_field()}}
                                    <input class="form-control" id="hf-email" name="email" type="email" name="hf-email" placeholder="Masukkan email..." autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label" for="hf-email">Password</label>
                                <div class="col-md-9">
                                    <input class="form-control" id="hf-email" name="password" type="password" name="hf-email" placeholder="Masukkan password ..." autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label" for="hf-email">Roles</label>
                                <div class="col-md-9">
                                    <select class="form-control" name="roles" id="sel1">
                                        <option value="1">Administrator</option>
                                        <option value="2">Manager</option>
                                        <option value="3">Supervisor</option>
                                        <option value="4">Karyawan</option>
                                    </select>
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
                        <i class="fa fa-align-justify"></i> <strong>Daftar</strong> Users</div>
                        <div class="card-body">
                            <table class="table table-responsive-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Roles</th>
                                        <th>Created At</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                    <tr>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}}</td>
                                        @if ($user->roles == 1)
                                            <td>Administrator</td>
                                        @elseif($user->roles==2)
                                            <td>Manager</td>
                                        @elseif ($user->roles == 3)
                                            <td>Supervisor</td>
                                        @elseif ($user->roles == 4)
                                            <td>Karyawan</td>
                                        @endif
                                        <td>{{$user->created_at}}</td>
                                        <td>
                                            <span class="badge badge-warning"><a data-toggle="modal" data-target="#exampleModal{{$user->id}}" href="">Edit</a></span>
                                            <span class="badge badge-danger"><a onclick="event.preventDefault(); document.getElementById('delete-form{{$user->id}}').submit();" href="{{url('admin/users/')}}/{{$user->id}}">Hapus</a></span>
                                            <form id="delete-form{{$user->id}}" action="{{url('admin/users/')}}/{{$user->id}}" method="POST" style="display: none;">
                                                @csrf
                                                {{method_field('DELETE')}}
                                            </form>
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
                            @foreach ($users as $user)
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{url('admin/users')}}/{{$user->id}}" method="post">
                                    <div class="modal-body">
                                            <div class="form-group row">
                                                <label class="col-md-3 col-form-label" for="hf-email">Nama</label>
                                                <div class="col-md-9">
                                                    {{csrf_field()}}
                                                    {{method_field('PUT')}}
                                                    <input value="{{$user->name}}" class="form-control" id="hf-email" name="nama" type="text" name="hf-email" placeholder="Masukkan nama..." autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-3 col-form-label" for="hf-email">Email</label>
                                                <div class="col-md-9">
                                                    <input value="{{$user->email}}" class="form-control" id="hf-email" name="email" type="email" name="hf-email" placeholder="Masukkan nama..." autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-3 col-form-label" for="hf-email">Roles</label>
                                                <div class="col-md-9">
                                                    <select class="form-control" name="roles" id="sel1">
                                                        @if($user->roles == 1)
                                                            <option value="1">Administrator</option>
                                                            <option value="2">Manager</option>
                                                            <option value="3">Supervisor</option>
                                                            <option value="4">Karyawan</option>
                                                        @elseif($user->roles == 2)
                                                            <option value="2">Manager</option>
                                                            <option value="1">Administrator</option>
                                                            <option value="3">Supervisor</option>
                                                            <option value="4">Karyawan</option>
                                                        @elseif($user->roles == 3)
                                                            <option value="3">Supervisor</option>
                                                            <option value="1">Administrator</option>
                                                            <option value="2">Manager</option>
                                                            <option value="4">Karyawan</option>

                                                        @elseif($user->roles == 4)
                                                            <option value="4">Karyawan</option>
                                                            <option value="1">Administrator</option>
                                                            <option value="2">Manager</option>
                                                            <option value="3">Supervisor</option>
                                                        @endif
                                                    </select>
                                                </div>
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
