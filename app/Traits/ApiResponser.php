<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * @author Mohammad.Y
 * @author Mohammad.Y <mhd.yari021@gmail.com>
 */
trait ApiResponser
{
    /**
     * Show response data
     * @author Mohammad.Y
     * @param array $data
     * @param int $code
     * @return array
     */
    private function successResponse($data, $code)
    {
        return response()->json([$data, $code]);
    }

    /**
     * Show error response
     * @author Mohammad.Y
     * @param string $message
     * @param int $code
     * @return array
     */
    protected function errorResponse($message, $code)
    {
        return response()->json([$message, $code], $code);
    }

    /**
     * Show all data
     * @author Mohammad.Y
     * @param array $collection
     * @param int $code
     * @return array
     */
    protected function showAll(Collection $collection, $code = 200)
    {
        return $this->successResponse($collection, $code);
    }

    /**
     * Show single data
     * @author Mohammad.Y
     * @param array $instance
     * @param int $code
     * @return array
     */
    protected function showOne(Model $instance, $code)
    {
        return $this->successResponse($instance, $code);
    }
}
