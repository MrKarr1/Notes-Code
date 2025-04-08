

const banner_cook = document.querySelector('#banner_cook')

cookie();

document.querySelector('#accepter-cookie').addEventListener('click', () => {
    // console.log('click');
    localStorage.setItem('consentement cookie', 'accepter')
    banner_cook.classList.add('cookie-none');
    cookie();
})

function cookie() {
    if (!window.localStorage.getItem('consentement cookie', 'accepter')) {
        banner_cook.classList.remove('cookie-none');
    } else {
        banner_cook.classList.add('cookie-none');
    }
}
