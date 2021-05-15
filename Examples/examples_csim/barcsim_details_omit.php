<?php

/**
 * JPGraph v4.1.0-beta.01
 */

if (empty($_GET['id'])) {
    echo 'Incorrect argument(s) to script <b>' . basename(__FILE__) . '</b>.';
} else {
    echo 'Some details on bar with id=' . $_GET['id'];
}
