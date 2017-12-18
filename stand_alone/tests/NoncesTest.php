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
use Alograg\Wp\Hash;

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
    protected $tick = 0;
    protected $action = null;
    protected $userId = null;
    protected $instanceId = null;
    protected $token = null;
    /**
     * Check if a string is a valid html
     *
     * @param string $string String to evaluate
     *
     * @return bool If pass a evaluation of XML validation
     */
    public static function validHtml($string)
    {
        $start = strpos($string, '<');
        $end  = strrpos($string, '>', $start);
        $len=strlen($string);
        if ($end !== false) {
            $string = substr($string, $start);
        } else {
            $string = substr($string, $start, $len-$start);
        }
        libxml_use_internal_errors(true);
        libxml_clear_errors();
        $xml = simplexml_load_string($string);
        $errors = libxml_get_errors();
        $isValid = 0 == count($errors);
        if (!$isValid) {
            fwrite(STDERR, PHP_EOL . print_r($string, true));
            fwrite(STDERR, PHP_EOL . print_r($errors, true));
        }
        return $isValid;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->action ='test';
        $this->nonce = new Nonces($this->action);
        $this->userId = session_id();
        $this->tick = ceil(time() / (24 * 60 * 60 / 2));
        $this->token = substr(
            Hash::forapplyTo(
                implode(
                    '|',
                    [
                      $this->tick,
                      $this->action,
                      $this->userId,
                      ]
                ),
                'nonce'
            ),
            -12,
            10
        );
    }
    /**
     * Test for Create Nonce
     *
     * @return void
     */
    public function testNoncesCreate()
    {
        $this->assertInstanceOf(
            Nonces::class,
            $this->nonce
        );
    }
    /**
     * Test tocken
     *
     * @return void
     */
    public function testToken()
    {
        $this->assertEquals($this->token, (string) $this->nonce);
    }
    /**
     * Test if the field is a valid html
     *
     * @return void
     */
    public function testField()
    {
        $_SERVER['REQUEST_URI'] = 'php.unit.test/nonce/';
        $this->assertTrue(
            self::validHtml(
                '<div>' . Nonces::field(
                    $this->action,
                    'field',
                    true,
                    false
                ) .'</div>'
            )
        );
    }
    /**
     * Test ifthe url append a noce var
     *
     * @return void
     */
    public function testUrl()
    {
        $url ='test/url.html';
        $nonceUrl = Nonces::url($url, $this->nonce);
        $this->assertEquals(
            $url . '?_wpnonce=' . $this->token,
            $nonceUrl
        );
    }
    /**
     * Test the validation of a tocken
     *
     * @return void
     */
    public function testValidate()
    {
        $this->assertTrue(Nonces::verify($this->token, $this->action));
    }
}
