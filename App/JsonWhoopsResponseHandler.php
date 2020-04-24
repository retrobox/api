<?php

namespace App;

use Whoops\Handler\Handler;
use Whoops\Exception\Formatter;

/**
 * Catches an exception and converts it to a JSON
 * response. Additionally can also return exception
 * frames for consumption by an API.
 * Adapted from the original response handler and reworked to add success key
 */
class JsonWhoopsResponseHandler extends Handler
{
    /**
     * @var bool
     */
    private bool $returnFrames = false;

    /**
     * @param bool|null $returnFrames
     * @return bool|$this
     */
    public function addTraceToOutput($returnFrames = null)
    {
        if (func_num_args() == 0) {
            return $this->returnFrames;
        }

        $this->returnFrames = (bool)$returnFrames;
        return $this;
    }

    /**
     * @return int
     */
    public function handle()
    {
        $response = [
            'success' => false,
            'errors' => [
                Formatter::formatExceptionAsDataArray(
                    $this->getInspector(),
                    $this->addTraceToOutput()
                )
            ]
        ];

        echo json_encode($response, defined('JSON_PARTIAL_OUTPUT_ON_ERROR') ? JSON_PARTIAL_OUTPUT_ON_ERROR : 0);

        return Handler::QUIT;
    }

    /**
     * @return string
     */
    public function contentType()
    {
        return 'application/json';
    }
}