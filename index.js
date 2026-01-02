window.addEventListener("scroll", function () {
    var header = document.querySelector("header");
    header.classList.toggle("sticky", window.scrollY > 0);
});

document.querySelector('.navbar-menu-toggle').addEventListener('click', function () {
    document.querySelector('.side-navbar').classList.toggle('active');
});

document.querySelector('.side-navbar .close-btn').addEventListener('click', function () {
    document.querySelector('.side-navbar').classList.remove('active');
});
document.addEventListener("DOMContentLoaded", function() {
const sliders = document.querySelectorAll(".slide-track");

fetch('admin/fetch_images.php')
.then(response => response.json())
.then(data => {
    console.log("Fetched data:", data);  // Debugging
    sliders.forEach((slider) => {
        slider.innerHTML = ""; // Clear slider before adding images

        data.forEach((imagePath) => {
            const img = document.createElement("img");
            img.src = imagePath; // Assuming imagePath is the full path to the image
            img.className = "slide-item";

            // Check if image loads successfully
            img.onerror = function() {
                console.error('Image not found: ', imagePath);
            };

            slider.appendChild(img);
        });

        // Duplicate images for infinite scroll
        const slides = Array.from(slider.children);
        slides.forEach(slide => {
            const clone = slide.cloneNode(true);
            slider.appendChild(clone);
        });

        // Stop sliding on mouse enter or focus
        slider.addEventListener('mouseenter', () => {
            slider.style.animationPlayState = 'paused'; // Pauses the animation on hover
        });

        slider.addEventListener('mouseleave', () => {
            slider.style.animationPlayState = 'running'; // Resumes the animation when not hovered
        });

        slider.addEventListener('focus', () => {
            slider.style.animationPlayState = 'paused'; // Pauses the animation when focused
        });

        slider.addEventListener('blur', () => {
            slider.style.animationPlayState = 'running'; // Resumes animation when focus is lost
        });
    });
})
.catch(error => {
    console.error('Error fetching images:', error);
});
});

/*Auto typing script*/
var TxtType = function(el, toRotate, period) {
this.toRotate = toRotate;
this.el = el;
this.loopNum = 0;
this.period = parseInt(period, 10) || 2000;
this.txt = '';
this.tick();
this.isDeleting = false;
};

TxtType.prototype.tick = function() {
var i = this.loopNum % this.toRotate.length;
var fullTxt = this.toRotate[i];

if (this.isDeleting) {
this.txt = fullTxt.substring(0, this.txt.length - 1);
} else {
this.txt = fullTxt.substring(0, this.txt.length + 1);
}

this.el.innerHTML = '<span class="wrap">'+this.txt+'</span>';

var that = this;
var delta = 200 - Math.random() * 100;

if (this.isDeleting) { delta /= 2; }

if (!this.isDeleting && this.txt === fullTxt) {
delta = this.period;
this.isDeleting = true;
} else if (this.isDeleting && this.txt === '') {
this.isDeleting = false;
this.loopNum++;
delta = 500;
}

setTimeout(function() {
that.tick();
}, delta);
};

window.onload = function() {
var elements = document.getElementsByClassName('typewrite');
for (var i=0; i<elements.length; i++) {
    var toRotate = elements[i].getAttribute('data-type');
    var period = elements[i].getAttribute('data-period');
    if (toRotate) {
      new TxtType(elements[i], JSON.parse(toRotate), period);
    }
}
// INJECT CSS
var css = document.createElement("style");
css.type = "text/css";
css.innerHTML = ".typewrite > .wrap { border-right: 0.08em solid #fff}";
document.body.appendChild(css);
};
