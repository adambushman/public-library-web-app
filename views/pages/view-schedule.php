<!-- Header -->
<?php include_once '../partials/head.php'; ?>

<!-- Navbar -->
<?php include_once '../partials/navbar.php'; ?>

<?php
// Get the current month and year

$currentYear = $_GET['year'] ?? date('Y');
$currentMonth = $_GET['month'] ?? date('n');

// Get previous and next month/year
$Date = new DateTime("$currentYear-$currentMonth-15");
$prev = array(
    "year" => (clone $Date)->modify('-1 month')->format('Y'), 
    "month" => (clone $Date)->modify('-1 month')->format('n')
);
$next = array(
    "year" => (clone $Date)->modify('+1 month')->format('Y'), 
    "month" => (clone $Date)->modify('+1 month')->format('n')
);

// First day of the month
$firstDayOfMonth = mktime(0, 0, 0, $currentMonth, 1, $currentYear);
// Number of days in the month
$daysInMonth = date('t', $firstDayOfMonth);
// Day of the week the month starts on (0 for Sunday, 6 for Saturday)
$startDay = date('w', $firstDayOfMonth);

// Day names for headers
$dayNames = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];


// Get all events & classes
require_once '../../config/dbauth.php';

$conn = connect();
$query = <<<_END
WITH SLOTS AS (
SELECT 
les.Date, les.Time, lr.Name AS RoomName, 'Event' AS SlotType, 
CONCAT(
    '{"id":', le.EventID, 
    ',"title":"', REPLACE(le.Title,'"','\"'), '"', 
    ',"description":"', REPLACE(le.Description,'"','\"'), '"', 
    ',"image":"', REPLACE(le.ImagePath,'"','\"'), '"',
	'}'
) AS `Details`
FROM LIB_EVENT_SCHEDULE les
INNER JOIN LIB_EVENT le ON le.EventID = les.EventID
INNER JOIN LIB_ROOM lr ON lr.RoomID = les.RoomID
UNION ALL
SELECT 
lcs.Date, lcs.Time, lr.Name AS RoomName, 'Class' AS SlotType, 
CONCAT(
    '{"id":', lc.ClassID, 
    ',"title":"', REPLACE(lc.Title,'"','\"'), '"', 
    ',"description":"', REPLACE(lc.Description,'"','\"'), '"', 
    ',"duration":', lc.DurationMins, 
    ',"image":"', REPLACE(lc.ImagePath,'"','\"'), '"',
	'}'
) AS `Details`
FROM LIB_CLASS_SCHEDULE lcs
INNER JOIN LIB_CLASS lc ON lc.ClassID = lcs.ClassID
INNER JOIN LIB_ROOM lr ON lr.RoomID = lcs.RoomID
)

SELECT 
Date, 
CONCAT('[', 
    GROUP_CONCAT(
        DISTINCT CONCAT(
            '{"time":"', Time, '"',
            ',"roomName":"', REPLACE(RoomName, '"', '\"'), '"',
            ',"type":"', REPLACE(SlotType, '"', '\"'), '"',
        	',"details":', Details, '}'
        )
    	SEPARATOR ','
	), 
']') AS `Slots`
FROM SLOTS
GROUP BY
Date
_END;
$result = $conn->query($query);
$rows = $result->num_rows;

$data = [];
while($row = $result->fetch_assoc()) {
    $data[$row['Date']] = $row; // Use 'Date' as the key
}

?>

<main>
    <div class="container my-4">
        <div class="row justify-content-center">
            <div class="col-10">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <?php
                    $date = new DateTime("$currentYear-$currentMonth-01");
                    $dateFormat = $date->format('F Y');

                    $dateFormat = $date->format('F Y');
                    echo <<<_END
                        <a class="btn btn-dark" href="view-schedule.php?year=$prev[year]&month=$prev[month]">
                            <i class="bi bi-chevron-left"></i>
                        </a>
                        <h1 class="text-center">$dateFormat</h1>
                        <a class="btn btn-dark" href="view-schedule.php?year=$next[year]&month=$next[month]">
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    _END;
                    ?>
                </div>
                <div class="row text-center fw-bold">
                    <?php foreach ($dayNames as $day): ?>
                        <div class="col border p-2"><?php echo $day; ?></div>
                    <?php endforeach; ?>
                </div>
                <div class="row">
                    <?php
                    // Blank cells before the first day of the month
                    for ($i = 0; $i < $startDay; $i++) {
                        echo '<div class="col border p-2"></div>';
                    }

                    // Days of the month
                    for ($day = 1; $day <= $daysInMonth; $day++) {
                        echo <<<_END
                        <div class="col border p-2" style="height:7rem">
                            <p class="mb-1">$day</p>
                        _END;

                        // Events
                        $currentDate = sprintf('%04d-%02d-%02d', $currentYear, $currentMonth, $day);
                        $currentDateToFormat = new DateTime(sprintf('%04d-%02d-%02d', $currentYear, $currentMonth, $day));
                        if(isset($data[$currentDate])) {
                            $slots = json_decode($data[$currentDate]['Slots'], true);
                            
                            foreach($slots as $slot) {
                                $time = new DateTime($slot['time']);
                                $formattedTime = $time->format('h:i A');
                                $typeClass = $slot['type'] == 'Event' ? 'bg-primary-subtle' : 'bg-danger-subtle';
                                $id = $slot['details']['id'];
                                $title = $slot['details']['title'];
                                $dtm = $currentDateToFormat->format('F d, Y') . '<br>' . $formattedTime;
                                
                                echo <<<_END
                                <p class='slot-item mb-1 badge text-black fw-normal $typeClass'
                                data-bs-toggle="tooltip"
                                data-bs-title="$title"

                                data-lib-id="$id"
                                data-lib-dtm="$dtm"
                                data-lib-room="$slot[roomName]"
                                data-lib-type="$slot[type]"
                                data-lib-title="$title"
                                >$formattedTime</p>
                                _END;
                            }
                        }

                        echo '</div>';

                        // Break to a new row after Saturday
                        if (($startDay + $day) % 7 == 0) {
                            echo '</div><div class="row">';
                        }
                    }

                    // Blank cells after the last day of the month
                    $remainingCells = (7 - ($startDay + $daysInMonth) % 7) % 7;
                    for ($i = 0; $i < $remainingCells; $i++) {
                        echo '<div class="col border p-2"></div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</main>


<!-- Modal -->
<section>
    <div class="modal fade" id="calendarModal" tabindex="-1" aria-labelledby="calendarModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="calendarModalLabel"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="modalDesc"></p>
                <div class="card-group">
                <div class="card text-center">
                    <div class="card-body">
                        <h4 class="card-title"><i class="bi bi-calendar-event"></i></h4>
                        <p id="dtmVal" class="card-text small"></p>    
                    </div>
                </div>
                <div class="card text-center">
                    <div class="card-body">
                        <h4 class="card-title"><i class="bi bi-map"></i></h4>
                        <p id="roomVal" class="card-text small"></p>
                    </div>
                </div>
                </div>
            </div>
            <div class="modal-footer d-grid">
                <a id="learnMore" href="" class="btn btn-primary">Learn More</a>
            </div>
            </div>
        </div>
    </div>
</section>

<script src="../../public/assets/javascript/schedule/toggle-modals.js"></script>

<!-- Footer -->
<?php include_once '../partials/footer.php'; ?>