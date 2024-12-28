<aside id="layout-menu" class="layout-menu-horizontal menu-horizontal menu bg-menu-theme flex-grow-0">
    <div class="container-xxl d-flex h-100">
        <ul class="menu-inner">
            @foreach($listMenus as $listMenu)
                <li class="menu-item">
                    <a href="{{ $listMenu['url'] }}" class="menu-link {{ $listMenu['type'] == 'main_menu' && count($listMenu['subMenus']) > 0 ? 'menu-toggle' : '' }}">
                        <i class="menu-icon tf-icons mdi mdi-{{ $listMenu['icon'] }}"></i>
                        <div data-i18n="{{ $listMenu['name'] }}">{{ $listMenu['name'] }}</div>
                    </a>
                    @if(count($listMenu['subMenus']) > 0)
                        <ul class="menu-sub">
                            @foreach($listMenu['subMenus'] as $subMenu)
                                <li class="menu-item">
                                    <a href="{{ $subMenu['url'] }}" class="menu-link">
                                        <i class="menu-icon tf-icons mdi mdi-{{ $subMenu['icon'] }}"></i>
                                        <div data-i18n="{{ $subMenu['name'] }}">{{ $subMenu['name'] }}</div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</aside>