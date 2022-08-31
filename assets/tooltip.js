let tooltipContainer;
let delay;
const longpress = 800;


const checkIfMobile = () => {
    if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)){
        return true;
      } else {
        return false;
    }
}
const createDiv = (tooltipText) => {
    tooltipContainer = document.createElement("div");
    tooltipContainer.classList.add('tooltip');
    tooltipContainer.style.setProperty('--tooltip-text',JSON.stringify(tooltipText));
    appendDivToBody(tooltipContainer);
}
const appendDivToBody = (div) => {
    document.body.appendChild(div);
}
const applyTooltipPosition = (event) => {
    if (isMobile) {
        tooltipContainer.style.setProperty('--mouse-x', event.pageX - 50 + 'px');
        tooltipContainer.style.setProperty('--mouse-y', event.pageY - 120 + 'px');
    } else {
        tooltipContainer.style.setProperty('--mouse-x', event.pageX - 0 + 'px');
        tooltipContainer.style.setProperty('--mouse-y', event.pageY - 60 + 'px');
    }
}
const setTooltipPosition = () => {
    window.addEventListener('mousemove', (event) => {
        applyTooltipPosition(event);
    });
}
const showTooltip = () => {
    const isVisible = tooltipContainer.classList.contains('visible');

    if (isVisible === false) {
        tooltipContainer.classList.add('visible');   
        setTimeout(() => {
            tooltipContainer.classList.remove('visible');   
          }, 3000)
    }
    setTooltipPosition();
}

const isMobile = checkIfMobile();
window.addEventListener("load", createDiv(tooltipText));
window.addEventListener('contextmenu', (event) => showTooltip());
window.addEventListener('dblclick', (event) => showTooltip());

window.addEventListener('mousedown', function (event) {
    function check() {
        showTooltip()
    }

    delay = setTimeout(check, longpress);
});
window.addEventListener('mouseup', function (e) {
    clearTimeout(delay);
});

if (isMobile) {
    let touchStartTimeStamp = 0;
    let touchEndTimeStamp = 0;
    
    const onTouchStart = (e) => {
      touchStartTimeStamp = e.timeStamp;
    };
    
    const onTouchEnd = (e) => {
      touchEndTimeStamp = e.timeStamp;
      let totalTimeTouch = touchEndTimeStamp - touchStartTimeStamp; 
      if (totalTimeTouch > 300) {
        showTooltip();
      }
    };
    
    window.addEventListener("touchstart", onTouchStart, false);
    window.addEventListener("touchend", onTouchEnd, false);
}

