const annonce = document.getElementById('annonce')
const categorie = document.getElementById('categorie')
const user = document.getElementById('user')
const edit = document.getElementById('edit')
const menu = document.getElementById('svg')
const menuLeft = document.getElementById('menuLeft')
const secondSec = document.getElementById('secondSec')
const td = document.querySelectorAll('.td')
const admin = document.getElementById('admin')
const pagination = document.querySelector('.pagination')

    /* Gere selon la taille ecranc */ 

if (screen.width < 576) {
    menuLeft.classList.add('d-none')
   
    if(pagination) {
        pagination.classList.add('pagination-sm');
    }

    td.forEach(element => {
        element.classList.add('d-none')
    });
    
}else {
    menuLeft.classList.add('d-block')
    menuLeft.classList.remove('d-none')
}

if (screen.width < 1025 ) {
    menuLeft.classList.add('d-block')
    
}else {
    pagination.classList.remove('pagination-sm');
    menuLeft.classList.add('d-block')
    menuLeft.classList.remove('d-none')
}


/* menu burger (version mobile) */

menu.addEventListener('click', function(){
    if (menuLeft.classList.contains('d-none')) {
        menuLeft.classList.remove('d-none')
        menuLeft.classList.add('d-block')

        secondSec.classList.add('d-none')

    } else {
        menuLeft.classList.remove('d-block')
        menuLeft.classList.add('d-none')
        
        secondSec.classList.remove('d-none')
    }
})

    /* change le "HOVER" */ 

annonce.addEventListener('click', function() {
    categorie.classList.remove('now')
    user.classList.remove('now')
    annonce.classList.add('now')
    edit.classList.remove('now')

})

categorie.addEventListener('click', function() {
    annonce.classList.remove('now')
    user.classList.remove('now')
    categorie.classList.add('now')
    edit.classList.remove('now')
})

user.addEventListener('click', function() {
    categorie.classList.remove('now')
    annonce.classList.remove('now')
    user.classList.add('now')
    edit.classList.remove('now')
})
