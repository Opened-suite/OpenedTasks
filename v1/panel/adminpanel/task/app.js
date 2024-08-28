let elementswrapper = document.getElementsByClassName("element-wrapper");
let progress = document.getElementsByClassName("box-progress-wrapper");


function passToList() {
    
    for (let i = 0; i < elementswrapper.length; i++) {
        elementswrapper[i].classList.add("project-line-wrapper");
        elementswrapper[i].classList.remove("project-box-wrapper");

        
    }

    for (let i = 0; i < progress.length; i++) {
        progress[i].classList.remove("box-progress-wrapper");
    }
}
