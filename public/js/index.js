const eventForm = document.getElementById('eventForm');
const eventList = document.getElementById('eventList');

// Function to add a new event to the list
function addEvent(event) {
    event.preventDefault();

    const eventName = document.getElementById('eventName').value;
    const eventDate = document.getElementById('eventDate').value;
    const eventDescription = document.getElementById('eventDescription').value;
    const eventImage = document.getElementById('eventImage').files[0];

    const eventItem = document.createElement('div');
    eventItem.classList.add('event-item');

    const reader = new FileReader();
    reader.onload = function(e) {
        const imageSrc = e.target.result;

        eventItem.innerHTML = `
            <img src="${imageSrc}" alt="Event Image">
            <div>
                <h3>${eventName}</h3>
                <p>${eventDate}
                <p>${eventDescription}</p>
            </div>
        `;

        eventList.appendChild(eventItem);
    };

    if (eventImage) {
        reader.readAsDataURL(eventImage);
    } else {
        // If no image is uploaded, just display the event without an image
        eventItem.innerHTML = `
            <div>
                <h3>${eventName}</h3>
                <p>${eventDate}
                <p>${eventDescription}</p>
            </div>
         `;
        eventList.appendChild(eventItem);
    }
    // Clear form
    eventForm.reset();
}

// Event listener for form submission
eventForm.addEventListener('submit', addEvent);

