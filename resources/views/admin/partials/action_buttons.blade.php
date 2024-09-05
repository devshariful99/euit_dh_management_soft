<div class="btn-group btn-group-sm">
    @foreach ($menuItems as $menuItem)
        @php
            $parameterArray = isset($menuItem['params']) ? $menuItem['params'] : [];
            //This function will take the route name and return the access permission.
            if (!isset($menuItem['routeName']) || $menuItem['routeName'] == '' || $menuItem['routeName'] == null) {
                $check = false;
            } elseif ($menuItem['routeName'] == 'javascript:void(0)') {
                $check = true;
                $route = 'javascript:void(0)';
            } else {
                $check = true;
                $route = route($menuItem['routeName'], $parameterArray);
            }
    
            //Parameters
    
        @endphp
        @if ($check)
            <a target="@if (isset($menuItem['target'])) {{ $menuItem['target'] }} @endif" title="@if (isset($menuItem['title'])) {{ $menuItem['title'] }} @endif" href="{{ $route }}" @if (isset($menuItem['delete']) && $menuItem['delete'] == true) onclick="return confirm('Are you sure?')" @endif class="@if (isset($menuItem['className'])) {{ $menuItem['className'] }} @endif "  @if (isset($menuItem['data-id'])) data-id="{{ $menuItem['data-id'] }}" @endif ><i
                class="{{($menuItem['iconClass']) }}"></i></a>
        @endif
    @endforeach
</div>