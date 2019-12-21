<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <!-- Fonts -->
        <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
        <!-- Styles -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.0/css/bulma.min.css">
    </head>
    <body>
        <div id="app">
        <section class="section">
                <div class="container">                    
            <h1 class="title">Azure Exploration</h1>
            </div>
        </section>

            <section class="section">
                <div class="container">      
                    <div class="box">
                    <h2 class="title">Azure Blob Uploader</h2>
                    <form action="/blob/upload" method="POST" class="form" enctype="multipart/form-data">
                        @csrf
                        <div class="field">
                            <label class="label">File</label>
                            <div class="control">
                                <div class="file">
                                    <label class="file-label">
                                        <input class="file-input" type="file" name="blobfile">
                                        <span class="file-cta">
                                        <span class="file-icon">
                                            <i class="fas fa-upload"></i>
                                        </span>
                                        <span class="file-label">
                                            Choose a file…
                                        </span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="control">
                            <button class="button is-success">Submit</button>
                        </div>
                    </form>
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
                    </div>              
                    
                </div>
            </section>
            <section class="section">
            <div class="container">
                <div class="box">
                    <h2 class="title">
                        Azure Cognitive
                    </h2>
                </div>
            </div>
            </section>
        </div>
    </body>
</html>
