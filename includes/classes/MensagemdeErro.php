<?php
class MensagemdeErro {
    public static function programa($text) {
        exit("<span class='errorBanner'>$text</span>");
    }
}
?>