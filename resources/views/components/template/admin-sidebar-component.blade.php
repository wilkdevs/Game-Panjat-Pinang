<aside
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark"
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="/">
            <img src="{{ isset($settings) ? $settings['logoImage'] : env('APP_LOGO') }}" class="navbar-brand-img h-100" alt="main_logo">
            <!-- <span class="ms-1 font-weight-bold text-white">{{ isset($settings) ? $settings['websiteName'] : env('APP_NAME') }}</span> -->
        </a>
    </div>
    <hr class="horizontal light mt-0 mb-2" />
    <div class="collapse navbar-collapse  w-auto h-100" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <!-- <li class="nav-item ">
                <a class="nav-link text-white {{ $isRouteParent('home') == 'active' ? 'active bg-gradient-success' : '' }}"
                    href="/admin/home">
                    <span class="sidenav-mini-icon"> DA </span>
                    <span class="sidenav-normal  ms-2  ps-1"> Dashboard </span>
                </a>
            </li> -->
            @if ($getAccessRights('voucher'))
                <li class="nav-item ">
                    <a class="nav-link text-white {{ $isRouteParent('voucher') == 'active' ? 'active bg-gradient-success' : '' }}"
                        data-bs-toggle="collapse" aria-expanded="false" href="#voucher">
                        <span class="sidenav-mini-icon"> V </span>
                        <span class="sidenav-normal  ms-2  ps-1"> Voucher <b class="caret"></b></span>
                    </a>
                    <div class="collapse show" id="voucher">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link text-white {{ $isRouteActive(['admin/voucher/list']) }}"
                                    href="/admin/voucher/list">
                                    <span class="sidenav-mini-icon"> DV </span>
                                    <span class="sidenav-normal  ms-2  ps-1"> Daftar Voucher</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endif
            @if ($getAccessRights('gift'))
                <li class="nav-item ">
                        <a class="nav-link text-white {{ $isRouteParent('gift') == 'active' ? 'active bg-gradient-success' : '' }}"
                            data-bs-toggle="collapse" aria-expanded="false" href="#gift">
                            <span class="sidenav-mini-icon"> CV </span>
                            <span class="sidenav-normal  ms-2  ps-1"> Hadiah <b class="caret"></b></span>
                        </a>
                    <div class="collapse show" id="gift">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link text-white {{ $isRouteActive(['admin/gift/list']) }}"
                                    href="/admin/gift/list">
                                    <span class="sidenav-mini-icon"> DP </span>
                                    <span class="sidenav-normal  ms-2  ps-1"> Daftar Hadiah</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white {{ $isRouteActive(['admin/gift/category/list']) }}"
                                    href="/admin/gift/category/list">
                                    <span class="sidenav-mini-icon"> DT </span>
                                    <span class="sidenav-normal  ms-2  ps-1"> Daftar Kategori</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endif
            @if ($getAccessRights('settings'))
                <li class="nav-item ">
                    <a class="nav-link text-white {{ $isRouteParent('setting') == 'active' ? 'active bg-gradient-success' : '' }}"
                        data-bs-toggle="collapse" aria-expanded="false" href="#settings">
                        <span class="sidenav-mini-icon"> SS </span>
                        <span class="sidenav-normal  ms-2  ps-1"> Pengaturan <b class="caret"></b></span>
                    </a>
                    <div class="collapse show" id="settings">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link text-white {{ $isRouteActive(['admin/setting/metatag']) }}"
                                    href="/admin/setting/metatag">
                                    <span class="sidenav-mini-icon"> M </span>
                                    <span class="sidenav-normal  ms-2  ps-1"> Meta Tag </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white {{ $isRouteActive(['admin/setting/view']) }}"
                                    href="/admin/setting/view">
                                    <span class="sidenav-mini-icon"> T </span>
                                    <span class="sidenav-normal  ms-2  ps-1"> Tampilan </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endif
            @if ($getAccessRights('admin_staff'))
                <li class="nav-item ">
                    <a class="nav-link text-white {{ $isRouteParent('staff') == 'active' ? 'active bg-gradient-success' : '' }}"
                        data-bs-toggle="collapse" aria-expanded="false" href="#admin_staff">
                        <span class="sidenav-mini-icon"> SS </span>
                        <span class="sidenav-normal  ms-2  ps-1"> Admin Staff <b class="caret"></b></span>
                    </a>
                    <div class="collapse show" id="admin_staff">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link text-white {{ $isRouteActive(['admin/staff/list']) }}"
                                    href="/admin/staff/list">
                                    <span class="sidenav-mini-icon"> M </span>
                                    <span class="sidenav-normal  ms-2  ps-1"> Daftar </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endif
        </ul>
    </div>
</aside>
