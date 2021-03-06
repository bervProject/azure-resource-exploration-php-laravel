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
    /**
     * Give list of blob
     */
    protected function list()
    {
        $connectionString = getenv('AZURE_STORAGE_CONNECTION_STRING');
        $containerName = getenv('AZURE_CONTAINER_BLOB');
        // Create blob client.
        $blobClient = BlobRestProxy::createBlobService($connectionString);
        $result = $blobClient->listBlobs($containerName);
        $output = array();
        foreach ($result->getBlobs() as $blob) {
            array_push($output, [
                'name' => $blob->getName(),
                'url' => $blob->getUrl()
            ]);
        }
        return $output;
    }
}