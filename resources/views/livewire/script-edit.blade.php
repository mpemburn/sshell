<div>
    <div id="controls">
        <select class="scripts" wire:model="scriptId" wire:change="editScript">
            <option value="0">Select a Script</option>
            @foreach($scripts as $id => $script)
                <option value="{{ $id }}">{{ $script }}</option>
            @endforeach
        </select>
        <input type="text" wire:model="scriptTitle" placeholder="Script title">
        <button class="term-btn" wire:click="save">Save</button>
        @if($showNewButton)
            <button class="term-btn" wire:click="newScript">New</button>
        @endif
        <div>
            <textarea id="script_editor" wire:model="editor"></textarea>
        </div>
    </div>
</div>
