<?php
namespace App\Lib;

use Log;

class StopWatch {
	/**
    * @var $timers array
    *  each element has key = timer Name
    *  and
    *   '1' = start time
    *   '2' = elapsed time
    *  Example: $timers['namea'][1] = 1503008567.2913
    *           $timers['namea'][2] = 1.0001149  <--- elapsed seconds
    *           $timers['namea'][3] = Boolean to indicated timer stopped
	*/
	private static $timers = array();
	/**
	* Start the timer
	*
	* @param $timerName string The name of the timer
	* @return void
	*/
	public static function start($timerName = 'default')
	{
		self::$timers[$timerName]['1'] = microtime(true);
	}
	/**
	 * Stop the specified timer
	 * @param  string $timerName [description]
	 * @return float   elapsed time since start() was called
	 */
	public static function stop($timerName = 'default')
	{
        $elapsed = self::elapsed($timerName);
        if (!isset(self::$timers[$timerName]['3'])) {
            self::$timers[$timerName]['2'] = $elapsed;
            self::$timers[$timerName]['3'] = true;
        }
		return self::formatPeriod(self::$timers[$timerName]['2']);
	}
	/**
	* Get the elapsed time in seconds
	*
	* @param $timerName string The name of the timer
	* @return float The elapsed time since start() was called
	*/
	public static function elapsed($timerName = 'default')
	{
        return microtime(true) - self::$timers[$timerName]['1'];
	}

  /**
   * Return all of the timers elapsed times
   *
   */
	public static function show($log=false,$description='')
	{
		$all = [];
        if(!empty($description)) {
            $description .= ": ";
        }
	  	foreach(self::$timers as $k=>$v)
		{
		 	if(isset($v['2'])) {
			  $all[$k] = self::formatPeriod($v['2']);
			} else {
			   $all[$k] = -1;
			}
            if ($log) {
                Log::info('StopWatch '. $description . "|". $k . "|". $all[$k]);
            }
            unset(self::$timers[$k]);
		}
		return $all;
	}

    /**
     * Remove all timers
     * @return [type] [description]
     */
    public static function clear()
    {
        foreach(self::$timers as $k=>$v)
        {
            unset(self::$timers[$k]);
        }
    }

    private static function formatPeriod($duration)
    {
        $hours =  (int) ($duration / 60 / 60);
        $minutes = (int) ($duration / 60) - $hours * 60;
        $seconds = round($duration - $hours * 60 * 60 - $minutes * 60, 3);
        return ($hours == 0 ? "00":$hours) . ":" .
                ($minutes == 0 ? "00":($minutes < 10? "0".$minutes:$minutes)) . ":" .
                ($seconds == 0 ? "00":($seconds < 10? "0".$seconds:$seconds));
    }
}