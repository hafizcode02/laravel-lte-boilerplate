    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="index3.html" class="brand-link">
            <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
                class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">ARSIP SURAT</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{ asset('dist/img/avatar.png') }}" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{ Auth::user()->name }}</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                @php
                    $menus = [
                        (object) [
                            'title' => 'MENU UTAMA',
                        ],
                        (object) [
                            'icon' => 'fas fa-tachometer-alt',
                            'name' => 'Dashboard',
                            'link' => '/dashboard',
                            'childs' => [],
                        ],
                        (object) [
                            'icon' => 'fas fa-list',
                            'name' => 'Jenis Surat',
                            'link' => '/jenis-surat',
                            'childs' => [],
                        ],
                        (object) [
                            'icon' => 'fas fa-user',
                            'name' => 'Pengguna',
                            'link' => '/manajemen-akun',
                            'childs' => [],
                            'is_superuser' => true, // Menambahkan field ini untuk mengontrol akses
                        ],
                        (object) [
                            'title' => 'DOKUMEN SURAT',
                        ],
                        (object) [
                            'icon' => 'fas fa-book',
                            'name' => 'Sekretariat',
                            'childs' => [
                                (object) [
                                    'name' => 'Surat Masuk',
                                    'link' => '/sekretariat/surat-masuk',
                                ],
                                (object) [
                                    'name' => 'Surat Keluar',
                                    'link' => '/sekretariat/surat-keluar',
                                ],
                            ],
                        ],
                        (object) [
                            'icon' => 'fas fa-book',
                            'name' => 'Bidang Pemuda',
                            'childs' => [
                                (object) [
                                    'name' => 'Surat Masuk',
                                    'link' => '/pemuda/surat-masuk',
                                ],
                                (object) [
                                    'name' => 'Surat Keluar',
                                    'link' => '/pemuda/surat-keluar',
                                ],
                            ],
                        ],
                        (object) [
                            'icon' => 'fas fa-book',
                            'name' => 'Bidang Olahraga',
                            'childs' => [
                                (object) [
                                    'name' => 'Surat Masuk',
                                    'link' => '/olahraga/surat-masuk',
                                ],
                                (object) [
                                    'name' => 'Surat Keluar',
                                    'link' => '/olahraga/surat-keluar',
                                ],
                            ],
                        ],
                        (object) [
                            'title' => 'AKUN PENGGUNA',
                        ],
                        (object) [
                            'icon' => 'fas fa-user',
                            'name' => 'Profil Akun',
                            'link' => '/profil-akun',
                            'childs' => [],
                        ],
                    ];
                @endphp

                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    @foreach ($menus as $menu)
                        @if (isset($menu->title))
                            <li class="nav-header">{{ $menu->title }}</li>
                            @continue
                        @endif

                        @if (isset($menu->is_superuser) && $menu->is_superuser && !Auth::user()->is_superuser)
                            @continue {{-- Menghentikan iterasi jika bukan superuser --}}
                        @endif

                        @php
                            $hasActiveChild = false;
                            if (count($menu->childs)) {
                                foreach ($menu->childs as $child) {
                                    if (Request::is(trim($child->link, '/'))) {
                                        $hasActiveChild = true;
                                        break;
                                    }
                                }
                            }
                        @endphp

                        <li class="nav-item @if ($hasActiveChild) menu-is-opening menu-open @endif">
                            <a class="nav-link
                            @if ((!count($menu->childs) && Request::is(trim($menu->link, '/'))) || $hasActiveChild) active @endif"
                                href="{{ count($menu->childs) ? '#' : $menu->link }}">
                                <i class="nav-icon {{ $menu->icon }}"></i>
                                <p>{{ $menu->name }}</p>
                                @if (count($menu->childs))
                                    <i class="right fas fa-angle-left"></i>
                                @endif
                            </a>
                            @if (count($menu->childs))
                                <ul class="nav nav-treeview"
                                    style="{{ Request::is(trim($child->link, '/')) ? 'display: block;' : 'display: none;' }}">
                                    @foreach ($menu->childs as $child)
                                        <li class="nav-item">
                                            <a class="nav-link {{ Request::is(trim($child->link, '/')) ? 'active' : '' }}"
                                                href="{{ $child->link }}">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>{{ $child->name }}</p>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                    <li class="nav-item">
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <a href="#" class="nav-link" id="logout-button">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>Logout</p>
                        </a>
                    </li>
                </ul>

            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    @push('scripts')
        <script>
            document.getElementById('logout-button').addEventListener('click', function(e) {
                e.preventDefault();
                document.getElementById('logout-form').submit();
            });
        </script>
    @endpush
