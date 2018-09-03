<?php
declare(strict_types=1);

namespace Paq85\Phpfoundations;

use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;

/**
 * Core things for good PHP development
 *
 * @depends symfony/debug: ^3.4
 */
final class Core
{
    /**
     * @var bool
     */
    private static $enabled = false;

    /**
     * Tells PHP to inform about all kind of errors in form of exceptions.
     * It does NOT set PHP to show errors in the output.
     * Unlike `\Symfony\Component\Debug\Debug` it does not use the `DebugClassLoader`
     *
     * Having error reporting enabled with conversion to exceptions gives you full control over your code.
     * It makes writing automatic tests easier which let's you provide much better software.
     * Many people disable error reporting in Production. IMHO it should be ENABLED on all environments.
     *
     * @see \Symfony\Component\Debug\Debug::enable
     */
    static public function convertErrors()
    {
        if (static::$enabled) {
            return;
        }

        static::$enabled = true;

        \error_reporting(E_ALL);

        if (!\in_array(PHP_SAPI, array('cli', 'phpdbg'), true)) {
            \ini_set('display_errors', '0');
            ExceptionHandler::register();
        }

        ErrorHandler::register()->throwAt(0, true);
    }
}