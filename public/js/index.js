const container = document.querySelector('.container');
const loadingBar = document.querySelector('.loading-bar .progress');
const loadingContainer = document.querySelector('.loading-container');
const loadingMessage = document.querySelector('.loading-message p');
const spinWheelImage = document.querySelector('.spin-wheel-image');

function showTerms() {
    const termsModal = document.getElementById('termsModal');
    termsModal.classList.add('active');
}

function closeTerms() {
    const termsModal = document.getElementById('termsModal');
    termsModal.classList.remove('active');
}

function loadImageWithProgress(imageUrl, callback) {
    loadingContainer.style.display = 'flex';

    let progress = 0;
    const interval = setInterval(() => {
        progress += 5;
        if (progress <= 100) {
            if (loadingBar) {
                loadingBar.style.width = `${progress}%`;
            }
            if (loadingMessage) {
                loadingMessage.textContent = `${progress}%`;
            }
        } else {
            clearInterval(interval);
        }
    }, 100);

    const image = new Image();
    image.src = imageUrl;

    image.onload = function() {
        clearInterval(interval);
        if (loadingBar) {
            loadingBar.style.width = '100%';
        }
        if (loadingMessage) {
            loadingMessage.textContent = '100%';
        }

        setTimeout(() => {

            callback(image);

            // Hide the entire loading container
            if (loadingContainer) {
                loadingContainer.style.display = 'none';
            }
        }, 500);
    };
}

// Example usage:
const previewGifUrl = server_settings['previewGameGif'];
const backgroundImageGameUrl = server_settings['backgroundImageGame'];
const spinWheelImageUrl = server_settings['spinWheelImage'];

if (voucher) {
    loadImageWithProgress(backgroundImageGameUrl, (image) => {
        container.style.backgroundImage = `url('${image.src}')`;
        loadImageWithProgress(spinWheelImageUrl, (image) => {
            spinWheelImage.src = image.src;
        });
    });
} else {
    loadImageWithProgress(previewGifUrl, (image) => {
        container.style.backgroundImage = `url('${image.src}')`;
    });
}

document.addEventListener('DOMContentLoaded', function() {
    if (voucher == null) return;

    const spinButton = document.getElementById('spin-button');
    const spinWheel = document.getElementById('spin-wheel');
    const giftsContainer = document.querySelector('.surrounding-gifts-container');
    const gifts = giftsContainer.querySelectorAll('.surrounding-gift');

    // Modal elements
    const prizeModal = document.getElementById('prize-modal');
    const prizeImage = document.getElementById('prize-image');
    const prizeName = document.getElementById('prize-name');
    const prizeDesc = document.getElementById('prize-desc');

    // Function to position gifts in a circle
    function positionGifts() {
        const totalGifts = gifts.length;
        const radius = 50; // Radius in percentage
        const center = 50; // Center in percentage

        gifts.forEach((gift, index) => {
            const angle = (360 / totalGifts) * index;
            const radians = angle * Math.PI / 180;
            const x = center + radius * Math.cos(radians);
            const y = center + radius * Math.sin(radians);

            gift.style.left = `calc(${x}% - 7.5%)`; // 7.5% is half the gift's width
            gift.style.top = `calc(${y}% - 7.5%)`; // 7.5% is half the gift's height
        });
    }

    // Call the positioning function on page load
    positionGifts();

    // Handle the spin animation and prize reveal
    spinButton.addEventListener('click', function() {
        spinButton.disabled = true; // Disable the button

        // Start spinning animations
        giftsContainer.classList.add('spinning-clockwise');
        spinWheel.classList.add('spinning-counter-clockwise');

        // Stop the animation after 3 seconds
        setTimeout(() => {
            giftsContainer.classList.remove('spinning-clockwise');
            spinWheel.classList.remove('spinning-counter-clockwise');

            // Show the prize modal
            prizeImage.src = voucher.gift.image;
            prizeName.textContent = voucher.gift.name;
            // prizeDesc.textContent = voucher.description;

            prizeModal.classList.add('active');
        }, 3000); // 3 seconds
    });

    // Function to close the prize modal
    window.closePrizeModal = function() {
        prizeModal.classList.remove('active');
    };
});

document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('prizeListModal');
    const toggleButtons = document.querySelectorAll('.toggle-btn');

    toggleButtons.forEach(button => {
        button.addEventListener('click', function() {
            const categoryName = this.dataset.category;
            const content = document.querySelector(`.collapsible-content[data-category="${categoryName}"]`);

            // Toggle the 'active' class on the header and content
            this.classList.toggle('active');
            content.classList.toggle('active');
        });
    });

    // Functions to show/hide the modal
    window.showPrizeList = function() {
        modal.classList.add('active');
    };

    window.hidePrizeList = function() {
        modal.classList.remove('active');
    };
});
