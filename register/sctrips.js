const password=document.getElementById('password');
const show=document.getElementById('show');
const hide=document.getElementById('hide');

show.addEventListener('click',()=>{
    show.style.display="none";
    hide.style.display="flex";
    password.type="text";
});

hide.addEventListener('click',()=>{
    hide.style.display="none";
    show.style.display="flex";
    password.type="password";
});