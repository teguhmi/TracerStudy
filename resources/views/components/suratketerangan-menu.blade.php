
@foreach ($menuData as $item)
    {{-- KONDISI 1: HEADER / KATEGORI MENU --}}
    @if (!empty($item['menuHeader']))

        <li class="menu-header small mt-5">
            <span class="menu-header-text" data-i18n="{{ $item['menuHeader'] }}">
                {{ $item['menuHeader'] }}
            </span>
        </li>

        {{-- KONDISI 2: MENU DENGAN SUBMENU --}}
    @elseif (!empty($item['submenu']))

        @php
            $isParentActive = collect($item['submenu'])->contains(function($sub) {
                return request()->is(ltrim($sub['url'], '/')) || request()->url() == url($sub['url']);
            });
        @endphp

        <li class="menu-item {{ $isParentActive ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                @if (!empty($item['icon']))
                    <i class="menu-icon icon-base {{ $item['icon'] }}"></i>
                @endif
                <div data-i18n="{{ $item['name'] }}">{{ $item['name'] }}</div>

                @if (!empty($item['badge']))
                    <div class="badge badge-center text-bg-{{ $item['badge_color'] ?? 'danger' }} rounded-pill ms-auto">
                        {{ $item['badge'] }}
                    </div>
                @endif
            </a>

            <ul class="menu-sub">
                @foreach ($item['submenu'] as $sub)
                    @php
                        $isSubActive = request()->is(ltrim($sub['url'], '/')) || request()->url() == url($sub['url']);
                    @endphp

                    <li class="menu-item {{ $isSubActive ? 'active' : '' }}">
                        <a href="{{ url($sub['url']) }}"
                           target="{{ $sub['target'] ?? '_self' }}"
                           class="menu-link">
                            @if (!empty($sub['icon']))
                                <i class="menu-icon icon-base {{ $sub['icon'] }}"></i>
                            @endif
                            <div data-i18n="{{ $sub['name'] }}">{{ $sub['name'] }}</div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </li>

        {{-- KONDISI 3: MENU TUNGGAL --}}
    @else

        @php
            $isActive = request()->is(ltrim($item['url'], '/')) || request()->url() == url($item['url']);
        @endphp

        <li class="menu-item {{ $isActive ? 'active' : '' }}">
            <a href="{{ url($item['url']) }}"
               target="{{ $item['target'] ?? '_self' }}"
               class="menu-link">
                @if (!empty($item['icon']))
                    <i class="menu-icon icon-base {{ $item['icon'] }}"></i>
                @endif
                <div data-i18n="{{ $item['name'] }}">{{ $item['name'] }}</div>

                @if (!empty($item['badge']))
                    <div class="badge badge-center text-bg-{{ $item['badge_color'] ?? 'danger' }} rounded-pill ms-auto">
                        {{ $item['badge'] }}
                    </div>
                @endif
            </a>
        </li>

    @endif
@endforeach
