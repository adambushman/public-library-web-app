<!-- Header -->
<?php include_once '../partials/head.php'; ?>

<!-- Navbar -->
<?php include_once '../partials/navbar.php'; ?>


<?php

require_once '../../config/dbauth.php';
require_once '../../helpers.php';

if(!isset($_SESSION['accountId'])) {
    header('Location: login.php');
}

$conn = connect();
$accountId = $_SESSION['accountId'];

$queryFramework = <<<_END
SELECT 
    la.*,
    lat.Name AS `AccountType`,
    JSON_OBJECT(
        'CheckoutHistory', JSON_ARRAYAGG(
            JSON_OBJECT(
                'CheckoutID', lc.CheckoutID,
                'CheckoutDate', lc.CheckoutDate,
                'DueDate', lc.DueDate,
                'ReturnDate', lc.ReturnDate,
                'Items', (
                    SELECT 
                        JSON_ARRAYAGG(
                            JSON_OBJECT(
                                'id', li.ItemID,
                                'title', li.Title,
                                'img', IFNULL(li.ImagePath, '')
                            )
                        )
                    FROM LIB_CHECKOUT_ITEM lci
                    INNER JOIN LIB_ITEM li ON li.ItemID = lci.ItemID
                    WHERE lci.CheckoutID = lc.CheckoutID
                ),
                'Fees', (
                    SELECT 
                        JSON_ARRAYAGG(
                            JSON_OBJECT(
                                'FeeType', lft.Name,
                                'Amount', lf.Amount,
                                'DatePaid', lf.PaidDate
                            )
                        )
                    FROM LIB_FEES lf
                    INNER JOIN LIB_FEE_TYPE lft ON lft.FeeTypeID = lf.FeeTypeID
                    WHERE lf.CheckoutID = lc.CheckoutID
                )
            )
        )
    ) AS `CheckoutHistory`
FROM LIB_ACCOUNT la
INNER JOIN LIB_ACCOUNT_TYPE lat ON lat.AccountTypeID = la.AccountTypeID
LEFT JOIN LIB_CHECKOUT lc ON lc.AccountID = la.AccountID
WHERE la.AccountID = ?
GROUP BY la.AccountID
_END;

$queryStmt = $conn->prepare($queryFramework);
$queryStmt->bind_param(
    "s", $accountId
);

$queryStmt->execute();
$result = $queryStmt->get_result();

if(!$result) echo $conn->error;

$queryStmt->close();
$conn->close();

$result->data_seek(0);
$row = $result->fetch_array(MYSQLI_ASSOC);

$data = array(
    "profile" => array(
        "Name" => $row['FirstName'] . ' ' . $row['LastName'], 
        "Phone" => $row['Phone'], 
        "Email" => $row['Email'],  
        "Address" => $row['Street'] . "<br>" . $row['City'] . ", " . $row['State'] . "<br>" . $row['Zip'], 
        "Member Since" => formatDate($row['StartDate'])
    ), 
    "security" => array(
        "username" => $row['Username'], 
        "password" => "************"
    ), 
    "checkout_history" => array(
        "items" => json_decode(stripslashes($row['CheckoutHistory']), true)['CheckoutHistory'] ?? []
    )
);

//var_dump($data['checkout_history']['items']);
//die();
?>

<main class="my-5">
    <div class="container-fluid">
        <div class="row justify-content-between mx-5">
            <aside class="col-lg-3 pe-5">
                <div class="offcanvas-lg offcanvas-end" tabindex="-1" id="offcanvasResponsive" aria-labelledby="offcanvasResponsiveLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasResponsiveLabel">Account</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#offcanvasResponsive" aria-label="Close"></button>
                    </div>
                    <div class="list-group" id="list-tab" role="tablist">
                        <a class="list-group-item list-group-item-action active" id="list-profile-list" data-bs-toggle="list" href="#list-profile" role="tab" aria-controls="list-profile">
                            <i class="bi bi-person-circle pe-2"></i>Profile
                        </a>
                        <a class="list-group-item list-group-item-action" id="list-security-list" data-bs-toggle="list" href="#list-security" role="tab" aria-controls="list-security">
                            <i class="bi bi-shield-lock pe-2"></i>Security
                        </a>
                        <a class="list-group-item list-group-item-action" id="list-checkout-history-list" data-bs-toggle="list" href="#list-checkout-history" role="tab" aria-controls="list-checkout-history">
                            <i class="bi bi-journal-bookmark pe-2"></i>Checkout History
                        </a>
                        <a class="list-group-item list-group-item-action" id="list-checkout-history-list" data-bs-toggle="list" href="#list-checkout-fees" role="tab" aria-controls="list-checkout-fees">
                            <i class="bi bi-receipt pe-2"></i>Checkout Fees
                        </a>
                    </div>
                </div>
            </aside>
            <section class="col-12 col-lg-9">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">
                        <div class="d-flex justify-content-between align-items-center">
                            <h2><i class="bi bi-person-circle pe-2"></i>Profile</h2>
                            <div>
                                <a href="edit-account.php?accountId=<?php echo $accountId ?>" class="btn btn-info">
                                    <i class="bi bi-pencil pe-2"></i>Edit Account
                                </a>
                                <button class="btn btn-sm btn-secondary d-lg-none d-inline-flex align-items-center" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasResponsive" aria-controls="offcanvasResponsive">
                                    <i class="bi bi-list"></i>
                                </button>
                            </div>
                        </div>
                        <hr>
                        <div class="row mt-4">
                            <div class="col-6">
                                <?php
                                foreach(array_slice($data['profile'], 0, 3) as $key => $value) {
                                    echo <<<_END
                                        <div class="mb-4">
                                            <p class="mb-1"><span class="badge text-bg-light">$key</span></p>
                                            <p class="lead">$value</p>
                                        </div>
                                    _END;
                                }
                                ?>
                            </div>
                            <div class="col-6">
                                <?php
                                foreach(array_slice($data['profile'], 3, 5) as $key => $value) {
                                    echo <<<_END
                                        <div class="mb-4">
                                            <p class="mb-1"><span class="badge text-bg-light">$key</span></p>
                                            <p class="lead">$value</p>
                                        </div>
                                    _END;
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="list-security" role="tabpanel" aria-labelledby="list-security-list">
                        <div class="d-flex justify-content-between align-items-center">
                            <h2><i class="bi bi-shield-check pe-2"></i>Security</h2>
                            <div>
                                <a href="edit-account.php?accountId=<?php echo $accountId ?>" class="btn btn-info">
                                    <i class="bi bi-pencil pe-2"></i>Edit Account
                                </a>
                                <button class="btn btn-sm btn-secondary d-lg-none d-inline-flex align-items-center" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasResponsive" aria-controls="offcanvasResponsive">
                                    <i class="bi bi-list"></i>
                                </button>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-6">
                                <?php
                                foreach($data['security'] as $key => $value) {
                                    echo <<<_END
                                        <div class="mb-4">
                                            <p class="mb-1"><span class="badge text-bg-light">$key</span></p>
                                            <p class="lead">$value</p>
                                        </div>
                                    _END;
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="list-checkout-history" role="tabpanel" aria-labelledby="list-checkout-history-list">
                        <div class="d-flex justify-content-between align-items-center">
                            <h2><i class="bi bi-journal-bookmark pe-2"></i>Checkout History</h2>
                            <div>
                                <button class="btn btn-sm btn-secondary d-lg-none d-inline-flex align-items-center" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasResponsive" aria-controls="offcanvasResponsive">
                                    <i class="bi bi-list"></i>
                                </button>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <table class="table">
                                    <?php 
                                        $itemsArray = $data['checkout_history']['items'];
                                        usort($itemsArray, function($a, $b) {
                                            return $b['CheckoutDate'] <=> $a['CheckoutDate'];
                                        });

                                        echo <<<_END
                                            <thead><tr>
                                            <th>Checkout Date</th>
                                            <th>Due Date</th>
                                            <th>Returned Date</th>
                                            <th>Items Checked Out</th>
                                            </tr></thead><tbody>
                                        _END;
                                        
										foreach($itemsArray as $item) {
                                            if(!is_null($item['CheckoutDate'])) {
                                                $checkoutFormatted = formatDate($item['CheckoutDate']);
                                                $dueFormatted = formatDate($item['DueDate']);
                                                $returnDate = is_null($item['ReturnDate'])  ? '' : formatDate($item['ReturnDate']);
                                                echo <<<_END
                                                <tr>
                                                    <td>$checkoutFormatted</td>
                                                    <td>$dueFormatted</td>
                                                    <td>$returnDate</td>
                                                    <td><div class='d-flex gap-2'>
                                                _END;

                                                foreach($item['Items'] as $i) {
                                                    echo <<<_END
                                                        <a href="view-item.php?itemId=$i[id]">
                                                            <img src='../../$i[img]' style='width:2rem'
                                                            data-bs-toggle='tooltip'
                                                            data-bs-title='$i[title]'
                                                            >
                                                        </a>
                                                    _END;
                                                    //echo "<p class='small mb-0'>$i[title]</p>";
                                                }
                                                echo "</div></td></tr>";
                                            }
                                        }
                                        echo "</tbody>";
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="list-checkout-fees" role="tabpanel" aria-labelledby="list-checkout-fees-list">
                        <div class="d-flex justify-content-between align-items-center">
                            <h2><i class="bi bi-receipt pe-2"></i>Checkout Fees</h2>
                            <div>
                                <button class="btn btn-sm btn-secondary d-lg-none d-inline-flex align-items-center" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasResponsive" aria-controls="offcanvasResponsive">
                                    <i class="bi bi-list"></i>
                                </button>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <table class="table">
                                    <?php 
                                        $itemsArray = $data['checkout_history']['items'];
                                        usort($itemsArray, function($a, $b) {
                                            return $b['CheckoutDate'] <=> $a['CheckoutDate'];
                                        });

                                        echo <<<_END
                                            <thead><tr>
                                            <th>Checkout Date</th>
                                            <th>Items Checked Out</th>
                                            <th>Summary of Fees</th>
                                            </tr></thead><tbody>
                                        _END;
                                        
                                        foreach($itemsArray as $item) {
											if(!is_null($item['CheckoutDate'])) {
												$returnDate = is_null($item['ReturnDate']) ? '' : $item['ReturnDate'];
												$checkoutFormatted = formatDate($item['CheckoutDate']);
												echo <<<_END
												<tr>
													<td>$checkoutFormatted</td>
													<td><div class='d-flex gap-2'>
												_END;
	
												foreach($item['Items'] as $i) {
													echo <<<_END
														<a href="view-item.php?itemId=$i[id]">
															<img src='../../$i[img]' style='width:2rem'
															data-bs-toggle='tooltip'
															data-bs-title='$i[title]'
															>
														</a>
													_END;
													//echo "<p class='small mb-0'>$i[title]</p>";
												}
	
												echo "</div></td>";
                                            
												if(!is_null($item['Fees'])) {
													echo "<td><dl class='row'>";
	
													foreach($item['Fees'] as $i) {
														$formattedDate = is_null($i['DatePaid']) ? '' : 'Paid - ' . formatDate($i['DatePaid']);
														echo <<<_END
															<dt class="col-5">$i[FeeType]</dt>
															<dd class="col-3">$$i[Amount]</dd>
															<dd class="col-4">$formattedDate</dd>
														_END;
														//echo "<p class='small mb-0'>$i[title]</p>";
													}
	
													echo "</dl></td>";
												} else {
													echo "<td></td>";
												}
												
												echo "</tr>";
											} 
										}
                                        echo "</tbody>";
                                    ?>
                                </table>
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