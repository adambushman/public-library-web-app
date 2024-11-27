<!-- Header -->
<?php include_once '../partials/head.php'; ?>

<!-- Navbar -->
<?php include_once '../partials/navbar.php'; ?>

<main class="my-5">
    <div class="container-fluid">
        <div class="row justify-content-between mx-5">
            <aside class="col-lg-3 pe-5">
                <div class="offcanvas-lg offcanvas-start" tabindex="-1" id="offcanvasResponsive" aria-labelledby="offcanvasResponsiveLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasResponsiveLabel">Filter Catalog</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#offcanvasResponsive" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <div class="input-group flex-nowrap">
                            <span class="input-group-text" id="addon-wrapping"><i class="bi bi-search"></i></span>
                            <input disabled type="text" name="search" class="form-control" aria-label="Search" aria-describedby="addon-wrapping">
                        </div>
                    </div>
                </div>
            </aside>
            <section class="col-12 col-lg-9">
                <div class="d-flex justify-content-between align-items-center">
                    <h2>Library Catalog</h2>
                    <div>
                        <a class="btn btn-sm btn-info" href="add-item.php">
                            <i class="bi bi-plus-square pe-2"></i>Add Item
                        </a>
                        <a class="btn btn-sm btn-info" href="update-item.php">
                            <i class="bi bi-check-square pe-2"></i>Update Item
                        </a>	

                        </a>							
						
                        <button class="btn btn-sm btn-secondary d-lg-none d-inline-flex align-items-center" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasResponsive" aria-controls="offcanvasResponsive">
                            <i class="bi bi-funnel pe-2"></i>Filter Catalog
                        </button>
                    </div>
                </div>
                <hr>
                <div class="row row-cols-1 row-cols-md-3 row-cols-xl-5 g-2">
                    <?php
                    require_once '../../config/dbauth.php';

                    $conn = connect();
                    $query = <<<_END
                        SELECT 
                        li.ItemID, li.Title, li.Description, GROUP_CONCAT(lc.Name SEPARATOR ', ') AS Names, li.Year, li.ImagePath
                        FROM LIB_ITEM_CREATOR lic
                        INNER JOIN LIB_ITEM li ON li.ItemID = lic.ItemID
                        INNER JOIN LIB_CREATOR lc ON lc.CreatorID = lic.CreatorID
                        GROUP BY
                        li.ItemID, li.Title, li.Description, li.Year, li.ImagePath
                    _END;
                    $result = $conn->query($query);
                    $rows = $result->num_rows;

                    for($i = 0; $i < $rows; ++$i) {
                        $result->data_seek($i); 
                        $row = $result->fetch_array(MYSQLI_ASSOC);

                        $img = ($row['ImagePath'] ?? 'ImageDirectory/default-image.jpg');

                        echo <<<_END
                        <div class="col">
                            <div class="card border-0">
                                <img src="../../$img" class="card-img-top catalog-item-img mb-3" alt="...">
                                <div class="card-body border rounded" style="height:16rem">
                                    <h5 class="card-title mb-0">$row[Title]</h5>
                                    <p class="small mb-3">$row[Names]</p>
                                    <p class="card-text small text-truncate-multiline">$row[Description]</p>
                                </div>
                                <a class="stretched-link" href="view-item.php?itemId=$row[ItemID]"></a>
                            </div>
                        </div>
                        _END;
                    }
                    ?>
                </div>
            </section>
        </div>
    </div>
</main>

<!-- Footer -->
<?php include_once '../partials/footer.php'; ?>