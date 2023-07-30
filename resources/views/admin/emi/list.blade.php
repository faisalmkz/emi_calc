<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('EMI Details') }}
        </h2>
    </x-slot>
        <form action="{{route('process.store')}}" method="POST">
            @csrf
            <button class="button" type="submit">Process Data</button>
        </form>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if(isset($tableRows))

        <table class="table table-custom">
        <thead>
            <tr>

                @foreach ($tableHeader as $headerRow)
               
                <th>{{$headerRow}}</th>
                
                @endforeach
            </tr>
        </thead>
        <tbody>
          
        @foreach ($tableRows as $row)
            <tr>
                @foreach ($row as $data)
                    <td>{{ $data }}</td>
                @endforeach
            </tr>
        @endforeach
        </tbody>

    </table>
        @else

        <h1>No Data</h1>
       
        @endif
        
        </div>
    </div>
</x-app-layout>
