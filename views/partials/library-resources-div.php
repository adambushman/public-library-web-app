<?php

echo <<<_END
<div class="row row-cols-1 row-cols-md-3 g-4">
    <div class="col">
        <div class="card text-center border-primary">
            <div class="card-body text-primary">
                <h1><i class="bi bi-collection-fill"></i></h1>
                <h3 class="mb-3">Comprehensive Catalog</h3>
                <p class="text-black mb-0">Explore our comprehensive catalog of books, music, movies, and more—something for every interest and age. Discover your next favorite!</p>
                <a href="view-catalog.php" class="stretched-link"></a>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card text-center border-success">
            <div class="card-body text-success">
                <h1><i class="bi bi-easel3-fill"></i></h1>
                <h3 class="mb-3">Engaging Classes</h3>
                <p class="text-black mb-0">Join our engaging classes in art, writing, and more! Learn new skills, express creativity, and connect with others</p>
                <a href="view-classes.php" class="stretched-link"></a>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card text-center border-warning">
            <div class="card-body text-warning">
                <h1><i class="bi bi-calendar-event-fill"></i></h1>
                <h3 class="mb-3">Exciting Events</h3>
                <p class="text-black mb-0">Don't miss our exciting events, including book fairs, author signings, and more! Join us for fun and inspiration at the library!</p>
                <a href="view-events.php" class="stretched-link"></a>
            </div>
        </div>
    </div>
</div>
_END;