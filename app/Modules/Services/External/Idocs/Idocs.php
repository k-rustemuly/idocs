<?php

namespace App\Modules\Services\External\Idocs;

use App\Http\Resources\Idocs\ExternalDocsmResource;
use App\Models\Doc;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Config;

class Idocs
{

    public $routes = [];

    public function __construct()
    {
        $config = config("integration.idocs");
        $this->routes = $config["routes"];
    }

    private function getInbox(){
        $response = Http::idocs()->get('/'.$this->routes["inbox_docs"]);
        if($response->ok())
            return $response->json();
        return [];
    }

    private function getOutbox(){
        $response = Http::idocs()->get('/'.$this->routes["outbox_docs"]);
        if($response->ok())
            return $response->json();
        return [];
    }

    public function getAllDocs()
    {
        $docs = collect(array_merge($this->getInbox(), $this->getOutbox()));
        $docs = ExternalDocsmResource::collection($docs)->resolve();
        Doc::upsert($docs, ['doc_id'], ['group', 'content_name', 'extension', 'name', 'number', 'status']);
        return $docs;
    }

    public function saveDocs()
    {
        $urls = array();
        $docs = Doc::all();
        foreach($docs as $doc)
        {
            $response = Http::idocs("v1")->withUrlParameters([
                'doc_id' => $doc->doc_id,
            ])->get('/'.$this->routes["file"]);
            if($response->ok())
            {
                $temp = tempnam(sys_get_temp_dir(), 'TMP_');
                file_put_contents($temp, $response->body());
                $doc_name = $doc->name.'.pdf';
                $adapter = File::streamUpload($doc->doc_id, $doc_name, $temp);
                $urls[] = $adapter->publicUrl($doc_name, new Config());
            }
        }
        return $urls;
    }
}
