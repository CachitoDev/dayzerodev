<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * @property array|null $payload
 * @property array|null $headers
 * @property array|null $response
 */
class RequestLog extends Model
{
    use HasFactory;

    protected $fillable = ['payload', 'headers', 'response'];
    protected $casts = ['payload'  => 'json',
                        'headers'  => 'json',
                        'response' => 'json'];

    /**
     * Create a new request log.
     *
     * @param Request $request
     * @return RequestLog
     */
    public static function store(Request $request)
    {
        return RequestLog::create([
            'payload'  => $request->toArray(),
            'headers'  => $request->header(),
            'response' => null
        ]);
    }

    /**
     * Set the response of the log.
     *
     * @param $response
     * @return void
     */
    public function setResponse(array $response)
    {
        $this->response = $response;
        $this->save();
    }
}
