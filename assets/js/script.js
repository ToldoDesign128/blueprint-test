const menuToggle = document.querySelector('.menu-toggle');
const menu = document.querySelector('.header__content__menu');

menuToggle.addEventListener('click', () => {
  menu.classList.toggle('menu-open'),
  menuToggle.classList.toggle('is-open');
});