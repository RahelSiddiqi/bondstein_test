@extends('layouts.app')

@section('content')
    <h1>Create User</h1>
    <form  class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" method="post" action="{{route('users.update',['user' => $data->id])}}">@csrf @method('PUT')<div class="mb-4"><label class="block text-gray-700 text-sm font-bold mb-2">Name</label><input value="{{$data->name}}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="name" type="text" placeholder="Enter User"></div>
<div class="mb-4"><label class="block text-gray-700 text-sm font-bold mb-2">Email</label><input value="{{$data->email}}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="email" type="text" placeholder="Enter User"></div>
<button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">Save</button></form>
@endsection
