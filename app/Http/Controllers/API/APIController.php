<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Builder;
use stdClass;
use Exception;

class APIController extends Controller
{
    const STATUS_ERROR = 'error';
    const STATUS_SUCCESS = 'success';
    const STATUS_WARNING = 'warning';


    /**
     * Devuelve una respuesta de éxito normalizada para la API
     *
     * @param string $message
     * @param array $extendedInfo
     *
     * @return JsonResponse
     */
    public function sendSuccess(
        string $message = '',
        array $extendedInfo = []
    ) {
        $success = new stdClass();
        $success->message = $message;
        $success->hash = $this->getMonitorHash();

        if (!empty($extendedInfo)) {
            foreach ($extendedInfo as $name => $value) {
                $success->$name = $value;
            }
        }

        $response = [
            'status' => self::STATUS_SUCCESS,
            'success' => $success,
        ];

        $this->monitorSuccess($success->message);

        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Devuelve una respuesta de error normalizada para la API
     *
     * @param int $status
     * @param string $message
     * @param array $extendedInfo
     *
     * @return JsonResponse
     */
    public function sendError(
        int $status = 500,
        string $message = '',
        array $extendedInfo = []
    ) {
        $error = new stdClass();
        $error->message = $message;
        $error->hash = $this->getMonitorHash();

        if (!empty($extendedInfo)) {
            foreach ($extendedInfo as $name => $value) {
                $error->$name = $value;
            }
        }

        $response = [
            'status' => self::STATUS_ERROR,
            'error' => $error,
        ];

        $this->monitorError($error->message);

        return response()->json($response, $status);
    }
}
