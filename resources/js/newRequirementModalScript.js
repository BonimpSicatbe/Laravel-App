// Handle the first select change (Group or Individual)
function handleFirstSelectChange(value) {
    const groupSection = document.getElementById('groupSection');
    const individualSection = document.getElementById('individualSection');

    // Show/hide the sections based on the selected value
    if (value === 'group') {
        groupSection.classList.remove('hidden');
        individualSection.classList.add('hidden');
    } else if (value === 'individual') {
        individualSection.classList.remove('hidden');
        groupSection.classList.add('hidden');
    } else {
        groupSection.classList.add('hidden');
        individualSection.classList.add('hidden');
    }
}

// Handle group change and dynamically show the target select options
function handleGroupChange(value) {
    const groupTargetSection = document.getElementById('groupTargetSection');
    const targetList = document.getElementById('selectTarget');

    groupTargetSection.classList.remove('hidden');
    targetList.innerHTML = ''; // Clear previous options

    if (value === 'course') {
        targetList.innerHTML += `<option value="course1">Course 1</option>`;
        targetList.innerHTML += `<option value="course2">Course 2</option>`;
    } else if (value === 'subject') {
        targetList.innerHTML += `<option value="subject1">Subject 1</option>`;
        targetList.innerHTML += `<option value="subject2">Subject 2</option>`;
    } else if (value === 'position') {
        targetList.innerHTML += `<option value="position1">Position 1</option>`;
        targetList.innerHTML += `<option value="position2">Position 2</option>`;
    }
}

// Handle individual change and dynamically show the people select options
function handleIndividualChange(value) {
    const peopleSection = document.getElementById('peopleSection');
    const targetPerson = document.getElementById('selectPerson');

    peopleSection.classList.remove('hidden');
    targetPerson.innerHTML = ''; // Clear previous options

    if (value === 'manager') {
        targetPerson.innerHTML += `<option value="person1">Manager 1</option>`;
        targetPerson.innerHTML += `<option value="person2">Manager 2</option>`;
    } else if (value === 'developer') {
        targetPerson.innerHTML += `<option value="person3">Developer 1</option>`;
        targetPerson.innerHTML += `<option value="person4">Developer 2</option>`;
    } else if (value === 'tester') {
        targetPerson.innerHTML += `<option value="person5">Tester 1</option>`;
        targetPerson.innerHTML += `<option value="person6">Tester 2</option>`;
    }
}
