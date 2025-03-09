const body = document.querySelector("body"),
      nav = document.querySelector("nav"),
      // modeToggle = document.querySelector(".dark-light"),
      searchToggle = document.querySelector(".searchToggle"),
      sidebarOpen = document.querySelector(".sidebarOpen"),
      siderbarClose = document.querySelector(".siderbarClose");


// js code to toggle search box
        searchToggle.addEventListener("click" , () =>{
        searchToggle.classList.toggle("active");
      });       
      
//   js code to toggle sidebar
sidebarOpen.addEventListener("click" , () =>{
    nav.classList.add("active");
});

body.addEventListener("click" , e =>{
    let clickedElm = e.target;

    if(!clickedElm.classList.contains("sidebarOpen") && !clickedElm.classList.contains("menu")){
        nav.classList.remove("active");
    }
});
// Login/signup form

const  home = document.querySelector(".home"),
  formContainer = document.querySelector(".form_container"),
  formCloseBtn = document.querySelector(".form_close"),
  signupBtn = document.querySelector("#signup"),
  loginBtn = document.querySelector("#login"),
  
  pwShowHide = document.querySelectorAll(".pw_hide"),
 formOpenBtn = document.querySelector("#form-open");
 const forgotPasswordLink = document.getElementById('forgot');
 const popupContainer = document.getElementById('popupContainer');
 const closeIcon = document.getElementById('closeIcon');
 
formOpenBtn.addEventListener("click", () => home.classList.add("show"));

pwShowHide.forEach((icon) => {
  icon.addEventListener("click", () => {
    let getPwInput = icon.parentElement.querySelector("input");
    if (getPwInput.type === "password") {
      getPwInput.type = "text";
      icon.classList.replace("uil-eye-slash", "uil-eye");
    } else {
      getPwInput.type = "password";
      icon.classList.replace("uil-eye", "uil-eye-slash");
    }
  });
});
// Function to clear form inputs
function clearFormInputs(formId) {
  var form = document.getElementById(formId);
  if (form) {
      var inputs = form.querySelectorAll('input');
      inputs.forEach(function(input) {
          input.value = ''; // Clear input value
      });
  }
}
// Close form and clear form inputs
formCloseBtn.addEventListener("click", function() {
  clearFormInputs('login-form'); 
  clearFormInputs('registration'); 
  home.classList.remove("show"); 
 
});
forgotPasswordLink.addEventListener('click', (e)=> {
  e.preventDefault();
  clearFormInputs('login-form');
  popupContainer.style.display = 'block';
});
closeIcon.addEventListener('click', (e)=> {
  e.preventDefault();
  clearFormInputs('resetForm');
  popupContainer.style.display = 'none';
});
signupBtn.addEventListener("click", (e) => {
  e.preventDefault();
   clearFormInputs('login-form');
  formContainer.classList.add("active");
 
});

loginBtn.addEventListener("click", (e) => {
  e.preventDefault();
  clearFormInputs('registration'); 
  formContainer.classList.remove("active");
  
});



jQuery(document).ready(function($){
  "use strict";
  //Scrool to top button
  $(window).scroll(function () {
    if ($(this).scrollTop() > 100) {
        $('.back-to-top').fadeIn('slow');
    } else {
        $('.back-to-top').fadeOut('slow');
    }
});
$('.back-to-top').click(function () {
    $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');
    return false;
});
//header animation
  $(".header").before($(".header").clone().addClass("animateIt"));
  $(window).on("scroll", function () {
      $("body").toggleClass("down", ($(window).scrollTop() > 80));
  }); //testimonial carousel
  
});



