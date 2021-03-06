<?php

namespace App\Http\Controllers\Blob;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as RequestClient;
use Illuminate\Http\Request;
use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Blob\Models\CreateBlockBlobOptions;

class BlobViewerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * View list of blobs.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function home(Request $request)
    {
        return view('blob');
    }

    /**
     * View list of blobs.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function list()
    {
        return view('blob-list');
    }

    /**
     * Upload blobs.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    protected function upload(Request $request)
    {
        $request->validate([
            'blob_file' => 'required|file'
        ]);
        //
        $blobfile = $request->blob_file;
        $connectionString = getenv('AZURE_STORAGE_CONNECTION_STRING');
        $containerName = getenv('AZURE_CONTAINER_BLOB');
        // Create blob client.
        $dateNow = date("Y-m-d-H-i-s");
        $originalName = $blobfile->getClientOriginalName();
        $blobClient = BlobRestProxy::createBlobService($connectionString);
        $blobClient->createBlockBlob($containerName, "blob/$dateNow-$originalName", file_get_contents($blobfile->getRealPath()));
        return redirect('/blob/list');
    }

    /**
     * Upload picture to cognitive.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function uploadCognitive(Request $request)
    {
        $request->validate([
            'cognitive_file' => 'required|file|image|mimes:jpeg,bmp,png'
        ]);
        //
        $blobfile = $request->cognitive_file;
        $extension = $blobfile->getClientOriginalExtension();
        $cognitivekey = getenv('AZURE_COGNITIVE_KEY');
        $cognitiveEndpoint = getenv('AZURE_COGNITIVE_ENDPOINT');
        // Create blob client.
        $client = new Client(['base_uri' => $cognitiveEndpoint]);
        $headers = [
            'Ocp-Apim-Subscription-Key' => $cognitivekey,
            'Content-Type' => 'application/octet-stream'
        ];
        $body = file_get_contents($blobfile->getRealPath());
        $req = new RequestClient('POST', 'vision/v2.0/analyze?visualFeatures=Description&language=en', $headers, $body);
        $response = $client->send($req);
        if ($response->getStatusCode() != 200) {
            return view('blob');
        }
        $bodyResponse = json_decode($response->getBody());
        $connectionString = getenv('AZURE_STORAGE_CONNECTION_STRING');
        $containerName = getenv('AZURE_CONTAINER_BLOB');
        $dateNow = date("Y-m-d-H-i-s");
        $originalName = $blobfile->getClientOriginalName();
        $capturedCaptions = $bodyResponse->description->captions[0]->text;
        $metadata = [
            'captions' => $capturedCaptions
        ];
        $options = new CreateBlockBlobOptions();
        $options->setMetadata($metadata);
        // Create blob client.
        $blobClient = BlobRestProxy::createBlobService($connectionString);
        $blobClient->createBlockBlob($containerName, "cognitive/$dateNow-$originalName", $body, $options);
        $output = [
            'file' => "data:image/$extension;base64," . base64_encode($body),
            'captions' => $capturedCaptions
        ];
        return view('cognitive-result', $output);
    }
}

