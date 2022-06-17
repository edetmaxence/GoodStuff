const item1 = document.getElementById('item1')
const item2 = document.getElementById('item2')
const item3 = document.getElementById('item3')

const category = document.getElementById('category')
const article = document.getElementById('article')


item1.addEventListener('click', function() {
    item2.classList.remove('now')
    item3.classList.remove('now')
    item1.classList.add('now')

})

item2.addEventListener('click', function() {
    item1.classList.remove('now')
    item3.classList.remove('now')
    item2.classList.add('now')
})

item3.addEventListener('click', function() {
    item2.classList.remove('now')
    item1.classList.remove('now')
    item3.classList.add('now')
})