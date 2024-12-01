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

$valuesQuery = <<<_END
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
    UNION ALL 
    SELECT li.ItemID, li.Title AS `Name`, 'Item' AS `Field` 
    FROM LIB_ITEM li
    UNION ALL 
    SELECT lat.AccountTypeID, lat.Name AS `Name`, 'AccountType' AS `Field` 
    FROM LIB_ACCOUNT_TYPE lat
    UNION ALL 
    SELECT la.AccountID, CONCAT(la.FirstName, ' ', la.LastName) AS `Name`, 'StaffAccounts' AS `Field` 
    FROM LIB_ACCOUNT la
	WHERE la.AccountTypeID IN (1,2)
    UNION ALL 
    SELECT la.AccountID, CONCAT(la.FirstName, ' ', la.LastName) AS `Name`, 'MemberAccounts' AS `Field` 
    FROM LIB_ACCOUNT la
	WHERE la.AccountTypeID = 3
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

$result = $conn->query($valuesQuery);
$itemsCatalog = array(
    'accountTypes' => [], 
    'creators' => [], 
    'creatorTypes' => [], 
    'genres' => [], 
    'items' => [], 
    'itemTypes' => [], 
    'mediaTypes' => [], 
    'memberAccounts' => [], 
    'publishers' => [], 
    'publisherTypes' => [], 
    'staffAccounts' => []
);

$index = 0;
foreach($itemsCatalog as &$item) {
    $result->data_seek($index);
    $item = json_decode(stripslashes($result->fetch_array(MYSQLI_ASSOC)['Records']), true);
    $index++;
}

function renderTable($catalogItems, $detailsLink, $editLink, $deleteLink) {
    echo <<<_END
        <table class="table">
            <thead><tr>
                <th>ID</th>
                <th>Name</th>
                <th class="text-end">Actions</th>
            </tr></thead>
            <tbody>
    _END;
            foreach($catalogItems as $item) {
                $details = $detailsLink . $item['id'] ?? '';
                $edit = $editLink . $item['id'] ?? '';
                $delete = $deleteLink . $item['id'] ?? '';
                echo <<<_END
                    <tr>
                        <td>$item[id]</td>
                        <td>$item[name]</td>
                        <td class="text-end">
                _END;
                if(!is_null($detailsLink)) {
                    echo <<<_END
                        <a href="$details" class="btn text-secondary"
                        data-bs-toggle="tooltip"
                        data-bs-title="Details"
                        ><i class="bi bi-chat-left-text"></i></a>
                    _END;
                }
                if(!is_null($editLink)) {
                    echo <<<_END
                        <a href="$edit" class="btn text-secondary"
                        data-bs-toggle="tooltip"
                        data-bs-title="Edit"
                        ><i class="bi bi-pencil"></i></a>
                    _END;
                }
                if(!is_null($deleteLink)) {
                    echo <<<_END
                        <form class="d-inline" action="$delete" method="POST">
                        <button type="submit" class="btn text-secondary"
                        data-bs-toggle="tooltip"
                        data-bs-title="Delete"
                        ><i class="bi bi-trash3"></i></button>
                    _END;
                }
                echo <<<_END
                        </form>
                        </td>
                    </tr>
                _END;
            }
            echo <<<_END
            </tbody>
        </table>
    _END;
}
?>

<main class="my-5">
    <div class="container-fluid">
        <div class="row justify-content-between mx-5">
            <aside class="col-lg-3 pe-5">
                <div class="offcanvas-lg offcanvas-end" tabindex="-1" id="offcanvasResponsive" aria-labelledby="offcanvasResponsiveLabel">
                    <div class="offcanvas-header">
                        <h4 class="offcanvas-title" id="offcanvasResponsiveLabel">Application Settings</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#offcanvasResponsive" aria-label="Close"></button>
                    </div>
                    <div class="list-group px-3 px-lg-0" id="list-tab" role="tablist">
                        <!-- ACCOUNT MANAGEMENT -->
                        <h5 class="mt-2">Accounts</h5>
                        <a class="list-group-item list-group-item-action rounded-top active" id="list-members-list" data-bs-toggle="list" href="#list-members" role="tab" aria-controls="list-members">
                            <i class="bi bi-people pe-2"></i>Members
                        </a>
                        <a class="list-group-item list-group-item-action" id="list-staff-list" data-bs-toggle="list" href="#list-staff" role="tab" aria-controls="list-staff">
                            <i class="bi bi-person-gear pe-2"></i>Staff
                        </a>
                        <a class="list-group-item list-group-item-action rounded-bottom" id="list-account-types-list" data-bs-toggle="list" href="#list-account-types" role="tab" aria-controls="list-account-types">
                            <i class="bi bi-person-vcard pe-2"></i>Account Types
                        </a>

                        <!-- CATALOG MANAGEMENT -->
                        <h5 class="mt-4">Catalog</h5>
                        <a class="list-group-item list-group-item-action rounded-top" id="list-items-list" data-bs-toggle="list" href="#list-items" role="tab" aria-controls="list-items">
                            <i class="bi bi-clipboard pe-2"></i>Items
                        </a>
                        <a class="list-group-item list-group-item-action" id="list-item-attributes-list" data-bs-toggle="list" href="#list-item-attributes" role="tab" aria-controls="list-item-attributes">
                            <i class="bi bi-list-ul pe-2"></i>Item Attributes
                        </a>
                        <a class="list-group-item list-group-item-action" id="list-creators-list" data-bs-toggle="list" href="#list-creators" role="tab" aria-controls="list-creators">
                            <i class="bi bi-palette pe-2"></i>Creators
                        </a>
                        <a class="list-group-item list-group-item-action" id="list-publishers-list" data-bs-toggle="list" href="#list-publishers" role="tab" aria-controls="list-publishers">
                            <i class="bi bi-bookmarks pe-2"></i>Publishers
                        </a>
                    </div>
                </div>
            </aside>
            <section class="col-12 col-lg-9">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="list-members" role="tabpanel" aria-labelledby="list-members-list">
                        <div class="d-flex justify-content-between align-items-center">
                            <h2><i class="bi bi-people pe-2"></i>Members</h2>
                            <div>
                                <button class="btn btn-sm btn-secondary d-lg-none d-inline-flex align-items-center" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasResponsive" aria-controls="offcanvasResponsive">
                                    <i class="bi bi-list"></i>
                                </button>
                            </div>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <a href="add-account.php?accountTypeId=3" class="btn btn-sm btn-info"><i class="bi bi-plus-lg pe-2"></i>Add Member</a>
                        </div>
                        <?php 
                        renderTable(
                            $itemsCatalog['memberAccounts'], // Items to fill
                            null, // Details link/path
                            'edit-account.php?accountId=', // Edit link/path
                            '../../controllers/account/delete-account-controller.php?accountId=' // Delete link/path
                        ) 
                        ?>
                    </div>
                    <div class="tab-pane fade" id="list-staff" role="tabpanel" aria-labelledby="list-staff-list">
                        <div class="d-flex justify-content-between align-items-center">
                            <h2><i class="bi bi-person-gear pe-2"></i>Staff</h2>
                            <div>
                                <button class="btn btn-sm btn-secondary d-lg-none d-inline-flex align-items-center" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasResponsive" aria-controls="offcanvasResponsive">
                                    <i class="bi bi-list"></i>
                                </button>
                            </div>
                        </div>
                        <hr>    
                        <div class="mb-3">
                            <a href="add-account.php?accountTypeId=2" class="btn btn-sm btn-info"><i class="bi bi-plus-lg pe-2"></i>Add Staff</a>
                        </div>                    
                        <?php 
                        renderTable(
                            $itemsCatalog['staffAccounts'], // Items to fill
                            null, // Details link/path
                            'edit-account.php?accountId=', // Edit link/path
                            '../../controllers/account/delete-account-controller.php?accountId=' // Delete link/path
                        ) 
                        ?>
                    </div>
                    <div class="tab-pane fade" id="list-account-types" role="tabpanel" aria-labelledby="list-account-types-list">
                        <div class="d-flex justify-content-between align-items-center">
                            <h2><i class="bi bi-person-vcard pe-2"></i>Account Types</h2>
                            <div>
                                <button class="btn btn-sm btn-secondary d-lg-none d-inline-flex align-items-center" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasResponsive" aria-controls="offcanvasResponsive">
                                    <i class="bi bi-list"></i>
                                </button>
                            </div>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <a href="add-item-field.php?table=LIB_ACCOUNT_TYPE" class="btn btn-sm btn-info"><i class="bi bi-plus-lg pe-2"></i>Add Account Type</a>
                        </div>
                        <?php 
                        renderTable(
                            $itemsCatalog['accountTypes'], // Items to fill
                            null, // Details link/path
                            'edit-item-field.php?table=LIB_ACCOUNT_TYPE&id=', // Edit link/path
                            '../../controllers/catalog/delete-item-field-controller.php?table=LIB_ACCOUNT_TYPE&id=' // Delete link/path
                        ) 
                        ?>
                    </div>
                    <div class="tab-pane fade" id="list-items" role="tabpanel" aria-labelledby="list-items-list">
                        <div class="d-flex justify-content-between align-items-center">
                            <h2><i class="bi bi-clipboard pe-2"></i>Items</h2>
                            <div>
                                <button class="btn btn-sm btn-secondary d-lg-none d-inline-flex align-items-center" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasResponsive" aria-controls="offcanvasResponsive">
                                    <i class="bi bi-list"></i>
                                </button>
                            </div>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <a href="add-item.php" class="btn btn-sm btn-info"><i class="bi bi-plus-lg pe-2"></i>Add Item</a>
                        </div>
                        <?php 
                        renderTable(
                            $itemsCatalog['items'], // Items to fill
                            'view-item.php?itemId=', // Details link/path
                            'edit-item.php?itemId=', // Edit link/path
                            '../../controllers/catalog/delete-item-controller.php?itemId=' // Delete link/path
                        ) 
                        ?>
                    </div>
                    <div class="tab-pane fade" id="list-item-attributes" role="tabpanel" aria-labelledby="list-item-attributes-list">
                        <div class="d-flex justify-content-between align-items-center">
                            <h2><i class="bi bi-list-ul pe-2"></i>Item Attributes</h2>
                            <div>
                                <button class="btn btn-sm btn-secondary d-lg-none d-inline-flex align-items-center" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasResponsive" aria-controls="offcanvasResponsive">
                                    <i class="bi bi-list"></i>
                                </button>
                            </div>
                        </div>
                        <hr>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="item-type-tab" data-bs-toggle="tab" data-bs-target="#item-type-tab-pane" type="button" role="tab" aria-controls="item-type-tab-pane" aria-selected="true">Item Types</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="media-type-tab" data-bs-toggle="tab" data-bs-target="#media-type-tab-pane" type="button" role="tab" aria-controls="media-type-tab-pane" aria-selected="false">Media Types</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="genre-tab" data-bs-toggle="tab" data-bs-target="#genre-tab-pane" type="button" role="tab" aria-controls="genre-tab-pane" aria-selected="false">Genres</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active mb-4" id="item-type-tab-pane" role="tabpanel" aria-labelledby="item-type-tab" tabindex="0">                                
                                <div class="my-3">
                                    <a href="add-item-field.php?table=LIB_ITEM_TYPE" class="btn btn-sm btn-info"><i class="bi bi-plus-lg pe-2"></i>Add Item Type</a>
                                </div>
                                <?php 
                                renderTable(
                                    $itemsCatalog['itemTypes'], // Items to fill
                                    null, // Details link/path
                                    'edit-item-field.php?table=LIB_ITEM_TYPE&id=', // Edit link/path
                                    '../../controllers/catalog/delete-item-field-controller.php?table=LIB_ITEM_TYPE&id=' // Delete link/path
                                ) 
                                ?>
                            </div>
                            <div class="tab-pane fade mb-4" id="media-type-tab-pane" role="tabpanel" aria-labelledby="media-type-tab" tabindex="0">
                                <div class="my-3">
                                    <a href="add-item-field.php?table=LIB_MEDIA_TYPE" class="btn btn-sm btn-info"><i class="bi bi-plus-lg pe-2"></i>Add Media Type</a>
                                </div>
                                <?php 
                                renderTable(
                                    $itemsCatalog['mediaTypes'], // Items to fill
                                    null, // Details link/path
                                    'edit-item-field.php?table=LIB_MEDIA_TYPE&id=', // Edit link/path
                                    '../../controllers/catalog/delete-item-field-controller.php?table=LIB_MEDIA_TYPE&id=' // Delete link/path
                                ) 
                                ?>
                            </div>
                            <div class="tab-pane fade mb-4" id="genre-tab-pane" role="tabpanel" aria-labelledby="genre-tab" tabindex="0">
                                <div class="my-3">
                                    <a href="add-item-field.php?table=LIB_GENRE" class="btn btn-sm btn-info"><i class="bi bi-plus-lg pe-2"></i>Add Genre</a>
                                </div>
                                <?php 
                                renderTable(
                                    $itemsCatalog['genres'], // Items to fill
                                    null, // Details link/path
                                    'edit-item-field.php?table=LIB_GENRE&id=', // Edit link/path
                                    '../../controllers/catalog/delete-item-field-controller.php?table=LIB_GENRE&id=' // Delete link/path
                                ) 
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="list-creators" role="tabpanel" aria-labelledby="list-creators-list">
                        <div class="d-flex justify-content-between align-items-center">
                            <h2><i class="bi bi-palette pe-2"></i>Creators</h2>
                            <div>
                                <button class="btn btn-sm btn-secondary d-lg-none d-inline-flex align-items-center" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasResponsive" aria-controls="offcanvasResponsive">
                                    <i class="bi bi-list"></i>
                                </button>
                            </div>
                        </div>
                        <hr>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="creator-tab" data-bs-toggle="tab" data-bs-target="#creator-tab-pane" type="button" role="tab" aria-controls="creator-tab-pane" aria-selected="true">Creators</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="creator-type-tab" data-bs-toggle="tab" data-bs-target="#creator-type-tab-pane" type="button" role="tab" aria-controls="creator-type-tab-pane" aria-selected="false">Creator Types</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active mb-4" id="creator-tab-pane" role="tabpanel" aria-labelledby="creator-tab" tabindex="0">
                                <div class="my-3">
                                    <a href="add-creator.php" class="btn btn-sm btn-info"><i class="bi bi-plus-lg pe-2"></i>Add Creator</a>
                                </div>
                                <?php 
                                renderTable(
                                    $itemsCatalog['creators'], // Items to fill
                                    'view-creator.php?creatorId=', // Details link/path
                                    'edit-creator.php?creatorId=', // Edit link/path
                                    '../../controllers/catalog/delete-creator-controller.php?creatorId=' // Delete link/path
                                ) 
                                ?>
                            </div>
                            <div class="tab-pane fade mb-4" id="creator-type-tab-pane" role="tabpanel" aria-labelledby="creator-type-tab" tabindex="0">
                                <div class="my-3">
                                    <a href="add-item-field.php?table=LIB_CREATOR_TYPE" class="btn btn-sm btn-info"><i class="bi bi-plus-lg pe-2"></i>Add Creator Type</a>
                                </div>
                                <?php 
                                renderTable(
                                    $itemsCatalog['creatorTypes'], // Items to fill
                                    null, // Details link/path
                                    'edit-item-field.php?table=LIB_CREATOR_TYPE&id=', // Edit link/path
                                    '../../controllers/catalog/delete-item-field-controller.php?table=LIB_CREATOR_TYPE&id=' // Delete link/path
                                ) 
                                ?>
                            </div>
                        </div>
                    </div>
                        <div class="tab-pane fade" id="list-publishers" role="tabpanel" aria-labelledby="list-publishers-list">
                        <div class="d-flex justify-content-between align-items-center">
                            <h2><i class="bi bi-bookmarks pe-2"></i>Publishers</h2>
                            <div>
                                <button class="btn btn-sm btn-secondary d-lg-none d-inline-flex align-items-center" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasResponsive" aria-controls="offcanvasResponsive">
                                    <i class="bi bi-list"></i>
                                </button>
                            </div>
                        </div>
                        <hr>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="publisher-tab" data-bs-toggle="tab" data-bs-target="#publisher-tab-pane" type="button" role="tab" aria-controls="publisher-tab-pane" aria-selected="true">Publishers</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="publisher-type-tab" data-bs-toggle="tab" data-bs-target="#publisher-type-tab-pane" type="button" role="tab" aria-controls="publisher-type-tab-pane" aria-selected="false">Publisher Types</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active mb-4" id="publisher-tab-pane" role="tabpanel" aria-labelledby="publisher-tab" tabindex="0">
                                <div class="my-3">
                                    <a href="add-publisher.php" class="btn btn-sm btn-info"><i class="bi bi-plus-lg pe-2"></i>Add Publisher</a>
                                </div>
                                <?php 
                                renderTable(
                                    $itemsCatalog['publishers'], // Items to fill
                                    null, // Details link/path
                                    'edit-publisher.php?publisherId=', // Edit link/path
                                    '../../controllers/catalog/delete-publisher-controller.php?publisherId=' // Delete link/path
                                ) 
                                ?>
                            </div>
                            <div class="tab-pane fade mb-4" id="publisher-type-tab-pane" role="tabpanel" aria-labelledby="publisher-type-tab" tabindex="0">
                                <div class="my-3">
                                    <a href="add-item-field.php?table=LIB_PUBLISHER_TYPE" class="btn btn-sm btn-info"><i class="bi bi-plus-lg pe-2"></i>Add Publisher Type</a>
                                </div>
                                <?php 
                                renderTable(
                                    $itemsCatalog['publisherTypes'], // Items to fill
                                    null, // Details link/path
                                    'edit-item-field.php?table=LIB_PUBLISHER_TYPE&id=', // Edit link/path
                                    '../../controllers/catalog/delete-item-field-controller.php?table=LIB_PUBLISHER_TYPE&id=' // Delete link/path
                                ) 
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</main>


<!-- Footer -->
<?php include_once '../partials/footer.php'; ?>