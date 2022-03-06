<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * API convert method
 * @author Mohammad.Y <mhd.yari021@gmail.com>
 */
trait ApiResponser
{
    /**
     * Show response data
     * @author Mohammad.Y <mhd.yari021@gmail.com>
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
     * @author Mohammad.Y <mhd.yari021@gmail.com>
     * @param string $message
     * @param int $code
     * @return array
     */
    protected function errorResponse($message, $code)
    {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }

    /**
     * Show all data
     * @author Mohammad.Y <mhd.yari021@gmail.com>
     * @param array $collection
     * @param int $code
     * @return array
     */
    protected function showAll(Collection $collection, $code = 200)
    {
        return $this->successResponse(['data' => $collection], $code);
    }

    /**
     * Show single data
     * @author Mohammad.Y <mhd.yari021@gmail.com>
     * @param array $instance
     * @param int $code
     * @return array
     */
    protected function showOne(Model $instance, $code = 200)
    {
        return $this->successResponse($instance, $code);
    }

    /**
     * Show token response
     * @author Mohammad.Y <mhd.yari021@gmail.com>
     * @param array $data
     * @param int $code
     * @return array
     */
    protected function tokenResponse($data, $code = 200)
    {
        return response()->json([$data, $code]);
    }
}
