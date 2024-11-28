[...document.querySelectorAll('.slot-item')].forEach(d => {
    d.addEventListener("click", e => {
        const data = {...e.target.dataset};
        console.log(data);
        document.getElementById("calendarModalLabel").textContent = data.libTitle;
        document.getElementById("dtmVal").innerHTML = data.libDtm;
        document.getElementById("roomVal").textContent = `${data.libRoom} Room`;
        
        const path = data.libType == 'Class' ? 'view-class.php?classId=' : 'view-event.php?eventId=';
        document.getElementById("learnMore").href = `${path}${data.libId}`;
        
        $("#calendarModal").modal('show');
    });
});

const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))