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
            <button class="term-btn" wire:click="newScript" wire:click="focusTitle">New</button>
        @endif
        @if($showDelete)
            <button class="term-btn float-right danger"
                    type="button"
                    wire:click="delete"
                    wire:confirm="Are you sure you want to delete this script?"
            >Delete
            </button>
        @endif
        <button class="term-btn float-right" wire:click="clear">Clear</button>
    </div>
    <div id="editor">
        <textarea id="script_editor" wire:model="editor"></textarea>
    </div>
</div>
<script>
    $(document).ready(function ($) {
    @this.on('focusTitle', () => {
        $('[data-name="scriptTitle"]').focus();
    });
    });
</script>
