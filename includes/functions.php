<?php

/*
funció per tonar format a les temperatures, amb un sol decimal i eliminant-lo si és 0
(ex: 22.0 → 22, 22.5 → 22.5)
*/
function formatTemp($valorTemp) {
    if (!is_numeric($valorTemp)) return 'N/A';
    return rtrim(rtrim(number_format((float)$valorTemp, 1), '0'), '.');
}

/*
la funció rep una data en format Y-m-d (la que retorna un <input type="date">) 
i la converteix al format d/m/Y per mostrar-la a l’usuari. 
Si la data no és vàlida, retorna una cadena buida. */
function formatarData($data) {
    $dataFormatejada = '';
    if ($data) {
        $d = DateTime::createFromFormat('Y-m-d', $data);
        if ($d) {
            $dataFormatejada = $d->format('d/m/Y');
        }
    }
    return $dataFormatejada;
}

?>
