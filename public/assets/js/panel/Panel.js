class Panel {
    constructor(container) {
        this.buttons = document.querySelectorAll(`.panel-button`)
        this.tabs = document.querySelectorAll(`.panel-element`)
        this.storageKey = container + "-active-tab";
        this.init()

    }

    init() {
        const savedIndex = localStorage.getItem(this.storageKey)
        if (savedIndex !== null) {
            const index = parseInt(savedIndex)
            if(!isNaN(index) && index  >= 0 && index < this.buttons.length) {
                this.active(index)
            }

        }
        this.buttons.forEach((button, index) => {
            button.addEventListener('click', () => {
                this.active(index);
                localStorage.setItem(this.storageKey, index.toString())
            })
            }
        )
    }

    active(index){
        this.buttons.forEach(button => button.classList.remove("active"))
        this.tabs.forEach(tab => tab.classList.remove("active"))
        this.buttons[index].classList.add("active")
        this.tabs[index].classList.add("active")

    }


}
window.onload = ()=> {
    new Panel("panel")
}

