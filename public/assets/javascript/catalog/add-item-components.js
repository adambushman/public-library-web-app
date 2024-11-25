// Logic to fire off a post request for a new "creator", 
// then add creator as option for selection
document.getElementById("creator-form").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent the default form submission behavior
    const formData = new FormData(this); // Gather form data
    
    fetch("../../controllers/catalog/add-creator-controller.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.text()) // Handle the response (can be JSON or text)
    .then(data => {
        const creator = JSON.parse(data);
        console.log(creator);
        const creator_inputs = document.querySelectorAll("#creator-input-fields select");
        let populated = false;
        [...creator_inputs].forEach(ci => {
            const option = document.createElement("option");
            option.value = creator.id;
            option.textContent = creator.name;
            ci.appendChild(option);
        
            if(ci.selectedIndex == 0 & !populated) {
                [...ci.children].forEach(c => {
                    c.selected = false;
                });
                option.selected = true;
                populated = true;
            }
        });
        
        // Close modal
        $('#creatorModal').modal('hide');
    })
    .catch(error => {
        console.error("Error:", error);
        alert("An error occurred. Please try again.");
    });
});


// Logic to fire off a post request for a new "publisher", 
// then add publisher as option for selection
document.getElementById("publisher-form").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent the default form submission behavior
    const formData = new FormData(this); // Gather form data
    
    fetch("../../controllers/catalog/add-publisher-controller.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.text()) // Handle the response (can be JSON or text)
    .then(data => {
        const publisher = JSON.parse(data);

        const publisher_inputs = document.querySelectorAll("#publisher-input-fields select");
        let populated = false;
        [...publisher_inputs].forEach(pi => {
            const option = document.createElement("option");
            option.value = publisher.id;
            option.textContent = publisher.name;
            pi.appendChild(option);
        
            if(pi.selectedIndex == 0 & !populated) {
                [...pi.children].forEach(p => {
                    p.selected = false;
                });
                option.selected = true;
                populated = true;
            }
        });
        
        // Close modal
        $('#publisherModal').modal('hide');
    })
    .catch(error => {
        console.error("Error:", error);
        alert("An error occurred. Please try again.");
    });
});


// Logic to fire off a post request for a new "item type", "media type", or "genre", 
// then add that value as the selected option

function prepModal(name, table_name, input_field, reopen) {
    const modal = document.getElementById('newItemModal');

    // Update title
    modal.getElementsByTagName("span")[0].textContent = name;

    // Update table name field
    const inputs = modal.getElementsByTagName('input');
    inputs[0].value = "";
    inputs[1].value = table_name;
    inputs[2].value = input_field;
    inputs[3].value = reopen;
}

document.getElementById("new-item-form").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent the default form submission behavior
    const formData = new FormData(this); // Gather form data

    fetch(`../../controllers/catalog/add-item-field-controller.php`, {
        method: "POST",
        body: formData
    })
    .then(response => response.text()) // Handle the response (can be JSON or text)
    .then(data => {
        const new_value = JSON.parse(data);

        const inputField = document.getElementById(new_value.input_field);
        [...inputField.children].forEach(c => c.selected = false);
        const option = document.createElement("option");
        option.value = new_value.id;
        option.textContent = new_value.name;
        option.selected = true;
        inputField.appendChild(option);

        // Close modal
        $("#newItemModal").modal('hide');

        // Open previous modal
        if(new_value.reopen == 'true') {
            if(new_value.name.includes('publisher')) {
                $("#publisherModal").modal('show');
            } else {
                $("#creatorModal").modal('show');
            }
        }
    })
    .catch(error => {
        console.error("Error:", error);
        alert("An error occurred. Please try again.");
    });
});   