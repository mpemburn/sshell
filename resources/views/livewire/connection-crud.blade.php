<div>
    <div id="controls">
        <select class="connections edit-select" wire:model="connectionId" wire:change="editConnection">
            <option value="0">Select a Connection</option>
            @foreach($connections as $id => $connection)
                <option value="{{ $id }}">{{ $connection }}</option>
            @endforeach
        </select>
        <button class="term-btn" wire:click="save">Save</button>
        @if($showNewButton)
            <button class="term-btn" wire:click="newConnection" wire:click="focusTitle">New</button>
        @endif
        @if($showDelete)
            <button class="term-btn float-right danger"
                    type="button"
                    wire:click="delete"
                    wire:confirm="Are you sure you want to delete this connection?"
            >Delete
            </button>
        @endif
        <button class="term-btn float-right" wire:click="clear">Clear</button>
    </div>
    <div id="connection_editor" class="row">
        <div class="required">
            * <input id="name" wire:model="name" placeholder="Connection Name"></input>
        </div>
        <div class="required">
            * <input id="host" wire:model="host" placeholder="Host Name or IP"></input>
        </div>
        <div class="required">
            * <input id="user" wire:model="user" placeholder="User Name"></input>
        </div>
        <div class="required">
            * <input id="key_path" wire:model="keyPath" placeholder="Path to Public Key"></input>
        </div>
        <div class="optional">
            <input id="pass_phrase" wire:model="passPhrase" placeholder="Pass Phrase"></input>
        </div>
    </div>
</div>
<script>
    $(document).ready(function ($) {
        @this.on('focusName', () => {
            $('#name').focus();
        });
    });
</script>
