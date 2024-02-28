<div>
    <div id="controls">
        <input id="command" class="commands" type="text" wire:model="command" placeholder="Enter a command">
        <button class="term-btn" wire:click="submit">Submit</button>
        <select class="commands" wire:model="commandId" wire:change="runCommand">
            <option value="">Select a Command</option>
            @foreach($commands as $id => $command)
                <option value="{{ $id }}">{{ $command }}</option>
            @endforeach
        </select>
        <span id="modify">
            <input class="commands" type="search" wire:model="modifier" wire:keyup="suggest" wire:click="suggest" placeholder="< Modify this command">
            @if ($showModifiers)
                <ul id="modifiers">
                @foreach($modifiers as $modifier)
                    <li wire:click="selectModifier('{{ $modifier }}')">{{ $modifier }}</li>
                @endforeach
            </ul>
            @endif
        </span>
        <button class="term-btn" wire:click="modify">Modify</button>
        <div wire:loading>
            <img id="loading"
                 src="https://cdnjs.cloudflare.com/ajax/libs/galleriffic/2.0.1/css/loader.gif" alt="" width="24"
                 height="24">
        </div>
        <button class="term-btn clear-btn" wire:click="clear">Clear</button>
    </div>
    {{-- This is the terminal: --}}
    <pre id="terminal">{{ $output }}</pre>
</div>
