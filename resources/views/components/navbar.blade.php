
<header>
    <div class="logo-container">
        <img src="{{ asset('images/Logo.png') }}" alt="Logo de la empresa">
    </div>
    <nav class="navigation">
        @auth
        <div >
            <a href="{{ url('/') }}">
            <i class="fa-solid fa-house" style="color: #ffffff;"></i>
                    <p>Inicio</p>
                </a>
            </div>
            <!-- <div>
            <a href="{{ url('/miseccion') }}" class="miSeccion">
                <i class="fa-solid fa-warehouse" style="color: #ffffff;"></i>
                    <p>Mi garaje</p>
                </a>
            </div> -->
            @if (!auth()->user()->taller)
                <div>
                <a href="{{ url('/formularioTaller') }}" class="miSeccion">
                    <i class="fa-solid fa-building-circle-arrow-right" style="color: #ffffff;"></i>
                        <p>Unirse como taller</p>
                    </a>
                </div>
            @else
                <div>
                <a href="{{ url('/mitaller') }}" class="miSeccion">
                    <i class="fa-solid fa-screwdriver-wrench" style="color: #ffffff;"></i>
                        <p>Mi taller</p>
                    </a>
                </div>
            @endif
        @else
            <div>
            <a href="{{ route('login') }}" class="login">
                <i class="fa-solid fa-right-to-bracket" style="color: #ffffff;"></i>
               
                    <p>Entrar</p>
                </a>
            </div>
            @if (Route::has('register'))
                <div>
                <a href="{{ route('register') }}" class="register ml-4">
                    <i class="fa-solid fa-pen-to-square" style="color: #ffffff;"></i>
                Registrarse</a>
                </div>
            @endif
        @endauth
    </nav>
    <div class="user-image-container">
        @auth
            <a href="{{ route('profile.edit') }}">
                @if (auth()->user()->profile_image)
                    <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" alt="Profile Image">
                @else
                    <div class="divIconsUser">
                        <i class="fa-solid fa-user" style="color: #000000;"></i>
                    </div>
                @endif
            </a>
        @else
            <div class="divIconsUser">
                <i class="fa-solid fa-user" style="color: #000000;"></i>
            </div>
        @endguest
    </div>
</header>