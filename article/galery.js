document.onkeydown = keyDown;
let galery = document.getElementById('galery');
let galeryInfo = document.getElementsByClassName('galeryInfo');
let images = document.getElementsByClassName('galery_image');
let galery_position = document.getElementById('galery_position');
var position = 0;

function keyDown(e) {
   e = e || window.event;
   if (galery == null || galery.classList.contains('hidden')) {
      return;
   }
   if (e.keyCode == '37') {
      downSlide();
   }
   else if (e.keyCode == '39') {
      upSlide();
   } else if (e.keyCode == '27') {
      galeryToggle();
   }
}

function upSlide() {
   slide(1);
}

function downSlide() {
   slide(-1);
}

function galeryToggle() {
   galery.classList.toggle('hidden');
}

function galeryInfoToggle() {
   Array.from(galeryInfo).forEach(element => {
      element.classList.toggle('hidden');
   });
}

function slide(number) {

   position = position + number;
   if (position < 0) {
      position = 0;
      return;
   }
   if (position > images.length - 1) {
      position = images.length - 1;
      return;
   }
   galery_position.innerHTML = position + 1;
   Array.from(images).forEach(element => {
      element.dataset.position = Number(element.dataset.position) - number;
      element.style.setProperty('--position', element.dataset.position);
   });
}