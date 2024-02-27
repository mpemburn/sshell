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
            <input class="commands" type="search" wire:model="modifier" placeholder="< Modify this command">
            <ul id="modifiers">
                @foreach($items as $item)
                    <li wire:click="handleItemClick('{{ $item }}')">{{ $item }}</li>
                @endforeach
            </ul>
        </span>
        <button class="term-btn" wire:click="modify">Modify</button>
    </div>
    {{-- This is the terminal: --}}
    <pre id="terminal">{{ $output }}</pre>
</div>
