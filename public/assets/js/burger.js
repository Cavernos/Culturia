
const menus = document.querySelectorAll(".order-content");
menus.forEach(menu => {
    const button = menu.previousElementSibling
    button.addEventListener('click', () => {
        menu.classList.toggle("open")
    })
})