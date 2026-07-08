<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\DatabaseBackup;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DatabaseExportController extends Controller
{
    public function export(Request $request)
    {
        if (!auth()->user()?->isAdmin()) {
            abort(403);
        }

        $sql = DatabaseBackup::dump();

        return response($sql, 200, [
            'Content-Type'        => 'application/sql',
            'Content-Disposition' => 'attachment; filename="' . DatabaseBackup::filename() . '"',
            'Content-Length'      => strlen($sql),
            'Cache-Control'       => 'no-cache',
        ]);
    }
}
