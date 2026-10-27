const atvetel = document.getElementById('atvetel');
const leadas = document.getElementById('leadas');
const osszeg = document.getElementById('osszeg');
const doboz = document.querySelector('.booking-card');


const napiAr = Number(doboz.dataset.ar);

function szamol() {

    if (atvetel.value !== '') {
        leadas.min = atvetel.value;
    }

    if (atvetel.value === '' || leadas.value === '') {
        osszeg.textContent = '–';
        return;
    }

    const napok = (new Date(leadas.value) - new Date(atvetel.value)) / (1000 * 60 * 60 * 24);

    if (napok <= 0) {
        osszeg.textContent = 'Hibás dátum';
        return;
    }

    const ar = napok * napiAr;
    osszeg.textContent = ar.toLocaleString('hu-HU') + ' Ft (' + napok + ' nap)';
}

atvetel.addEventListener('change', szamol);
leadas.addEventListener('change', szamol);
szamol();

