<?php

namespace App\Http\Controllers\Api\Blob;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as RequestClient;
use Illuminate\Http\Request;
use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Blob\Models\CreateBlockBlobOptions;

class BlobController extends Controller
{
    protected $blobClient;
    protected $containerName;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $connectionString = getenv('AZURE_STORAGE_CONNECTION_STRING');
        // Create blob client.
        $this->blobClient = BlobRestProxy::createBlobService($connectionString);
        $this->containerName = getenv('AZURE_CONTAINER_BLOB');
    }
    /**
     * Give list of blob
     */
    protected function list()
    {

        $result = $this->blobClient->listBlobs($this->containerName);
        $output = array();
        foreach ($result->getBlobs() as $blob) {
            array_push($output, [
                'name' => $blob->getName(),
                'url' => $blob->getUrl()
            ]);
        }
        return $output;
    }

    /**
     * Upload blobs.
     *
     * @param Request $request
     */
    protected function upload(Request $request)
    {
        $request->validate([
            'blob_file' => 'required|file|max:8000'
        ]);
        //
        $blobfile = $request->blob_file;
        // Create blob client.
        $dateNow = date("Y-m-d-H-i-s");
        $originalName = $blobfile->getClientOriginalName();
        $this->blobClient->createBlockBlob($this->containerName, "blob/$dateNow-$originalName", file_get_contents($blobfile->getRealPath()));
        return ['message' => 'success', 'status' => 200];
    }

    /**
     * Upload picture to cognitive.
     *
     * @param Request $request
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function uploadCognitive(Request $request)
    {
        $request->validate([
            'cognitive_file' => 'required|file|max:8000|image|mimes:jpeg,bmp,png'
        ]);
        $blobfile = $request->cognitive_file;
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
            return $response;
        }
        $bodyResponse = json_decode($response->getBody());
        $capturedCaptions = $bodyResponse->description->captions[0]->text;
        $metadata = [
            'captions' => $capturedCaptions
        ];
        $options = new CreateBlockBlobOptions();
        $options->setMetadata($metadata);

        $dateNow = date("Y-m-d-H-i-s");
        $originalName = $blobfile->getClientOriginalName();
        $this->blobClient->createBlockBlob($this->containerName, "cognitive/$dateNow-$originalName", $body, $options);
        return ['captions' => $capturedCaptions];
    }
}