async function digestPassword(psw) {
    // encode as (utf-8) Uint8Array
    const pswUint8 = new TextEncoder().encode(psw);
    // hash the encoded password
    const hashBuffer = await crypto.subtle.digest('SHA-256', pswUint8);
    // convert buffer to byte array
    const hashArray = Array.from(new Uint8Array(hashBuffer));
    // convert bytes to string (of hexadecimal)
    const hashHex = hashArray.map(b => b.toString(16).padStart(2, '0')).join('');

    return hashHex;
}

async function accediUtil(id) {
    const text = document.getElementById(id).value;
    const hash = await digestPassword(text);
    document.getElementById(id).value = hash;
    document.getElementById('formAccedi').submit();
}

function registratiUtil(form, id, repeat) {
    form.addEventListener('submit', function(event){
        event.preventDefault();
    });

    let psw1 = document.getElementById(id);
    let psw2 = document.getElementById(repeat);

    const text = psw1.value;
    const text2 = psw2.value;

    console.log(id, ':', text);
    //psw1.value = 'Juppiter';
    //console.log(document.getElementById(id).value);
    digestPassword(psw1.value).then(hash => {
        console.log(hash);
        psw1.value = hash;
        //document.getElementById(id).value = 'Juppiter';
        console.log(psw1.value);

        digestPassword(text2).then(hash2 => {
            psw2.value = hash2;
            console.log(text2, ':', document.getElementById(repeat).value);
            
            //psw2.value = psw1.value;

            form.submit();
            console.log('fine', this);
            return true;
        });

        return false
    });

    return false;
}