<!-- Header -->
<?php include_once '../partials/head.php'; ?>

<!-- Navbar -->
<?php include_once '../partials/navbar.php'; ?>

<main>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <?php
                require_once '../../config/dbauth.php';
                require_once '../../helpers.php';

                $itemId = $_GET['itemId'];

                $conn = connect();
                $query = <<<_END
                WITH
                UNAVAIL AS (
                SELECT
                lci.ItemID
                ,COUNT(lc.CheckoutID) AS Unavailable
                FROM LIB_CHECKOUT lc
                INNER JOIN LIB_CHECKOUT_ITEM lci ON lci.CheckoutID = lc.CheckoutID
                WHERE lc.ReturnDate IS NULL
                )
                SELECT
                li.ItemID, li.Isbn, li.Title, li.Description, li.Year, li.IssueNumber, li.LibCopies, li.LibCopies - COALESCE(Unavailable,0) AS AvailableCopies, 
                li.LibLocation, li.ImagePath AS `ItemImg`, it.Name AS `ItemType`, mt.Name AS `MediaType`, g.Name AS `Genre`, 
                CONCAT('[', 
                    GROUP_CONCAT(
                        DISTINCT CONCAT(
                            '{"id":', lc.CreatorID, 
                            ',"name":"', REPLACE(lc.Name, '"', '\"'), 
                            '","bio":"', REPLACE(lc.Bio, '"', '\"'), 
                            '","image":"', REPLACE(lc.ImagePath, '"', '\"'), 
                            '","type":"', REPLACE(ct.Name, '"', '\"'), '"}'
                        )
                    SEPARATOR ','
                    ), 
                ']') AS `Creators`, 
                CONCAT('[', 
                    GROUP_CONCAT(
                        DISTINCT CONCAT(
                            '{"id":', lp.PublisherID, 
                            ',"name":"', REPLACE(lp.Name, '"', '\"'), 
                            '","type":"', REPLACE(pt.Name, '"', '\"'), '"}'
                        )
                    SEPARATOR ','
                    ), 
                ']') AS `Publishers`
                FROM LIB_ITEM li
                INNER JOIN LIB_ITEM_CREATOR lic ON li.ItemID = lic.ItemID
                INNER JOIN LIB_CREATOR lc ON lc.CreatorID = lic.CreatorID
                INNER JOIN LIB_CREATOR_TYPE ct ON ct.CreatorTypeID = lc.CreatorTypeID
                INNER JOIN LIB_ITEM_PUBLISHER lip ON li.ItemID = lip.ItemID
                INNER JOIN LIB_PUBLISHER lp ON lp.PublisherID = lip.PublisherID
                INNER JOIN LIB_PUBLISHER_TYPE pt ON pt.PublisherTypeID = lp.PublisherTypeID
                INNER JOIN LIB_ITEM_TYPE it ON it.ItemTypeID = li.ItemTypeID
                INNER JOIN LIB_MEDIA_TYPE mt ON mt.MediaTypeID = li.MediaTypeID
                INNER JOIN LIB_GENRE g ON g.GenreID = li.GenreID
                LEFT JOIN UNAVAIL u ON u.ItemID = li.ItemID
                WHERE li.ItemID = $itemId
                GROUP BY
                li.ItemID, li.Isbn, li.Title, li.Description, li.Year, li.IssueNumber, li.LibCopies, 
                li.LibCopies - COALESCE(Unavailable,0), li.LibLocation, li.ImagePath, it.Name, mt.Name, g.Name
                _END;

                $result = $conn->query($query);
                $rows = $result->num_rows;

                $result->data_seek(0); 
                $row = $result->fetch_array(MYSQLI_ASSOC);

                $itemImg = ($row['ItemImg'] ?? 'ImageDirectory/default-image.jpg');
                $creators = json_decode($row['Creators'], true);
                $publishers = json_decode($row['Publishers'], true);
                $creator_names = implode(', ', array_map(fn($x) => "$x[name]",  $creators));
                $publisher_names = implode(array_map(fn($x) => "$x[name]",  $publishers));
                $creator_type = $creators[0]['type'];

                $item_meta = array(
                    array("caption" => "Item Type", "value" => $row['ItemType'], "icon" => "bi-inbox"), 
                    array("caption" => "Media Type", "value" => $row['MediaType'], "icon" => "bi-aspect-ratio"), 
                    array("caption" => "Available Copies", "value" => $row['LibCopies'], "icon" => "bi-bookmark-check"), 
                    array("caption" => "ISBN", "value" => formatISBN($row['Isbn']), "icon" => "bi-upc-scan"), 
                    array("caption" => "Location", "value" => $row['LibLocation'], "icon" => "bi-map"), 
                    //array("caption" => "Library Copies", "value" => $row['LibCopies'], "icon" => "bi-bookmarks"), 
                    array("caption" => "Author(s)", "value" => $creator_names, "icon" => "bi-pen"), 
                    array("caption" => "Release Year", "value" => $row['Year'], "icon" => "bi-calendar-event"), 
                    array("caption" => "Genre", "value" => $row['Genre'], "icon" => "bi-arrow-through-heart"), 
                    array("caption" => "Publisher(s)", "value" => $publisher_names, "icon" => "bi-clipboard2-check")
                );

                function constructCard($instance) {
                    echo <<<_END
                    <div class="card">
                        <div class="card-body text-bg-light text-center">
                            <h4 class="mb-1"><i class="bi $instance[icon]"></i></h4>
                            <p class="small mb-1">$instance[caption]</p>
                            <p class="fw-bold mb-0">$instance[value]</p>
                        </div>
                    </div>
                    _END;
                }

                echo <<<_END
                    <div class="col-8 col-md-4 col-xl-3">
                        <img class="img-fluid" src='../../$itemImg' alt="">
                    </div>
                    <div class="col-12 col-md-6 col-xl-5 mt-3 mt-md-0 d-flex flex-column justify-content-center">
                        <div>
                            <h1 class="display-5 mb-3">$row[Title]</h1>
                            <div style="height:13rem">
                                <p class="lead text-truncate-multiline">$row[Description]</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mb-3">
                                <a class="btn btn-sm btn-primary d-inline-flex justify-content-center align-items-center w-100" href="#">
                                    <i class="bi bi-door-open pe-2"></i> 
                                    Checkout
                                </a>
                            </div>
                            <div class="col-6">
                                <a class="btn btn-sm btn-warning d-inline-flex justify-content-center align-items-center w-100" href="edit-item.php?itemId=$itemId">
                                    <i class="bi bi-pencil pe-2"></i>    
                                    Update
                                </a>
                            </div>
                            <div class="col-6">
                                <a class="btn btn-sm btn-danger d-inline-flex justify-content-center align-items-center w-100" href="../../controllers/catalog/delete-item-controller.php?itemId=$itemId">
                                    <i class="bi bi-trash pe-2"></i>
                                    Remove
                                </a>
                            </div>
                        </div>
                    </div>
                _END;
            ?>
        </div>
        <div class="row justify-content-center mt-4">
            <div class="col-12 col-md-10 p-3">
                <?php
                echo '<div class="card-group">';
                foreach(array_slice($item_meta, 0, 5) as $meta) {
                    constructCard($meta);
                }
                echo '</div>';
                ?>
            </div>
        </div>
        <div class="row justify-content-center mt-1">
            <div class="col-12 col-md-10 p-3">
                <?php
                    echo '<div class="card-group">';
                    foreach(array_slice($item_meta, 5, 4) as $meta) {
                        constructCard($meta);
                    }
                    echo '</div>';
                ?>
            </div>
        </div>
        <div class="row justify-content-center mt-3 mb-5">
            <?php
            echo <<<_END
            <div class="col-md-10">
                <h4 class="mb-4">About the $creator_type(s)</h4>
                <div class="row row-cols-2 row-cols-md-4 g-4">
            _END;

            foreach($creators as $creator) {
                echo <<<_END
                <div class="col">
                    <div class="card">
                        <img src="../../$creator[image]" class="card-img-top" alt="...">
                        <div class="card-body" style="height:15rem">
                            <h5 class="card-title">$creator[name] | $creator[type]</h5>
                            <p class="card-text text-truncate-multiline">$creator[bio]</p>
                            <a class="stretched-link" href="view-creator.php?creatorId=$creator[id]"></a>
                        </div>
                    </div>
                </div>
                _END;
            }
            echo '</div>';
            ?>
        </div>
    </div>
</main>

<!-- Footer -->
<?php include_once '../partials/footer.php'; ?>