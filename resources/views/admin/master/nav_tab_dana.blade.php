<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" >
        <a href="{{ route('admin.master.dana-master') }}" class="nav-link text-primary hover:text-white {{ Route::currentRouteNamed('admin.master.dana-master') ? 'active fw-bold ' : '' }}" id="home-tab"  onmouseover="this.classList.add('text-white', 'bg-primary')" 
        onmouseout="this.classList.remove('text-white', 'bg-primary')">Dana utama</a>
    </li>
    <li class="nav-item" >
        <a href="{{ route('admin.master.dana-pembagian') }}" class="nav-link text-primary hover:text-white {{ Route::currentRouteNamed('admin.master.dana-pembagian') ? 'active fw-bold ' : '' }}" id="home-tab"  onmouseover="this.classList.add('text-white', 'bg-primary')" 
        onmouseout="this.classList.remove('text-white', 'bg-primary')">Pembagian Dana</a>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link text-primary" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Rincian Pembagian</button>
    </li>
</ul>