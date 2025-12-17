


class ModalBox extends HTMLElement {
    constructor() {
        super();
        this.className = "overlay"
    }
    connectedCallback() {
        if (this.initialized) return;
        this.initialized = true
        const content = this.innerHTML
        this.innerHTML = `
               
              <div class="modal">
                    <button type="button" class="button close">&times;</button>  
                    ${content}  
                </div>      
        `

        this.querySelector(".close").addEventListener("click", () => {
            this.removeAttribute("open")
        })
        this.addEventListener('click', e => {
            if(e.target.classList.contains("overlay")){
                this.close()
            }
        })


    }

    open() {
        this.setAttribute("open", "")
    }

    close() {
        this.removeAttribute("open")
    }
}
customElements.define("modal-box", ModalBox)

const register = document.getElementById("register-btn");
const modal = document.getElementById("register")
register.addEventListener("click", () => {
    modal.open()
})