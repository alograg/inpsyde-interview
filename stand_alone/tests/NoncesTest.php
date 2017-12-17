<?php
/**
 * This filesis the main clase
 *
 * PHP version 5
 *
 * @category Package
 * @package  WordPress
 * @author   Henry Isaac Galvez Thuillier <henry@alograg.me>
 * @license  http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link     https://github.com/alograg/inpsyde-interview/stand_alone
 */
namespace Alograg\Wp\Tests;

use PHPUnit\Framework\TestCase;
use Alograg\Wp\Nonces;

/**
 * Undocumented class
 *
 * @category Package
 * @package  WordPress
 * @author   Henry Isaac Galvez Thuillier <henry@alograg.me>
 * @license  http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link     https://github.com/alograg/inpsyde-interview/stand_alone
 */
class NoncesTest extends TestCase
{
    /**
     * Test for wp_create_nonce
     *
     * @return void
     */
    public function testNoncesCreate()
    {
        $temp = new Nonces();
        return $temp instanceof Nonces;
    }
}
