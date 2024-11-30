<!-- Header -->
<?php include_once '../partials/head.php'; ?>

<!-- Navbar -->
<?php include_once '../partials/navbar.php'; ?>

<!-- Authorization Code -->
<?php
require_once '../../config/dbauth.php';
require_once '../../helpers.php';

$conn = connect();

$roles = isset($_SESSION['accountId']) ? getAccountRoles($conn, $_SESSION['accountId']) : [];
preventMembers($roles); // Redirect if "Member"


$itemId = prepSanitaryData($conn, $_GET['itemId']);

$query = <<<_END
    WITH
    VALS AS (
    SELECT ItemTypeID AS ID, Name, 'ItemType' AS `Field` 
    FROM LIB_ITEM_TYPE 
    UNION ALL 
    SELECT *, 'MediaType' AS `Field` 
    FROM LIB_MEDIA_TYPE 
    UNION ALL 
    SELECT *, 'Genre' AS `Field` 
    FROM LIB_GENRE 
    UNION ALL 
    SELECT lc.CreatorID, lc.Name, 'Creator' AS `Field` 
    FROM LIB_CREATOR lc 
    UNION ALL 
    SELECT lp.PublisherID, lp.Name, 'Publisher' AS `Field` 
    FROM LIB_PUBLISHER lp 
    )
    SELECT 
    `Field`
    ,CONCAT('[', 
    GROUP_CONCAT(
    DISTINCT CONCAT(
        '{"id":', ID, 
        ',"name":"', Name, '"}'
    )
    SEPARATOR ','
    ), 
    ']') AS `Records`
    FROM VALS
    GROUP BY `Field`
    ORDER BY `Field`
_END;
$result = $conn->query($query);

$selectItems = array(
    'creators' => [], 
    'genres' => [], 
    'itemTypes' => [], 
    'mediaTypes' => [], 
    'publishers' => []
);

$index = 0;
foreach($selectItems as &$item) {
    $result->data_seek($index);
    $item = json_decode(stripslashes($result->fetch_array(MYSQLI_ASSOC)['Records']), true);
    $index++;
}

$queryFramework = <<<_END
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
    li.LibLocation, li.ImagePath AS `ItemImg`, it.ItemTypeID, mt.MediaTypeID, g.GenreID, 
    CONCAT('[', GROUP_CONCAT(DISTINCT lc.CreatorID SEPARATOR ','), ']') AS `Creators`, 
    CONCAT('[', GROUP_CONCAT(DISTINCT lp.PublisherID SEPARATOR ','), ']') AS `Publishers`
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
    WHERE li.ItemID = ?
    GROUP BY
    li.ItemID, li.Isbn, li.Title, li.Description, li.Year, li.IssueNumber, li.LibCopies, 
    li.LibCopies - COALESCE(Unavailable,0), li.LibLocation, li.ImagePath, it.Name, mt.Name, g.Name
_END;
$queryStmt = $conn->prepare($queryFramework);
$queryStmt->bind_param("i", $itemId);
$queryStmt->execute();

$result = $queryStmt->get_result();
$result->data_seek(0);
$row = $result->fetch_array(MYSQLI_ASSOC);

$result->close();
$conn->close();
?>

<main>
    <div class="container mt-5">
        <div class="row justify-content-center mt-5">
            <div class="col-12 col-md-8">
                <div class="row justify-content-center">
                    <div class="col-6 col-md-4 col-lg-3 col-xxl-2">
                        <img class="img-fluid" src="../../<?php echo $row['ItemImg'] ?>" alt="">
                    </div>
                    <div class="col-md-6 col-lg-4 d-flex align-items-center mt-3 mt-md-0">
                        <h1 class="display-4">Edit library item</h1>
                    </div>
                    <p class="mt-4 text-center"><i>* required inputs</i></p>
                </div>
                <form class="row justify-content-between g-3 mt-0" action="../../controllers/catalog/edit-item-controller.php?itemId=<?php echo $itemId ?>" method="post" enctype="multipart/form-data">
                    <div class="col-12 text-bg-secondary rounded px-2 py-1">
                        <h5 class="mb-0">Item Details</h5>
                    </div>
                    <div class="col-md-9">
                        <label for="#title-in" class="col-form-label fw-bold">*Title</label>
                        <input id="title-in" class="form-control" type="text" name="title" aria-label="Item title input" value="<?php echo $row['Title'] ?>" required>
                    </div>
                    <div class="col-md-3">
                        <label for="#year" class="col-form-label fw-bold">*Release Year</label>
                        <input id="year" class="form-control" type="number" name="year" aria-label="Release year input" min="1000" max="2025" value="<?php echo $row['Year'] ?>" required>
                    </div>

                    <div class="col-12">
                        <label for="#description-in" class="col-form-label fw-bold">*Description</label>
                        <textarea class="form-control" name="description" id="description-in" rows="4" required><?php echo $row['Description'] ?></textarea>
                    </div>

                    <div class="col-md-4">
                        <label for="#item-type-in" class="col-form-label fw-bold">*Item Type</label>
                        <select id="item-type-in" class="form-select" name="itemType" aria-label="Item type input" required>
                        <?php
                        foreach($selectItems['itemTypes'] as $type) {
                            $selected = $type['id'] == $row['ItemTypeID'] ? 'selected' : '';
                            echo <<<_END
                                <option value="$type[id]" $selected>$type[name]</option>
                            _END;
                        }
                        ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="#media-in" class="col-form-label fw-bold">*Media Type</label>
                        <select id="media-in" class="form-select" name="mediaType" aria-label="Media type input" required>
                        <?php
                        foreach($selectItems['mediaTypes'] as $type) {
                            $selected = $type['id'] == $row['ItemTypeID'] ? 'selected' : '';
                            echo <<<_END
                                <option value="$type[id]" $selected>$type[name]</option>
                            _END;
                        }
                        ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="#genre-in" class="col-form-label fw-bold">*Genre</label>
                        <select id="genre-in" class="form-select" name="genre" aria-label="Genre input" required>
                        <?php
                        foreach($selectItems['genres'] as $genre) {
                            $selected = $genre['id'] == $row['GenreID'] ? 'selected' : '';
                            echo <<<_END
                                <option value="$genre[id]" $selected>$genre[name]</option>
                            _END;
                        }
                        ?>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="#copies" class="col-form-label fw-bold">*Number of Copies</label>
                        <input id="copies" class="form-control" type="number" name="copies" aria-label="Copies number input" min="1" max="10" value="<?php echo $row['LibCopies'] ?>" required>
                    </div>
                    <div class="col-md-3">
                        <label for="#issue" class="col-form-label fw-bold">Issue Number</label>
                        <input id="issue" class="form-control" type="number" name="issue" aria-label="Issue number input" min="1" value="<?php echo $row['IssueNumber'] ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="#imgUpload" class="col-form-label fw-bold">*Item Image</label>
                        <input class="form-control" type="file" name="imgUpload" id="imgUpload" aria-label="Card image upload">
                        <p class="text-danger"><i>Only select for upload of new image</i></p>
                    </div>

                    <div class="col-12 mt-5 text-bg-secondary rounded px-2 py-1">
                        <h5 class="mb-0">Source Details</h5>
                    </div>
                    <div class="col-md-5">
                        <div id="creator-input-fields" style="min-height: 10rem">
                            <label for="#creator-in" class="col-form-label fw-bold">*Creators</label>
                            <?php
                            $creator_array = json_decode(stripslashes($row['Creators']), true);
                            for($i = 0; $i < count($creator_array); $i++) {
                                $index = $i + 1;
                                echo <<<_END
                                <div class="d-flex mt-2 gap-2">
                                <select id="creator-in" class="form-select form-select-sm" name="creator$index" aria-label="Creator input" required>
                                _END;

                                foreach($selectItems['creators'] as $creator) {
                                    $selected = $creator['id'] == $creator_array[$i] ? 'selected' : '';
                                    echo <<<_END
                                        <option value="$creator[id]" $selected>$creator[name]</option>
                                    _END;
                                }

                                echo "</select>";

                                if($i != 0) {
                                    echo <<<_END
                                    <button onclick="removeParent(this)" type="button" class="btn btn-sm btn-danger"><i class="bi bi-x"></i></button>
                                    _END;
                                }

                                echo "</div>";
                            }
                            ?>
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            <button onclick="includeAnother('creator')" id="creator-include" disabled type="button" class="btn btn-sm btn-light"><i class="bi bi-arrow-return-left pe-2"></i>Include another</button>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div id="publisher-input-fields" style="min-height: 10rem">
                            <label for="#publisher-in" class="col-form-label fw-bold">*Publishers</label>
                            <?php
                            $publisher_array = json_decode(stripslashes($row['Publishers']), true);
                            for($i = 0; $i < count($publisher_array); $i++) {
                                $index = $i + 1;
                                echo <<<_END
                                <div class="d-flex mt-2 gap-2">
                                <select id="publisher-in" class="form-select form-select-sm" name="publisher$index" aria-label="Publisher input" required>
                                _END;

                                foreach($selectItems['publishers'] as $publisher) {
                                    $selected = $publisher['id'] == $publisher_array[$i] ? 'selected' : '';
                                    echo <<<_END
                                        <option value="$publisher[id]" $selected>$publisher[name]</option>
                                    _END;
                                }

                                echo "</select>";

                                if($i != 0) {
                                    echo <<<_END
                                    <button onclick="removeParent(this)" type="button" class="btn btn-sm btn-danger"><i class="bi bi-x"></i></button>
                                    _END;
                                }

                                echo "</div>";
                            }
                            ?>
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            <button onclick="includeAnother('publisher')" id="publisher-include" disabled type="button" class="btn btn-sm btn-light"><i class="bi bi-arrow-return-left pe-2"></i>Include another</button>
                        </div>
                    </div>

                    <div class="col-12 mt-5 text-bg-secondary rounded px-2 py-1">
                        <h5 class="mb-0">Library Details</h5>
                    </div>
                    <div class="col-md-4">
                        <label for="#isbn" class="col-form-label fw-bold">*ISBN-13 Code</label>
                        <input id="isbn" class="form-control" type="text" name="isbn" aria-label="ISBN 13 code input" value="<?php echo $row['Isbn'] ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label for="#location" class="col-form-label fw-bold">*Location Code</label>
                        <input id="location" class="form-control" type="text" name="location" aria-label="Location input"value="<?php echo $row['LibLocation'] ?>" required>
                    </div>

                    <div class="my-5 d-grid gap-2">
                        <button type="submit" class="btn btn-success">Save Item</button>
                        <a href="view-item.php?itemId=<?php echo $itemId ?>" class="btn btn-light">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<script src="../../public/assets/javascript/catalog/add-item.js"></script>
<script>
    toggleInclude('creator', true);
    toggleInclude('publisher', true);
</script>

<!-- Footer -->
<?php include_once '../partials/footer.php'; ?>