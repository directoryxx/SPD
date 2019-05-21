<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            
            @if(Auth::user()->roles == 1)
                <li class="nav-item">
                    <a class="nav-link" href="{{url('admin/index')}}">
                        <i class="nav-icon icon-speedometer"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('admin/kategori')}}">
                        <i class="nav-icon icon-note"></i> Kategori
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{url('admin/users')}}">
                        <i class="nav-icon icon-user"></i> Users
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{url('admin/proyekselesai')}}">
                        <i class="nav-icon icon-list"></i> Proyek Selesai
                    </a>
                </li>
                
            @endif

            @if(Auth::user()->roles == 2)
                <li class="nav-item">
                    <a class="nav-link" href="{{url('manager/index')}}">
                        <i class="nav-icon icon-speedometer"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('manager/createproject')}}">
                        <i class="nav-icon icon-book-open"></i> Tambah Proyek
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{url('manager/proyekselesai')}}">
                        <i class="nav-icon icon-list"></i> Proyek Selesai
                    </a>
                </li>
            @endif

            @if(Auth::user()->roles == 3)
                <li class="nav-item">
                    <a class="nav-link" href="{{url('supervisor/index')}}">
                        <i class="nav-icon icon-speedometer"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('supervisor/proyekselesai')}}">
                        <i class="nav-icon icon-list"></i> Proyek Selesai
                    </a>
                </li>
            @endif

            @if(Auth::user()->roles == 4)
                <li class="nav-item">
                    <a class="nav-link" href="{{url('karyawan/index')}}">
                        <i class="nav-icon icon-speedometer"></i> Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{url('karyawan/proyekselesai')}}">
                        <i class="nav-icon icon-list"></i> Proyek Selesai
                    </a>
                </li>
            @endif
        </ul>
    </nav>
</div>
