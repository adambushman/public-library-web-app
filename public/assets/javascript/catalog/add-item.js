// Setup array of creator/publisher values
let creatorList = [...document.getElementById('creator-in').children].map(e => {
    return {id: e.value, label: e.label};
});
let publisherList = [...document.getElementById('publisher-in').children].map(e => {
    return {id: e.value, label: e.label};
});


// Enable "include-another" button
function toggleInclude(type, enabled) {
    document.getElementById(`${type}-include`).disabled = !enabled;
}

['creator', 'publisher'].forEach((d) => {
    document.getElementById(`${d}-in`).addEventListener("change", (e) => {
        toggleInclude(d, true);
    });
});

// Remove parent
function removeParent(el) {
    const label = el.parentNode.parentNode.children[0];
    const typeRaw = label.textContent.toLowerCase();
    const type = typeRaw.substring(0, typeRaw.length - 1)
    toggleInclude(type, true);

    el.parentNode.remove();
}


function includeAnother(type) {
    const container = document.getElementById(`${type}-input-fields`);
    const numSelect = container.querySelectorAll('select').length;

    const newDiv = document.createElement("div");
    ['d-flex', 'mt-2', 'gap-2'].forEach(d => newDiv.classList.toggle(d));

    const newSelect = document.createElement("select");
    newSelect.id = `${type}${numSelect + 1}-in`;
    ['form-select', 'form-select-sm'].forEach(d => newSelect.classList.toggle(d));
    newSelect.name = `${type}${numSelect + 1}`;
    newSelect.ariaLabel = `${type} input`;
    newSelect.addEventListener("change", e => toggleInclude(type, true));

    const list = type == 'publisher' ? publisherList : creatorList;
    list.forEach((l,i) => {
        const option = document.createElement("option");
        option.value = l.id;
        option.textContent = l.label;
        if(i == 0) {
            option.selected = true;
            option.disabled = false;
        }
        newSelect.appendChild(option);
    });
    
    const newButton = document.createElement("button");
    ['btn', 'btn-sm', 'btn-danger'].forEach(d => newButton.classList.toggle(d));
    newButton.innerHTML = `<i class="bi bi-x"></i>`;
    newButton.type = "button";
    newButton.addEventListener("click", e => {
        removeParent(e.target.parentNode);
    });
    
    // String together new elements
    newDiv.appendChild(newSelect);
    newDiv.appendChild(newButton);
    container.appendChild(newDiv);

    // Disable "include-another" button
    toggleInclude(type, false);
}