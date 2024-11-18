 // POP UP DE PÁGINAS/PERFiL
 const openPopupBtn = document.getElementById('openPopup');
 const popup = document.getElementById('popup');
 const closePopupBtn = document.querySelector('.popup-close');

 openPopupBtn.addEventListener('click', () => {
     popup.classList.add('show');
 });

 closePopupBtn.addEventListener('click', () => {
     popup.classList.remove('show');
 });


 /* 
 deixar esse código comentado resolve meu problema, mas é a melhor opção?
 
 window.addEventListener('click', (event) => {
     if (event.target !== popup && !popup.contains(event.target) && event.target !== openPopupBtn) {
         popup.classList.remove('show');
     }
 }); 
 */
