<div>
    <input type="text" wire:model="street_name" placeholder="Street Name">
    <input type="text" wire:model="suburb" placeholder="Suburb">
    <input type="text" wire:model="postcode" placeholder="Postcode">
    <input type="text" wire:model="state" placeholder="State">
    
    <button wire:click="validateAddress" wire:loading.attr="disabled">Validate Address</button>
    
    @if($loading)
        <div>Loading...</div>
    @elseif($validAddress)
        <div>Valid Address: {{ $validAddress }}</div>
    @else
        <div>{{ $validationMessage }}</div>
    @endif
</div>