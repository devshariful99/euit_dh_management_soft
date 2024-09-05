@auth
    <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
            <img src="https://assets.infyom.com/logo/blue_logo_150x150.png" class="user-image img-circle elevation-2"
                alt="User Image">
            {{-- <span class="d-none d-md-inline">{{ Auth::user()->name }}</span> --}}
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <!-- User image -->
            <li class="user-header bg-primary">
                <img src="https://assets.infyom.com/logo/blue_logo_150x150.png" class="img-circle elevation-2"
                    alt="User Image">
                <p>
                    {{ Auth::user()->name }}
                    <small>Member since {{ Auth::user()->created_at->format('M. Y') }}</small>
                </p>
            </li>
            <!-- Menu Footer-->
            <li class="user-footer">
                {{-- <a href="#" class="btn btn-default btn-flat">Profile</a> --}}
                <a href="javascript:void(0)" class="btn btn-default btn-flat w-100"
                    onclick="document.getElementById('logout-form').submit();">
                    {{ __('Sign out') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </li>
@endauth
