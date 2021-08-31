<nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light">

    <a class="navbar-brand" href="#">
        @if (!Auth::guest())
            <span class="text-info">LB</span>
        @else
            <span class="text-info">LB Representaciones</span>
        @endif        
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNavDropdown">

    </div>
    
</nav>
