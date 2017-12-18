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
class Hash
{
    /**
    * Codifi data
    *
    * @param string $data
    * @param string $salt
    * @return string
    */
    public static function forapplyTo($data, $salt)
    {
        return hash_hmac('md5', $data, $salt);
    }
}
