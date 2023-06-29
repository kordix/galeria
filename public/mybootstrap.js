document.querySelector('#navbarDropdownMenuLink').addEventListener('click', function(){
    document.querySelector('#navbardropdownmenu').classList.toggle('show');
})

document.querySelector('.navbar-nav').querySelector(`a[href="${window.location.pathname}"]`).classList.add('active');

document.querySelector('#hamburger').addEventListener('click', function(){
    document.querySelector('.navbar-collapse').classList.toggle('show');    

})

function showToast(){
    document.querySelector('#liveToast').classList.remove('hide');
    setTimeout(()=>{ hideToast()},5000);
    // document.querySelector('#liveToast').style.opacity = 1;
}

function hideToast(){
    document.querySelector('#liveToast').classList.add('hide');
    // document.querySelector('#liveToast').style.opacity = 0;
}