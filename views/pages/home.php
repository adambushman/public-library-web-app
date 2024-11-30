<!-- Header -->
<?php include_once '../partials/head.php'; ?>

<!-- Navbar -->
<?php include_once '../partials/navbar.php'; ?>


<main>
  <div id="homeHero" class="container-fluid">
    <div class="row h-100 align-items-center justify-content-center">
      <div class="col-12 col-md-8 text-center">
        <h1 class="text-img-overlay display-1 text-white fw-bold mb-5">Welcome to the Library</h1>
        <form action="view-catalog.php" method="GET">
            <div class="input-group mb-3">
              <input name="searchTerm" type="text" class="form-control" placeholder="i.e. To Kill A Mockingbird" aria-label="Search" aria-describedby="basic-addon2">
              <button class="btn btn-primary btn-outline-light" id="search">
                <i class="bi bi-search"></i>
              </span>
            </div>
        </form>
      </div>
    </div>
  </div>
</main>

<section class="my-5">
  <div class="container">
    <?php include_once '../partials/library-resources-div.php'; ?>
  </div>
</section>

<section>
  <div class="container mb-5">
    <div class="row justify-content-center">
      <div class="col-12 col-md-8 d-flex flex-column justify-content-center">
        <h1 class="display-5 text-center mb-4">What's happening at the library</h1>
      </div>
      <div class="col-12 col-md-8">
        <div id="carouselAuto" class="carousel slide" data-bs-ride="carousel">
          <div id="carouselWrapper" class="carousel-inner text-center">
            <div class="carousel-item active position-relative">
              <img src="../../ImageDirectory/story-hour.jpg" class="d-block w-100" alt="...">
              <h2 class="text-img-overlay text-white carousel-text">Join us for story hour Wednesday and Thursdays from 10am - 11am!</h2>
            </div>
            <div class="carousel-item position-relative">
              <img src="../../ImageDirectory/book-fair.jpg" class="d-block w-100" alt="...">
              <h2 class="text-img-overlay text-white carousel-text">Upcoming book fair with 10% off and BOGO!</h2>
            </div>
            <div class="carousel-item position-relative">
              <img src="../../ImageDirectory/art-classes.jpg" class="d-block w-100" alt="...">
              <h2 class="text-img-overlay text-white carousel-text">Paint with Ms. Rachel; art class for Mom and Kids!</h2>
            </div>
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#carouselAuto" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carouselAuto" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>
        <div class="d-grid mt-2">
          <a href="view-schedule.php" class="btn btn-secondary rounded-0">Explore full schedule of events and classes!</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Footer -->
<?php include_once '../partials/footer.php'; ?>