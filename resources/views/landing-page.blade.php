

@extends('layouts.landing')
@section('content')

  <div class="bg-custom-gradient text-white py-5 px-4 px-md-5">
    <div class="container-xl">
      <div class="row align-items-center text-center text-md-start g-4">
        <div class="col-md-7">
          <h1 class="display-4 fw-bold mb-3">PLAY THE FUTURE</h1>
          <p class="lead mb-4">Rental PlayStation cepat dan mudah. Langsung main tanpa ribet.</p>
          <div class="d-flex justify-content-center justify-content-md-start gap-2">
            <button class="btn btn-light text-custom-primary fw-bold rounded-pill px-4 py-2">Book Now</button>
            <button class="btn btn-outline-light rounded-pill px-4 py-2">Explore</button>
          </div>
        </div>
        <div class="col-md-5 text-center">
          <img src="https://upload.wikimedia.org/wikipedia/commons/0/00/PlayStation_5_and_DualSense_with_transparent_background.png" alt="PS5" class="img-fluid hero-img">
        </div>
      </div>
    </div>
  </div>

  <div class="container-xl my-5 px-4">
    <div class="row g-4">
      
      <div class="col-lg-8">
        <h2 class="h3 fw-bold mb-4">Available PS Consoles</h2>
        <div class="row g-3">
          
          <div class="col-md-6">
            <div class="card h-100 border-0 shadow-sm p-3 rounded-4">
              <img src="https://upload.wikimedia.org/wikipedia/commons/0/00/PlayStation_5_and_DualSense_with_transparent_background.png" class="card-img-top p-3 mx-auto" alt="PS5" style="height: 180px; object-fit: contain;">
              <div class="card-body text-center d-flex flex-column justify-content-between">
                <div>
                  <h3 class="h5 card-title fw-bold">PlayStation 5</h3>
                  <p class="card-text text-muted small">Performa tinggi dan grafis terbaik.</p>
                </div>
                <button class="btn btn-primary rounded-pill w-100 mt-3">Reserve</button>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="card h-100 border-0 shadow-sm p-3 rounded-4">
              <img src="https://upload.wikimedia.org/wikipedia/commons/4/4e/PS4-Console-wDS4.png" class="card-img-top p-3 mx-auto" alt="PS4 Pro" style="height: 180px; object-fit: contain;">
              <div class="card-body text-center d-flex flex-column justify-content-between">
                <div>
                  <h3 class="h5 card-title fw-bold">PlayStation 4 Pro</h3>
                  <p class="card-text text-muted small">Gaming stabil dan nyaman.</p>
                </div>
                <button class="btn btn-primary rounded-pill w-100 mt-3">Reserve</button>
              </div>
            </div>
          </div>

        </div>
      </div>

      <div class="col-lg-4">
        
        <div class="card border-0 shadow-sm p-3 rounded-4 mb-3">
          <h3 class="h5 fw-bold mb-3">Featured Games</h3>
          <div class="d-flex flex-column gap-3">
            <div class="d-flex align-items-center gap-3">
              <img src="https://upload.wikimedia.org/wikipedia/en/a/a7/God_of_War_Ragnar%C3%B6k_cover.jpg" class="rounded sidebar-img" alt="God of War">
              <span class="fw-semibold">God of War</span>
            </div>
            <div class="d-flex align-items-center gap-3">
              <img src="https://upload.wikimedia.org/wikipedia/en/b/b9/Elden_Ring_Box_art.jpg" class="rounded sidebar-img" alt="Elden Ring">
              <span class="fw-semibold">Elden Ring</span>
            </div>
            <div class="d-flex align-items-center gap-3">
              <img src="https://upload.wikimedia.org/wikipedia/en/0/0c/Spider-Man_2_PS5_cover.jpg" class="rounded sidebar-img" alt="Spider-Man 2">
              <span class="fw-semibold">Spider-Man 2</span>
            </div>
          </div>
        </div>

        <div class="card border-0 shadow-sm p-3 rounded-4">
          <h3 class="h5 fw-bold mb-2">Rental Info</h3>
          <p class="text-muted m-0">Harga mulai <span class="text-dark fw-bold">Rp5.000/jam</span></p>
          <button class="btn btn-primary rounded-pill mt-3 align-self-start px-4">Reserve</button>
        </div>

      </div>

    </div>
  </div>
@endsection
