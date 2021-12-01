// Back To Top
backIcon.onclick = () => {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
}
// Fixed Header When Over Scroll
let header = document.getElementById("header__main");
window.onscroll = () => {
  if (window.pageYOffset > header.offsetTop) {
    header.classList.add("sticky");
    backIcon.style.display = "block";
  } else {
    header.classList.remove("sticky");
    backIcon.style.display = "none";
  }
};

// Toast
const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 1000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
})

// Currency Formatter
var vndfm = new Intl.NumberFormat('en-US', {
  style: 'currency',
  currency: 'VND',
});