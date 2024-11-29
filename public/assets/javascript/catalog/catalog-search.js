document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.getElementById("searchBar");
    const searchTerm = searchInput.value.trim().toLowerCase();
  
    // Trigger search if the input is pre-filled
    if (searchTerm) {
        performSearch(searchTerm);
    }
    
    // Attach the input event listener
    searchInput.addEventListener("input", debounce(function () {
        performSearch(this.value.trim().toLowerCase());
    }, 300));
});

// Search function
function performSearch(searchTerm) {
    const items = document.querySelectorAll(".catalog-item");

    items.forEach(item => {
        const text = item.textContent.toLowerCase();
        if (text.includes(searchTerm)) {
            item.classList.remove("visually-hidden");
        } else {
            item.classList.add("visually-hidden");
        }
    });
}

// Debounce function to improve performance
function debounce(func, delay) {
    let timer;
    return function (...args) {
        clearTimeout(timer);
        timer = setTimeout(() => func.apply(this, args), delay);
    };
}  