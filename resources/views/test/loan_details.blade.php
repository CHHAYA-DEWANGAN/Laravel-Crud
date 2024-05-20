@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Loan Details</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Client ID</th>
                    <th>Number of Payments</th>
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
    </div>
    <a href="{{ route('process-page') }}" class="process-button">go on Process Data page</a>
    
@endsection