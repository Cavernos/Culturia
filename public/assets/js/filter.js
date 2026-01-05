const checkBoxes = document.querySelectorAll('.filter-panel-menu .filter-checkbox')
const buttons = document.querySelectorAll('.active-filters .button')
checkBoxes.forEach((checkbox, index) => {
    checkbox.addEventListener('change', () => {
        buttons[index].classList.toggle('active', checkbox.checked);
    })
})