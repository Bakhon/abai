<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#">
        <img src="{{ asset('img/level1/logo_kmg.svg') }}" width="46" height="46" class="d-inline-block" alt="">
        <span class="menu-collapsed brand-name">Панель управления</span>
    </a>
    <a href="#top" data-toggle="sidebar-colapse">
        <i class="fas fa-bars fa-lg"></i>
    </a>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <img src="{{ asset('img/level1/icon_geology.svg') }}" width="15" height="15" class="workTypeLogo">
                <a href=""><span class="workTypeText">Геология</span></a>
            </li>
            <li class="nav-item active">
                <img src="{{ asset('img/level1/icon_razrabotka.svg') }}" width="15" height="15" class="workTypeLogo">
                <a href=""><span class="workTypeText">Разработка</span></a>
            </li>
            <li class="nav-item active">
                <img src="{{ asset('img/level1/icon_dobycha.svg') }}" width="15" height="15" class="workTypeLogo">
                <a href=""><span class="workTypeText">Добыча</span></a>
            </li>
            <li class="nav-item active">
                <img src="{{ asset('img/level1/icon_obustroystvo.svg') }}" width="15" height="15" class="workTypeLogo">
                <a href=""><span class="workTypeText">Обустройство</span></a>
            </li>
        </ul>
        <form class="form-inline my-2 my-lg-0">
            <li class="nav-item">
                <i class="fas fa-bell fa-lg"></i>
            </li>
            <li class="nav-item">
                <img src="{{ asset('img/level1/icon_user.svg') }}" width="30" height="30" alt="">
            </li>
            <li class="nav-item">
                <i class="fas fa-ellipsis-v"></i>
            </li>
        </form>
    </div>
</nav>

<script>
    // Hide submenus
    // $('#body-row .collapse').collapse('hide'); 

    // Collapse click
    $('[data-toggle=sidebar-colapse]').click(function() {
        SidebarCollapse();
    });

    function SidebarCollapse () {
        $('.menu-collapsed').toggleClass('d-none');
        $('.sidebar-submenu').toggleClass('d-none');
        $('.submenu-icon').toggleClass('d-none');
        $('#sidebar-container').toggleClass('sidebar-expanded sidebar-collapsed');
        
        // Treating d-flex/d-none on separators with title
        var SeparatorTitle = $('.sidebar-separator-title');
        //var SeparatorTitle = document.getElementsByClassName('sidebar-separator-title');
        if ( SeparatorTitle.hasClass('d-flex') ) {
            SeparatorTitle.removeClass('d-flex');
        } else {
            SeparatorTitle.addClass('d-flex');
        }
    }
</script>
<style>
    .bg-dark {
        background-color: #20274e !important;
        height: 80px;
    }

    .fas {
        color: white;
    }
    #body-row {
        margin-left:0;
        margin-right:0;
    }
    #sidebar-container {
        min-height: 100vh;   
        background-color: #20274e;
        padding: 0;
    }

    /* Sidebar sizes when expanded and expanded */
    .sidebar-expanded {
        width: 328px;
    }
    .sidebar-collapsed {
        width: 60px;
    }

    /* Menu item*/
    #sidebar-container .list-group a {
        height: 50px;
        color: white;
    }

    /* Submenu item*/
    #sidebar-container .list-group .sidebar-submenu a {
        height: 45px;
        padding-left: 30px;
    }
    .sidebar-submenu {
        font-size: 0.9rem;
    }

    /* Separators */
    .sidebar-separator-title {
        background-color: #20274e;
        height: 35px;
    }
    .sidebar-separator {
        background-color: #20274e;
        height: 25px;
    }
    .logo-separator {
        background-color: #20274e;    
        height: 60px;
    }

    /* Closed submenu icon */
    #sidebar-container .list-group .list-group-item[aria-expanded="false"] .submenu-icon::after {
        content: " \f0dd";
        font-family: Font Awesome 5 Free;
        display: inline;
        text-align: right;
        padding-left: 10px;
    }
    /* Opened submenu icon */
    #sidebar-container .list-group .list-group-item[aria-expanded="true"] .submenu-icon::after {
        content: " \f0dd";
        font-family: Font Awesome 5 Free;
        display: inline;
        text-align: right;
        padding-left: 10px;
    }

    .searchInput {
        width: 328px;
        border: none;
        height: 40px;
        font-size: 16px;
        background-color: #353d6a;
        /* font-family: "Font Awesome 5 Free"; */
        /* font-weight: 600; */
        background-image: url({{ asset('img/level1/icon_search.svg') }});
        background-repeat: no-repeat;
        background-size: 25px 25px;
        background-position: 22px 10px;
        padding-left: 72px;
        color:white;
    }
    .companyLogo{
        margin-right: 15px;
    }
    .companyName {
        font-size: 16px;
    }
    .brand-name {
        margin-left: 15px;
        font-size: 16px;
    }
    .brand-name{
        margin-right: 82px;
    }
    .workTypeLogo{
        margin-left:80px;
    }
    .workTypeText{
        color:white;
        font-size: 16px;
        margin-left:13px;
    }
</style>