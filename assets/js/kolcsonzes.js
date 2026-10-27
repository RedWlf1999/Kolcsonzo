const autoSelect = document.getElementById('auto');
const atvetel = document.getElementById('atvetel');
const leadas = document.getElementById('leadas');
const extrak = document.querySelectorAll('.extra input');

const kep = document.getElementById('osszesito-kep');
const autoNev = document.getElementById('osszesito-auto');
const napokMezo = document.getElementById('osszesito-napok');
const berlesMezo = document.getElementById('osszesito-berles');
const extrakMezo = document.getElementById('osszesito-extrak');
const osszegMezo = document.getElementById('osszesito-osszeg');

function ft(szam) {
    return szam.toLocaleString('hu-HU') + ' Ft';
}


function napokSzama() {
    if (atvetel.value === '' || leadas.value === '') {
        return 0;
    }
    const egyNap = 1000 * 60 * 60 * 24;
    const napok = (new Date(leadas.value) - new Date(atvetel.value)) / egyNap;
    return napok > 0 ? napok : 0;
}

function frissit() {
    if (atvetel.value !== '') {
        leadas.min = atvetel.value;
    }

    const auto = AUTOK[autoSelect.value];
    if (auto) {
        autoNev.textContent = auto.nev;
        kep.src = '/Kolcsonzo/assets/pics/cars/' + auto.kep;
        kep.hidden = false;
    } else {
        autoNev.textContent = 'Még nincs autó kiválasztva';
        kep.hidden = true;
    }

    const napok = napokSzama();
    napokMezo.textContent = napok > 0 ? napok + ' nap' : '–';

    let extraNapi = 0;
    extrak.forEach(function (extra) {
        if (extra.checked) {
            extraNapi += Number(extra.dataset.ar);
        }
    });

    if (!auto || napok === 0) {
        berlesMezo.textContent = '–';
        extrakMezo.textContent = '–';
        osszegMezo.textContent = '–';
        return;
    }

    const berles = auto.ar * napok;
    const extraOsszesen = extraNapi * napok;

    berlesMezo.textContent = ft(berles);
    extrakMezo.textContent = ft(extraOsszesen);
    osszegMezo.textContent = ft(berles + extraOsszesen);
}

autoSelect.addEventListener('change', frissit);
atvetel.addEventListener('change', frissit);
leadas.addEventListener('change', frissit);
extrak.forEach(function (extra) {
    extra.addEventListener('change', frissit);
});

frissit();
