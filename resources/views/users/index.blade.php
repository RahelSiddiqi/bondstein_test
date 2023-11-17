@extends('layouts.app')

@section('content')
 <h1>User Details</h1>
    <table class="table-auto"><thead><tr><th>SL</th><th>name</th><th>email</th></tr></thead><tbody> @foreach ($data as $d)<tr><td>{{ $d->name}}</td><td>{{ $d->email}}</td><td><a href="{{ route('users.edit',['user' => $d->id]) }}">Edit</a></td><td><form method="POST" action="{{ route('users.destroy',['user' => $d->id]) }}"> @method('delete') @csrf <button type="submit" class="btn btn-danger btn-sm">Delete</button></form></td></tr>@endforeach</tbody></table>
@endsection
