<?php

namespace App\Http\Livewire;

use App\Models\Campaign;
use App\Models\Group;
use App\Models\Student;
use App\View\Components\AdminAppLayout;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;

class Students extends Component
{
    use WithPagination, AuthorizesRequests;

    public $campaign = null;
    public $student_id, $firstname, $lastname, $email, $group;
    public $isModalOpen = 0;
    public $itemIdToDelete = null;

    public $rules = [
        'firstname' => 'required|min:3',
        'lastname' => 'required|min:3',
        'email' => 'required|email',
        'group' => 'required'
    ];

    public function mount(Campaign $campaign, Student $student)
    {
        $this->campaign = $campaign;

        if ($student->exists) {
            $this->student_id = $student->id;
            $this->firstname = $student->firstname;
            $this->lastname = $student->lastname;
            $this->email = $student->email;
            $this->group = $student->group->id;

            $this->isModalOpen = 1;
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function render()
    {
        $this->authorize('manage-campaign', $this->campaign);

        $students = Student::where('campaign_id', $this->campaign->id)->orderBy('id', 'desc')->paginate(10);

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

        Student::updateOrCreate(['id' => $this->student_id], [
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'campaign_id' => $this->campaign->id,
            'group_id' => $this->group,
        ]);

        session()->flash('message', $this->student_id ? 'Student updated successfully.' : 'Student created successfully.');

        $this->closeModal();

        $this->resetInputFields();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        $this->student_id = $student->id;
        $this->firstname = $student->firstname;
        $this->lastname = $student->lastname;
        $this->email = $student->email;
        $this->group = $student->group_id;

        $this->openModal();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Student $student)
    {
        $student->delete();

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
        $this->reset(['student_id', 'firstname', 'lastname', 'email', 'group']);
    }
}
