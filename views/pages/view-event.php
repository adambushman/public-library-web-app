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

                $conn = connect();
                $roles = isset($_SESSION['accountId']) ? getAccountRoles($conn, $_SESSION['accountId']) : [];
                $eventId = prepSanitaryData($conn, $_GET['eventId']);

                $queryFramework = <<<_END
                    SELECT * 
                    FROM LIB_EVENT le
                    WHERE le.EventID = ?
                _END;
                $queryStmt = $conn->prepare($queryFramework);
                $queryStmt->bind_param("i", $eventId);
                $queryStmt->execute();

                $result = $queryStmt->get_result();
                $result->data_seek(0); 
                $row = $result->fetch_array(MYSQLI_ASSOC);

                $eventImg = ($row['ImagePath'] ?? 'ImageDirectory/default-image.jpg');

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
                    <div class="col-10 col-md-6 col-xl-5">
                        <img class="img-fluid" src='../../$eventImg' alt="">
                    </div>
                    <div class="col-12 col-md-6 col-xl-5 mt-3 mt-md-0 d-flex flex-column justify-content-center">
                        <div>
                            <h1 class="display-5 mb-3">$row[Title]</h1>
                            <div style="height:13rem">
                                <p class="lead text-truncate-multiline">$row[Description]</p>
                            </div>
                        </div>
                _END;
                if(count(array_intersect($roles, array("Admin", "Staff")))) {
                    echo <<<_END
                        <div class="row">
                            <div class="col-6">
                                <a class="btn btn-sm btn-warning d-inline-flex justify-content-center align-items-center w-100" href="#" disabled>
                                    <i class="bi bi-pencil pe-2"></i>    
                                    Update
                                </a>
                            </div>
                            <div class="col-6">
                                <a class="btn btn-sm btn-danger d-inline-flex justify-content-center align-items-center w-100" href="#" disabled>
                                    <i class="bi bi-trash pe-2"></i>
                                    Remove
                                </a>
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