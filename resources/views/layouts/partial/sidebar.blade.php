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
</div><div class="sidebar" data-color="green" data-image="{{ asset('backend/img/sidebar-1.jpg') }}">

    <div class="logo">
        <a href="#" class="simple-text">
            LVQ 3
        </a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li class="{{ Request::is('/') ? 'active': '' }}">
                <a href="#">
                    <i class="material-icons">dashboard</i>
                    <p>Dashboard</p>
                </a>
            </li>


        </ul>
    </div>
</div>