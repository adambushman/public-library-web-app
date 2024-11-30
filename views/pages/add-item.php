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


$query = <<<_END
    WITH
    VALS AS (
    SELECT ItemTypeID AS ID, Name, NULL AS description, 'ItemType' AS `Field` 
    FROM LIB_ITEM_TYPE
    UNION ALL 
	SELECT MediaTypeID AS ID, Name, NULL AS description, 'MediaType' AS `Field`
	FROM LIB_MEDIA_TYPE 
	UNION ALL 
	SELECT GenreID AS ID, Name, description, 'Genre' AS `Field` 
	FROM LIB_GENRE 
	UNION ALL 
	SELECT CreatorID AS ID, Name, NULL AS description, 'Creator' AS `Field` 
	FROM LIB_CREATOR lc 
	UNION ALL 
	SELECT PublisherID AS ID, Name, description, 'Publisher' AS `Field` 
	FROM LIB_PUBLISHER lp 
	UNION ALL 
	SELECT CreatorTypeID AS ID, Name, NULL AS description, 'CreatorType' AS `Field` 
	FROM LIB_CREATOR_TYPE lct 
	UNION ALL 
	SELECT PublisherTypeID AS ID, Name, NULL AS description, 'PublisherType' AS `Field` 
	FROM LIB_PUBLISHER_TYPE lpt
    )
    SELECT 
	`Field`,
	CONCAT('[', 
	GROUP_CONCAT(
	DISTINCT CONCAT(
	'{"id":', ID, 
	',"name":"', Name, '"', 
	(CASE WHEN description IS NOT NULL THEN ', "description": "' + description + '"' ELSE '' END)
	,'}'
	)
	SEPARATOR ','), 
	']') AS `Records`
    FROM VALS
    GROUP BY `Field`
    ORDER BY `Field`
_END;

$result = $conn->query($query);

$result->data_seek(0);
$creators = json_decode(stripslashes($result->fetch_array(MYSQLI_ASSOC)['Records'], true));
$result->data_seek(1);
$creatorTypes = json_decode(stripslashes($result->fetch_array(MYSQLI_ASSOC)['Records'], true));
$result->data_seek(2);
$genres = json_decode(stripslashes($result->fetch_array(MYSQLI_ASSOC)['Records'], true));
$result->data_seek(3);
$itemTypes = json_decode(stripslashes($result->fetch_array(MYSQLI_ASSOC)['Records'], true));
$result->data_seek(4);
$mediaTypes = json_decode(stripslashes($result->fetch_array(MYSQLI_ASSOC)['Records'], true));
$result->data_seek(5);
$publishers = json_decode(stripslashes($result->fetch_array(MYSQLI_ASSOC)['Records'], true));
$result->data_seek(6);
$publisherTypes = json_decode(stripslashes($result->fetch_array(MYSQLI_ASSOC)['Records'], true));

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
                            foreach($itemTypes as $type) {
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
                            foreach($mediaTypes as $type) {
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
                            foreach($genres as $genre) {
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
                                    foreach($creators as $creator) {
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
                                    foreach($publishers as $publisher) {
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
                <form id="creator-form" class="row g-3">
                    <div class="col-md-9">
                        <label for="#name-in" class="col-form-label fw-bold">*Creator Name</label>
                        <input id="name-in" class="form-control" type="text" name="name" aria-label="Name input" required>
                    </div>
                    <div class="col-md-3">
                        <label for="#gender-in" class="col-form-label fw-bold">*Gender</label>
                        <select id="gender-in" class="form-select" name="gender" aria-label="Gender input" required>
                            <option selected disabled></option>
                            <option value="M">Male</option>
                            <option value="F">Female</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label for="#bio-in" class="col-form-label fw-bold">*Biography</label>
                        <textarea class="form-control" name="bio" id="bio-in" rows="4" required></textarea>
                    </div>

                    <div class="col-md-6">
                        <label for="#date-born-in" class="col-form-label fw-bold">*Birth Date</label>
                        <input class="form-control" type="date" name="dateBorn" id="date-born-in" aria-label="Date born input" required>
                    </div>
                    <div class="col-md-6">
                        <label for="#date-died-in" class="col-form-label fw-bold">Death Date</label>
                        <input class="form-control" type="date" name="dateDied" id="date-died-in" aria-label="Date died input">
                    </div>

                    <div class="col-md-6">
                        <label for="#creator-type-in" class="col-form-label fw-bold">*Creator Type</label>
                        <div class="input-group">
                            <select id="creator-type-in" class="form-select" name="creatorType" aria-label="Creator type input" required>
                            <?php
                            echo <<<_END
                                <option selected disabled></option>
                            _END;
                            foreach($creatorTypes as $type) {
                                echo <<<_END
                                    <option value="$type[id]">$type[name]</option>
                                _END;
                            }
                            ?>
                            </select>
                            <button class="btn btn-primary" type="button" id="button-addon2"
                                data-bs-toggle="modal" 
                                data-bs-target="#newItemModal"
                                onclick="prepModal('creator type','LIB_CREATOR_TYPE','creator-type-in', 'true')"
                            ><i class="bi bi-plus-lg"></i></button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="#imgUpload" class="col-form-label fw-bold">*Creator Image</label>
                        <input class="form-control" type="file" name="imgUpload" id="imgUpload" aria-label="Creator image upload" required>
                    </div>
                    
                    <div class="col-6 mt-5">
                        <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                    </div>
                    <div class="col-6 mt-5">
                        <button type="submit" class="btn btn-success w-100">Add Creator</button>
                    </div>
                </form>
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
                    <form id="publisher-form" class="row g-3">
                        <div class="col-12">
                            <label for="#name-in" class="col-form-label fw-bold">*Publisher Name</label>
                            <input id="name-in" class="form-control" type="text" name="name" aria-label="Publisher name input" required>
                        </div>
                        <div class="col-12">
                            <label for="#publisher-type-in" class="col-form-label fw-bold">*Publisher Type</label>
                            <div class="input-group">
                                <select id="publisher-type-in" class="form-select" name="publisherType" aria-label="Publisher type input" required>
                                <?php
                                echo <<<_END
                                    <option selected disabled></option>
                                _END;
                                foreach($publisherTypes as $type) {
                                    echo <<<_END
                                        <option value="$type[id]">$type[name]</option>
                                    _END;
                                }
                                ?>
                                </select>
                                <button class="btn btn-primary" type="button" id="button-addon2"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#newItemModal"
                                    onclick="prepModal('publisher type','LIB_PUBLISHER_TYPE','publisher-type-in', 'true')"
                                ><i class="bi bi-plus-lg"></i></button>
                            </div>
                        </div>
                        
                        <div class="col-6 mt-5">
                            <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                        </div>
                        <div class="col-6 mt-5">
                            <button type="submit" class="btn btn-success w-100">Add Publisher</button>
                        </div>
                    </form>
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
                    <form id="new-item-form" class="row g-3">
                        <div class="col-12">
                            <label for="#name-in" class="col-form-label fw-bold">*Field Name</label>
                            <input id="name-in" class="form-control" type="text" name="name" aria-label="Item name input" required>
                        </div>

                        <input id="table-in" class="visually-hidden" type="text" name="table" value="">
                        <input id="inputField-in" class="visually-hidden" type="text" name="inputField" value="">
                        <input id="reopen-in" class="visually-hidden" type="text" name="reopen" value="">
                        
                        <div class="col-6 mt-5">
                            <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                        </div>
                        <div class="col-6 mt-5">
                            <button type="submit" class="btn btn-success w-100">Add Field</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="../../public/assets/javascript/catalog/add-item.js"></script>
<script src="../../public/assets/javascript/catalog/add-item-components.js"></script>

<!-- Footer -->
<?php include_once '../partials/footer.php'; ?>