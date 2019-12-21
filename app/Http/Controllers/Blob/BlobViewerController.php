<?php
namespace App\Http\Controllers\Blob;

use App\Http\Controllers\Controller;
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
    protected function list(Request $request)
    {
        //$connectionString = getenv('AZURE_STORAGE_CONNECTION_STRING');
        //$containerName = 'dicoding-container-blob';
        // Create blob client.
        //$blobClient = BlobRestProxy::createBlobService($connectionString);
        //$result = $blobClient->listBlobs($containerName);
        $output = array();
        //foreach ($result->getBlobs() as $blob)
        //{
        //    array_push($output, [
        //        'name' => $blob->getName(),
        //        'url' => $blob->getUrl()
        //    ]);
        //}
        return view('blob', ['data' => $output]);
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
            $containerName = 'dicoding-container-blob';
            // Create blob client.
            $blobClient = BlobRestProxy::createBlobService($connectionString);
            $blobClient->createBlockBlob($containerName, $blobfile->getClientOriginalName(), file_get_contents($blobfile->getRealPath()));
            return redirect('/blob');
        }
        return view('welcome');
    }
}

