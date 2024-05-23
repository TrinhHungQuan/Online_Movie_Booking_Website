let navbar = document.querySelector('.header .flex');

document.querySelector('#menu-btn').onclick = () => {
  profile.classList.remove('active');
};

let profile = document.querySelector('.header .flex .profile');

document.querySelector('#user-btn').onclick = () => {
  profile.classList.toggle('active');
};

window.onscroll = () => {
  profile.classList.remove('active');
};
