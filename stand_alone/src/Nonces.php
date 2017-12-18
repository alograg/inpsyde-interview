<?php
/**
 * This files is the main clase
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
class Nonces
{
    protected $tick = 0;
    protected $action = null;
    protected $userId = null;
    public $token = null;
    /**
     * Construcctor
     *
     * @param string|int $action Scalar value to add context to the nonce.
     * @param string|int $userId User identifier.
     */
    public function __construct($action, $userId=null)
    {
        $this->action = $action;
        $this->userId = $userId ?: session_id();
        $this->tick = self::tick();
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
     * As token
     *
     * @return string
     */
    public function __toString()
    {
        return $this->token;
    }
    /**
     * Get the time-dependent variable for nonce creation.
     *
     * A nonce has a lifespan of two ticks. Nonces in their second tick may be
     * updated, e.g. by autosave.
     *
     * @return float Float value rounded up to the next highest integer.
     */
    public static function tick()
    {
        $nonce_life = 24 * 60 * 60;
        return ceil(time() / ($nonce_life / 2));
    }

    /**
     * Generate HTML field with NonceString
     *
     * @param int|string $action  Optional. Action name. Default -1.
     * @param string     $name    Optional. Nonce name. Default '_wpnonce'.
     * @param bool       $referer Optional. Whether to set the referer field
     *                            for validation. Default true.
     * @param bool       $echo    Optional. Whether to display or return hidden form
     *                            field. Default true.
     *
     * @return string Nonce field HTML markup.
     */
    public static function field(
        $action = -1,
        $name = "_wpnonce",
        $referer = true,
        $echo = true
    ) {
        $name = strtolower(preg_replace('/\W/i', '-', $name));
        $nonce_field = '<input type="hidden" id="' . $name
                      . '" name="' . $name
                      . '" value="' . self::getToken($action)
                      . '" />';
        if ($referer) {
            $nonce_field .= Referer::field();
        }
        if ($echo) {
            echo $nonce_field;
        }
        return $nonce_field;
    }

    /**
     * Generate a Nonces and take he tocken
     *
     * @param integer $action Scalar value to add context to the nonce.
     *
     * @return string Tocken string
     */
    public static function getToken($action = -1)
    {
        $nonce = new self($action);
        return $nonce->token;
    }
    /**
     * Retrieve URL with nonce added to URL query.
     *
     * @param string            $actionUrl URL to add nonce action.
     * @param int|string|Nonces $action    Optional. Nonce action name.
     *                                     Default -1.
     * @param string            $name      Optional. Nonce name.
     *                                     Default '_wpnonce'.
     *
     * @return string Escaped URL with nonce action added.
     */
    public static function url($actionUrl, $action = -1, $name = '_wpnonce')
    {
        $actionUrl = str_replace('&amp;', '&', $actionUrl);
        $urlParts = parse_url($actionUrl);
        $hasQuery = isset($urlParts['query']);
        $query = $hasQuery ? parse_str($urlParts['query']) : [];
        $query[$name] = $action instanceof self
                      ? $action->token
                      : self::getToken($action);
        $stringQuery = http_build_query($query);
        if ($hasQuery) {
            return str_replace($urlParts['query'], $stringQuery, $actionUrl);
        }
        return str_replace(
            $urlParts['path'],
            $urlParts['path'] . '?' . $stringQuery, $actionUrl
        );
    }
    /**
     * Verify that correct nonce was used with time limit.
     *
     * The user is given an amount of time to use the token, so therefore, since the
     * UID and $action remain the same, the independent variable is the time.
     *
     * @param string     $nonce  Nonce that was used in the form to verify
     * @param string|int $action Should give context to what is taking place and be
     *                           the same when nonce was created.
     *
     * @return false|int False if the nonce is invalid, 1 if the nonce is valid and
     *                   generated between
     *                   0-12 hours ago, 2 if the nonce is valid and generated
     *                   between 12-24 hours ago.
     */
    public static function verify($nonce, $action = -1)
    {
        $nonce = (string) $nonce;
        if (empty($nonce)) {
            return false;
        }
        $rebuildNonce = new self($action);
        return hash_equals($rebuildNonce->token, $nonce);
    }
}
