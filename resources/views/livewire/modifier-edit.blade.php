<div>
    <div id="controls">
        <select class="modifiers edit-select" wire:model="modifierId" wire:change="editModifier">
            <option value="0">Select a Modifier</option>
            @foreach($modifiers as $id => $modifier)
                <option value="{{ $id }}">{{ $modifier }}</option>
            @endforeach
        </select>
        <button class="term-btn" wire:click="save">Save</button>
        @if($showNewButton)
            <button class="term-btn" wire:click="newModifier" wire:click="focusTitle">New</button>
        @endif
        @if($showDelete)
            <button class="term-btn float-right danger"
                    type="button"
                    wire:click="delete"
                    wire:confirm="Are you sure you want to delete this modifier?"
            >Delete
            </button>
        @endif
        <button class="term-btn float-right" wire:click="clear">Clear</button>
    </div>
    <div id="editor">
        <textarea id="modifier_editor" wire:model="editor"></textarea>
    </div>
</div>
<script>
    $(document).ready(function ($) {
        @this.on('focusTitle', () => {
            $('#modifier_editor').focus();
        });
    });
</script>
