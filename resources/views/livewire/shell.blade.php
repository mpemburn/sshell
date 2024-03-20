<div>
    <div id="controls" class="{{ $connected ? '' : 'disabled' }}">
        <input id="command" class="inputs" type="text" wire:model="command" wire:keydown.enter="submit" placeholder="Enter a command">
        <button class="term-btn" wire:click="submit">Submit</button>
        <select id="scripts" class="scripts" wire:model="scriptId" wire:change="runScript">
            <option value="0">Select a Script</option>
            @foreach($scripts as $id => $script)
                <option value="{{ $id }}">{{ $script }}</option>
            @endforeach
        </select>
        <span id="modify">
            <input class="inputs" type="search" wire:model="modifier" wire:keyup="suggest" wire:click="suggest" placeholder="< Modify this command" {{ $scriptId === 0 ? 'disabled' : '' }}>
            @if ($showModifiers)
                <ul id="modifiers">
                @foreach($modifiers as $modifier)
                    <li wire:click="selectModifier('{{ $modifier }}')">{{ $modifier }}</li>
                @endforeach
            </ul>
            @endif
        </span>
        <button class="term-btn" wire:click="modify" {{ $scriptId === 0 ? 'disabled' : '' }}>Modify</button>
        <input type="checkbox" wire:model="shouldSaveModifier" wire:click="saveModifier" name="save_modifier"/> Save modifier
        <div wire:loading>
            <img id="loading"
                 src="https://cdnjs.cloudflare.com/ajax/libs/galleriffic/2.0.1/css/loader.gif" alt="" width="24"
                 height="24">
        </div>
        <button class="term-btn float-right" wire:click="clear">Clear</button>
    </div>
    {{-- This is the terminal: --}}
    <pre id="terminal">{{ $output }}</pre>
</div>
