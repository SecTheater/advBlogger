 <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if(Sentinel::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    @if (Sentinel::getUser()->profile_picture)
                                        @php
                                            $profile_picture = Sentinel::getUser()->profile_picture;
                                        @endphp
                                        <img src="{{ asset("profile_pictures/$profile_picture") }}" style="max-width: 30px;max-height: 50px;border-radius: 50%">
                                    @else
                                    <span><i class="fa fa-user-circle fa-lg" aria-hidden="true"></i></span>
                                    @endif
                                    {{ Sentinel::getUser()->first_name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                    @if (Sentinel::getUser()->hasAnyAccess(['*.create','*.approve']))
                                        <li><a href="{{ route('posts.create') }}">Create A Post</a></li>
                                        <li><a href="{{ route('posts.unapproved') }}">List Un-Approved Posts</a></li>
                                        {{-- expr --}}
                                    @endif
                                    <li><a href="/profile/{{ \Sentinel::getUser()->username}}">Update Your Profile</a></li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>