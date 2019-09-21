<?php

class StringUtil {
    public static function convertRecursion($to_encoding, $from_encoding, $input) {
        if ($input != null) {
            $result = [];
            if(is_array($input)) {
                foreach($input as $key => $value) {
                    $result [$key] = StringUtil::convertRecursion($to_encoding, $from_encoding, $value);
                }
                return $result;
            } else if (is_string($input)) {
                return mb_convert_encoding($input, $to_encoding, $from_encoding);
            } else {
                return $input;
            }
        } else {
            return null;
        }
    }

    public static function escapeHtmlSpecialChars($encoding, $input) {
        if ($input != null) {
            $result = [];
            if(is_array($input)) {
                foreach($input as $key => $value) {
                    $result [$key] = StringUtil::escapeHtmlSpecialChars($encoding, $value);
                }
                return $result;
            } else {
                return htmlspecialchars($input, ENT_COMPAT, $encoding);
            }
        } else {
            return null;
        }
    }
}