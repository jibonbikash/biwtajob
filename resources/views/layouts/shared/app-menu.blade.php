<ul class="metismenu" id="menu-bar">
    <li class="menu-title">Navigation</li>

    <li>
        <a href="{{route('dashboard')}}">
            <i data-feather="home"></i>
            <span> Dashboard </span>
        </a>
    </li>
    <li class="menu-title">Jobs</li>
    <li>
        <a href="{{route('jobs.index')}}">
            <i data-feather="list"></i>
            <span> All Jobs </span>
        </a>
    </li>
    <li>
        <a href="{{route('jobs.create')}}">
            <i data-feather="plus-square"></i>
            <span> Add New Job </span>
        </a>
    </li>
    <li>
        <a href="{{route('applicants')}}">
            <i data-feather="users"></i>
            <span> Applicant List</span>
        </a>
    </li>

    <li>
        <a href="{{route('rollSetting')}}">
            <i data-feather="sliders"></i>
            <span>Roll Setting </span>
        </a>
    </li>
    <li>
        <a href="{{route('seatPlan')}}">
            <i data-feather="columns"></i>
            <span>Exam Seat Plan </span>
        </a>
    </li>
    <li class="menu-title">Custom</li>
    <li>
        <a href="javascript: void(0);">
            <i data-feather="file-text"></i>
            <span> Pages </span>
            <span class="menu-arrow"></span>
        </a>
        <ul class="nav-second-level" aria-expanded="false">
            <li>
                <a href="/pages/starter">Starter</a>
            </li>
            <li>
                <a href="/pages/profile">Profile</a>
            </li>
            <li>
                <a href="/pages/activity">Activity</a>
            </li>
            <li>
                <a href="/pages/invoice">Invoice</a>
            </li>
            <li>
                <a href="/pages/pricing">Pricing</a>
            </li>
            <li>
                <a href="/pages/maintenance">Maintenance</a>
            </li>
            <li>
                <a href="/errors/404">Error 404</a>
            </li>
            <li>
                <a href="/errors/500">Error 500</a>
            </li>
        </ul>
    </li>

    <li>
        <a href="javascript: void(0);">
            <i data-feather="layout"></i>
            <span> Layouts </span>
            <span class="menu-arrow"></span>
        </a>
        <ul class="nav-second-level" aria-expanded="false">
            <li>
                <a href="/layout-example/horizontal">Horizontal Nav</a>
            </li>
            <li>
                <a href="/layout-example/rtl">RTL</a>
            </li>
            <li>
                <a href="/layout-example//dark">Dark</a>
            </li>
            <li>
                <a href="/layout-example/scrollable">Scrollable</a>
            </li>
            <li>
                <a href="/layout-example/boxed">Boxed</a>
            </li>
            <li>
                <a href="/layout-example/loader">With Pre-loader</a>
            </li>
            <li>
                <a href="/layout-example/dark-sidebar">Dark Side Nav</a>
            </li>
            <li>
                <a href="/layout-example/condensed-sidebar">Condensed Nav</a>
            </li>
        </ul>
    </li>

    <li class="menu-title">Components</li>

    <li>
        <a href="javascript: void(0);">
            <i data-feather="package"></i>
            <span> UI Elements </span>
            <span class="menu-arrow"></span>
        </a>
        <ul class="nav-second-level" aria-expanded="false">
            <li>
                <a href="/ui/bootstrap">Bootstrap UI</a>
            </li>
            <li>
                <a href="javascript: void(0);" aria-expanded="false">Icons
                    <span class="menu-arrow"></span>
                </a>
                <ul class="nav-third-level" aria-expanded="false">
                    <li>
                        <a href="/ui/icons-feather">Feather Icons</a>
                    </li>
                    <li>
                        <a href="/ui/icons-unicons">Unicons Icons</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="/ui/widgets">Widgets</a>
            </li>
        </ul>
    </li>

</ul>
