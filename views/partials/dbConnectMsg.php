<?php

require_once '../../config/dbauth.php';

function testConnect() {
    try {
        $conn = connect();
        return "<p>DB connected 👍</p>";
    } catch ( \Throwable $e ) {
        return "<p>DB <i>NOT</i> connected 👎</p>";
    }
}
