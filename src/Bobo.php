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

    public static function flushLog()
    {
        $filename = storage_path('log/laravel.log');

        if (file_exists($filename)) {
            print "<pre>";

            print file_get_contents($filename);

            print "</pre>";

            unlink($filename);

            exit;
        }
    }

    /**
     * ヘッドラインの出力.
     *
     * @return string ヘッドラインのHTML
     */
    public static function headline()
    {
        $Parsedown = new \Parsedown();

        return $Parsedown->text(file_get_contents(resource_path('views/bobo/headline.txt')));
    }

    public static function history()
    {
        $Parsedown = new \Parsedown();

        return $Parsedown->text(file_get_contents(resource_path('views/bobo/md_history.txt')));
    }

    public static function info()
    {
        $Parsedown = new \Parsedown();

        return $Parsedown->text(file_get_contents(resource_path('views/bobo/md_info.txt')));
    }

    public static function news()
    {
        $Parsedown = new \Parsedown();

        return $Parsedown->text(file_get_contents(resource_path('views/bobo/news.txt')));
    }

    public static function version()
    {
        return file_get_contents(resource_path('views/bobo/version.txt'));
    }

    private static function makeVersion()
    {

        $history = file(resource_path('views/bobo/md_history.txt'));

        $version = preg_replace(["/.*Version/", "/\n/", "/\r/"], "", $history[0]);

        file_put_contents(resource_path('views/bobo/version.txt'), trim($version));
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

        while (count($headline) < 3 || count($outputs)) {
            $headline[] = array_shift($outputs);
        }

        file_put_contents(resource_path('views/bobo/headline.txt'), implode("\n", $headline));
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

    private static function getMdfile($path)
    {
        $texts = explode("\r\n", file_get_contents($path));
        $data = [];
        $key = '';
        foreach ($texts as $text) {
            if (substr($text, 0, 5) == '#### ') {
                if ($key) {
                    $data[] = [
                        'key' => $key,
                        'text' => implode("\n", $new_texts),
                    ];
                }
                $new_texts = [];

                $key = substr($text, 5, 10);
            }

            $new_texts[] = $text;
        }
        $data[] = [
            'key' => $key,
            'text' => implode("\n", $new_texts),
        ];

        return $data;
    }
}
