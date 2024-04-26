const parallax_el = document.querySelectorAll(".parallax");

let xValue = 0,
    yValue = 0;
let rotateDegree = 0;

function update(cursorPostion) { 
    parallax_el.forEach((el) => {
        let speedx = el.dataset.speedx;
        let speedy = el.dataset.speedy;
        let speedz = el.dataset.speedz;
        let rotateSpeed = el.dataset.rotation;

        let isInLeft = parseFloat(getComputedStyle(el).left) < window.innerWidth / 2 ? 1 : -1;

        let zValue = (cursorPostion - parseFloat(getComputedStyle(el).left)) * isInLeft * 0.1;

        el.style.transform = `translateX(calc(-50% + ${-xValue * speedx}px)) translateY(calc(-50% + ${-yValue * speedy}px)) perspective(2300px) rotateY(${rotateDegree * rotateSpeed}deg) translateZ(${zValue * speedz}px)`;
    })
}
update(0);
window.addEventListener("mousemove", (e) => {
    xValue = e.clientX - window.innerWidth / 2;
    yValue = e.clientY - window.innerHeight /2;
    
    rotateDegree = (xValue / (window.innerWidth / 2)) * 20;
    update(e.clientX);
})
 

/*GSAP ANIMATION*/
    
let timeline = gsap.timeline();
timeline.from(
    ".text h2",
    {
        y: window.innerHeight - document.querySelector(".text h1").getBoundingClientRect().top,
        duration:2,
        opacity:0,
    },
    "2.5"
)
.from(
    ".text h1",
    {
        y: -150,
        duration:1.5,
        opacity:0,
    },
    "3"
)