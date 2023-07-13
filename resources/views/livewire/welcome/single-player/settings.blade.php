<div>
    <x-input.control.horizontal for="solo-name">
        <x-slot:label>Name:</x-slot:label>

        <x-input id="solo-name" class=" input-bordered w-full" />

    </x-input.control.horizontal>

    <x-input.control.horizontal for="remember-settings">
        <x-slot:label>Remember For Future Games</x-slot:label>

        <x-input.toggle :disabled="true" id="remember-settings" class=" toggle-primary" />

    </x-input.control.horizontal>
</div>
