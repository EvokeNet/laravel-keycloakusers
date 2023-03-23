<?php

namespace App\Http\Livewire;

use App\Models\Campaign;
use App\Models\Group;
use App\Models\User;
use App\View\Components\AdminAppLayout;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class Students extends Component
{
    use WithPagination, AuthorizesRequests;

    public $campaign = null;
    public $user_id, $name, $email, $group;
    public $isModalOpen = 0;
    public $itemIdToDelete = null;

    public $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email',
        'group' => 'required'
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

        $students = User::where('role', 'student')->where('campaign_id', $this->campaign->id)->orderBy('id', 'desc')->paginate(10);

        $groups = Group::where('campaign_id', $this->campaign->id)->orderBy('name')->get();

        return view('livewire.students.view', ['students' => $students, 'groups' => $groups])
            ->layout(AdminAppLayout::class);
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

        if ($this->user_id) {
            $user = User::find($this->user_id);
            $user->name = $this->name;
            $user->email = $this->email;
            $user->group_id = $this->group;

            $user->update();

            $message = 'Student updated successfully';
        } else {
            $password = Str::random(10);

            User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($password),
                'role' => 'student',
                'campaign_id' => $this->campaign->id,
                'group_id' => $this->group,
            ]);

            $message = 'Student created successfully';
        }

        session()->flash('message', $message);

        $this->closeModal();

        $this->resetInputFields();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $this->user_id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->group = $user->group_id;

        $this->openModal();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(User $user)
    {
        $user->delete();

        $this->itemIdToDelete = null;

        session()->flash('message', 'Student deleted successfully.');
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
        $this->reset(['user_id', 'name', 'email', 'group']);
    }
}
