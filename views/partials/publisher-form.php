<?php

function renderPublisherForm($publisherTypes, $echoBack = true, $valuesArray = null) {
    $lang = is_null($valuesArray) ? "Add" : "Edit";
    $langLower = strtolower($lang);
    $actionVal = !$echoBack ? "../../controllers/catalog/$langLower-publisher-controller.php?echo=$echoBack&publisherId=$valuesArray[PublisherID]" : '';
    $methodVal = !$echoBack ? 'POST' : '';

    $name = $valuesArray['Name'] ?? '';
    $publisherTypeId = $valuesArray['PublisherTypeID'] ?? '';

    echo <<<_END
        <form id="publisher-form" class="row g-3" method="$methodVal" action="$actionVal">
            <div class="col-12">
                <label for="#name-in" class="col-form-label fw-bold">*Publisher Name</label>
                <input id="name-in" class="form-control" type="text" name="name" aria-label="Publisher name input" value="$name" required>
            </div>
            <div class="col-12">
                <label for="#publisher-type-in" class="col-form-label fw-bold">*Publisher Type</label>
                <div class="input-group">
                    <select id="publisher-type-in" class="form-select" name="publisherType" aria-label="Publisher type input" required>

        _END;
                    if(is_null($valuesArray)) {
                        echo "<option selected disabled></option";
                    }
                    foreach($publisherTypes as $type) {
                        $selected = $type['id'] == $publisherTypeId ? 'selected' : '';
                        echo <<<_END
                            <option $selected value="$type[id]">$type[name]</option>
                        _END;
                    }
        echo <<<_END
                    </select>
                    <button class="btn btn-primary" type="button" id="button-addon2"
                        data-bs-toggle="modal" 
                        data-bs-target="#newItemModal"
                        onclick="prepModal('publisher type','LIB_PUBLISHER_TYPE','publisher-type-in', 'true')"
                    ><i class="bi bi-plus-lg"></i></button>
                </div>
            </div>
            
            <div class="col-6 mt-5">
    _END;
    if(!$echoBack) {
        echo '<a href="application-settings.php" class="btn btn-secondary w-100">Cancel</a>';
    } else {
        echo '<button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal" aria-label="Close">Cancel</button>';
    }
    echo <<<_END
            </div>
            <div class="col-6 mt-5">
                <button type="submit" class="btn btn-success w-100">$lang Publisher</button>
            </div>
        </form>
    _END;
}