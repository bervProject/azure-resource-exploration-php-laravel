@extends('layout.main')
@section('content')
<div class="container">
<h2 class="title">Blob List</h2>
                    <table class="table">
                        <thead>
                            <th>File Name</th>
                            <th>File URL</th>
                        </thead>
                        <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $item['name'] }}</td>
                                <td><a href="{{ $item['url'] }}">{{ $item['url'] }}</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <a class="button is-link" href="/">Back to Home</a>
                    </div>
@endsection