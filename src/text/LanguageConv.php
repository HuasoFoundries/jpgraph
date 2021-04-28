<?php

/**
 * JPGraph - Community Edition
 */

namespace Amenadiel\JpGraph\Text;

use Amenadiel\JpGraph\Util;
use function iconv;

/**
 * @class LanguageConv
 * // Description:
 * // Converts various character encoding into proper
 * // UTF-8 depending on how the library have been configured and
 * // what font family is being used
 */
class LanguageConv
{
    private $g2312;

    public function Convert($aTxt, $aFF)
    {
        if (Configs::getConfig('LANGUAGE_GREEK')) {
            if (Configs::getConfig('GREEK_FROM_WINDOWS')) {
                $unistring = self::gr_win2uni($aTxt);
            } else {
                $unistring = self::gr_iso2uni($aTxt);
            }

            return $unistring;
        }

        if (Configs::getConfig('LANGUAGE_CYRILLIC')) {
            if (Configs::getConfig('CYRILLIC_FROM_WINDOWS')
                && \mb_stristr(Configs::getConfig('LANGUAGE_CHARSET'), 'windows-1251')) {
                $aTxt = \convert_cyr_string($aTxt, 'w', 'k');
            }

            if (\mb_stristr(Configs::getConfig('LANGUAGE_CHARSET'), 'koi8-r')
                || \mb_stristr(Configs::getConfig('LANGUAGE_CHARSET'), 'windows-1251')) {
                $isostring = \convert_cyr_string($aTxt, 'k', 'i');
                $unistring = self::iso2uni($isostring);
            } else {
                $unistring = $aTxt;
            }

            return $unistring;
        }

        if (Configs::getConfig('FF_SIMSUN') === $aFF) {
            // Do Chinese conversion
            if (null === $this->g2312) {
                $this->g2312 = new GB2312toUTF8();
            }

            return $this->g2312->gb2utf8($aTxt);
        }

        if (Configs::getConfig('FF_BIG5') === $aFF) {
            if (!\function_exists('iconv')) {
                Util\JpGraphError::RaiseL(25006);
                //('Usage of Configs::FF_CHINESE (Configs::FF_BIG5) font family requires that your PHP setup has the iconv() function. By default this is not compiled into PHP (needs the "--width-iconv" when configured).');
            }

            return \iconv('BIG5', 'UTF-8', $aTxt);
        }

        if (Configs::getConfig('ASSUME_EUCJP_ENCODING')
            && (Configs::getConfig('FF_MINCHO') === $aFF
                || Configs::getConfig('FF_GOTHIC') === $aFF
                || Configs::getConfig('FF_PMINCHO') === $aFF
                || Configs::getConfig('FF_PGOTHIC') === $aFF)) {
            if (!\function_exists('mb_convert_encoding')) {
                Util\JpGraphError::RaiseL(25127);
            }

            return \mb_convert_encoding($aTxt, 'UTF-8', 'EUC-JP');
        }

        if (Configs::getConfig('FF_DAVID') === $aFF
            || Configs::getConfig('FF_MIRIAM') === $aFF
            || Configs::getConfig('FF_AHRON') === $aFF) {
            return self::heb_iso2uni($aTxt);
        }

        return $aTxt;
    }

    // Translate iso encoding to unicode
    public static function iso2uni($isoline)
    {
        $uniline = '';

        for ($i = 0; \mb_strlen($isoline) > $i; ++$i) {
            $thischar = \mb_substr($isoline, $i, 1);
            $charcode = \ord($thischar);
            $uniline .= (175 < $charcode) ? '&#' . (1040 + ($charcode - 176)) . ';' : $thischar;
        }

        return $uniline;
    }

    // Translate greek iso encoding to unicode
    public static function gr_iso2uni($isoline)
    {
        $uniline = '';

        for ($i = 0; \mb_strlen($isoline) > $i; ++$i) {
            $thischar = \mb_substr($isoline, $i, 1);
            $charcode = \ord($thischar);
            $uniline .= (179 < $charcode && 183 !== $charcode && 187 !== $charcode && 189 !== $charcode) ? '&#' . (900 + ($charcode - 180)) . ';' : $thischar;
        }

        return $uniline;
    }

    // Translate greek win encoding to unicode
    public static function gr_win2uni($winline)
    {
        $uniline = '';

        for ($i = 0; \mb_strlen($winline) > $i; ++$i) {
            $thischar = \mb_substr($winline, $i, 1);
            $charcode = \ord($thischar);

            if (161 === $charcode || 162 === $charcode) {
                $uniline .= '&#' . (740 + $charcode) . ';';
            } else {
                $uniline .= ((183 < $charcode && 187 !== $charcode && 189 !== $charcode) || 180 === $charcode) ? '&#' . (900 + ($charcode - 180)) . ';' : $thischar;
            }
        }

        return $uniline;
    }

    public static function heb_iso2uni($isoline)
    {
        $isoline = \hebrev($isoline);
        $o = '';

        $n = \mb_strlen($isoline);

        for ($i = 0; $i < $n; ++$i) {
            $c = \ord(\mb_substr($isoline, $i, 1));
            $o .= (223 < $c) && (251 > $c) ? '&#' . (1264 + $c) . ';' : \chr($c);
        }

        return \utf8_encode($o);
    }
}
