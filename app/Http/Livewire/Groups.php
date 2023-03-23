<?php

namespace App\Http\Livewire;

use App\Models\Campaign;
use App\Models\Group;
use App\View\Components\AdminAppLayout;
use App\View\Components\AppLayout;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Groups extends Component
{
    use WithPagination, AuthorizesRequests;

    public $campaign = null;
    public $group_id, $name;
    public $isModalOpen = 0;
    public $itemIdToDelete = null;

    public $rules = [
        'name' => 'required|min:3'
    ];

    public function mount(Campaign $campaign)
    {
        $this->campaign = $campaign;
    }

    /**
     * Display a listing of the resource.
     */
    public function render()
    {
        $this->authorize('manage-campaign', $this->campaign);

        $groups = Group::where('campaign_id', $this->campaign->id)->orderBy('id', 'desc')->paginate(10);

        $user = Auth::user();

        $view = view('livewire.groups.view', ['groups' => $groups]);

        if ($user->role == 'admin') {
            $view->layout(AdminAppLayout::class);

            return $view;
        }

        $view->layout(AppLayout::class);

        return $view;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->resetInputFields();

        $this->openModal();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        $this->validate();

        Group::updateOrCreate(['id' => $this->group_id], [
            'name' => $this->name,
            'campaign_id' => $this->campaign->id
        ]);

        session()->flash('message', $this->group_id ? 'Group updated successfully.' : 'Group created successfully.');

        $this->closeModal();

        $this->resetInputFields();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Group $group)
    {
        $this->group_id = $group->id;
        $this->name = $group->name;

        $this->openModal();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Group $group)
    {
        $group->delete();

        $this->itemIdToDelete = null;

        session()->flash('message', 'Group deleted successfully.');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function openModal()
    {
        $this->isModalOpen = true;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function confirmItemDeletion($id)
    {
        $this->itemIdToDelete = $id;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    private function resetInputFields(){
        $this->reset(['group_id', 'name']);
    }
}