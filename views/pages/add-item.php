<!-- Header -->
<?php include_once '../partials/head.php'; ?>

<!-- Navbar -->
<?php include_once '../partials/navbar.php'; ?>

<!-- Auth Code -->
<?php
require_once '../../config/dbauth.php';
require_once '../../helpers.php';

// Redirect to login if user is logged in
if(!isset($_SESSION['accountId'])) {
    header('Location: login.php');
	exit();
}

$conn = connect();

$roles = isset($_SESSION['accountId']) ? getAccountRoles($conn, $_SESSION['accountId']) : [];
preventMembers($roles); // Redirect if "Member"

$query = <<<_END
	WITH VALS AS (
    SELECT ItemTypeID AS ID, Name, 'ItemType' AS `Field` 
    FROM LIB_ITEM_TYPE 
    UNION ALL 
    SELECT *, 'MediaType' AS `Field` 
    FROM LIB_MEDIA_TYPE 
    UNION ALL 
    SELECT *, 'Genre' AS `Field` 
    FROM LIB_GENRE 
    UNION ALL 
    SELECT lct.CreatorTypeID, lct.Name, 'CreatorType' AS `Field` 
    FROM LIB_CREATOR_TYPE lct
    UNION ALL 
    SELECT lpt.PublisherTypeID, lpt.Name, 'PublisherType' AS `Field` 
    FROM LIB_PUBLISHER_TYPE lpt 
    UNION ALL 
    SELECT lp.PublisherID, lp.Name, 'Publisher' AS `Field` 
    FROM LIB_PUBLISHER lp
    UNION ALL 
    SELECT lc.CreatorID, lc.Name, 'Creator' AS `Field` 
    FROM LIB_CREATOR lc
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
    'creatorTypes' => [], 
    'genres' => [], 
    'itemTypes' => [], 
    'mediaTypes' => [], 
    'publishers' => [], 
    'publisherTypes' => []
);

$index = 0;
foreach($selectItems as &$item) {
    $result->data_seek($index);
    $item = json_decode(stripslashes($result->fetch_array(MYSQLI_ASSOC)['Records']), true);
    $index++;
}

$result->close();
$conn->close();
?>

<main>
    <div class="container mt-5">
        <div class="row justify-content-center mt-5">
            <div class="col-12 col-md-8">
                <h1 class="display-4 text-center">Add item to library</h1>
                <p class="text-center"><i>* required inputs</i></p>
                <form class="row justify-content-between g-3 mt-5" action="../../controllers/catalog/add-item-controller.php" method="post" enctype="multipart/form-data">
                    <div class="col-12 text-bg-secondary rounded px-2 py-1">
                        <h5 class="mb-0">Item Details</h5>
                    </div>
                    <div class="col-md-9">
                        <label for="#title-in" class="col-form-label fw-bold">*Title</label>
                        <input id="title-in" class="form-control" type="text" name="title" aria-label="Item title input" required>
                    </div>
                    <div class="col-md-3">
                        <label for="#year" class="col-form-label fw-bold">*Release Year</label>
                        <input id="year" class="form-control" type="number" name="year" aria-label="Release year input" min="1000" max="2025" required>
                    </div>

                    <div class="col-12">
                        <label for="#description-in" class="col-form-label fw-bold">*Description</label>
                        <textarea class="form-control" name="description" id="description-in" rows="4" required></textarea>
                    </div>

                    <div class="col-md-4">
                        <label for="#item-type-in" class="col-form-label fw-bold">*Item Type</label>
                        <div class="input-group">
                            <select id="item-type-in" class="form-select" name="itemType" aria-label="Item type input" required>
                            <?php
                            echo <<<_END
                                <option selected disabled></option>
                            _END;
                            foreach($selectItems['itemTypes'] as $type) {
                                echo <<<_END
                                    <option value="$type[id]">$type[name]</option>
                                _END;
                            }
                            ?>
                            </select>
                            <button class="btn btn-primary" type="button" id="button-addon2"
                                data-bs-toggle="modal" 
                                data-bs-target="#newItemModal"
                                onclick="prepModal('item type','LIB_ITEM_TYPE','item-type-in','false')"
                            ><i class="bi bi-plus-lg"></i></button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="#media-in" class="col-form-label fw-bold">*Media Type</label>
                        <div class="input-group">                            
                            <select id="media-in" class="form-select" name="mediaType" aria-label="Media type input" required>
                            <?php
                            echo <<<_END
                                <option selected disabled></option>
                            _END;
                            foreach($selectItems['mediaTypes'] as $type) {
                                echo <<<_END
                                    <option value="$type[id]">$type[name]</option>
                                _END;
                            }
                            ?>
                            </select>
                            <button class="btn btn-primary" type="button" id="button-addon2"
                                data-bs-toggle="modal" 
                                data-bs-target="#newItemModal"
                                onclick="prepModal('media type','LIB_MEDIA_TYPE','media-in','false')"
                            ><i class="bi bi-plus-lg"></i></button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="#genre-in" class="col-form-label fw-bold">*Genre</label>
                        <div class="input-group">
                            <select id="genre-in" class="form-select" name="genre" aria-label="Genre input" required>
                            <?php
                            echo <<<_END
                                <option selected disabled></option>
                            _END;
                            foreach($selectItems['genres'] as $genre) {
                                echo <<<_END
                                    <option value="$genre[id]">$genre[name]</option>
                                _END;
                            }
                            ?>
                            </select>
                            <button class="btn btn-primary" type="button" id="button-addon2"
                                data-bs-toggle="modal" 
                                data-bs-target="#newItemModal"
                                onclick="prepModal('genre','LIB_GENRE','genre-in', 'false')"
                            ><i class="bi bi-plus-lg"></i></button>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label for="#copies" class="col-form-label fw-bold">*Number of Copies</label>
                        <input id="copies" class="form-control" type="number" name="copies" aria-label="Copies number input" min="1" max="10" required>
                    </div>
                    <div class="col-md-3">
                        <label for="#issue" class="col-form-label fw-bold">Issue Number</label>
                        <input id="issue" class="form-control" type="number" name="issue" aria-label="Issue number input" min="1">
                    </div>
                    <div class="col-md-6">
                        <label for="#imgUpload" class="col-form-label fw-bold">*Item Image</label>
                        <input class="form-control" type="file" name="imgUpload" id="imgUpload" aria-label="Card image upload" required>
                    </div>

                    <div class="col-12 mt-5 text-bg-secondary rounded px-2 py-1">
                        <h5 class="mb-0">Source Details</h5>
                    </div>
                    <div class="col-md-5">
                        <div id="creator-input-fields" style="min-height: 10rem">
                            <label for="#creator-in" class="col-form-label fw-bold">*Creators</label>
                            <div class="input-group">
                                <select id="creator-in" class="form-select form-select-sm" name="creator1" aria-label="Creator input" required>
                                    <?php
                                    echo <<<_END
                                        <option selected disabled></option>
                                    _END;
                                    foreach($selectItems['creators'] as $creator) {
                                        echo <<<_END
                                            <option value="$creator[id]">$creator[name]</option>
                                        _END;
                                    }
                                    ?>
                                </select>
                                <button id="creator-add" type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#creatorModal"
                                ><i class="bi bi-plus-lg"></i></button>
                            </div>
                        </div>
                        <div class="d-grid mt-3">
                            <button onclick="includeAnother('creator')" id="creator-include" disabled type="button" class="btn btn-sm btn-light"><i class="bi bi-arrow-return-left pe-2"></i>Include another</button>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div id="publisher-input-fields" style="min-height: 10rem">
                            <label for="#publisher-in" class="col-form-label fw-bold">*Publishers</label>
                            <div class="input-group">
                                <select id="publisher-in" class="form-select form-select-sm" name="publisher1" aria-label="Publisher input" required>
                                    <?php
                                    echo <<<_END
                                        <option selected disabled></option>
                                    _END;
                                    foreach($selectItems['publishers'] as $publisher) {
                                        echo <<<_END
                                            <option value="$publisher[id]">$publisher[name]</option>
                                        _END;
                                    }
                                    ?>
                                </select>
                                <button id="publisher-add" type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#publisherModal"
                                ><i class="bi bi-plus-lg"></i></button>
                            </div>
                        </div>
                        <div class="d-grid mt-3">
                            <button onclick="includeAnother('publisher')" id="publisher-include" disabled type="button" class="btn btn-sm btn-light"><i class="bi bi-arrow-return-left pe-2"></i>Include another</button>
                        </div>
                    </div>

                    <div class="col-12 mt-5 text-bg-secondary rounded px-2 py-1">
                        <h5 class="mb-0">Library Details</h5>
                    </div>
                    <div class="col-md-4">
                        <label for="#isbn" class="col-form-label fw-bold">*ISBN-13 Code</label>
                        <input id="isbn" class="form-control" type="text" name="isbn" aria-label="ISBN 13 code input" required>
                    </div>
                    <div class="col-md-4">
                        <label for="#location" class="col-form-label fw-bold">*Location Code</label>
                        <input id="location" class="form-control" type="text" name="location" aria-label="Location input" required>
                    </div>

                    <div class="my-5 d-grid gap-2">
                        <button type="submit" class="btn btn-success">Add Item</button>
                        <a href="view-catalog.php" class="btn btn-light">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<section>
    <!-- Creator Modal -->
    <div class="modal fade" id="creatorModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="creatorModalLabel">Add Creator</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php
                require_once '../partials/creator-form.php';
                renderCreatorForm($selectItems['creatorTypes']);
                ?>
            </div>
        </div>
    </div>
</section>

<section>
    <!-- Publisher Modal -->
    <div class="modal fade" id="publisherModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="publisherModalLabel">Add Publisher</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php
                    require_once '../partials/publisher-form.php';
                    renderPublisherForm($selectItems['publisherTypes']);
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <!-- New Field Modal -->
    <div class="modal fade" id="newItemModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="label">Add new field to <span></span></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php
                    require_once '../partials/item-field-form.php';
                    renderFieldForm();
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="../../public/assets/javascript/catalog/add-item.js"></script>
<script src="../../public/assets/javascript/catalog/add-item-components.js"></script>

<!-- Footer -->
<?php include_once '../partials/footer.php'; ?>