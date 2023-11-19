function clearAll() {
    // Clear input fields
    let inputFields = document.querySelectorAll('input');
    inputFields.forEach((input) => {
        input.value = '';
    });

    // Select empty option in select tags
    let selectTags = document.querySelectorAll('select');
    selectTags.forEach((select) => {
        select.selectedIndex = 0;
    });
    
    let textareas = document.querySelectorAll('textarea');
    textareas.forEach((textarea) => {
        textarea.value = '';
    });

    const srcImageDefault ="../icons/pet-profile-bg.jpg";
    let profile = document.querySelector("#profile-pic");
    profile.src = srcImageDefault;
}

// Attach the clearAll function to the button click event
let clearButton = document.querySelector('#clearAll');
clearButton.addEventListener('click', clearAll);