class Modal extends HTMLElement {
    constructor() {
        super()
        this.className = "overlay"
    }

    connectedCallback() {
        this.render()
        if(this.initialized) return
        this.initialized = true
        this.querySelector(".close").addEventListener("click", () => {
            this.close()
        })
        this.addEventListener("click", (e) => {
            if(e.target.classList.contains("overlay")) {
                this.close()
            }
        })

    }
    render() {
        const content = this.innerHTML
        this.innerHTML =`
           
             <div class="modal">
                   <button type="button" class="button close">&times;</button>
                   ${content}
            </div>
        `
    }

    open() {
        this.setAttribute("open", "")
    }
     close() {
        this.removeAttribute("open")
     }
}
customElements.define("modal-box", Modal)
const modal_buttons = document.querySelectorAll("[for-modal]")

modal_buttons.forEach((button) => {
    button.addEventListener("click", (e) => {
        document.getElementById(button.getAttribute("for-modal")).open()
    })
})