<div class="join">

    {{-- {{ $years }} --}}
    <label class="self-center pr-3 join-item" for="specific-date-yearmin">
        From:
    </label>
    <select wire:model='yearMin' class="select select-bordered join-item" name="specific-date-yearmin" id="specific-date-yearmin">
        <option disabled value="0" @selected($yearMin == 0)>
            Select a year
        </option>

        @foreach ($yearsMin as $yearMinloop)
        <option value="{{ $yearMinloop }}" @selected($yearMin == $yearMinloop)>{{ $yearMinloop }}</option>
        @endforeach
    </select>


    <label class="self-center pl-5 pr-3 join-item" for="specific-date-yearmax">
        To:
    </label>

    @if($yearsMax)
    <select wire:model='yearMax' class="select select-bordered join-item" name="specific-date-yearmin" id="specific-date-yearmax">
        <option disabled value="0" @selected($yearMax == 0)>
            Select a year
        </option>

        @foreach ($yearsMax as $yearMaxloop)
        <option value="{{ $yearMaxloop }}" @selected($yearMax == $yearMaxloop)>{{ $yearMaxloop }}</option>
        @endforeach
    </select>
    @endif
    @if( $yearMin == 0 )
    {{-- <select class="select select-bordered join-item" wire:loading>
        <option disabled selected value="0">
            Loading...
        </option>
    </select> --}}
    @endif
</div>
