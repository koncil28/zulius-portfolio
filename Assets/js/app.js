const enterBtn = document.getElementById("enterBtn");
const opening = document.getElementById("opening");
const mainContent = document.getElementById("mainContent");

enterBtn.addEventListener("click", () => {
    opening.style.opacity = "0";
    opening.style.pointerEvents = "none";

    setTimeout(() => {
        opening.style.display = "none";
        mainContent.style.opacity = "1";
    }, 1000);
});

// Reveal Animation
const reveals = document.querySelectorAll(".reveal");

window.addEventListener("scroll", () => {
    reveals.forEach((el) => {
        const windowHeight = window.innerHeight;
        const elementTop = el.getBoundingClientRect().top;
        const revealPoint = 100;

        if (elementTop < windowHeight - revealPoint) {
            el.style.opacity = "1";
            el.style.transform = "translateY(0)";
        }
    });
});

gsap.registerPlugin(ScrollTrigger);

// HERO TEXT PARALLAX
gsap.to(".hero-title", {
    y: -100,
    opacity: 0.5,
    scrollTrigger: {
        trigger: ".hero",
        start: "top top",
        end: "bottom top",
        scrub: true
    }
});

gsap.to(".hero-subtitle", {
    y: -50,
    opacity: 0,
    scrollTrigger: {
        trigger: ".hero",
        start: "top top",
        end: "bottom top",
        scrub: true
    }
});

gsap.utils.toArray("section").forEach((section) => {
    gsap.from(section, {
        opacity: 0,
        y: 100,
        duration: 1,
        ease: "power3.out",
        scrollTrigger: {
            trigger: section,
            start: "top 80%",
        }
    });
});

gsap.utils.toArray(".project img").forEach((img) => {
    gsap.from(img, {
        scale: 1.2,
        opacity: 0,
        duration: 1.2,
        ease: "power3.out",
        scrollTrigger: {
            trigger: img,
            start: "top 85%"
        }
    });
});

gsap.utils.toArray(".scene-text").forEach((text, i) => {
    gsap.to(text, {
        opacity: 1,
        scrollTrigger: {
            trigger: ".manifesto-scene",
            start: "top top",
            end: "bottom bottom",
            scrub: true,
        }
    });
});
// SCROLL INDICATOR FADE OUT
gsap.to(".scroll-indicator", {
    opacity: 0,
    scrollTrigger: {
        trigger: ".hero",
        start: "top top",
        end: "bottom top",
        scrub: true
    }
});

document.querySelector(".scroll-indicator").addEventListener("click", function(e) {
    e.preventDefault();
    document.querySelector("#manifesto").scrollIntoView({
        behavior: "smooth"
    });
});
