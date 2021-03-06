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
                        <i class="fa fa-align-justify"></i> <strong>Proyek</strong> Aktif </div>
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
                                        <td><a href="{{url('supervisor/detailproyek')}}/{{$proyek->id}}">{{$proyek->namaproyek}}</td>
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
