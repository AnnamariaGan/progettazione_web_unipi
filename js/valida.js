function onChangeMail(){
    let mail = document.getElementById('email').value;
    
    let atIndex = mail ? mail.indexOf('@') : -1;
    if(mail && (atIndex == -1 || atIndex != mail.lastIndexOf('@') 
        || mail.indexOf('.') < atIndex) ){ 
        alert("inserire una mail valida");
    }
}