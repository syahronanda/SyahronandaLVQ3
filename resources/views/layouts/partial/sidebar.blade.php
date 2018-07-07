<div class="sidebar" data-color="purple" data-image="{{ asset('backend/img/sidebar-1.jpg') }}">

    <div class="logo">
        <a href="#" class="simple-text">
            LVQ 3
        </a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li class="{{ Request::is('admin/dashboard*') ? 'active': '' }}">
                <a href="#">
                    <i class="material-icons">dashboard</i>
                    <p>Dashboard</p>
                </a>
            </li>

        </ul>
    </div>
</div><div class="sidebar" data-color="purple" data-image="{{ asset('backend/img/sidebar-2.jpg') }}">

    <div class="logo">
        <a href="#" class="simple-text">
            LVQ 3
        </a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li class="{{ Request::is('data') ? 'active': '' }}">
                <a href="{{route('data.index')}}">
                    {{--<i class="material-icons">dashboard</i>--}}
                    <p>Data</p>
                </a>
            </li>
            <li class="{{ Request::is('proses') ? 'active': '' }}">
                <a href="{{route('proses.store')}}">
                    {{--<i class="material-icons">dashboard</i>--}}
                    <p>Pelatihan & Pengujian</p>
                </a>
            </li>
            <li class="{{ Request::is('hasil') ? 'active': '' }}">
                <a href="{{route('hasil.index')}}">
                    {{--<i class="material-icons">dashboard</i>--}}
                    <p>Hasil Pengujian</p>
                </a>
            </li>
            <li class="{{ Request::is('uji') ? 'active': '' }}">
                <a href="{{route('uji.index')}}">
                    {{--<i class="material-icons">dashboard</i>--}}
                    <p>Uji Data Tunggal</p>
                </a>
            </li>


        </ul>


    </div>
</div>