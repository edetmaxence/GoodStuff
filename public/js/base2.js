const annonce = document.getElementById('annonce')
const categorie = document.getElementById('categorie')
const user = document.getElementById('user')
const edit = document.getElementById('edit')


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
