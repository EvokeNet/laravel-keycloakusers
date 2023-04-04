<?php

namespace App\Http\Livewire\Admin;

use App\Models\Group;
use App\Models\Student;
use App\View\Components\AdminAppLayout;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use App\Models\SyncLog;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Crypt;

class Logs extends Component
{
    use WithPagination, AuthorizesRequests;

    public $campaign_id;

    /**
     * Display a listing of the resource.
     */
    public function render()
    {
        $this->authorize('viewAny', SyncLog::class);

        $logs = SyncLog::orderBy('id', 'desc')->paginate(10);

        $logs->each(function ($item) {
            if ($item->model == Group::class) {
                $item->route = 'campaigns.groups';
                $item->routeparam = $item->group->campaign_id;
            }

            if ($item->model == Student::class) {
                $item->route = 'campaigns.students';
                $item->routeparam = $item->student->campaign_id;
            }
        });

        return view('livewire.admin.logs.view', ['logs' => $logs])
            ->layout(AdminAppLayout::class);
    }
}
