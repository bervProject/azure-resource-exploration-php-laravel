@extends('layout.main')

@section('content')
    <section class="section">
        <div class="container">
            <h1 class="title">Azure Exploration</h1>
        </div>
    </section>
    <section class="section">
        <div class="container">
            <div class="columns">
                <div class="column">
                    <div class="box">
                        <h2 class="title">Azure Blob Uploader</h2>
                        <a class="button is-link" href="{{ route('blob-list') }}">Visit Here</a>
                    </div>
                </div>
                <div class="column">
                    <div class="box">
                        <h2 class="title">
                            Azure Cognitive
                        </h2>
                        <a class="button is-link" href="{{ route('cognitive') }}">Visit Here</a>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
