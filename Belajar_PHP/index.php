<?php
$hari = date("d");


if ($hari < "10") {
    echo "awal bulan";
} else if ($hari > 20) {
    echo "makan promag";
} else {
    echo "tengah bulan";
}

echo "<br>";

$meletus = "kuning";

switch ($meletus) {
    case 'hijau':
        echo "duarrr";
        break;
    case 'kuning':
        echo "pftttt......";
        break;
    case 'kelabu':
        echo "der";
        break;
    default:
        echo "balonku masih utuh";
}

$w = 99;

while ($w <= 100) {
    echo "anda kurang promag senilai $w <br> ";
    $w++;
}

do {
    echo "promag yang harus dimakan adalah $w <br>";
    $w++;
} while ($w <= 100);

$kelas = array("satu", "dua", "tiga");
$room = ["empat", "lima", "enam"];

var_dump($kelas);

echo "<br>";
echo $kelas[1] . "<br>";

foreach ($kelas as $k) {
    echo $k . "<br>";
}

$klas = [["satu"], ["dua"], ["tiga"]];

echo $klas[1][0] . "<br>";

var_dump($klas);
