<?php

/**
 * Bobo.
 */

namespace Antron\Bobo;

/**
 * Bobo.
 */
class Bobo
{

    /**
     * check Log.
     *
     * @return boolean
     */
    public static function checkLog()
    {
        if (file_exists(storage_path('logs/laravel.log'))) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Flush Log.
     */
    public static function viewTempLog()
    {
        $filename = storage_path('logs/laravel.log');

        if (file_exists($filename)) {
            print "<pre>";

            print file_get_contents($filename);

            print "</pre>";

            self::accumeLog(storage_path('logs/laravel.log'));
        }
    }

    /**
     * history.
     * 
     * @return string html
     */
    public static function history()
    {
        $Parsedown = new \Parsedown();

        return $Parsedown->text(file_get_contents(resource_path('views/bobo/md_history.txt')));
    }

    public static function flushLog()
    {
        $finder = new \Symfony\Component\Finder\Finder();

        foreach ($finder->in(storage_path('logs')) as $fileinfo) {
            unlink($fileinfo->getPathname());
        }
    }

    /**
     * HeadLine.
     *
     * @return string html
     */
    public static function headline()
    {
        $Parsedown = new \Parsedown();

        return $Parsedown->text(file_get_contents(resource_path('views/bobo/headline.txt')));
    }

    /**
     * news.
     * 
     * @return string html
     */
    public static function news()
    {
        $Parsedown = new \Parsedown();

        return $Parsedown->text(file_get_contents(resource_path('views/bobo/news.txt')));
    }

    public static function update()
    {
        self::makeVersion();

        $outputs = [];

        foreach (self::getCompare() as $compare) {
            $outputs[] = $compare['text'];
        }
        file_put_contents(resource_path('views/bobo/news.txt'), implode("\n", $outputs));

        $headline = [];

        while (count($headline) < 3 && count($outputs)) {
            $headline[] = array_shift($outputs);
        }

        file_put_contents(resource_path('views/bobo/headline.txt'), implode("\n", $headline));
    }

    /**
     * Version.
     * 
     * @return type
     */
    public static function version()
    {
        return file_get_contents(resource_path('views/bobo/version.txt'));
    }

    /**
     * Accume.
     * 
     * @param string $path
     */
    private static function accumeLog($path)
    {
        if (file_exists($path)) {
            $logs = file_get_contents($path);

            $newpath = str_replace('.log', '_all.log', $path);

            file_put_contents($newpath, $logs, FILE_APPEND | LOCK_EX);

            unlink($path);
        }
    }

    private static function makeVersion()
    {

        $history = file(resource_path('views/bobo/md_history.txt'));

        $version = preg_replace(["/.*Version/", "/\n/", "/\r/"], "", $history[0]);

        file_put_contents(resource_path('views/bobo/version.txt'), trim($version));
    }

    private static function getCompare()
    {

        $md_info = self::getMdfile(resource_path('views/bobo/md_info.txt'));

        $md_history = self::getMdfile(resource_path('views/bobo/md_history.txt'));

        $compares = [];

        while (count($md_info) && count($md_history)) {
            if ($md_info[0]['key'] > $md_history[0]['key']) {
                $compares[] = array_shift($md_info);
            } else {
                $compares[] = array_shift($md_history);
            }
        }

        while (count($md_info)) {
            $compares[] = array_shift($md_info);
        }

        while (count($md_history)) {
            $compares[] = array_shift($md_history);
        }

        return $compares;
    }

    /**
     * マークダウンのテキストを配列化.
     * 「#### 2017/01/16 Version 1.1.2」から「2017/01/16」を抜き出して配列化する。
     * 
     * @param type $path
     * @return type
     */
    private static function getMdfile($path)
    {
        $texts = explode("\r\n", file_get_contents($path));

        $data = [];

        $lines = [];

        $day_old = self::getDay($texts[0]);

        foreach ($texts as $text) {
            $day_new = self::getDay($text);

            if ($day_new && $day_old && $day_new <> $day_old) {
                $data[] = self::_setData($day_old, $lines);

                $lines = [];

                $day_old = $day_new;
            }

            $lines[] = $text;
        }

        $data[] = self::_setData($day_old, $lines);

        return $data;
    }

    private static function _setData($day_old, $lines)
    {
        return [
            'key' => $day_old,
            'text' => implode("\n", $lines),
        ];
    }

    private static function getDay($text)
    {
        if (substr($text, 0, 5) == '#### ') {
            return substr($text, 5, 10);
        } else {
            return '';
        }
    }

}
