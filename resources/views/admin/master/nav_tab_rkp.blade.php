<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" >
        <a href="{{ route('admin.master.urusan') }}" class="nav-link text-primary hover:text-white {{ Route::currentRouteNamed('admin.master.urusan') ? 'active fw-bold ' : '' }}" id="home-tab"  onmouseover="this.classList.add('text-white', 'bg-primary')" 
        onmouseout="this.classList.remove('text-white', 'bg-primary')">Urusan</a>
    </li>
    <li class="nav-item" >
        <a href="{{ route('admin.master.dana-pembagian') }}" class="nav-link text-primary hover:text-white {{ Route::currentRouteNamed('admin.master.dana-pembagian') ? 'active fw-bold ' : '' }}" id="home-tab"  onmouseover="this.classList.add('text-white', 'bg-primary')" 
        onmouseout="this.classList.remove('text-white', 'bg-primary')">Program</a>
    </li>
</ul>