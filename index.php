<?php

function sortByPriceAscending(string $jsonString): string
{
    $data = json_decode($jsonString, true);

    array_multisort(array_column($data, 'price'), SORT_ASC, $data);

    return json_encode($data);
}

echo sortByPriceAscending('[{"name":"eggs","price":1},{"name":"coffee","price":9.99},{"name":"biscuit","price":1},{"name":"rice","price":4.04},{"name":"cracker","price":4.04}]');
