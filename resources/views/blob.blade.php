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
                        <form action="{{ route('cognitive-uploader') }}" method="POST" class="form"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="field">
                                <label class="label">File</label>
                                <div class="control">
                                    <div id="azure-cognitive" class="file has-name">
                                        <label class="file-label">
                                            <input class="file-input" type="file" name="cognitive_file"
                                                   accept="image/*">
                                            <span class="file-cta">
                                        <span class="file-icon">
                                            <i class="fas fa-upload"></i>
                                        </span>
                                        <span class="file-label">
                                            Choose a file…
                                        </span>
                                        </span>
                                            <span class="file-name">
                                              No file uploaded
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                @error('cognitive_file')
                                <div class="content">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="control">
                                <button class="button is-success">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection

@section('script')
    <script>
        const fileInput = document.querySelector('#azure-cognitive input[type=file]');
        fileInput.onchange = () => {
            if (fileInput.files.length > 0) {
                const fileName = document.querySelector('#azure-cognitive .file-name');
                fileName.textContent = fileInput.files[0].name;
            }
        }

        const fileInput2 = document.querySelector('#azure-blob-upload input[type=file]');
        fileInput2.onchange = () => {
            if (fileInput2.files.length > 0) {
                const fileName = document.querySelector('#azure-blob-upload .file-name');
                fileName.textContent = fileInput2.files[0].name;
            }
        }
    </script>
@endsection
