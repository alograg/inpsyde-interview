<?php
/**
 * This files is an utilitie class
 *
 * PHP version 5
 *
 * @category Package
 * @package  WordPress
 * @author   Henry Isaac Galvez Thuillier <henry@alograg.me>
 * @license  http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link     https://github.com/alograg/inpsyde-interview/stand_alone
 */
namespace Alograg\Wp;

/**
 * Undocumented class
 *
 * @category Package
 * @package  WordPress
 * @author   Henry Isaac Galvez Thuillier <henry@alograg.me>
 * @license  http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link     https://github.com/alograg/inpsyde-interview/stand_alone
 */
class Referer
{
    /**
     * Generate refererfield
     *
     * @param bool $echo Optional. Whether to echo or return the referer field.
     *                   Default false.
     *
     * @return string Referer field HTML markup.
     */
    public function field($echo = false)
    {
        $referer_field = '<input type="hidden" name="_wp_http_referer" value="'
                         . preg_replace('/\W/', '-', $_SERVER['REQUEST_URI'])
                         . '" />';
        if ($echo) {
            echo $referer_field;
        }
        return $referer_field;
    }
}
