<?php 

function renderFieldForm($controller = null, $method = null, $table = null, $value = null, $lang = null) {
    $controllerVal = $controller ?? '';
    $methodVal = $method ?? '';
    if(!is_null($lang)) {
        echo "<h3>$lang value to '$table'</h3>";
    }
    echo <<<_END
        <form id="new-item-form" action="$controllerVal" method="$methodVal" class="row g-3">
            <div class="col-12">
                <label for="#name-in" class="col-form-label fw-bold">*Field Name</label>
                <input id="name-in" class="form-control" type="text" name="name" aria-label="Item name input" value="$value" required>
            </div>

            <input id="table-in" class="visually-hidden" type="text" name="table" value="$table">
            <input id="inputField-in" class="visually-hidden" type="text" name="inputField" value="">
            <input id="reopen-in" class="visually-hidden" type="text" name="reopen" value="">
            
            <div class="col-6 mt-5">
    _END;
    if(!is_null($table)) {
        echo '<a href="application-settings.php" class="btn btn-secondary w-100">Cancel</a>';
    } else {
        echo '<button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal" aria-label="Close">Cancel</button>';
    }
    echo <<<_END
            </div>
            <div class="col-6 mt-5">
                <button type="submit" class="btn btn-success w-100">$lang Field</button>
            </div>
        </form>
    _END;
}