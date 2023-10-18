<header>
    <div class="container">
        <div class="logo">
            <a href="{{url("/")}}">
                RIVF'23
            </a>
        </div>
        <nav>
            <a
                href="{{url("/audience-registration")}}"
                class="{{Request::is('audience-registration') ? 'active' : ''}}"
            >
                For Audience
            </a>
            <a
                href="{{url("/author-registration")}}"
                class="{{Request::is('author-registration') ? 'active' : ''}}"
            >
                For Authors
            </a>
            <a
                href="#"
            >
                Manage Registration
            </a>
        </nav>
    </div>
</header>
