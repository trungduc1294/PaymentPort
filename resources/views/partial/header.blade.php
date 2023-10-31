<header>
    <div class="container">
        <div class="logo">
            <a href="{{url("/")}}">
                ICHST-2023
            </a>
        </div>
        <nav>
            <a
                href="{{url("/")}}"
                class="{{Request::is('/') ? 'active' : ''}}"
            >
                Guildline
            </a>
            <a
                href="{{url("/audience-registration-page")}}"
                class="{{Request::is('audience-registration-page') ? 'active' : ''}}"
            >
                For Audience
            </a>
            <a
                href="{{url("/author")}}"
                class="{{Request::is('author') ? 'active' : ''}}"
            >
                For Authors
            </a>
            <a
                href="{{url("/registration-manage")}}"
                class="{{Request::is('registration-manage') ? 'active' : ''}}"
            >
                Manage Registration
            </a>
        </nav>
    </div>
</header>
