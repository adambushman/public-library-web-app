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

                $classId = $_GET['classId'];

                $conn = connect();
                $query = <<<_END
                SELECT 
                lc.*
                ,CONCAT('[', 
                    GROUP_CONCAT(
                        DISTINCT CONCAT(
                            '{"id":', li.InstructorID, 
                            ',"name":"', REPLACE(li.Name, '"', '\"'), 
                            '","bio":"', REPLACE(li.Bio, '"', '\"'), 
                            '","image":"', REPLACE(li.ImagePath, '"', '\"'), '"}'
                        )
                        SEPARATOR ','
                    ), 
                ']') AS `INSTRUCTORS`
                ,CONCAT('[', 
                    GROUP_CONCAT(
                        DISTINCT CONCAT('"', DATE_FORMAT(lcs.Date, '%W'), '"') 
                        SEPARATOR ','
                    ), 
                ']') AS DAYS_OF_WEEK
                ,CASE
                WHEN TIME(lcs.Time) BETWEEN '05:00:00' AND '11:59:59' THEN 'Morning'
                WHEN TIME(lcs.Time) BETWEEN '12:00:00' AND '16:59:59' THEN 'Afternoon'
                WHEN TIME(lcs.Time) BETWEEN '17:00:00' AND '20:59:59' THEN 'Evening'
                ELSE 'Night'
                END AS TIME_OF_DAY

                FROM LIB_CLASS lc
                INNER JOIN LIB_CLASS_INSTRUCTOR lic ON lic.ClassID = lc.ClassID
                INNER JOIN LIB_INSTRUCTOR li ON li.InstructorID = lic.InstructorID
                INNER JOIN LIB_CLASS_SCHEDULE lcs ON lcs.ClassID = lc.ClassID

                WHERE lc.ClassID = $classId
                _END;

                $result = $conn->query($query);
                $rows = $result->num_rows;

                $result->data_seek(0); 
                $row = $result->fetch_array(MYSQLI_ASSOC);

                $itemImg = ($row['ImagePath'] ?? 'ImageDirectory/default-image.jpg');
                $instructors = json_decode($row['INSTRUCTORS'], true);
                $instructor_names = implode(', ', array_map(fn($x) => "$x[name]",  $instructors));
                $daysofweek = implode(', ', json_decode($row['DAYS_OF_WEEK'], true));

                $item_meta = array(
                    array("caption" => "Day(s) of Week", "value" => $daysofweek, "icon" => "bi-calendar-week"), 
                    array("caption" => "Media Type", "value" => $row['TIME_OF_DAY'], "icon" => "bi-clock"),
                    array("caption" => "Instructor(s)", "value" => $instructor_names, "icon" => "bi-easel3-fill")
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
                    <div class="col-10 col-md-6 col-xl-5">
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
                                    <i class="bi bi-file-earmark-check pe-2"></i> 
                                    Register
                                </a>
                            </div>
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
                    </div>
                _END;
            ?>
        </div>
        <div class="row justify-content-center mt-4">
            <div class="col-12 col-md-10 p-3">
                <?php
                echo '<div class="card-group">';
                foreach(array_slice($item_meta, 0, 3) as $meta) {
                    constructCard($meta);
                }
                echo '</div>';
                ?>
            </div>
        </div>
        <!--
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
        -->
        <div class="row justify-content-center mt-3 mb-5">
            <?php
            echo <<<_END
            <div class="col-md-10">
                <h4 class="mb-4">About the Instructor(s)</h4>
                <div class="row row-cols-2 row-cols-md-4 g-4">
            _END;

            foreach($instructors as $instructor) {
                echo <<<_END
                <div class="col">
                    <div class="card">
                        <img src="../../$instructor[image]" class="card-img-top" alt="...">
                        <div class="card-body" style="height:15rem">
                            <h5 class="card-title">$instructor[name]</h5>
                            <p class="card-text text-truncate-multiline">$instructor[bio]</p>
                            <a class="stretched-link" href="view-instructor.php?instructorId=$instructor[id]"></a>
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