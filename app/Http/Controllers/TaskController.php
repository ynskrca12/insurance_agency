<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\Customer;
use App\Models\Policy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TaskController extends Controller
{
    /**
     * Görev listesi
     */
    public function index(Request $request)
    {
        $query = Task::with([
            'assignedTo',
            'assignedBy',
            'customer',
            'policy'
        ]);

        // Arama
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")
                ->orWhereHas('customer', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            });
        }

        // Durum filtresi
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Öncelik filtresi
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // Kategori filtresi
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Atanan kişi filtresi
        if ($request->filled('assigned_to')) {
            if ($request->assigned_to === 'me') {
                $query->where('assigned_to', auth()->id());
            } else {
                $query->where('assigned_to', $request->assigned_to);
            }
        }

        // Tarih filtresi
        if ($request->filled('date_filter')) {
            switch ($request->date_filter) {
                case 'today':
                    $query->whereDate('due_date', now());
                    break;
                case 'overdue':
                    $query->where('due_date', '<', now())
                        ->whereNotIn('status', ['completed', 'cancelled']);
                    break;
                case 'this_week':
                    $query->whereBetween('due_date', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'next_week':
                    $query->whereBetween('due_date', [now()->addWeek()->startOfWeek(), now()->addWeek()->endOfWeek()]);
                    break;
            }
        }

        // Sıralama
        $sortBy = $request->get('sort_by', 'due_date');
        $sortOrder = $request->get('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        $tasks = $query->get();

        $stats = [
            'total' => Task::count(),
            'pending' => Task::where('status', 'pending')->count(),
            'in_progress' => Task::where('status', 'in_progress')->count(),
            'completed' => Task::where('status', 'completed')->count(),
            'overdue' => Task::where('due_date', '<', now())
                ->whereNotIn('status', ['completed', 'cancelled'])
                ->count(),
            'my_tasks' => Task::where('assigned_to', auth()->id())
                ->whereNotIn('status', ['completed', 'cancelled'])
                ->count(),
        ];

        $users = User::forCurrentTenant()->orderBy('name')->get();

        return view('tasks.index', compact('tasks', 'stats', 'users'));
    }
    /**
     * Kanban görünümü
     */
    public function kanban(Request $request)
    {
        $query = Task::with(['assignedTo', 'customer', 'policy']);

        // Sadece benim görevlerim filtresi
        if ($request->get('my_tasks') === 'true') {
            $query->where('assigned_to', auth()->id());
        }

        $tasks = $query->get()->groupBy('status');

        $users = User::forCurrentTenant()->orderBy('name')->get();

        return view('tasks.kanban', compact('tasks', 'users'));
    }

    /**
     * Yeni görev formu
     */
    public function create(Request $request)
    {
        $users = User::forCurrentTenant()->orderBy('name')->get();
        $customers = Customer::where('status', 'active')->orderBy('name')->get();
        $policies = [];

        // URL'den müşteri ID'si geldiyse
        $selectedCustomer = null;
        if ($request->filled('customer_id')) {
            $selectedCustomer = Customer::find($request->customer_id);
            $policies = Policy::where('customer_id', $request->customer_id)
                ->where('status', 'active')
                ->get();
        }

        return view('tasks.create', compact('users', 'customers', 'policies', 'selectedCustomer'));
    }

    /**
     * Görev kaydet
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|in:call,meeting,follow_up,document,renewal,payment,quotation,other',
            'priority' => 'required|in:low,normal,high,urgent',
            'status' => 'required|in:pending,in_progress,completed,cancelled',
            'assigned_to' => 'required|exists:users,id',
            'customer_id' => 'nullable|exists:customers,id',
            'policy_id' => 'nullable|exists:policies,id',
            'due_date' => 'required|date',
            'due_time' => 'nullable|date_format:H:i',
            'reminder_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // Tarih ve saat birleştir
            $dueDateTime = $validated['due_date'];
            if (!empty($validated['due_time'])) {
                $dueDateTime = $validated['due_date'] . ' ' . $validated['due_time'];
            }

            $task = Task::create([
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'category' => $validated['category'],
                'priority' => $validated['priority'],
                'status' => $validated['status'],
                'assigned_to' => $validated['assigned_to'],
                'assigned_by' => auth()->id(),
                'customer_id' => $validated['customer_id'] ?? null,
                'policy_id' => $validated['policy_id'] ?? null,
                'due_date' => $dueDateTime,
                'reminder_date' => $validated['reminder_date'] ?? null,
                'notes' => $validated['notes'] ?? null,
            ]);

            // TODO: Atanan kişiye bildirim gönder

            DB::commit();

            return redirect()->route('tasks.show', $task)
                ->with('success', 'Görev başarıyla oluşturuldu.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Görev oluşturulurken bir hata oluştu: ' . $e->getMessage());
        }
    }

    /**
     * Görev detay
     */
    public function show(Task $task)
    {
        $task->load([
            'assignedTo',
            'assignedBy',
            'customer',
            'policy',
            'comments.user',
            'activityLogs.user',
        ]);

        return view('tasks.show', compact('task'));
    }

    /**
     * Görev düzenleme formu
     */
    public function edit(Task $task)
    {
        $users = User::forCurrentTenant()->orderBy('name')->get();
        $customers = Customer::where('status', 'active')->orderBy('name')->get();
        $policies = [];

        if ($task->customer_id) {
            $policies = Policy::where('customer_id', $task->customer_id)
                ->where('status', 'active')
                ->get();
        }

        return view('tasks.edit', compact('task', 'users', 'customers', 'policies'));
    }

    /**
     * Görev güncelle
     */
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|in:call,meeting,follow_up,document,renewal,payment,quotation,other',
            'priority' => 'required|in:low,normal,high,urgent',
            'status' => 'required|in:pending,in_progress,completed,cancelled',
            'assigned_to' => 'required|exists:users,id',
            'customer_id' => 'nullable|exists:customers,id',
            'policy_id' => 'nullable|exists:policies,id',
            'due_date' => 'required|date',
            'due_time' => 'nullable|date_format:H:i',
            'reminder_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $oldStatus = $task->status;
            $oldAssignedTo = $task->assigned_to;

            // Tarih ve saat birleştir
            $dueDateTime = $validated['due_date'];
            if (!empty($validated['due_time'])) {
                $dueDateTime = $validated['due_date'] . ' ' . $validated['due_time'];
            }

            $task->update([
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'category' => $validated['category'],
                'priority' => $validated['priority'],
                'status' => $validated['status'],
                'assigned_to' => $validated['assigned_to'],
                'customer_id' => $validated['customer_id'] ?? null,
                'policy_id' => $validated['policy_id'] ?? null,
                'due_date' => $dueDateTime,
                'reminder_date' => $validated['reminder_date'] ?? null,
                'notes' => $validated['notes'] ?? null,
            ]);

            // Durum değiştiyse tamamlanma zamanını kaydet
            if ($oldStatus !== 'completed' && $validated['status'] === 'completed') {
                $task->update(['completed_at' => now()]);
            }

            // Atanan kişi değiştiyse bildirim gönder
            if ($oldAssignedTo !== $validated['assigned_to']) {
                // TODO: Yeni atanan kişiye bildirim gönder
            }

            // Aktivite logu
            $task->activityLogs()->create([
                'tenant_id' => $task->tenant_id,
                'task_id' => $task->id,
                'user_id' => auth()->id(),
                'action' => 'updated',
                'description' => 'Görev güncellendi',
                'changes' => $task->getChanges(),
            ]);

            DB::commit();

            return redirect()->route('tasks.show', $task)
                ->with('success', 'Görev başarıyla güncellendi.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Görev güncellenirken bir hata oluştu: ' . $e->getMessage());
        }
    }

    /**
     * Görev sil
     */
    public function destroy(Task $task)
    {
        try {
            $task->delete();

            return redirect()->route('tasks.index')
                ->with('success', 'Görev başarıyla silindi.');

        } catch (\Exception $e) {
            return back()->with('error', 'Görev silinirken bir hata oluştu: ' . $e->getMessage());
        }
    }

    /**
     * Durum güncelle (AJAX)
     */
    public function updateStatus(Request $request, Task $task)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,completed,cancelled',
        ]);

        $oldStatus = $task->status;

        $task->update([
            'status' => $validated['status'],
            'completed_at' => $validated['status'] === 'completed' ? now() : null,
        ]);

        // Aktivite logu
        $task->activityLogs()->create([
            'tenant_id' => $task->tenant_id,
            'task_id' => $task->id,
            'user_id' => auth()->id(),
            'action' => 'status_changed',
            'description' => "Durum değişti: {$oldStatus} → {$validated['status']}",
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Durum güncellendi.',
        ]);
    }

    /**
     * Yorum ekle
     */
    public function addComment(Request $request, Task $task)
    {
        $validated = $request->validate([
            'comment' => 'required|string',
        ]);

        $comment = $task->comments()->create([
            'user_id' => auth()->id(),
            'comment' => $validated['comment'],
        ]);

        return back()->with('success', 'Yorum eklendi.');
    }
}
