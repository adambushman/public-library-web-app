<?php

function formatISBN($isbn) {
    return preg_replace('/(\d{3})(\d{1})(\d{5})(\d{3})(\d{1})/', '$1-$2-$3-$4-$5', $isbn);
} 