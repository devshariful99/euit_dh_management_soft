@foreach ($menuItems as $menuItem)
    @php
        $subMenuCheck = false;
        //This function will take the route name and return the access permission.
        if (isset($menuItem['routeName']) && $menuItem['routeName'] == 'submenu') {
            $subMenuCheck = true;
        }
        if (
            !isset($menuItem['routeName']) ||
            $menuItem['routeName'] == '' ||
            $menuItem['routeName'] == null ||
            $menuItem['routeName'] == 'submenu'
        ) {
            $check = false;
        } else {
            $check = true;
        }

        //Parameters
        $parameterArray = isset($menuItem['params']) ? $menuItem['params'] : [];
        $subParameterArray = isset($menuItem['subMenu']['subParams']) ? $menuItem['subMenu']['subParams'] : [];
    @endphp
    @if ($check)
        <li class="nav-item">
            <a href="{{ route($menuItem['routeName'], $parameterArray) }}"
                class="nav-link {{ $pageSlug == $menuItem['pageSlug'] ? 'active' : '' }}">
                <i class="nav-icon {{ $menuItem['iconClass'] ?? 'fa-solid fa-minus' }} {{ $pageSlug == $menuItem['pageSlug'] ? 'fa-beat' : '' }}"
                    @if (!isset($menuItem['iconClass'])) style="font-size: .9rem" @endif></i>
                <p>{{ __($menuItem['label']) }}</p>
            </a>
        </li>
    @elseif($subMenuCheck)
        @php
            // Assuming $menuItem['subMenu'] is an array
            $subMenuArray = $menuItem['subMenu'];
            // Use array_reduce to check if any subRouteName is set and has access
            $showSub = array_reduce(
                $subMenuArray,
                function ($carry, $subMenu) {
                    // Check if subRouteName is set and has access
                    return $carry || (isset($subMenu['subRouteName']) && $subMenu['subRouteName'] !== '');
                },
                false,
            );
        @endphp
        @if ($showSub)
            <li class="nav-item @if (isset($menuItem['pageSlug']) && collect($menuItem['pageSlug'])->contains($pageSlug)) menu-is-opening menu-open @endif">
                <a href="javascript:void(0)" class="nav-link @if (isset($menuItem['pageSlug']) && collect($menuItem['pageSlug'])->contains($pageSlug)) active @endif">
                    <i class="fa-solid fa-minus nav-icon" style="font-size: .9rem"></i>
                    <p>
                        {{ $menuItem['label'] }}
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>

                <ul class="nav nav-treeview" @if (isset($menuItem['subMenu']) && collect($menuItem['pageSlug'])->contains($pageSlug)) style="display: block" @endif>
                    @foreach ($menuItem['subMenu'] as $subMenu)
                        @php
                            if (
                                !isset($subMenu['subRouteName']) ||
                                $subMenu['subRouteName'] == '' ||
                                $subMenu['subRouteName'] == null
                            ) {
                                $check = false;
                            } else {
                                $check = true;
                            }
                        @endphp
                        @if ($check)
                            <li class="nav-item">
                                <a href="{{ route($subMenu['subRouteName'], $subParameterArray) }}"
                                    class="nav-link @if (isset($subMenu['subPageSlug']) && $pageSlug == $subMenu['subPageSlug']) active @endif">
                                    <i class="fa-solid fa-minus nav-icon" style="font-size: .7rem"></i>
                                    <p>{{ _($subMenu['subLabel']) }}</p>
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </li>
        @endif
    @endif
@endforeach
