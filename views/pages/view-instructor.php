<!-- Header -->
<?php include_once '../partials/head.php'; ?>

<!-- Navbar -->
<?php include_once '../partials/navbar.php'; ?>

<main>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <?php
                require_once '../../config/dbauth.php';

                $instructorId = $_GET['instructorId'];

                $conn = connect();
                $query = <<<_END
                SELECT 
                li.*
                ,CONCAT('[', 
                    GROUP_CONCAT(
                        DISTINCT CONCAT(
                            '{"id":', lc.ClassID, 
                            ',"title":"', REPLACE(lc.Title, '"', '\"'), 
                            '","description":"', REPLACE(lc.Description, '"', '\"'), 
                            '","image":"', REPLACE(lc.ImagePath, '"', '\"'), '"}'
                        )
                        SEPARATOR ','
                    ), 
                ']') AS `CLASSES`

                FROM LIB_CLASS lc
                INNER JOIN LIB_CLASS_INSTRUCTOR lic ON lic.ClassID = lc.ClassID
                INNER JOIN LIB_INSTRUCTOR li ON li.InstructorID = lic.InstructorID
                INNER JOIN LIB_CLASS_SCHEDULE lcs ON lcs.ClassID = lc.ClassID

                WHERE li.InstructorID = $instructorId
                _END;

                $result = $conn->query($query);
                $rows = $result->num_rows;

                $result->data_seek(0); 
                $row = $result->fetch_array(MYSQLI_ASSOC);

                $instructorImg = ($row['ImagePath'] ?? 'ImageDirectory/default-image.jpg');
                $classes = json_decode($row['CLASSES'], true);

                echo <<<_END
                    <div class="col-10 col-md-6 col-xl-4">
                        <img class="img-fluid" src='../../$instructorImg' alt="">
                    </div>
                    <div class="col-12 col-md-6 col-xl-4 mt-3 mt-md-0 d-flex flex-column justify-content-evenly">
                        <div>
                            <h1 class="display-5 mb-2">$row[Name]</h1>
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
                <h3 class="mb-3">Classes at the library</h3>
                <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-2">

                    <?php
                    foreach($classes as $class) {

                        $img = ($class['image'] ?? 'ImageDirectory/default-image.jpg');

                        echo <<<_END
                        <div class="col">
                            <div class="card border-0">
                                <img src="../../$img" class="card-img-top class-item-img mb-3" alt="...">
                                <div class="card-body border rounded" style="height:16rem">
                                    <h5 class="card-title mb-2">$class[title]</h5>
                                    <p class="card-text small text-truncate-multiline">$class[description]</p>
                                </div>
                                <a class="stretched-link" href="view-class.php?classId=$class[id]"></a>
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