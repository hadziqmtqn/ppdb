<aside id="layout-menu" class="layout-menu-horizontal menu-horizontal menu bg-menu-theme flex-grow-0">
    <div class="container-xxl d-flex h-100">
        <ul class="menu-inner">
            <li class="menu-item {{ $title == 'Dashboard' ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" class="menu-link">
                    <i class="menu-icon tf-icons mdi mdi-home-outline"></i>
                    <div data-i18n="Dashboard">Dashboard</div>
                </a>
            </li>
            @if(auth()->user()->hasRole('user'))
                <li class="menu-item {{ $title == 'Manajemen Siswa' ? 'active' : '' }}">
                    <a href="{{ route('student.show', auth()->user()->username) }}" class="menu-link">
                        <i class="menu-icon tf-icons mdi mdi-account-outline"></i>
                        <div data-i18n="Siswa">Siswa</div>
                    </a>
                </li>
                <li class="menu-item {{ $title == 'Tagihan Saat Ini' || $title == 'Transaksi Pembayaran' ? 'active' : '' }}">
                    <a href="javascript:void(0)" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons mdi mdi-cash-fast"></i>
                        <div data-i18n="Pembayaran">Pembayaran</div>
                    </a>

                    <ul class="menu-sub">
                        <li class="menu-item {{ $title == 'Transaksi Pembayaran' ? 'active' : '' }}">
                            <a href="{{ route('payment-transaction.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons mdi mdi-cash-sync"></i>
                                <div data-i18n="Histori Transaksi">Histori Transaksi</div>
                            </a>
                        </li>
                        <li class="menu-item {{ $title == 'Tagihan Saat Ini' ? 'active' : '' }}">
                            <a href="{{ route('current-bill.index', auth()->user()->username) }}" class="menu-link">
                                <i class="menu-icon tf-icons mdi mdi-cash-plus"></i>
                                <div data-i18n="Tagihan Saat Ini">Tagihan Saat Ini</div>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="menu-item {{ $title == 'Kirim Pesan' ? 'active' : '' }}">
                    <a href="{{ route('conversation.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons mdi mdi-send"></i>
                        <div data-i18n="Kirim Pesan">Kirim Pesan</div>
                    </a>
                </li>
            @else
                @foreach($listMenus as $listMenu)
                    @if($listMenu) <!-- Pastikan menu tidak null -->
                    @php
                        $isActive = $listMenu['url'] == url()->current() || collect($listMenu['subMenus'])
                            ->filter(fn($subMenu) => $subMenu['url'] == url()->current())
                            ->isNotEmpty();

                        $isActiveTitle = $listMenu['name'] == $title || collect($listMenu['subMenus'])
                            ->filter(fn($subMenu) => $subMenu['name'] == $title)
                            ->isNotEmpty();
                    @endphp
                    <li class="menu-item {{ $isActive || $isActiveTitle ? 'active' : '' }}">
                        <a href="{{ $listMenu['url'] != '#' ? $listMenu['url'] : 'javascript:void(0)' }}" class="menu-link {{ $listMenu['type'] == 'main_menu' && count($listMenu['subMenus']) > 0 ? 'menu-toggle' : '' }}">
                            <i class="menu-icon tf-icons mdi mdi-{{ $listMenu['icon'] }}"></i>
                            <div data-i18n="{{ $listMenu['name'] }}">{{ $listMenu['name'] }}</div>
                        </a>
                        @if(count($listMenu['subMenus']) > 0)
                            <ul class="menu-sub">
                                @foreach($listMenu['subMenus'] as $subMenu)
                                    @if($subMenu) <!-- Pastikan submenu tidak null -->
                                    <li class="menu-item {{ ($subMenu['url'] == url()->current()) || ($subMenu['name'] == $title) ? 'active' : '' }}">
                                        <a href="{{ $subMenu['url'] }}" class="menu-link">
                                            <i class="menu-icon tf-icons mdi mdi-{{ $subMenu['icon'] }}"></i>
                                            <div data-i18n="{{ $subMenu['name'] }}">{{ $subMenu['name'] }}</div>
                                        </a>
                                    </li>
                                    @endif
                                @endforeach
                            </ul>
                        @endif
                    </li>
                    @endif
                @endforeach
            @endif
        </ul>
    </div>
</aside>