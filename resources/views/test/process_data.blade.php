@extends('layouts.app')

@if (count($emi_data) > 0)
<h1>EMI Details</h1>
    <table>
        <thead>
            <tr>
                @foreach ($emi_column as $column=>$v)
                    <th>{{ $column }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($emi_data as $row)
                <tr>
                    @foreach ($emi_column as $column=>$v)
                        <td>{{ $row->$column }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form method="POST" action="{{ route('process-data') }}">
    @csrf
    <button type="submit" class="process-button">Process Data</button>
</form>