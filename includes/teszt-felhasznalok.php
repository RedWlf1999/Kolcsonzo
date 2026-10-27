<?php
// Teszt felhasználók, amíg nincs kész a valódi, adatbázisos bejelentkezés.
// A jelszavak titkosítva (password_hash) vannak tárolva, ahogy élesben is kell.
//   admin@admin.hu / admin
//   user@user.hu   / user

const TESZT_FELHASZNALOK = [
    [
        'email'  => 'admin@admin.hu',
        'jelszo' => '$2y$10$6RF/WXsfZEBByHYmr6.VeedMdteP8e1mHsVDqnEY/5NXt/tPKD752',
        'nev'    => 'Admin',
        'role'   => 'admin',
    ],
    [
        'email'  => 'user@user.hu',
        'jelszo' => '$2y$10$ZEEUAh1hd2WGLZiFCzxy9uAMjdQ.bu.UtkZ9rN4wxEog7Iim5bHCW',
        'nev'    => 'Teszt Elek',
        'role'   => 'user',
    ],
];

// Visszaadja a felhasználót, ha az e-mail és a jelszó stimmel, különben null-t
function tesztBelepes(string $email, string $jelszo): ?array {
    foreach (TESZT_FELHASZNALOK as $felhasznalo) {
        if (strtolower($email) === $felhasznalo['email'] && password_verify($jelszo, $felhasznalo['jelszo'])) {
            return $felhasznalo;
        }
    }
    return null;
}
