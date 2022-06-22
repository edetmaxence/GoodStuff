const annonce = document.getElementById('annonce')
const categorie = document.getElementById('categorie')
const user = document.getElementById('user')
const edit = document.getElementById('edit')
const menu = document.getElementById('svg')
const menuLeft = document.getElementById('menuLeft')
const secondSec = document.getElementById('secondSec')
const td = document.querySelectorAll('.td')
const admin = document.getElementById('admin')
const userColor = document.getElementById('userColor')
const userName = document.querySelectorAll('.userName')


if (screen.width < 576) {
    menuLeft.classList.add('d-none')
    td.forEach(element => {
        element.classList.add('d-none')
        userColor.classList.add('user')
        admin.classList.add('admin')
    });
    
}else {
    menuLeft.classList.add('d-block')
    menuLeft.classList.remove('d-none')
}

if (screen.width < 1025 ) {
    menuLeft.classList.add('d-block')
    userName.forEach(element => {
        element.classList.add('d-none')
    });
    
}else {
    menuLeft.classList.add('d-block')
    menuLeft.classList.remove('d-none')
}


menu.addEventListener('click', function(){
    if (menuLeft.classList.contains('d-block')) {
        menuLeft.classList.remove('d-block')
        menuLeft.classList.add('d-none')
        
        secondSec.classList.remove('d-none')
    } else {
        menuLeft.classList.add('d-block')
        menuLeft.classList.remove('d-none')
        secondSec.classList.add('d-none')
    }
})

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
