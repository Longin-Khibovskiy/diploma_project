var swiperRight = new Swiper(".swiper_right", {
    grabCursor: true,
    speed: 800,
    loop: true,
    mousewheel: {
        invert: false,
    },
    scrollbar: {
        el: ".swiper-scrollbar",
        draggable: true,
    },
    slidesPerView: 1,
    spaceBetween: 10,
    autoplay: {
        delay: 3000,
        disableOnInteraction: false
    },
    breakpoints: {
        900: {
            slidesPerView: 1,
            spaceBetween: 20,
        },
        1200: {
            slidesPerView: 1,
            spaceBetween: 20,
        },
    },
});

var swiperLeft = new Swiper(".swiper_left", {
    direction: 'horizontal',
    initialSlide: document.querySelectorAll('.swiper_left .swiper-slide').length - 1, // Старт с последнего слайда
    loop: true,
    mousewheel: {
        invert: true,
    },
    scrollbar: {
        el: ".swiper-scrollbar",
        draggable: true,
    },
    autoplay: {
        delay: 3000,
        reverseDirection: true,
        disableOnInteraction: false
    },
    grabCursor: true,
    speed: 800,
    slidesPerView: 1,
    spaceBetween: 10,
    breakpoints: {
        900: {
            slidesPerView: 1,
            spaceBetween: 20,
        },
        1200: {
            slidesPerView: 1,
            spaceBetween: 20,
        },
    },
});

document.querySelectorAll('.nav_link').forEach(link => {
    link.addEventListener('mouseover', () => {
        if (!link.classList.contains('active')) {
            document.querySelector('.nav_link.active').classList.add('no-highlight');
        }
    });
    link.addEventListener('mouseout', () => {
        document.querySelector('.nav_link.active').classList.remove('no-highlight');
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const btn = document.getElementById("button-up");
    if (window.pageYOffset > 800) btn.style.display = "block";
    else btn.style.display = "none";
    window.addEventListener("scroll", function () {
        if (window.pageYOffset > 800) btn.style.display = "block";
        else btn.style.display = "none";
    });
    btn.addEventListener("click", function (event) {
        event.preventDefault();
        window.scrollTo({top: 0, behavior: "smooth"});
    });
});

document.querySelectorAll('.dropdown-toggle').forEach(dropDownFunc);

function dropDownFunc(dropDown) {
    console.log(dropDown.classList.contains('click-dropdown'));

    if (dropDown.classList.contains('click-dropdown') === true) {
        dropDown.addEventListener('click', function (e) {
            e.preventDefault();

            if (this.nextElementSibling.classList.contains('dropdown-active') === true) {
                this.parentElement.classList.remove('dropdown-open');
                this.nextElementSibling.classList.remove('dropdown-active');

            } else {
                closeDropdown();

                this.parentElement.classList.add('dropdown-open');
                this.nextElementSibling.classList.add('dropdown-active');
            }
        });
    }

    if (dropDown.classList.contains('hover-dropdown') === true) {

        dropDown.onmouseover = dropDown.onmouseout = dropdownHover;

        function dropdownHover(e) {
            if (e.type === 'mouseover') {
                closeDropdown();
                this.parentElement.classList.add('dropdown-open');
                this.nextElementSibling.classList.add('dropdown-active');
            }
            if (e.type === 'mouseout') {
                e.target.nextElementSibling.onmouseleave = closeDropdown;
            }
        }
    }

}

window.addEventListener('click', function (e) {
    if (e.target.closest('.dropdown-container') === null) {
        closeDropdown();
    }

});

function closeDropdown() {
    document.querySelectorAll('.dropdown-container').forEach(function (container) {
        container.classList.remove('dropdown-open')
    });

    document.querySelectorAll('.dropdown-menu').forEach(function (menu) {
        menu.classList.remove('dropdown-active');
    });
}

document.querySelectorAll('.dropdown-menu').forEach(function (dropDownList) {
    dropDownList.onmouseleave = closeDropdown;
});

function scrollToSection(sectionId) {
    const section = document.querySelector(sectionId);
    if (section) {
        section.scrollIntoView({
            behavior: 'smooth',
            block: 'center'
        });
    }
}

function handleNavigation(sectionId) {
    if (window.location.pathname === '/') {
        window.location.hash = sectionId;
        scrollToSection(sectionId);
    } else {
        window.location.href = `/${sectionId}`;
    }
}

document.addEventListener('DOMContentLoaded', function () {
    if (window.location.pathname === '/' && window.location.hash) {
        scrollToSection(window.location.hash);
    }
});