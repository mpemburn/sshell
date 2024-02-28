<div>
    <div id="controls">
        <select class="scripts" wire:model="scriptId" wire:change="editScript">
            <option value="0">Select a Script</option>
            @foreach($scripts as $id => $script)
                <option value="{{ $id }}">{{ $script }}</option>
            @endforeach
        </select>
        <input type="text" wire:model="scriptTitle" data-name="scriptTitle" placeholder="Script title">
        <button class="term-btn" wire:click="save">Save</button>
        @if($showNewButton)
            <button class="term-btn" wire:click="newScript" wire:click="focusInput">New</button>
        @endif
        @if($showDelete)
        <button class="term-btn float-right danger"
            type="button"
            wire:click="delete"
            wire:confirm="Are you sure you want to delete this script?"
        >Delete</button>
        @endif
        <button class="term-btn float-right" wire:click="clear">Clear</button>

        <div>
            <textarea id="script_editor" wire:model="editor"></textarea>
        </div>
    </div>
</div>
<script>
    window.addEventListener('livewire:load', () => {
        @this.on('focusTitle', () => {
            document.querySelector('[data-name="scriptTitle"]').focus()
        });
    });



    // document.addEventListener('livewire:load', function () {
    //     Livewire.on('focus-input', function () {
    //         alert('Foc us!');
    //         const inputElement = document.querySelector('[x-ref="scriptTitle"]');
    //         if (inputElement) {
    //             inputElement.focus();
    //         }
    //     });
    // });
</script>
