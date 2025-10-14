<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AuditLogController extends Controller
{
    /**
     * Display audit logs.
     */
    public function index(Request $request)
    {
        // Only superadmin can view audit logs
        if (!Gate::allows('viewAny', AuditLog::class)) {
            abort(403, 'Unauthorized action.');
        }

        $query = AuditLog::with(['user'])->latest();

        // Filter by action
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by model type
        if ($request->filled('model_type')) {
            $query->where('model_type', $request->model_type);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Search by IP address
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('ip_address', 'like', '%' . $request->search . '%')
                    ->orWhereHas('user', function ($userQuery) use ($request) {
                        $userQuery->where('name', 'like', '%' . $request->search . '%');
                    });
            });
        }

        $logs = $query->paginate(50);

        // Get filter options
        $users = User::select('id', 'name')->orderBy('name')->get();
        $actions = AuditLog::select('action')->distinct()->pluck('action');
        $modelTypes = AuditLog::select('model_type')->distinct()->whereNotNull('model_type')->pluck('model_type');

        return view('audit-logs.index', compact('logs', 'users', 'actions', 'modelTypes'));
    }

    /**
     * Show specific audit log.
     */
    public function show(AuditLog $auditLog)
    {
        if (!Gate::allows('view', $auditLog)) {
            abort(403, 'Unauthorized action.');
        }

        $auditLog->load('user');

        return view('audit-logs.show', compact('auditLog'));
    }

    /**
     * Export audit logs.
     */
    public function export(Request $request)
    {
        if (!Gate::allows('viewAny', AuditLog::class)) {
            abort(403, 'Unauthorized action.');
        }

        // Implementation for CSV export
        // TODO: Implement export functionality
        return back()->with('info', 'Export functionality coming soon');
    }
}
