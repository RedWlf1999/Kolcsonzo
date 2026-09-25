const pw = document.getElementById('password');
const pw2 = document.getElementById('password2');

function pwKriteriumok(){
    const ertek = pw.value;
    if(ertek.length < 8){
        pw.setCustomValidity('A jelszónak legalább 8 karakterből kell állnia');
    }
    else if(!/[0-9]/.test(ertek)){
        pw.setCustomValidity('A jelszónak tartalmaznia kell legalább egy számot.');
    }
    else if(!/[!@#$%&*?._-]/.test(ertek)){
        pw.setCustomValidity('A jelszónak tartalmaznia kell legalább egy speciális karaktert (pl. ! ? @ #).');
    }
    else{
        pw.setCustomValidity('');
    }
}

function pwEllenorzes(){
    if(pw2.value === ''){
        pw2.setCustomValidity('');
    }
    else if(pw2.value !== pw.value){
        pw2.setCustomValidity('A két jelszó nem egyezik!');
    }
    else{
        pw2.setCustomValidity('');
    }
}


pw.addEventListener('input', pwKriteriumok);

pw.addEventListener('input', pwEllenorzes);
pw2.addEventListener('input', pwEllenorzes);


