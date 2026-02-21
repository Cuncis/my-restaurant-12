<div class="container-fluid fixed-top shadow-sm" style="background:#fff;">
    <div class="container px-0">
        <nav class="navbar navbar-light bg-white navbar-expand-xl py-3">
            <a href="{{ route('menu') }}" class="navbar-brand d-flex align-items-center gap-2">
                <i class="fa fa-utensils text-primary fs-4"></i>
                <span class="fw-bold text-primary fs-5">Restoranku</span>
            </a>
            <button class="navbar-toggler py-2 px-3 border-0" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarCollapse">
                <span class="fa fa-bars text-primary"></span>
            </button>
            <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                <div class="navbar-nav mx-auto gap-1">
                    <a href="{{ route('menu') }}"
                        class="nav-item nav-link px-3 fw-medium {{ request()->routeIs('menu') ? 'text-primary' : '' }}">Menu</a>
                    <a href="{{ route('cart') }}"
                        class="nav-item nav-link px-3 fw-medium {{ request()->routeIs('cart') ? 'text-primary' : '' }}">Keranjang</a>
                </div>
                <div class="d-flex align-items-center gap-3 ms-3">
                    @php $cartCount = collect(Session::get('cart', []))->sum('qty'); @endphp

                    {{-- Cart icon --}}
                    <a href="{{ route('cart') }}" class="position-relative text-dark" style="line-height:1;">
                        <i class="fa fa-shopping-bag" style="font-size:1.4rem;"></i>
                        <span id="cart-count"
                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                            style="font-size:0.6rem; {{ $cartCount < 1 ? 'display:none;' : '' }}">
                            {{ $cartCount ?: 0 }}
                        </span>
                    </a>

                    @auth
                        <div class="dropdown">
                            <button class="btn d-flex align-items-center gap-2 px-2 py-1 border rounded-pill"
                                style="background:#f8f9fa;" type="button" data-bs-toggle="dropdown">
                                {{-- Avatar initial --}}
                                <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white fw-bold"
                                    style="width:28px;height:28px;font-size:0.75rem;flex-shrink:0;">
                                    {{ strtoupper(substr(auth()->user()->full_name ?? auth()->user()->name ?? '?', 0, 1)) }}
                                </div>
                                <span class="fw-medium" style="font-size:0.9rem;max-width:120px;" class="text-truncate">
                                    {{ auth()->user()->full_name ?? auth()->user()->name }}
                                </span>
                                <i class="fa fa-chevron-down" style="font-size:0.7rem;opacity:0.5;"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-1" style="min-width:180px;">
                                <li class="px-3 py-2">
                                    <small class="text-muted d-block" style="font-size:0.75rem;">Masuk sebagai</small>
                                    <span class="fw-semibold"
                                        style="font-size:0.85rem;">{{ auth()->user()->role->name ?? 'User' }}</span>
                                </li>
                                <li>
                                    <hr class="dropdown-divider my-1">
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="dropdown-item text-danger d-flex align-items-center gap-2">
                                            <i class="fa fa-sign-out" style="width:16px;"></i> Keluar
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary btn-sm px-3 rounded-pill">
                            Masuk
                        </a>
                    @endauth
                </div>
            </div>
        </nav>
    </div>
</div>


<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Menu Kami</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item active text-primary">Silakan pilih menu favorit anda</li>
    </ol>
</div>
<!-- Single Page Header End -->