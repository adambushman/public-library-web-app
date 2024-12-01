<?php

function renderCreatorForm($creatorTypes, $echoBack = true, $valuesArray = null) {
    $lang = is_null($valuesArray) ? "Add" : "Edit";
    $langLower = strtolower($lang);
    $creatorString = is_null($valuesArray) ? '' : "&creatorId=$valuesArray[CreatorID]";
    $actionVal = !$echoBack ? "../../controllers/catalog/$langLower-creator-controller.php?echo=$echoBack" . $creatorString : '';
    $methodVal = !$echoBack ? 'POST' : '';

    $name = $valuesArray['Name'] ?? '';
    $gender = $valuesArray['Gender'] ?? '';
    $bio = $valuesArray['Bio'] ?? '';
    $bDate = $valuesArray['DateBorn'] ?? '';
    $dDate = $valuesArray['DateDied'] ?? '';
    $creatorTypeId = $valuesArray['CreatorTypeID'] ?? '';

    $gender1 = $gender == "M" ? 'selected' : '';
    $gender2 = $gender == "F" ? 'selected' : '';
    $genderDefault = count(array_intersect(['selected'], array($gender1, $gender2))) > 0 ? '' : 'selected';
    echo <<<_END
        <form id="creator-form" class="row g-3" method="$methodVal" action="$actionVal" enctype="multipart/form-data">
            <div class="col-md-9">
                <label for="#name-in" class="col-form-label fw-bold">*Creator Name</label>
                <input id="name-in" class="form-control" type="text" name="name" aria-label="Name input" value="$name" required>
            </div>
            <div class="col-md-3">
                <label for="#gender-in" class="col-form-label fw-bold">*Gender</label>
                <select id="gender-in" class="form-select" name="gender" aria-label="Gender input" required>
                    <option $genderDefault disabled></option>
                    <option $gender1 value="M">Male</option>
                    <option $gender2 value="F">Female</option>
                </select>
            </div>

            <div class="col-12">
                <label for="#bio-in" class="col-form-label fw-bold">*Biography</label>
                <textarea class="form-control" name="bio" id="bio-in" rows="4" required>$bio</textarea>
            </div>

            <div class="col-md-6">
                <label for="#date-born-in" class="col-form-label fw-bold">*Birth Date</label>
                <input class="form-control" type="date" name="dateBorn" id="date-born-in" aria-label="Date born input" value="$bDate" required>
            </div>
            <div class="col-md-6">
                <label for="#date-died-in" class="col-form-label fw-bold">Death Date</label>
                <input class="form-control" type="date" name="dateDied" id="date-died-in" aria-label="Date died input" value="$dDate">
            </div>

            <div class="col-md-6">
                <label for="#creator-type-in" class="col-form-label fw-bold">*Creator Type</label>
                <div class="input-group">
                    <select id="creator-type-in" class="form-select" name="creatorType" aria-label="Creator type input" required>
        _END;
                    if(is_null($valuesArray)) {
                        echo "<option selected disabled></option>";
                    }
                    foreach($creatorTypes as $type) {
                        $selected = $type['id'] == $creatorTypeId ? 'selected' : '';
                        echo <<<_END
                            <option $selected value="$type[id]">$type[name]</option>
                        _END;
                    }
        echo <<<_END
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
    _END;
    if(!is_null($valuesArray)) {
        echo '<p class="text-danger"><i>Only select for upload of new image</i></p>';
    }
    echo <<<_END
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
                <button type="submit" class="btn btn-success w-100">$lang Creator</button>
            </div>
        </form>
    _END;
}