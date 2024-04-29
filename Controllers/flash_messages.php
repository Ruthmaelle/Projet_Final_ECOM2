<?php

function flash($name = '', $message = '', $class = 'alert alert-success') {
    if (!empty($name)) {
        if (!empty($message) && empty($_SESSION[$name])) {
            if (!empty($_SESSION[$name])) {
                unset($_SESSION[$name]);
            }

            $_SESSION[$name] = $message;
            $_SESSION[$name . '_class'] = $class;
        } elseif (empty($message) && !empty($_SESSION[$name])) {
            $class = !empty($_SESSION[$name . '_class']) ? $_SESSION[$name . '_class'] : 'alert alert-success';
            if (is_array($_SESSION[$name])) {
                $messageToDisplay = implode(' ', $_SESSION[$name]);
            }else{
                $messageToDisplay = $_SESSION[$name];
            }
            echo '<div class="' . $class . '" id="msg-flash">' . htmlspecialchars($messageToDisplay) . '</div>';
            unset($_SESSION[$name]);
            unset($_SESSION[$name . '_class']);
        }
    }
}
?>
