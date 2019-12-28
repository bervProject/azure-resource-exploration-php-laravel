<?php
namespace App\Http\Controllers\Blob;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as RequestClient;
use Illuminate\Http\Request;
use MicrosoftAzure\Storage\Blob\BlobRestProxy;

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
     * @param  array  $data
     * @return \App\User
     */
    protected function home(Request $request)
    {
        return view('blob');
    }

    /**
     * View list of blobs.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function list(Request $request)
    {
        $connectionString = getenv('AZURE_STORAGE_CONNECTION_STRING');
        $containerName = getenv('AZURE_CONTAINER_BLOB');
        // Create blob client.
        $blobClient = BlobRestProxy::createBlobService($connectionString);
        $result = $blobClient->listBlobs($containerName);
        $output = array();
        foreach ($result->getBlobs() as $blob)
        {
            array_push($output, [
                'name' => $blob->getName(),
                'url' => $blob->getUrl()
            ]);
        }
        return view('blob-list', ['data' => $output]);
    }

    /**
     * Upload blobs.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function upload(Request $request)
    {
        if ($request->hasFile('blobfile') && $request->file('blobfile')->isValid()) {
            //
            $blobfile = $request->blobfile;
            $connectionString = getenv('AZURE_STORAGE_CONNECTION_STRING');
            $containerName = getenv('AZURE_CONTAINER_BLOB');
            // Create blob client.
            $dateNow = date("Y-m-d-H-i-s");
            $blobClient = BlobRestProxy::createBlobService($connectionString);
            $blobClient->createBlockBlob($containerName, $dateNow."-".$blobfile->getClientOriginalName(), file_get_contents($blobfile->getRealPath()));
            return redirect('/blob/list');
        }
        return view('welcome');
    }

    /**
     * Upload blobs.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function uploadCognitive(Request $request)
    {
        if ($request->hasFile('blobfile') && $request->file('blobfile')->isValid()) {
            //
            $blobfile = $request->blobfile;
            $extension = $blobfile->getClientOriginalExtension();
            if ($extension != 'png' && $extension != 'jpg' && $extension != 'jpeg')
            {
                return view('welcome');
            }
            $cognitivekey = getenv('AZURE_COGNITIVE_KEY');
            $cognitiveEndpoint = getenv('AZURE_COGNITIVE_ENDPOINT');
            // Create blob client.
            $client = new Client(['base_uri' => $cognitiveEndpoint]);
            $headers = [
                'Ocp-Apim-Subscription-Key' => $cognitivekey,
                'Content-Type' => 'application/octet-stream'
            ];
            $body = file_get_contents($blobfile->getRealPath());
            $req = new RequestClient('POST', 'vision/v2.0/analyze', $headers, $body);
            $response = $client->send($req);
            return $response->getBody();
            //return redirect('/blob/list');
        }
        return view('welcome');
    }

    /**
     * Upload blobs.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function cognitiveView(Request $request)
    {
        if ($request->hasFile('blobfile') && $request->file('blobfile')->isValid()) {
            //
            $blobfile = $request->blobfile;
            $extension = $blobfile->getClientOriginalExtension();
            if ($extension != 'png' && $extension != 'jpg' && $extension != 'jpeg')
            {
                return view('welcome');
            }
            $connectionString = getenv('AZURE_STORAGE_CONNECTION_STRING');
            $containerName = 'dicoding-container-blob';
            // Create blob client.
            $dateNow = date("Y-m-d-H-i-s");
            $blobClient = BlobRestProxy::createBlobService($connectionString);
            $blobClient->createBlockBlob($containerName, $dateNow."-".$blobfile->getClientOriginalName(), file_get_contents($blobfile->getRealPath()));
            return redirect('/blob/list');
        }
        return view('welcome');
    }
}

