<?php

namespace Modules\App\View;

use \Michelf\Markdown;

class View
{
    public static function tryApi()
    {
        $methods = array(
            'getProducts',
            'getNewProducts',
            'getArticle'
        );

        $html = '
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>API Testing</title>
            </head>
            <body>
                <h1>API Testing</h1>
                <h2>API Methods</h2>
                <ul>';

        // Перечисляем методы класса ProductAPI с полями ввода для параметров запроса
        foreach ($methods as $method) {
            $html .= '
                    <li>
                        <h3>' . $method . '</h3>
                        <label for="' . $method . '_query">Query:</label>
                        <input type="text" id="' . $method . '_query" name="' . $method . '_query">
                        <button onclick="testApi(\'' . $method . '\')">Test</button>
                        <div id="' . $method . '_response"></div>
                    </li>';
        }

        $html .= '
                </ul>
                <h2>README</h2>';

        $readme = file_get_contents(__DIR__. '/../../../readme.md');
        $readme_html = Markdown::defaultTransform($readme);

        $html .= $readme_html;

        $html .= '
                <script>
                    function testApi(method) {
                        var query = document.getElementById(method + "_query").value;
                        fetch("/" + method + "/" + encodeURIComponent(query))
                            .then(response => response.json())
                            .then(data => {
                                var responseDiv = document.getElementById(method + "_response");
                                responseDiv.innerHTML = JSON.stringify(data);
                            })
                            .catch(error => console.error("Error:", error));
                    }
                </script>
            </body>
            </html>';

        echo $html;
    }
}
