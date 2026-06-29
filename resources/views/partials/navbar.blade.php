<nav class="navbar navbar-expand-lg navbar-dark custom-navbar fixed-top">

    <div class="container">

        <a class="navbar-brand fw-bold" href="/properties">
            Sweet Home
        </a>

        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNav"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <div
            class="collapse navbar-collapse"
            id="navbarNav"
        >

            <ul class="navbar-nav ms-auto align-items-lg-center">

                <li class="nav-item">
                    <a class="nav-link" href="/properties">
                        Home
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/simulation">
                        Simulasi KPR
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/affordability">
                        Hitung Harga
                    </a>
                </li>

            </ul>

        </div>

    </div>

</nav>

<style>

.custom-navbar {

    background: linear-gradient(
        90deg,
        #0056ff,
        #1e88ff
    );

    padding: 18px 0;

    box-shadow: 0 4px 15px rgba(0,0,0,0.15);
}

.navbar-brand {

    font-size: 34px;

    color: white !important;

    letter-spacing: 1px;
}

.nav-link {

    color: white !important;

    margin-left: 25px;

    font-weight: 600;

    transition: 0.3s;

    position: relative;
}

.nav-link:hover {

    color: #dbeafe !important;
}

.nav-link::after {

    content: '';

    position: absolute;

    left: 0;

    bottom: -5px;

    width: 0;

    height: 2px;

    background: white;

    transition: 0.3s;
}

.nav-link:hover::after {

    width: 100%;
}

</style>