<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Loan Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>No of Payments </th>
                    <th>First Payment Date</th>
                    <th>Last Payment Date</th>
                    <th>Loan Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($loanDetails as $loanDetail)
                <tr>
                    <td>{{ $loanDetail->clientid }}</td>
                    <td>{{ $loanDetail->num_of_payment }}</td>
                    <td>{{ $loanDetail->first_payment_date }}</td>
                    <td>{{ $loanDetail->last_payment_date }}</td>
                    <td>{{ $loanDetail->loan_amount }}</td>
                    
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $loanDetails->links() }}

        
        </div>
    </div>
</x-app-layout>
