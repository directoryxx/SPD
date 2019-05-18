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
                
            @endif

            @if(Auth::user()->roles == 2)
                <li class="nav-item">
                    <a class="nav-link" href="{{url('manager/index')}}">
                        <i class="nav-icon icon-speedometer"></i> Dashboard
                    </a>
                </li>
            @endif

            @if(Auth::user()->roles == 3)
                <li class="nav-item">
                    <a class="nav-link" href="{{url('supervisor/index')}}">
                        <i class="nav-icon icon-speedometer"></i> Dashboard
                    </a>
                </li>
            @endif

            @if(Auth::user()->roles == 4)
                <li class="nav-item">
                    <a class="nav-link" href="{{url('karyawan/index')}}">
                        <i class="nav-icon icon-speedometer"></i> Dashboard
                    </a>
                </li>
            @endif
        </ul>
    </nav>
</div>
