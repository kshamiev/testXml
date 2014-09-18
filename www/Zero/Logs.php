<?php

/**
 * Component. Monitoring i sniatie statistiki raboty` prilozheniia.
 *
 * Profilirovanny`e danny`e po prilozheniiam:
 * - Paulzovatel`skie soobshcheniia
 * - Oshibki programmirovaniia
 * - Iscliucheniia
 * - Tai`mery` vremeni vy`polneniia
 * - Zatrachennaia pamiat`
 * - Dei`stvii` pol`zovatelia
 *
 * @package Zero.Component
 * @author Konstantin Shamiev aka ilosa <konstantin@phpzero.com>
 * @version $Id$
 * @link http://www.phpzero.com/
 * @copyright <PHP_ZERO_COPYRIGHT>
 * @license http://www.phpzero.com/license/
 */
class Zero_Logs
{
    private static $_fp = null;

    public static function Init($logFile = 'app.log')
    {
        $file_log = PATH_LOG . '/' . $logFile;
        if ( !is_dir(dirname($file_log)) )
            mkdir(dirname($file_log), 0777, true);
        self::$_fp = fopen($file_log, 'a');
    }

    /**
     * Obrabotchik oshibok dlia funktcii set_error_handler()
     *
     * @param int $code kod oshibki
     * @param string $message soobshchenie ob oshibke
     * @param string $filename fai`l v kotorom proizoshla oshibka
     * @param string $line stroka, v kotoroi` proizoshla oshibka
     * @throws ErrorException
     */
    public static function Handler_Error($code, $message, $filename, $line)
    {
        throw new ErrorException($message, $code, 0, $filename, $line);
    }

    /**
     * Obrabotchik iscliuchenii` dlia funktcii set_exception_handler()
     *
     * - '403' standartny`i` otvet na zakry`ty`i` razdel (stranitcu sai`ta)
     * - '404' standartny`i` otvet ne nai`dennogo dokumenta
     * - '500' vse ostal`ny`e kriticheskie oshibki prilozheniia libo servera
     *
     * @param Exception $exception
     */
    public static function Handler_Exception(Exception $exception)
    {
        $range_file_error = 10;

        $error = "#{ERROR_EXCEPTION} " . $exception->getMessage() . ' ' . $exception->getFile() . '(' . $exception->getLine() . ')';
        self::Error($error);
        echo $error . "\n<br>";

        $traceList = $exception->getTrace();
        array_shift($traceList);
        foreach ($traceList as $id => $trace)
        {
            if ( !isset($trace['args']) )
                continue;
            $args = [];
            $range_file_error = $range_file_error - 2;
            foreach ($trace['args'] as $arg)
            {
                if ( is_scalar($arg) )
                    $args[] = "'" . $arg . "'";
                else if ( is_array($arg) )
                    $args[] = print_r($arg, true);
                else if ( is_object($arg) )
                    $args[] = get_class($arg) . ' Object...';
            }
            $trace['args'] = join(', ', $args);
            if ( isset($trace['class']) )
                $callback = $trace['class'] . $trace['type'] . $trace['function'];
            else if ( isset($trace['function']) )
                $callback = $trace['function'];
            else
                $callback = '';
            if ( !isset($trace['file']) )
                $trace['file'] = '';
            if ( !isset($trace['line']) )
                $trace['line'] = 0;
            $error = "\t#{" . $id . "}" . $trace['file'] . '(' . $trace['line'] . '): ' . $callback . "(" . str_replace("\n", "", $trace['args']) . ");";
            self::Error($error);
            echo $error . "\n<br>";
        }
    }

    public static function Error($data)
    {
        self::_Save_File('error', $data);
        return false;
    }

    public static function Info($data)
    {
        self::_Save_File('info', $data);
        return true;
    }

    private static function _Save_File($level, $data)
    {
        fputs(self::$_fp, date('[Y-m-d H:i:s]') . "\t[" . $level . "]\t" . trim($data) . "\n");
    }

}