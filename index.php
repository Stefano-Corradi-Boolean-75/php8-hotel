<?php
/*
Parte 1:

Partiamo da questo array di hotel. https://www.codepile.net/pile/OEWY7Q1G

Stampare tutti i nostri hotel con tutti i dati disponibili.

Dopo aver stampato la lista in modo "grezzo", aggiungiamo Bootstrap e sistemiamo tutto in una tabella

----------

BONUS 1:

Tramite un form filtrare gli hotel in base alla disponibilità del parcheggio

BONUS 2:

Aggiungiamo un altro campo al form che permette di filtrare anche per voto

----------

Se non c’è un filtro, visualizzare come in precedenza tutti gli hotel

----------

NOTE:
Durante la correzione di questo esercizio possiamo cogliere l'occasione per evidenziare il disordine che si crea
quando abbiamo dati, logica e visualizzazione tutti nello stesso script. Si tratta di un approccio "sporco".
Questa è un'ottima occasione per introdurre le funzionalità include/require.

*/

$hotels = [

    [
        'name' => 'Hotel Belvedere',
        'description' => 'Hotel Belvedere Descrizione',
        'parking' => true,
        'vote' => 4,
        'distance_to_center' => 10.4
    ],
    [
        'name' => 'Hotel Futuro',
        'description' => 'Hotel Futuro Descrizione',
        'parking' => true,
        'vote' => 2,
        'distance_to_center' => 2
    ],
    [
        'name' => 'Hotel Rivamare',
        'description' => 'Hotel Rivamare Descrizione',
        'parking' => false,
        'vote' => 1,
        'distance_to_center' => 1
    ],
    [
        'name' => 'Hotel Bellavista',
        'description' => 'Hotel Bellavista Descrizione',
        'parking' => false,
        'vote' => 5,
        'distance_to_center' => 5.5
    ],
    [
        'name' => 'Hotel Milano',
        'description' => 'Hotel Milano Descrizione',
        'parking' => true,
        'vote' => 2,
        'distance_to_center' => 50
    ],

];

// di default l'elenco filtrato che ciclerò in pagina comprende tutto l'array
$filteredhotels =  $hotels;

//var_dump($_SERVER);

var_dump($_GET);

// MODALITA' SENZA FUNZIONI
// verifico se è presente il dato in $_GET['parking']
//if(isset($_GET['parking']) && $_GET['parking'] == 1){
// if(!empty($_GET['parking'])){
//     // 1. creare array temp dove salvare l'array tiltrato
//     $temp_hotels = [];

//     // 2. ciclare tutto l'array e pushare nell'array temp solo gli hotel che hano il parcheggio
//     foreach($filteredhotels as $hotel){
//         if($hotel['parking']) $temp_hotels[] = $hotel;
//     }

//     // 3. sostituire $filteredhotels con l'array temporaneo
//     $filteredhotels = $temp_hotels;
// }

// // se ho scelto senza parcheggio verifico l'esistenza del parametro parcking in GET e che sia però vuoto
// if(isset($_GET['parking']) && empty($_GET['parking'])){
//     // 1. creare array temp dove salvare l'array tiltrato
//     $temp_hotels = [];

//     // 2. ciclare tutto l'array e pushare nell'array temp solo gli hotel che hano il parcheggio
//     foreach($filteredhotels as $hotel){
//         if(!$hotel['parking']) $temp_hotels[] = $hotel;
//     }

//     // 3. sostituire $filteredhotels con l'array temporaneo
//     $filteredhotels = $temp_hotels;
// }

// if(!empty($_GET['vote'])){
//     $temp_hotels = [];

//     foreach($filteredhotels as $hotel){
//         // pusho l'elemento solo se il voto è >= di quello che mi arriva in GET
//         if($hotel['vote'] >= $_GET['vote']) $temp_hotels[] = $hotel;
//     }

//     $filteredhotels = $temp_hotels;
// }

// MODALITA'CON array_filter senza arrow funct

// ricevo da array_filter l'hotel che viene ciclato
// function checkParking($hotel){
//     // la funziokne di callback di un array_filter deve restituire true o false
//     // se parking è true sarà valido l'arra_filter pushando l'elemnto in $filteredhotels
//     return $hotel['parking'] == $_GET['parking'];
// }

// function checkVote($hotel){
//     // se il voto dell'hotel ciclato è >= al voto in GET la funzione restituisce true altrimenti false
//     return $hotel['vote'] >= $_GET['vote'];
// }

// if(!empty($_GET['parking']) || (isset($_GET['parking']) && empty($_GET['parking']))){
//     // array_filter(array_da_filtrare, funzione che restituisce true o false) -> NB la funzione deve essere richiamata tra apici e è lei a passare come parametro l'elemento ciclato
//     $filteredhotels = array_filter($filteredhotels, 'checkParking');
// }

// if(!empty($_GET['vote'])){
//     $filteredhotels = array_filter($filteredhotels, 'checkVote');
// }

// MODALITA'CON array_filter CON arrow funct
if(!empty($_GET['parking']) || (isset($_GET['parking']) && empty($_GET['parking']))){
    $filteredhotels = array_filter($filteredhotels, fn($hotel) => $hotel['parking'] == $_GET['parking']);
}

if(!empty($_GET['vote'])){
    $filteredhotels = array_filter($filteredhotels, fn($hotel) => $hotel['vote'] >= $_GET['vote']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>PHP Hotels</title>
</head>

<body>

    <div class="container py-4">
        <div class="row">
            <div class="col-12">
                
                <!-- con $_SERVER['PHP_SELF'] faccio puntare il form alla pagina stessa senza dovere scrivere il nome del file  -->
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get" class="row gx-3 gy-2 align-items-center">
                
               
                
                <div class="col-sm-3">
                        <input class="form-check-input" type="radio" name="parking" id="parking1" value="" >
                        <label class="form-check-label" for="parking1">
                            senza parcheggio
                        </label>
                        
                        
                        <input class="form-check-input" type="radio" name="parking" id="parking2" value="1"  >
                        <label class="form-check-label" for="parking2">
                            con parcheggio
                        </label>
                        
                    </div>

                    <div class="col-sm-3">
                        <label for="vote">Voto</label>
                        <input type="number" name="vote" id="vote">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">Cerca</button>
                        <button type="reset" class="btn btn-secondary">Annulla</button>
                    </div>
                </form>
            </div>
            <div class="col-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">Descrizione</th>
                            <th scope="col">Parcheggio</th>
                            <th scope="col">Stelle</th>
                            <th scope="col">Distanza dal centro</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($filteredhotels as $hotel): ?>
                            <tr>
                                <td><?php echo $hotel['name'] ?></td>
                                <td><?php echo $hotel['description'] ?></td>
                                <td><?php echo $hotel['parking'] ? 'Sì' : 'No' ?></td>
                                <td><?php echo $hotel['vote'] ?></td>
                                <td><?php echo $hotel['distance_to_center'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                 
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>


