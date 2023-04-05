<x-dialog-modal wire:model="isUploadModalOpen">
    <x-slot name="title">
        {{ __('Upload bulk students') }}
    </x-slot>

    <x-slot name="content">
        <form method="post" enctype="multipart/form-data">
            <div class="">
                <div class="mb-4">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file">Upload CSV file</label>
                    <input
                        class="relative m-0 block w-full min-w-0 flex-auto rounded border border-solid border-neutral-300 bg-clip-padding py-[0.32rem] px-3 text-base font-normal text-neutral-700 transition duration-300 ease-in-out file:-mx-3 file:-my-[0.32rem] file:overflow-hidden file:rounded-none file:border-0 file:border-solid file:border-inherit file:bg-neutral-100 file:px-3 file:py-[0.32rem] file:text-neutral-700 file:transition file:duration-150 file:ease-in-out file:[margin-inline-end:0.75rem] file:[border-inline-end-width:1px] hover:file:bg-neutral-200 focus:border-primary focus:text-neutral-700 focus:shadow-[0_0_0_1px] focus:shadow-primary focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:file:bg-neutral-700 dark:file:text-neutral-100"
                        type="file"
                        wire:model.defer="file"
                        id="file" />
                    <x-input-error for="file" class="mt-2" />
                    <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3">
                        <p>CSV comma separated only.</p>
                        <p>One student per line.</p>
                    </div>
                    <a
                        class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
                        href="{{asset('/templates/students.csv')}}"><i class="fa fa-download"></i> Download a template file</a>
                </div>
            </div>
        </form>
    </x-slot>

    <x-slot name="footer">
        <x-secondary-button wire:click="closeUploadModal()">
            {{ __('Cancel') }}
        </x-secondary-button>

        <x-button wire:click.prevent="processUpload()" class="ml-2">
            {{ __('Upload') }}
        </x-button>
    </x-slot>
</x-dialog-modal>
