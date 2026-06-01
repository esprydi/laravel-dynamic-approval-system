<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\Workflow;
use App\Models\WorkflowStep;
use App\Models\DocumentApproval;
use Illuminate\Support\Facades\DB;

class DocumentController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $myDocuments = Document::where('user_id', $user->id)
            ->with('workflow', 'currentStep.role')
            ->latest()
            ->get();
            
        $roles = $user->roles->pluck('id');
        
        $pendingApprovals = Document::where('status', 'Pending')
            ->whereHas('currentStep', function($q) use($roles) {
                $q->whereIn('role_id', $roles);
            })
            ->with('user', 'workflow')
            ->latest()
            ->get();
            
        return view('dashboard', compact('myDocuments', 'pendingApprovals'));
    }

    public function create()
    {
        $workflows = Workflow::all();
        return view('documents.create', compact('workflows'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'workflow_id' => 'required|exists:workflows,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        DB::transaction(function () use ($request) {
            $firstStep = WorkflowStep::where('workflow_id', $request->workflow_id)
                ->orderBy('order', 'asc')
                ->first();

            Document::create([
                'user_id' => auth()->id(),
                'workflow_id' => $request->workflow_id,
                'title' => $request->title,
                'content' => $request->content,
                'status' => 'Pending',
                'current_step_id' => $firstStep ? $firstStep->id : null,
            ]);
        });

        return redirect()->route('dashboard')->with('success', 'Pengajuan dokumen berhasil dibuat.');
    }

    public function show(Document $document)
    {
        $document->load('user', 'workflow.steps.role', 'currentStep.role', 'approvals.user');
        return view('documents.show', compact('document'));
    }

    public function approve(Request $request, Document $document)
    {
        $step = $document->currentStep;
        if (!$step || !auth()->user()->hasRole($step->role->name)) {
            abort(403, 'Unauthorized');
        }

        DB::transaction(function () use ($request, $document, $step) {
            DocumentApproval::create([
                'document_id' => $document->id,
                'user_id' => auth()->id(),
                'workflow_step_id' => $step->id,
                'status' => 'Approved',
                'notes' => $request->notes,
            ]);

            $nextStep = WorkflowStep::where('workflow_id', $document->workflow_id)
                ->where('order', '>', $step->order)
                ->orderBy('order', 'asc')
                ->first();

            if ($nextStep) {
                $document->update(['current_step_id' => $nextStep->id]);
            } else {
                $document->update([
                    'current_step_id' => null,
                    'status' => 'Approved'
                ]);
            }
        });

        return redirect()->route('dashboard')->with('success', 'Dokumen berhasil disetujui.');
    }

    public function reject(Request $request, Document $document)
    {
        $step = $document->currentStep;
        if (!$step || !auth()->user()->hasRole($step->role->name)) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'notes' => 'required'
        ]);

        DB::transaction(function () use ($request, $document, $step) {
            DocumentApproval::create([
                'document_id' => $document->id,
                'user_id' => auth()->id(),
                'workflow_step_id' => $step->id,
                'status' => 'Rejected',
                'notes' => $request->notes,
            ]);

            $document->update([
                'current_step_id' => null,
                'status' => 'Rejected'
            ]);
        });

        return redirect()->route('dashboard')->with('success', 'Dokumen berhasil ditolak.');
    }
}
