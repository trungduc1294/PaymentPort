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
                href="{{url("/author-show-posts")}}"
                class="{{Request::is('author-show-posts') ? 'active' : ''}}"
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
