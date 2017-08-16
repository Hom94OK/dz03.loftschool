<?php

// TASK1
function task1()
{
    $xmlPath = 'xml/data.xml';
    $xml = simplexml_load_file($xmlPath);

    foreach ($xml->Address as $value) {
        echo '<div class="inline-block">';
        echo '<h2>' . $value->attributes() . '</h2>';
        echo '<table>';
        echo '<tr>';
        foreach ($value as $key => $item) {
            echo '<th>' . $key . '</th>';
        }
        echo '</tr>';
        echo '<tr>';
        foreach ($value as $item) {
            echo '<td>' . $item . '</td>';
        }
        echo '</tr>';
        echo '</table>';
        echo '</div>';
    }

    echo '<h3>DeliveryNotes' . '</h3><br>';
    echo $xml->DeliveryNotes;

    echo '<h2>order</h2>';
    foreach ($xml->Items->Item as $item) {
        echo '<div class="inline-block">';
        echo '<h2>' . $item->attributes() . '</h2>' . '<br>';
        echo '<table>';
        echo '<tr>';
        foreach ($item as $key => $value) {
            echo '<th>' . $key . '</th>';
        }
        echo '</tr>';
        echo '<tr>';
        foreach ($item as $value) {
            echo '<td>' . $value . '</td>';
        }
        echo '<tr>';
        echo '</table>';
        echo '</div>';
    }
}

function task2()
{
    // 1
    $jsonPath = 'json/output.json';
    $jsonPath2 = 'json/output2.json';
    $data = [
        "countries" => [
            "Россия" => [
                "0" => "Москва",
                "1" => "Санкт-Петербург",
                "2" => "Новосибирск"
            ],
            "США" => [
                "0" => "Нью-Йорк",
                "1" => "Лос-Анджелес",
                "2" => "Чикаго"
            ]
        ]
    ];
    $jsonString = json_encode($data);
    file_put_contents($jsonPath, $jsonString);

    // 2
    $random_bol = rand(0, 1);
    $jsonFile = file_get_contents($jsonPath);
    $jsonArray = json_decode($jsonFile, true);
    $jsonArray['countries']['Испания'] = [
        "0" => "Мадрид",
        "1" => "Барселона",
        "2" => "Валенсия"
    ];
    if ($random_bol) {
        file_put_contents('json/output2.json', json_encode($jsonArray));
    } else {
        file_put_contents('json/output2.json', $jsonFile);
    }

    // 3
    $jsonFile = file_get_contents($jsonPath);
    $jsonFile2 = file_get_contents($jsonPath2);
    $jsonFile_dec = json_decode($jsonFile, true);
    $jsonFile2_dec = json_decode($jsonFile2, true);
    if ($jsonFile_dec == $jsonFile2_dec) {
        echo ' Файлы одинаковые';
    } else {
        echo '<pre>';
        $result = array_diff_assoc($jsonFile2_dec['countries'], $jsonFile_dec['countries']);
        print_r($result);
    }
}

function task3()
{
    // 1
    $csvPath = "csv/table.csv";
    $file_openCSV = fopen($csvPath, "w");
    $data = [];
    for ($i = 0; $i <= 50; $i++) {
        $data[$i] = rand(1, 100);
    }
    echo '<pre>';
    print_r($data);

    // 2
    fputcsv($file_openCSV, $data, ';'); // defoult , exel ;
    fclose($file_openCSV);

    // 3
    $file_openCSV = fopen($csvPath, "r");
    $csvData = fgetcsv($file_openCSV, '', ";");
    $i = 0;
    $sum = 0;
    foreach ($csvData as $key => $value) {
        if (!($csvData[$i] % 2)) {
            $sum++;
        }
        $i++;
    }
    echo "<br>В CSV файле $sum парных числа";
}

function task4()
{
    $url = "https://en.wikipedia.org/w/api.php?action=query&titles=Main%20Page&prop=revisions&rvprop=content&format=json";
    $curl = curl_init($url);

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);

    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    $result = curl_exec($curl);
    curl_close($curl);

    $result_decode = json_decode($result, true);

    $page_id = $result_decode['query']['pages']['15580374']['pageid'];
    $title = $result_decode['query']['pages']['15580374']['title'];

    echo 'page_id - ' . $page_id . '<br>' . 'title - ' . $title;
}
