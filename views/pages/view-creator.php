<!-- Header -->
<?php include_once '../partials/head.php'; ?>

<!-- Navbar -->
<?php include_once '../partials/navbar.php'; ?>

<main>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <?php
                require_once '../../config/dbauth.php';

                $creatorId = $_GET['creatorId'];

                $conn = connect();
                $query = <<<_END
                SELECT 
                lc.CreatorID, lc.Name, lc.Gender, lc.DateBorn, lc.DateDied, lc.Bio, lc.ImagePath, lct.Name AS `CreatorType`, 
                CONCAT('[', 
                GROUP_CONCAT(
                    DISTINCT CONCAT(
                        '{"id":', li.ItemID, 
                        ',"title":"', li.Title, 
                        '","description":"', li.Description, 
                        '","image":"', li.ImagePath, '"}'
                    )
                    SEPARATOR ','
                ), 
                ']') AS `Works`
                FROM LIB_ITEM_CREATOR lic
                INNER JOIN LIB_CREATOR lc ON lc.CreatorID = lic.CreatorID
                INNER JOIN LIB_CREATOR_TYPE lct ON lct.CreatorTypeID = lc.CreatorTypeID
                LEFT JOIN LIB_ITEM li ON li.ItemID = lic.ItemID
                WHERE lc.CreatorID = $creatorId
                _END;

                $result = $conn->query($query);
                $rows = $result->num_rows;

                $result->data_seek(0); 
                $row = $result->fetch_array(MYSQLI_ASSOC);

                $creatorImg = ($row['ImagePath'] ?? 'ImageDirectory/default-image.jpg');
                $works = json_decode($row['Works'], true);
                $lifeDates = array(
                    $row['DateBorn'] != NULL ? sprintf("%s", date("F j, Y", strtotime($row['DateBorn']))) : '', 
                    $row['DateDied'] != NULL ? sprintf("%s", date("F j, Y", strtotime($row['DateDied']))) : ''
                );

                echo <<<_END
                    <div class="col-8 col-md-4 col-xl-2">
                        <img class="img-fluid" src='../../$creatorImg' alt="">
                    </div>
                    <div class="col-12 col-md-6 col-xl-4 mt-3 mt-md-0 d-flex flex-column justify-content-evenly">
                        <div>
                            <h1 class="display-5 mb-2">$row[Name]</h1>
                            <h4 class="mb-1">$row[CreatorType]</h4>
                            <p class="mb-0">$lifeDates[0] - $lifeDates[1]</p>
                        </div>
                    </div>
                _END;
            ?>
        </div>
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <h3>Biography</h3>
                <p class="lead"><?php echo $row['Bio'] ?></p>
            </div>
        </div>
        <div class="row justify-content-center my-5">
            <div class="col-md-8">
                <h3>Works at the library</h3>
                <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-2">

                    <?php
                    foreach($works as $work) {

                        $img = ($work['image'] ?? 'ImageDirectory/default-image.jpg');

                        echo <<<_END
                        <div class="col">
                            <div class="card border-0">
                                <img src="../../$img" class="card-img-top catalog-item-img mb-3" alt="...">
                                <div class="card-body border rounded" style="height:16rem">
                                    <h5 class="card-title mb-2">$work[title]</h5>
                                    <p class="card-text small text-truncate-multiline">$work[description]</p>
                                </div>
                                <a class="stretched-link" href="view-item.php?itemId=$work[id]"></a>
                            </div>
                        </div>
                        _END;
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Footer -->
<?php include_once '../partials/footer.php'; ?>