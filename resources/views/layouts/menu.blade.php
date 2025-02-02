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
                <li class="menu-item {{ $title == 'Siswa' ? 'active' : '' }}">
                    <a href="{{ route('student.show', auth()->user()->username) }}" class="menu-link">
                        <i class="menu-icon tf-icons mdi mdi-account-outline"></i>
                        <div data-i18n="Siswa">Siswa</div>
                    </a>
                </li>
            @else
                @foreach($listMenus as $listMenu)
                    @if($listMenu) <!-- Pastikan menu tidak null -->
                    @php
                        $isActive = $listMenu['url'] == url()->current() || collect($listMenu['subMenus'])->contains(function ($subMenu) {
                            return $subMenu['url'] == url()->current();
                        });

                        $isActiveTitle = $listMenu['name'] == $title || collect($listMenu['subMenus'])->contains(function ($subMenu) use ($title) {
                            return $subMenu['name'] == $title;
                        });
                    @endphp
                    <li class="menu-item {{ $isActive || $isActiveTitle ? 'active' : '' }}">
                        <a href="{{ $listMenu['url'] }}" class="menu-link {{ $listMenu['type'] == 'main_menu' && count($listMenu['subMenus']) > 0 ? 'menu-toggle' : '' }}">
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