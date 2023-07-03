import './bootstrap';


//* Layouts

document.querySelector("#navbtn").addEventListener('click', () => {
    const nav_content = document.querySelector('#nav_content');
    nav_content.classList.toggle('hidden')
});

window.addEventListener('scroll', function () {
    if (window.scrollY > 150) {
        document.querySelector('header').classList.add('sticky');
        document.querySelector('header').classList.add('shadow-md');
    }else{
        document.querySelector('header').classList.remove('sticky');
        document.querySelector('header').classList.remove('shadow-md');
    }
});
