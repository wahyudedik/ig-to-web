<?php

namespace App\Http\Controllers;

use App\Services\ZKTeco\IClockIngestService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class ZKTecoIClockController extends BaseController
{
    public function cdata(Request $request, IClockIngestService $ingest)
    {
        $expected = (string) config('attendance.iclock_secret');
        if ($expected !== '') {
            $token = (string) ($request->query('token')
                ?? $request->input('token')
                ?? $request->query('iclock_token')
                ?? $request->input('iclock_token')
                ?? '');

            if (!hash_equals($expected, $token)) {
                abort(403);
            }
        }

        $serialNumber = (string) ($request->query('SN') ?? $request->input('SN') ?? 'UNKNOWN');
        $payload = (string) $request->getContent();

        if ($payload === '' && is_string($request->input('data'))) {
            $payload = (string) $request->input('data');
        }

        $ingest->ingest($serialNumber, $payload, $request->ip());

        return response("OK");
    }
}
