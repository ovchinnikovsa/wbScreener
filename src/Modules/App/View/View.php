<?php

namespace Modules\App\View;

use \Michelf\Markdown;

class View
{
    private static array $apiMethods = [
        'getProducts' => 'search_query',
        'getNewProducts' => 'search_query',
        'getArticle' => 'article',
    ];

    public static function tryApi()
    {
        $methods = self::drawMethodForm();
        $readme = self::parseReadme();
        require_once __DIR__ . '/testApiPage.php';
        die();
    }

    private static function drawMethodForm(): string
    {
        $html = '';
        foreach (self::$apiMethods as $method => $queryParam) {
            $html .= '<li>
                        <h3>' . $method . '</h3>
                        <form method="GET" action="/' . $method . '" target="_blank">
                            <label for="' . $queryParam . '">Query param ' . $queryParam . ':</label>
                            <input type="text" name="' . $queryParam . '">
                            <button type="submit">Test</button>
                        </form>
                    </li>';
        }
        return $html;
    }

    private static function parseReadme(): string
    {
        $html = '';
        try {
            $readme = file_get_contents(__DIR__ . '/../../../readme.md');
            $readme_html = Markdown::defaultTransform($readme);
            $indexOfSection = strpos($readme_html, '<h2>API Методы</h2>');
            $sectionHtml = substr($readme_html, $indexOfSection);
            $html .= $sectionHtml;
        } catch (\Throwable $th) {
            return $html;
        }
        return $html;
    }
}
