function ArataAboutSlider() {
    const container = document.querySelector('.about-slider-container');
    if (!container) return;

    const track = container.querySelector('.about-slider-track');
    const slides = Array.from(track.children);
    const nextButton = document.querySelector('.about-slider-nav[data-direction="next"]');
    const prevButton = document.querySelector('.about-slider-nav[data-direction="prev"]');

    if (slides.length <= 3) return; // Infinite loop doesn't make sense with too few items

    // --- Infinite Loop Setup ---
    const slidesToClone = 3;
    for (let i = 0; i < slidesToClone; i++) {
        const clone = slides[i].cloneNode(true);
        track.appendChild(clone);
    }

    let currentIndex = 0;
    let isTransitioning = false;

    function updateSlider(instant = false) {
        if (instant) {
            track.style.transition = 'none';
        }

        const slideWidth = slides[0].offsetWidth;
        const gap = parseInt(window.getComputedStyle(track).gap) || 0;
        const amountToMove = currentIndex * (slideWidth + gap);
        track.style.transform = `translateX(-${amountToMove}px)`;

        if (instant) {
            // Restore transition after the instant move
            setTimeout(() => {
                track.style.transition = '';
            }, 50);
        }
    }

    function handleNext() {
        if (isTransitioning) return;
        isTransitioning = true;
        currentIndex++;
        updateSlider();
    }

    function handlePrev() {
        if (isTransitioning) return;

        if (currentIndex === 0) {
            // Instantly jump to the end of the original slides
            isTransitioning = true;
            currentIndex = slides.length;
            updateSlider(true);

            // Then, animate to the slide before it
            setTimeout(() => {
                currentIndex--;
                updateSlider();
            }, 50);
        } else {
            isTransitioning = true;
            currentIndex--;
            updateSlider();
        }
    }

    track.addEventListener('transitionend', () => {
        isTransitioning = false;
        if (currentIndex >= slides.length) {
            // Reached the end of the cloned slides, jump back to the start
            currentIndex = 0;
            updateSlider(true);
        }
    });

    nextButton.addEventListener('click', handleNext);
    prevButton.addEventListener('click', handlePrev);

    // Initial and resize handling
    let resizeTimer;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            currentIndex = 0;
            updateSlider(true);
        }, 100);
    });

    // Initial position
    updateSlider(true);
}

// Run the slider logic
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', ArataAboutSlider);
} else {
    ArataAboutSlider();
}
