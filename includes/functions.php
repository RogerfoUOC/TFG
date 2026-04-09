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

<script>
    // funció per als botons "Avui" i "Ahir" de la pàgina historic.php i log.php
    function getAhir(){      
        // calcula la data d'ahir
        const avui = new Date();
        const ahir = new Date(avui);
        ahir.setDate(avui.getDate() - 1);
        
        // formata la data a dd/mm/yyyy
        const dia = String(ahir.getDate()).padStart(2, '0');
        const mes = String(ahir.getMonth() + 1).padStart(2, '0');
        const any = ahir.getFullYear();
        const dataAhir = `${any}-${mes}-${dia}`; // format correcte: YYYY-MM-DD   
        document.getElementById("inputData").value = dataAhir;
    }

    function getAvui(){
        // agafa la data d'avui
        const avui = new Date();
        
        // formata la data a dd/mm/yyyy
        const dia = String(avui.getDate()).padStart(2, '0');
        const mes = String(avui.getMonth() + 1).padStart(2, '0');
        const any = avui.getFullYear();
        const dataAvui = `${any}-${mes}-${dia}`;  // format correcte: YYYY-MM-DD        
        document.getElementById("inputData").value = dataAvui;
    }

    // funció per als botons "Avui i Ahir" de la pàgina comparar.php
    function setDatesRapides(){ 
        const avui = new Date();
        const ahir = new Date(avui);
        ahir.setDate(avui.getDate() - 1);
        
        // format YYYY-MM-DD
        const formatData = (date) => {
            const dia = String(date.getDate()).padStart(2, '0');
            const mes = String(date.getMonth() + 1).padStart(2, '0');
            const any = date.getFullYear();
            return `${any}-${mes}-${dia}`;
        };

        // aplica la data d'Avui i Ahir als camps
        document.getElementById("inputData1").value = formatData(avui);
        document.getElementById("inputData2").value = formatData(ahir);
    }
</script>