<?php

namespace App\Http\Livewire\Admin;

use App\View\Components\AdminAppLayout;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use App\Models\Campaign;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Crypt;

class Campaigns extends Component
{
    use WithPagination, AuthorizesRequests;

    public $campaign_id, $name, $realm, $client_id, $client_secret;
    public $isModalOpen = 0;
    public $itemIdToDelete = null;

    public $rules = [
        'name' => 'required|min:3',
        'realm' => 'required|min:3',
        'client_id' => 'required|min:3',
        'client_secret' => 'required|min:3',
    ];

    /**
     * Display a listing of the resource.
     */
    public function render()
    {
        $this->authorize('viewAny', Campaign::class);

        $campaigns = Campaign::orderBy('id', 'desc')->paginate(10);

        return view('livewire.admin.campaigns.view', ['campaigns' => $campaigns])
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

        Campaign::updateOrCreate(['id' => $this->campaign_id], [
            'name' => $this->name,
            'realm' => $this->realm,
            'client_id' => Crypt::encryptString($this->client_id),
            'client_secret' => Crypt::encryptString($this->client_secret),
        ]);

        session()->flash('message', $this->campaign_id ? 'Campaign updated successfully.' : 'Campaign created successfully.');

        $this->closeModal();

        $this->resetInputFields();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Campaign $campaign)
    {
        $this->campaign_id = $campaign->id;
        $this->name = $campaign->name;
        $this->realm = $campaign->realm;
        $this->client_id = Crypt::decryptString($campaign->client_id);
        $this->client_secret = Crypt::decryptString($campaign->client_secret);

        $this->openModal();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Campaign $campaign)
    {
        $campaign->delete();

        $this->itemIdToDelete = null;

        session()->flash('message', 'Campaign deleted successfully.');
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
    private function resetInputFields()
    {
        $this->reset(['campaign_id', 'name', 'realm', 'client_id', 'client_secret']);
    }
}
