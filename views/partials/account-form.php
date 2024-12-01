<?php

function renderAccountForm($controller, $accountType = false, $valuesArray = null) {
    $firstName = $valuesArray['FirstName'] ?? '';
    $lastName = $valuesArray['LastName'] ?? '';
    $phone = $valuesArray['Phone'] ?? '';
    $email = $valuesArray['Email'] ?? '';
    $street = $valuesArray['Street'] ?? '';
    $city = $valuesArray['City'] ?? '';
    $state = $valuesArray['State'] ?? '';
    $zip = $valuesArray['Zip'] ?? '';
    $username = $valuesArray['Username'] ?? '';
    $accountTypeId = $valuesArray['AccountTypeID'] ?? $_GET['accountTypeId'] ?? 3;

    $lang = is_null($valuesArray) ? 'Create' : 'Edit';

    echo <<<_END
    <form class="row justify-content-between g-3 mt-5" method='POST' action='$controller'>
        <div class="col-md-6">
            <label for="#first-name-in" class="col-form-label fw-bold">*First Name</label>
            <input id="first-name-in" class="form-control" type="text" name="firstName" aria-label="First name input" value="$firstName" required>
        </div>
        <div class="col-md-6">
            <label for="#last-name-in" class="col-form-label fw-bold">*Last Name</label>
            <input id="last-name-in" class="form-control" type="text" name="lastName" aria-label="Last name input" value="$lastName" required>
        </div>
        <div class="col-md-6">
            <div>
                <label for="#phone-in" class="col-form-label fw-bold">*Phone Number<span class="fw-normal small ms-2">(###-###-####)</span></label>
                <input id="phone-in" class="form-control" type="tel" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" name="phone" aria-label="Phone number input" value="$phone" required>
            </div>
            <div>
                <label for="#email-in" class="col-form-label fw-bold">*Email Address</label>
                <input id="email-in" class="form-control" type="email" name="email" aria-label="Email address input" value="$email" required>
            </div>
        </div>
        <div class="col-md-6">
            <div>
                <label for="#street-in" class="col-form-label fw-bold">*Street</label>
                <input id="street-in" class="form-control" type="text" name="street" aria-label="Street input" value="$street" required>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <label for="#city-in" class="col-form-label fw-bold">*City</label>
                    <input id="city-in" class="form-control" type="text" name="city" aria-label="City input" value="$city" required>
                </div>
                <div class="col-sm-3">
                    <label for="#state-in" class="col-form-label fw-bold">*State</label>
                    <input id="state-in" class="form-control" type="text" name="state" aria-label="State input" value="$state" required>
                </div>
                <div class="col-sm-3">
                    <label for="#zip-in" class="col-form-label fw-bold">*Zip Code</label>
                    <input id="zip-in" class="form-control" type="text" name="zip" aria-label="Zip code input" value="$zip" required>
                </div>
            </div>
        </div>
        <div class="col-md-6 mt-md-5">
            <div>
                <label for="#username-in" class="col-form-label fw-bold">*Username</label>
                <input id="username-in" class="form-control" type="text" name="username" aria-label="Username input" value="$username" required>
            </div>
        </div>
        <div class="col-md-6 mt-md-5">
            <label for="#password-in" class="col-form-label fw-bold">*Password</label>
            <input id="password-in" class="form-control" type="password" name="password" aria-label="Password input" disabled>
        </div>
    _END;

        if($accountType) {
            $selected1 = $accountTypeId == 1 ? 'selected' : '';
            $selected2 = $accountTypeId == 2 ? 'selected' : '';
            $selected3 = $accountTypeId == 3 ? 'selected' : '';
            $default = count(array_intersect(['selected'], [$selected1, $selected2, $selected3])) > 0 ? '' : 'selected';
            echo <<<_END
            <div class="col-12">
                <label for="#account-type-in" class="col-form-label fw-bold">*Account Type</label>
                <select id="account-type-in" class="form-select" name="accountType" aria-label="Account type input" required>
                    <option $default disabled></option>
                    <option $selected1 value="1">Admin</option>
                    <option $selected2 value="2">Staff</option>
                    <option $selected3 value="3">Member</option>
                </select>
            </div>
            _END;
        }

        echo <<<_END
        <div class="mt-5 d-grid gap-2">
            <button type="submit" class="btn btn-success">$lang Account</button>
            <a href="home.php" class="btn btn-secondary">Cancel</a>
        </div>
        </form>
    _END;
}